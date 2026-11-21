# Deploying testing-soft on Debian with Docker

The stack (`docker-compose.yml`) runs three containers:

| Container | Image | Role |
|-----------|-------|------|
| `web` | built from `Dockerfile` (target `web`, Nginx) | Published on host port **5000**; serves `/theme`, `/images`, `/sound`, `/build`, `/storage`; sends everything else to PHP |
| `app` | built from `Dockerfile` (target `app`, PHP 8.4-FPM) | Runs Laravel; runs migrations and `artisan optimize` on start |
| `db` | `mysql:8.4` | Database, stored in the `db-data` volume, not exposed to the internet |

Uploaded files and logs live in the `storage` volume. Both volumes survive
`docker compose down` and rebuilds.

Tested target: Debian 12 (bookworm) or 13 (trixie), x86_64 or arm64, 1 GB RAM minimum (2 GB recommended for building).

---

## 1. Install Docker Engine

Log in to the server as a user with `sudo`:

```bash
sudo apt update
sudo apt install -y ca-certificates curl git
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/debian/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/debian $(. /etc/os-release && echo "$VERSION_CODENAME") stable" \
  | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
sudo usermod -aG docker $USER   # log out and back in afterwards
docker compose version          # check it works
```

## 2. Get the code

```bash
sudo mkdir -p /opt/testing-soft && sudo chown $USER: /opt/testing-soft
git clone https://github.com/applandsys/testing-soft-new.git /opt/testing-soft
cd /opt/testing-soft
```

(Private repo: use a GitHub deploy key or a personal access token.)

## 3. Configure `.env`

```bash
cp .env.production.example .env
echo "base64:$(openssl rand -base64 32)"   # paste the output as APP_KEY
openssl rand -base64 24                    # use for DB_PASSWORD
openssl rand -base64 24                    # use for DB_ROOT_PASSWORD
nano .env
chmod 600 .env
```

Set at least: `APP_KEY`, `DB_PASSWORD`, `DB_ROOT_PASSWORD`, and
`APP_URL=http://SERVER_IP:5000` (your server's public IP; the port must match
`HTTP_BIND`). Add mail settings if the app must send email (password reset).
Leave `SESSION_SECURE_COOKIE=false`, since the site runs on plain http.

> Keep `APP_KEY` the same forever once users exist; changing it logs everyone
> out and breaks encrypted data.

## 4. Build and start

```bash
docker compose up -d --build
docker compose ps            # all three should be "running"/"healthy"
docker compose logs -f app   # watch migrations run
```

Open `http://SERVER_IP:5000/`. The health endpoint is `http://SERVER_IP:5000/up`.
If it doesn't load, check the cloud provider's firewall/security group allows
inbound TCP 5000 (step 6).

Create the first user by registering on the site, or with tinker:

```bash
docker compose exec app php artisan tinker
```

## 5. Move data from the old cPanel server (optional)

Export the database from cPanel (phpMyAdmin → Export → SQL), copy it to the
server, then:

```bash
docker compose exec -T db sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"' < old-dump.sql
docker compose restart app
```

If files were uploaded to `storage/app/public` on the old host, copy them in:

```bash
docker compose cp ./old-storage-public/. app:/var/www/html/storage/app/public/
docker compose exec app chown -R www-data:www-data storage
```

## 6. Firewall and port 5000

The site is plain http on `http://SERVER_IP:5000` (no domain, no HTTPS).

- **Cloud firewall:** if the server is on a cloud provider (Hetzner, AWS,
  DigitalOcean, etc.), allow inbound TCP **5000** and **22** in its firewall /
  security group.
- **On the server (optional):**

  ```bash
  sudo apt install -y ufw
  sudo ufw allow OpenSSH
  sudo ufw allow 5000/tcp
  sudo ufw enable
  ```

  Note: Docker writes its own iptables rules, so a published port is reachable
  even if `ufw` doesn't list it. Closing 5000 means changing `HTTP_BIND`, not
  only `ufw`. MySQL is never published, so it stays private either way.
- **Different port:** change both `HTTP_BIND` and the port in `APP_URL` in
  `.env`, then `docker compose up -d`.

Without HTTPS, passwords are sent unencrypted. That's acceptable on a trusted
network; for public internet use, consider adding a domain + HTTPS later.

## 7. Deploying updates

```bash
cd /opt/testing-soft
git pull
docker compose up -d --build   # rebuilds images, migrations run on app start
docker image prune -f          # remove old image layers
```

To skip automatic migrations, set `RUN_MIGRATIONS=false` and run them by hand:
`docker compose exec app php artisan migrate --force`.

## 8. Backups and restore

Backup (put this in cron, e.g. `0 3 * * *`):

```bash
mkdir -p /opt/backups
cd /opt/testing-soft && docker compose exec -T db sh -c \
  'mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" --single-transaction --routines "$MYSQL_DATABASE"' \
  | gzip > /opt/backups/db-$(date +%F).sql.gz
find /opt/backups -name 'db-*.sql.gz' -mtime +14 -delete
```

Restore:

```bash
gunzip -c /opt/backups/db-YYYY-MM-DD.sql.gz | docker compose exec -T db sh -c \
  'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"'
```

Copy backups off the server too (another machine or object storage).

## Useful commands

```bash
docker compose logs -f app web          # logs
docker compose exec app php artisan ... # any artisan command
docker compose exec app php artisan down / up   # maintenance mode
docker compose restart app              # after editing .env
docker compose down                     # stop (data volumes are kept)
```

`.env` changes need `docker compose up -d` (or `restart app`): the entrypoint
re-runs `artisan optimize`, which rebuilds the config cache.

## Troubleshooting

- **`APP_KEY is not set`**: fill `APP_KEY` in `.env`, then `docker compose up -d`.
- **502 Bad Gateway**: `docker compose logs app` (usually a DB or migration error).
- **Login redirects back / CSRF 419**: `SESSION_SECURE_COOKIE` must be `false`
  (the site is plain http).
- **Links or redirects drop the `:5000`**: check `APP_URL=http://SERVER_IP:5000`
  in `.env`, then `docker compose restart app`.
- **Page doesn't load at all**: port 5000 is blocked by the cloud firewall, or
  `docker compose ps` shows `web` isn't running.
- **Build killed on a 1 GB server**: add swap (`sudo fallocate -l 2G /swapfile && sudo chmod 600 /swapfile && sudo mkswap /swapfile && sudo swapon /swapfile`).

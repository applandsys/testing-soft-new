# Deploying testing-soft on Debian with Docker

The stack (`docker-compose.yml`) runs three containers:

| Container | Image | Role |
|-----------|-------|------|
| `web` | built from `Dockerfile` (target `web`, Nginx) | Serves `/theme`, `/images`, `/sound`, `/build`, `/storage`; sends everything else to PHP |
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

Set at least: `APP_KEY`, `APP_URL`, `DB_PASSWORD`, `DB_ROOT_PASSWORD`, and mail
settings if the app must send email (password reset).

> Keep `APP_KEY` the same forever once users exist; changing it logs everyone
> out and breaks encrypted data.

## 4. Build and start

```bash
docker compose up -d --build
docker compose ps            # all three should be "running"/"healthy"
docker compose logs -f app   # watch migrations run
```

Open `http://SERVER_IP/`. The health endpoint is `http://SERVER_IP/up`.

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

## 6. HTTPS (recommended)

Docker-published ports bypass `ufw`, so run Nginx + Certbot on the host and
keep the container on localhost only.

1. In `.env` set `HTTP_BIND=127.0.0.1:8080` and `SESSION_SECURE_COOKIE=true`,
   and make sure `APP_URL` starts with `https://`. Then `docker compose up -d`.
2. Point your domain's DNS A record to the server.
3. On the host:

```bash
sudo apt install -y nginx certbot python3-certbot-nginx
sudo tee /etc/nginx/sites-available/testing-soft > /dev/null <<'EOF'
server {
    listen 80;
    server_name your-domain.com;
    client_max_body_size 20m;

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Port $server_port;
    }
}
EOF
sudo ln -s /etc/nginx/sites-available/testing-soft /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d your-domain.com    # issues the certificate and auto-renews
```

Firewall (optional): `sudo apt install ufw && sudo ufw allow OpenSSH && sudo ufw allow 'Nginx Full' && sudo ufw enable`.

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
- **Login redirects back / CSRF 419 on http**: `SESSION_SECURE_COOKIE` must be
  `false` until HTTPS is set up.
- **Links use http:// behind HTTPS**: check `APP_URL` and that the host Nginx
  sends `X-Forwarded-Proto`.
- **Build killed on a 1 GB server**: add swap (`sudo fallocate -l 2G /swapfile && sudo chmod 600 /swapfile && sudo mkswap /swapfile && sudo swapon /swapfile`).

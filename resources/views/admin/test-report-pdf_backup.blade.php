<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .date {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        .ok {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Test Result Report</h2>

<table>
    <thead>
    <tr>
        <th width="70%">Item Name</th>
        <th width="30%">OK</th>
    </tr>
    </thead>
    <tbody>
  /*   @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td class="ok">✔ OK</td>
        </tr>
    @endforeach */
    </tbody>
</table>

<div class="date">Date: {{ $date }}</div>

</body>
</html>

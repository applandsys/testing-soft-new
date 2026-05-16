<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .date {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #000;
            padding: 0;
        }

        img {
            width: 100%;
            display: block;
        }
    </style>
</head>

<body>

<h2>Test Result Report</h2>

<table>
    <tbody>
        <tr>
            <td>
                <img src="{{ asset('report.jpg') }}" alt="Report Image">
            </td>
        </tr>
    </tbody>
</table>

<div class="date">
    Date: {{ $date }}
</div>

</body>
</html>

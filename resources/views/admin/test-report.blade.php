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


<div class="text-center mt-3">
    <h1 class="text-center" style="text-align: center">Element Analysis Table</h1>
    <h4 class="fw-bold">
       <div class="date">Date: {{ $date }}</div>
    </h4>
    <div>
         <img src="{{ request()->getScheme() }}://65.21.91.186/public/report.png" alt="Report Image">
    </div>
</div>

</body>
</html>

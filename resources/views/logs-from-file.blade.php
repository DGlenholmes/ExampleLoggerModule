<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            display: flex;
            justify-content: center;
        }

        .content {
            text-align: center;
            width: 100%;
        }

    </style>
</head>
<body>
<div class="flex-center full-height container">

    <div class="content">
        <a href="/">Home</a>
        <table class="table table-bordered table-striped">
            <thead>
                <th>Type</th>
                <th>Message</th>
                <th>IP Address</th>
                <th>Timestamp</th>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log['type'] }}</td>
                    <td>{{ $log['message'] }}</td>
                    <td>{{ $log['ip_address'] }}</td>
                    <td>{{ $log['created_at'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

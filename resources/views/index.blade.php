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
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .content,
        .logForm {
            text-align: center;
            width: 100%;
        }

        label, input, select {
            width: 50%;
            margin-top: 5px;
        }

        select {
            height: 2.2em;
        }

    </style>
</head>
<body>
<div class="flex-center full-height container">

    <div class="content">
        <a href="/logs-from-file">View File Logs Output</a>
        <br/>
        <a href="/logs-from-database">View Database Logs Output</a>

        <form name="logForm" class="logForm" method="post" action="">

            <label>
                Log Message:
                <input type="text" name="logMessage">
            </label>

            <select name="logType">
                <option value="error">Error</option>
                <option value="info">Info</option>
                <option value="warning">Warning</option>
            </select>

            {{ csrf_field() }}
            <input type="submit" class="btn btn-success">
        </form>
    </div>
</div>
</body>
</html>

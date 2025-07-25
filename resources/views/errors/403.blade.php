<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMIS</title>
    <link rel="shortcut icon" href="{{asset('images/pnp_hss_logo.jpg')}}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        html, body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: sans-serif;
            font-weight: 400;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .error-container {
            text-align: center;
            padding: 20px;
        }
        .error-code {
            font-size: 200px;
            font-weight: 700;
            margin: 0;
            color: #99A7AF;
        }
        .error-message {
            font-size: 24px;
            margin: 20px 0;
            color: #E36C5D;
        }
        .error-details {
            font-size: 16px;
            color: #6c757d;
        }
        .back-home {
            margin-top: 20px;
        }
        .back-home a {
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }
        .back-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">
            403
        </div>
        <div class="error-message">
        	Forbidden
        </div>
        <div class="error-details">
        	Access to this resource on the server is denied.
        	<br>
            You are not authorized to view this resource.
        </div>
        <div class="back-home">
            <a href="{{route('dashboard.index')}}">Back to Home</a>
        </div>
    </div>
</body>
</html>

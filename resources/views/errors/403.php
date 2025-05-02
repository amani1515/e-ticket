<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .container {
            display: inline-block;
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 4rem;
            color: #e74c3c;
        }
        p {
            font-size: 1.2rem;
        }
        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <p><strong>Unauthorized Access Forbidden</strong></p>
        <p>You do not have permission to access this page.</p>
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>dashboard</title>
</head>
<body>
    <h1>Ini adalah dashboard</h1>
    <p>Selamat datang, {{Auth::user()->name}}</p>
    <a href="{{route('logout')}}">logout</a>
</body>
</html>
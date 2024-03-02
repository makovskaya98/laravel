<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/css/bootstrap.min.css', 'resources/js/app.js', 'resources/js/bootstrap/bootstrap.bundle.min.js'])

</head>
<body class="antialiased">
    <div class="page">
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
</body>
</html>

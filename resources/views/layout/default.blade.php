<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filas</title>
</head>

<body>
    @if (session()->has('message'))
        <h3>{{ session('message') }}</h3>
    @endif
    @yield('content')
</body>

</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades Tango Sueldo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/master.css">
</head>
<body>
    <div class="header">
        <div class="business-header">
            <p>{{ auth()->user()->client->business_name }}</p>
        </div>
        <div class="user-header">
            <a href="{{ route('editar_usuario') }}">{{ auth()->user()->username}}</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
        </div>
        
    </div>
    <div class="main-container">
        @yield('content')
    </div>
</body>
</html>
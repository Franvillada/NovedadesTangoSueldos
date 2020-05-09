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
            @if(auth()->user()->role->role == 'superadmin')
            <form action="{{ route('elegir_cliente') }}" method="post">
                @csrf
                <div>
                    <select name="client" id="client" class="form-control" onchange="form.submit()">
                        @foreach(session('clientes') as $client)
                        @if(session()->has('clienteElegido'))
                        <option value="{{ $client->id }}" <?php echo ($client->id == session('clienteElegido')->id) ? 'selected' : '' ?>>{{ $client->business_name }}</option>
                        @else
                        <option value="{{$client->id }}" <?php echo ($client->id == auth()->user()->client->id) ? 'selected' : '' ?>>{{ $client->business_name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </form>
            @else
            <p>{{ auth()->user()->client->business_name }}</p>
            @endif
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
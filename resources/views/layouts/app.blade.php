<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades Tango Sueldo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/master.css">
    @if(isset($informado))
        <meta http-equiv="refresh" content="1;url=download">
    @endif
</head>
<body>
    <div class="header">
        <div class="business-header">
            @foreach(auth()->user()->role->task as $permiso)
                @if($permiso->task == 'elegir_cliente')
                <form action="{{ route('elegir_cliente') }}" method="post">
                    @csrf
                    <div>
                        <select name="client" id="client" class="form-control" onchange="form.submit()">
                            @if(session()->has('clienteElegido'))
                                <option value="{{auth()->user()->client->id}}">{{auth()->user()->client->business_name}}</option>
                                @foreach(session('clientes') as $client)
                                    <option value="{{ $client->id }}" <?php echo ($client->id == session('clienteElegido')->id) ? 'selected' : '' ?>>{{ $client->business_name }}</option>
                                @endforeach
                            @else
                                <option value="{{auth()->user()->client->id}}">{{auth()->user()->client->business_name}}</option>
                                @foreach(session('clientes') as $client)
                                    <option value="{{ $client->id }}" <?php echo ($client->id == auth()->user()->client->id) ? 'selected' : '' ?>>{{ $client->business_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </form>
                @endif
            @endforeach
            
            @if(auth()->user()->role->role != 'superadmin')
            <p>{{ auth()->user()->client->business_name }}</p>
            @endif
        </div>
        <div class="user-header">
            <a href="{{ route('editar_propio') }}">{{ auth()->user()->username}}</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
        </div>
        
    </div>
    @if(session()->has('status'))
        @foreach($errors->all() as $error)
            <span class="popuptext alert-danger" id="pop-up"><strong>{{session('status')}}:</strong> {{$error}}</span>
        @endforeach
    @endif
    <div class="main-container">
        @yield('content')
    </div>
    <script>
        if(document.getElementById('pop-up')){
            setTimeout(function(){
                document.getElementById('pop-up').style.display = 'none'
            },3000);
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades Tango Sueldo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        (function(d) {
        var config = {
            kitId: 'vnv2gdm',
            scriptTimeout: 3000,
            async: true
        },
        h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
        })(document);
    </script>
    @if(Session::has('download.in.the.next.request'))
        <meta http-equiv="refresh" content="0;url=registro-novedades/download">
    @endif
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
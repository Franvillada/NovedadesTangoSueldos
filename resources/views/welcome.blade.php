<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades Tango Sueldo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/master.css">
</head>
<body>

    <div class="welcome-container">
        <div class="title text-center">
            <h1>Novedades Tango Sueldo</h1>
            <h2>Estudio MR y Asociados</h2>
        </div>

        <div class="row login-form">
            <div class="col-3 offset-col-4-and-half">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input  class="form-control" 
                                type="email" 
                                name="email" 
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Ingresa tu email">
                        <div class="{{ $errors->has('email') ? 'alert alert-danger' : 'd-none' }}">
                            {!! $errors->first('email', '<span>:message</span>') !!}
                        </div>    
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input  class="form-control" 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="Ingresa tu contraseña">
                        <div class="{{ $errors->has('password') ? 'alert alert-danger' : 'd-none' }}">
                            {!! $errors->first('password', '<span>:message</span>') !!}
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">INGRESAR</button>
                </form>
            </div>
            
        </div>
    </div>
    
</body>
</html>
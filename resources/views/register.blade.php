<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Registro de Usuario</h1>

    {{-- MOSTRAR ERRORES DE VALIDACIÓN --}}
    @if ($errors->any())
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
        <h3>Errores:</h3>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- MOSTRAR MENSAJE DE ÉXITO --}}
    @if (session('success'))
    <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('saveUser')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Cédula:</label>
            <input type="text" name="cedula" value="{{ old('cedula') }}" required>
        </div>

        <div>
            <label>Nombre:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Apellido:</label>
            <input type="text" name="lastname" value="{{ old('lastname') }}" required>
        </div>

        <div>
            <label>Fecha de Nacimiento:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" required>
        </div>

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Teléfono:</label>
            <input type="text" name="phoneNum" value="{{ old('phoneNum') }}" required>
        </div>

        <div>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>

        <label>Imagen:</label>
        <input type="file" name="image">

        <button type="submit">Registrar</button>
    </form>

    <a href="{{ route('showUsers') }}"> Show Users </a>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Edicion de Usuario</h1>

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
    <form action="{{ route('updateUser', $user->cedula) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Nombre:</label>
            <input type="text" name="name" value="{{ $user->name }}" required>
        </div>

        <div>
            <label>Apellido:</label>
            <input type="text" name="lastname" value="{{ $user->lastname }}" required>
        </div>

        <div>
            <label>Fecha de Nacimiento:</label>
            <input type="date" name="birthDate" value="{{ $user->birthDate }}" required>
        </div>

        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div>
            <label>Teléfono:</label>
            <input type="text" name="phoneNum" value="{{ $user->phoneNum }}" required>
        </div>

        <label>Imagen:</label>
        @if ($user->image)
        <img src="{{ asset('storage/' . $user->image) }}" alt="Imagen actual" width="120"
            style="display:block; margin-bottom:10px;">
        @endif

        <label for="image">Cambiar Imagen:</label>
        <input type="file" name="image">


        <button type="submit">Editar</button>
    </form>

</body>

</html>
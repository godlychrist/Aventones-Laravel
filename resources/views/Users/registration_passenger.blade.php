<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Aventones | Registro</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Tu CSS (mismo que el del login) -->
  <link rel="stylesheet" href="/css/logIn.css" />
</head>

<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3"
      style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Registro Pasajeros</h2>

<form action="{{ route('saveUser')}}" method="POST" enctype="multipart/form-data"
      class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
    @csrf

    {{-- MUESTRA ERRORES DE VALIDACIÓN --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label for="name" class="form-label fw-bold text-dark">Nombre</label>
            <input type="text" id="name" name="name" class="form-control"
                   value="{{ old('name') }}" placeholder="Juan" required>
        </div>
        <div class="col-12 col-md-6">
            <label for="lastname" class="form-label fw-bold text-dark">Apellidos</label>
            <input type="text" id="lastname" name="lastname" class="form-control"
                   value="{{ old('lastname') }}" placeholder="Pérez Solano" required>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12 col-md-6">
            <label for="cedula" class="form-label fw-bold text-dark">Cédula</label>
            <input type="text" id="cedula" name="cedula" class="form-control"
                   value="{{ old('cedula') }}" placeholder="1-2345-6789" required>
        </div>
        <div class="col-12 col-md-6">
            <label for="birthDate" class="form-label fw-bold text-dark">Fecha de Nacimiento</label>
            <input type="date" id="birthDate" name="birthDate" class="form-control"
                   value="{{ old('birthDate') }}" required>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12 col-md-6">
            <label for="email" class="form-label fw-bold text-dark">Correo</label>
            <input type="email" id="email" name="email" class="form-control"
                   value="{{ old('email') }}" placeholder="tu@correo.com" required>
        </div>
        <div class="col-12 col-md-6">
            <label for="phoneNum" class="form-label fw-bold text-dark">Teléfono</label>
            <input type="tel" id="phoneNum" name="phoneNum" class="form-control"
                   value="{{ old('phoneNum') }}" placeholder="8888-8888" required>
        </div>
    </div>

    <div class="mt-3">
        <label for="image" class="form-label fw-bold text-dark">Fotografía Personal</label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
    </div>

    <div class="row g-3 mt-1">
        <div class="col-12 col-md-6">
            <label for="password" class="form-label fw-bold text-dark">Password</label>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="********" required>
        </div>

        <div class="col-12 col-md-6">
            <label for="password_confirmation" class="form-label fw-bold text-dark">Confirmar Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control" placeholder="********" required>
        </div>
        
    </div>

    <div class="d-flex justify-content-center mt-4">
        <button type="submit" class="login-btn btn btn-primary">Register</button>
    </div>

    <p class="register-text text-center mt-3">
        <a href="{{ route('registerDriver') }}">Iniciar Sesión Como Conductor </a>
    </p>

    <p class="register-text text-center mt-3">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </p>
</form>


      </form>
    </div>
  </main>

  <footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
      <a href="{{ route('/index') }}">Rides</a> |
      <a href="{{ route('login') }}">Login</a> |
      <a href="{{ route('register') }}">Registro Pasajero</a> |
      <a href="{{ route('registerDriver') }}">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
  </footer>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aventones | Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 460px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>

      <!-- Formulario de Login -->
      <form action="{{ route('loginAttempt') }}" method="POST" id="loginForm" class="formulario-login text-start w-100 mt-3">
        @csrf <!-- Protección CSRF de Laravel -->

        <!-- Alerta dinámica controlada por JS -->
        <div id="alertBox" class="alert d-none w-100 text-start mb-3" role="alert"></div>

        <div class="mb-3">
          <label for="cedula" class="form-label fw-bold text-dark">Cédula</label>
          <input type="text" id="cedula" name="cedula" class="form-control" placeholder="1-2345-6789" required />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-bold text-dark">Contraseña</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="********" required />
        </div>

                <p class="register-text mb-1">
            ¿Quieres conducir? <a href="{{ url('/registration_driver') }}">Regístrate como conductor</a>
        </p>

                <p class="register-text text-center mt-3">
        ¿No tienes cuenta? <a href="{{ url('/registration_passenger') }}">Regístrate como pasajero</a>
        </p>

        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="login-btn btn btn-primary w-100">Iniciar sesión</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
      <a href="/pages/public_rides.php">Rides</a> |
      <a href="/login">Login</a> |
      <a href="/pages/registration_passenger.php">Registro Pasajero</a> |
      <a href="/pages/registration_driver.php">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
  </footer>

  <script src="/js/login.js"></script>
</body>

</html>

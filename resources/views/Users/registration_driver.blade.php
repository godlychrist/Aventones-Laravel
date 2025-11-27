<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones | Registro Conductor</title>
    <meta name="description" content="Regístrate como conductor en Aventones">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Registration CSS -->
    <link rel="stylesheet" href="{{ asset('css/registration_driver.css') }}" />
</head>

<body>
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
        <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
        <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    </button>

<main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">

    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center 
                d-flex flex-column align-items-center gap-3"
         style="max-width: 700px; width:100%;">

        <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
        <h2 class="h5 text-secondary m-0">Registro Conductores</h2>

        {{-- ===== FORMULARIO ===== --}}
        <form action="{{ route('saveDriver') }}" method="POST" enctype="multipart/form-data"
              class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
            @csrf

            {{-- Nombre / Apellidos --}}
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold text-dark">Nombre</label>
                    <input type="text" name="name" class="form-control" placeholder="Juan" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold text-dark">Apellidos</label>
                    <input type="text" name="lastname" class="form-control" placeholder="Pérez Solano" required>
                </div>
            </div>

            {{-- Cédula / Fecha Nacimiento --}}
            <div class="row g-3 mt-1">
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold text-dark">Cédula</label>
                    <input type="text" name="cedula" class="form-control" placeholder="1-2345-6789" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold text-dark">Fecha de Nacimiento</label>
                    <input type="date" name="birthDate" class="form-control" required>
                </div>
            </div>

            {{-- Email / Teléfono --}}
            <div class="row g-3 mt-1">
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold text-dark">Correo</label>
                    <input type="email" name="email" class="form-control" placeholder="tu@correo.com" required>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold text-dark">Teléfono</label>
                    <input type="tel" name="phoneNum" class="form-control" placeholder="8888-8888" required>
                </div>
            </div>

            {{-- Foto --}}
            <div class="mt-3">
                <label class="form-label fw-bold text-dark">Fotografía Personal</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            {{-- Password --}}
            <!-- Password / Confirmación -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="password" class="form-label fw-bold text-dark">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="password_confirm" class="form-label fw-bold text-dark">Repeat Password</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="********" required>
          </div>
        </div>
            {{-- Botón --}}
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="login-btn btn btn-primary">Registrar</button>
            </div>

            {{-- Link Login --}}
            <p class="register-text text-center mt-3">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </form>

    </div>
    
</main>

<footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Registro Pasajero</a> |
        <a href="{{ route('registerDriver') }}">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
</footer>

<script>
const themeToggle = document.getElementById('themeToggle');
const body = document.body;

// Check for saved theme preference or default to light mode
const currentTheme = localStorage.getItem('theme') || 'light';
if (currentTheme === 'dark') {
    body.classList.add('dark-mode');
}

themeToggle.addEventListener('click', function() {
    body.classList.toggle('dark-mode');

    // Save the theme preference
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});
</script>

</body>

</html>

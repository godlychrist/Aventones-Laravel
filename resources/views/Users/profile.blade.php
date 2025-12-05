@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Aventones | Mi Perfil</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- CSS general --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    {{-- CSS perfil --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
</head>

<body>
    {{-- Botón modo claro/oscuro --}}
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

    <div class="dashboard-container profile-page">

        {{-- Header --}}
        <header class="dashboard-header">
            <h1 class="brand-title">AVENTONES</h1>
            <h2 class="dashboard-subtitle">Mi Perfil</h2>
            <p class="welcome-text">Hola, {{ $user->name }} {{ $user->lastname }}</p>
        </header>

        <section class="cards-grid single-column">
            <article class="dashboard-card card-info profile-card" style="max-width: 420px; width: 100%; margin: 0 auto;">

                {{-- MENSAJE DE ÉXITO --}}
                @if(session('success'))
                    <div class="alert alert-success mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- FORMULARIO PERFIL --}}
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="formulario-profile">
                    @csrf

                    {{-- FOTO DE PERFIL --}}
                    <div class="avatar-row mb-3">
                        <div class="avatar-wrapper">
                            <img src="{{ $user->image ? asset('storage/'.$user->image) : '/images/avatar_placeholder.png' }}" alt="Foto de perfil">
                        </div>

                        <div class="avatar-input">
                            <label class="form-label d-block mb-2">Cambiar fotografía</label>

                            <div class="file-row mb-1">
                                <label for="image" class="btn btn-outline btn-file-small">
                                    Elegir archivo
                                </label>
                                <span id="file-chosen" class="text-muted">Ningún archivo</span>
                            </div>

                            <input type="file" id="image" name="image" class="file-input-hidden" accept="image/*">
                            <small class="text-muted">Deja vacío si no deseas cambiarla.</small>
                        </div>
                    </div>

                    {{-- NOMBRE --}}
                    <div class="field-group mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- APELLIDOS --}}
                    <div class="field-group mb-3">
                        <label for="lastname" class="form-label">Apellidos</label>
                        <input type="text" id="lastname" name="lastname" class="form-control"
                               value="{{ old('lastname', $user->lastname) }}" required>
                    </div>

                    {{-- CEDULA --}}
                    <div class="field-group mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" id="cedula" name="cedula" class="form-control"
                               value="{{ $user->cedula }}" readonly>
                    </div>

                    {{-- FECHA NACIMIENTO --}}
                    <div class="field-group mb-3">
                        <label for="birthDate" class="form-label">Fecha de nacimiento</label>
                        <input type="date" id="birthDate" name="birthDate" class="form-control"
                               value="{{ old('birthDate', $user->birthDate ? \Carbon\Carbon::parse($user->birthDate)->format('Y-m-d') : '') }}">
                    </div>

                    {{-- CORREO --}}
                    <div class="field-group mb-3">
                        <label for="mail" class="form-label">Correo</label>
                        <input type="email" id="mail" name="mail" class="form-control"
                               value="{{ old('mail', $user->email) }}" required>
                    </div>

                    {{-- TELEFONO --}}
                    <div class="field-group mb-3">
                        <label for="phoneNum" class="form-label">Teléfono</label>
                        <input type="tel" id="phoneNum" name="phoneNum" class="form-control"
                               value="{{ old('phoneNum', $user->phoneNum) }}" required>
                    </div>

                    {{-- BOTONES --}}
                    <div class="mt-4 d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-info w-100">
                            Guardar cambios
                        </button>

                        <a href="{{ route('/index') }}" class="btn btn-outline w-100">
                            ⬅ Volver al panel
                        </a>
                    </div>

                </form>
            </article>
        </section>

        {{-- Footer --}}
        <footer class="dashboard-footer">
            <nav class="footer-nav" aria-label="Footer navigation">
                <a href="{{ route('home') }}">Buscar Rides</a>
                <span class="footer-separator">|</span>
                <a href="{{ route('rides') }}">Mis Rides</a>
                <span class="footer-separator">|</span>
                <a href="{{ route('vehicles') }}">Mis Vehículos</a>
            </nav>
            <p class="footer-copy">© 2025 Aventones.com - Todos los derechos reservados</p>
        </footer>

    </div>

    <script>
        // Tema claro/oscuro
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') body.classList.add('dark-mode');

        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark' : 'light');
        });

        // Mostrar nombre del archivo
        const fileInput  = document.getElementById('image');
        const fileChosen = document.getElementById('file-chosen');

        if (fileInput) {
            fileInput.addEventListener('change', () => {
                fileChosen.textContent = fileInput.files.length ? fileInput.files[0].name : 'Ningún archivo';
            });
        }
    </script>

</body>
</html>

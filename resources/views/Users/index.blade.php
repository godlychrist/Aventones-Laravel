@php
    $cedula   = Auth::user()->cedula;
    $name     = Auth::user()->name;
    $lastname = Auth::user()->lastname;
    $userType = strtolower(trim(Auth::user()->userType));

    $isDriver = $userType === 'driver';
    $isUser   = $userType === 'user';
    $isAdmin  = $userType === 'admin';
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones | Dashboard</title>
    <meta name="description" content="Panel principal de Aventones - Gestiona tus viajes y vehículos">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Dashboard CSS --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    {{-- Theme Toggle Button --}}
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

    <div class="dashboard-container">
        {{-- Header --}}
        <header class="dashboard-header">
            <h1 class="brand-title">AVENTONES</h1>
            <h2 class="dashboard-subtitle">Panel Principal</h2>
            <p class="welcome-text">Bienvenido, {{ $name }} {{ $lastname }}</p>
        </header>

        {{-- ================== CONDUCTOR ================== --}}
        @if ($isDriver)
            <div class="cards-grid">
                {{-- Rides Card --}}
                <article class="dashboard-card card-primary">
                    <h3 class="card-title">
                        <span class="card-title-icon">🚗</span>
                        Rides
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('ride.create') }}" class="btn btn-primary">
                            <span>➕</span> Crear Ride
                        </a>
                        <a href="{{ route('rides') }}" class="btn btn-outline">
                            <span>👀</span> Ver Mis Rides
                        </a>
                    </div>
                </article>

                {{-- Vehicles Card --}}
                <article class="dashboard-card card-success">
                    <h3 class="card-title">
                        <span class="card-title-icon">🚙</span>
                        Vehículos
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('vehicle.create') }}" class="btn btn-success">
                            <span>➕</span> Crear Vehículo
                        </a>
                        <a href="{{ route('vehicles') }}" class="btn btn-info">
                            <span>👀</span> Ver Mis Vehículos
                        </a>
                    </div>
                </article>

                {{-- Profile & Bookings Card --}}
                <article class="dashboard-card card-warning">
                    <h3 class="card-title">
                        <span class="card-title-icon">👤</span>
                        Reservas y Perfil
                    </h3>
                    <div class="card-actions">
                        <a href="/pages/myBookings.php" class="btn btn-warning">
                            <span>📋</span> Mis Reservas
                        </a>
                        <a href="/pages/profile.php" class="btn btn-info">
                            <span>👤</span> Ver Perfil
                        </a>
                        <a href="/logout" class="btn btn-outline">
                            <span>🚪</span> Cerrar Sesión
                        </a>
                    </div>
                </article>
            </div>

        {{-- ================== PASAJERO ================== --}}
        @elseif ($isUser)
            <div class="cards-grid single-column">
                <article class="dashboard-card card-primary">
                    <h3 class="card-title">
                        <span class="card-title-icon">🚗</span>
                        Panel de Pasajero
                    </h3>
                    <div class="card-actions">
                        <a href="/index.php" class="btn btn-primary">
                            <span>🔍</span> Buscar Rides Disponibles
                        </a>
                        <a href="/pages/myBookings.php" class="btn btn-warning">
                            <span>📋</span> Mis Reservas
                        </a>
                        <a href="/pages/profile.php" class="btn btn-info">
                            <span>👤</span> Ver Perfil
                        </a>
                        <a href="/logout" class="btn btn-outline">
                            <span>🚪</span> Cerrar Sesión
                        </a>
                    </div>
                </article>
            </div>

        {{-- ================== ADMIN ================== --}}
        @elseif ($isAdmin)
            <div class="cards-grid single-column">
                <article class="dashboard-card card-primary">
                    <h3 class="card-title">
                        <span class="card-title-icon">⚙️</span>
                        Panel de Administrador
                    </h3>
                    <div class="card-actions">
                        <a href="/pages/users.php" class="btn btn-primary">
                            <span>👥</span> Ver Usuarios
                        </a>
                        <a href="/logout" class="btn btn-outline">
                            <span>🚪</span> Cerrar Sesión
                        </a>
                    </div>
                </article>
            </div>
        @endif

        {{-- Footer --}}
        <footer class="dashboard-footer">
            <nav class="footer-nav" aria-label="Footer navigation">
                <a href="/index.php">Buscar Rides</a>
                <span class="footer-separator">|</span>
                <a href="/pages/myBookings.php">Mis Reservas</a>
                @if ($isDriver)
                    <span class="footer-separator">|</span>
                    <a href="/functions/showride.php">Mis Rides</a>
                    <span class="footer-separator">|</span>
                    <a href="{{ route('vehicles') }}">Mis Vehículos</a>
                @endif
            </nav>
            <p class="footer-copy">© 2025 Aventones.com - Todos los derechos reservados</p>
        </footer>
    </div>

    {{-- Theme Toggle Script --}}
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

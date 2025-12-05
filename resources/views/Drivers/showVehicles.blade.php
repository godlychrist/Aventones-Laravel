@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Vehículos - Aventones</title>
    <meta name="description" content="Gestiona tus vehículos en Aventones">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vehicles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vehicles_list.css') }}">

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
<div class="wrapper container-fluid px-3">

    <!-- HEADER -->
    <header class="main-header text-center my-3">
        <div class="header-box mt-3">
            <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
                    <a href="{{ route('index') }}">Panel</a>
                    <a href="{{ route('rides') }}">Rides</a>
                    <a href="{{ route('vehicles') }}" class="active">Vehículos</a>
                    <a href="#">Reservas</a>
                </nav>

                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold">{{ $user->name }}</span>
                    <a href="{{ route('editUser', $user->cedula) }}" class="btn btn-sm btn-outline-secondary">Perfil</a>
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-secondary">Cerrar sesión</a>
                </div>

            </div>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main class="container">
        <h2 class="title text-center">Mis Vehículos</h2>
        <hr class="divider">

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('vehicle.create') }}" class="btn btn-success">
                ➕ Nuevo Vehículo
            </a>
        </div>

        @forelse ($vehicles as $vehicle)
            <div class="vehicle-card">
                <div class="vehicle-header">
                    <h3 class="vehicle-title">🚗 {{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                    <span class="vehicle-plate">{{ $vehicle->plateNum }}</span>
                </div>

                <div class="vehicle-content">
                    <div class="vehicle-info">
                        <div class="info-item">
                            <span class="info-label">🎨 Color</span>
                            <span class="info-value">{{ $vehicle->color }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">📅 Año</span>
                            <span class="info-value">{{ $vehicle->year }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">💺 Capacidad</span>
                            <span class="info-value">{{ $vehicle->capacity }} pasajeros</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">🏷️ Marca</span>
                            <span class="info-value">{{ $vehicle->brand }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">🚙 Modelo</span>
                            <span class="info-value">{{ $vehicle->model }}</span>
                        </div>
                    </div>

                    <div class="vehicle-image">
                        @if ($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                        @else
                            <div class="no-image">📷 Sin foto</div>
                        @endif
                    </div>
                </div>

                <div class="vehicle-actions">
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-secondary btn-sm">
                        ✏️ Editar
                    </a>

                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-secondary btn-sm"
                                onclick="return confirm('¿Eliminar este vehículo?')">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">🚙</div>
                <h3>No tienes vehículos registrados todavía</h3>
                <p class="text-muted">Registra tu primer vehículo para comenzar a crear rides</p>
                <a href="{{ route('vehicle.create') }}" class="btn btn-success mt-3">
                    ➕ Registrar Mi Primer Vehículo
                </a>
            </div>
        @endforelse

    </main>

    <!-- FOOTER -->
    <footer class="footer text-center mt-4">
        <nav class="footer-nav mb-2">
            <a href="{{ route('index') }}">Panel</a> |
            <a href="{{ route('rides') }}">Rides</a> |
            <a href="{{ route('vehicles') }}" class="active">Vehículos</a> |
            <a href="#">Reservas</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>

</div>

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
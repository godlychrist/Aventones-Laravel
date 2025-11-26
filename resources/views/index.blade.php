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
    <title>Aventones | Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/logIn.css') }}">
</head>

<body class="bg-light">

<main class="container min-vh-100 py-5">
    <div class="text-center mb-5">
        <h1 class="brand-title fw-bold text-primary mb-2">AVENTONES</h1>
        <h2 class="text-secondary m-0">Panel Principal</h2>
        <p class="text-muted mt-2">
            Bienvenido, {{ $name }} {{ $lastname }}.
        </p>
    </div>

    <div class="row g-4 justify-content-center">

        {{-- ================== CONDUCTOR ================== --}}
        @if ($isDriver)

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-primary">
                    <div class="card-body">
                        <h3 class="h5 text-primary mb-3">Rides</h3>
                        <div class="d-grid gap-3">
                            <a href="/pages/ride_create.php" class="btn btn-primary w-100">➕ Crear Ride</a>
                            <a href="/index.php" class="btn btn-info w-100 text-white">🔍 Buscar Rides Disponibles</a>
                            <a href="/functions/showride.php" class="btn btn-outline-primary w-100">👀 Ver Mis Rides</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-success">
                    <div class="card-body">
                        <h3 class="h5 text-success mb-3">Vehículos</h3>
                        <div class="d-grid gap-3">
                           <a href="{{ route('vehicle.create') }}" class="btn btn-success w-100">🚗 Crear Vehículo</a>

                           <a href="{{ route('vehicles') }}" class="btn btn-info w-100 text-white">👀 Ver Mis Vehículos</a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-warning">
                    <div class="card-body">
                        <h3 class="h5 text-warning mb-3">Reservas y Perfil</h3>
                        <div class="d-grid gap-3">
                            <a href="/pages/myBookings.php" class="btn btn-warning w-100 text-dark">📋 Mis Reservas</a>
                            <a href="/pages/profile.php" class="btn btn-info w-100 text-white">👤 Ver Perfil</a>
                            <a href="/logout" class="btn btn-outline-secondary w-100">🚪 Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>

        {{-- ================== PASAJERO ================== --}}
        @elseif ($isUser)

            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-sm border-primary">
                    <div class="card-body p-4">
                        <h3 class="h5 text-primary mb-4 text-center">Panel de Pasajero</h3>
                        <div class="d-grid gap-3">
                            <a href="/index.php" class="btn btn-primary w-100 py-2">🔍 Buscar Rides Disponibles</a>
                            <a href="/pages/myBookings.php" class="btn btn-warning w-100 py-2 text-dark">📋 Mis Reservas</a>
                            <a href="/pages/profile.php" class="btn btn-info w-100 py-2 text-white">👤 Ver Perfil</a>
                            <a href="/logout" class="btn btn-outline-secondary w-100 py-2">🚪 Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>

        {{-- ================== ADMIN ================== --}}
        @elseif ($isAdmin)

            <div class="col-12 col-md-6 col-lg-5">
                <div class="card shadow-sm border-primary">
                    <div class="card-body p-4">
                        <h3 class="h5 text-primary mb-4 text-center">Panel de Administrador</h3>
                        <div class="d-grid gap-3">
                            <a href="/pages/users.php" class="btn btn-primary w-100 py-2">🔍 Ver Usuarios</a>
                            <a href="/logout" class="btn btn-outline-secondary w-100 py-2">🚪 Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>
</main>

<footer class="footer text-center mt-5">
    <nav class="footer-nav mb-2">
        <a href="/index.php">Buscar Rides</a> |
        <a href="/pages/myBookings.php">Mis Reservas</a>
        @if ($isDriver)
            | <a href="/functions/showride.php">Mis Rides</a>
            | <a href="/functions/showvehicle.php">Mis Vehículos</a>
        @endif
    </nav>
    <p class="footer-copy">© Aventones.com</p>
</footer>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mis Rides - Aventones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ride.css') }}">
</head>

<body>
<div class="wrapper container-fluid px-3">

    <!-- HEADER -->
    <header class="main-header text-center my-3">
        <div class="header-box mt-3">
            <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
                    <a href="{{ url('/main') }}">Panel</a>
                    <a href="{{ route('rides') }}" class="active fw-bold">Rides</a>
                    <a href="{{ url('/vehicles') }}">Vehículos</a>
                    <a href="{{ url('/bookings') }}">Reservas</a>
                </nav>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/profile') }}" class="btn btn-sm btn-outline-secondary">Perfil</a>
                    <a href="{{ url('/logout') }}" class="btn btn-sm btn-outline-secondary">Cerrar sesión</a>
                </div>

            </div>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main class="container">
        <div class="content-body">
            <h2 class="title text-center">Mis Rides</h2>
            <hr class="divider" />

            <!-- Botón Nuevo -->
            <div class="d-flex justify-content-end mb-3">
                <a href="#" class="btn btn-new-ride">➕ Nuevo Ride</a>
            </div>

            <!-- TABLA -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre del Ride</th>
                            <th>Lugar de salida</th>
                            <th>Lugar de llegada</th>
                            <th>Fecha y hora</th>
                            <th>Espacios disponibles</th>
                            <th>Costo por espacio</th>
                            <th>Vehículo</th>
                            <th style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No tienes rides creados todavía.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer text-center mt-4">
        <nav class="footer-nav mb-2">
            <a href="{{ url('/main') }}">Panel</a> |
            <a href="{{ route('rides') }}" class="fw-bold">Rides</a> |
            <a href="{{ url('/vehicles') }}">Vehículos</a> |
            <a href="{{ url('/bookings') }}">Reservas</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rides - Aventones</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/home.css') }}" />

</head>

<body>
    <div class="wrapper container-fluid px-3">
   <header class="main-header text-center my-3">
    <div class="header-box mt-3">
      <header class="main-header text-center my-3">
    <div class="header-box mt-3">
        <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
              
                <a href="{{ route('rides') }}" class="active fw-bold">Panel</a>

              
                <a href="{{ route('rides') }}">Rides</a>

                <a href="{{ url('/vehicles') }}">Vehículos</a>
                <a href="{{ url('/bookings') }}">Reservas</a>
            </nav>


            <div class="d-flex align-items-center gap-3">

    @auth
        <a href="{{ url('/profile') }}" class="btn btn-sm btn-outline-secondary">Perfil</a>
        <a href="{{ url('/logout') }}" class="btn btn-sm btn-outline-secondary">Cerrar sesión</a>
    @endauth

    @guest
        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">Sign In</a>
    @endguest

</div>


        </div>
    </div>
</header>


        </div>
    </div>
</header>

        <main class="container">
            <div class="content-body">
                <h2 class="title text-center">Rides Disponibles</h2>
                <hr class="divider" />

                <!-- Search Form -->
                <form action="" method="get" class="mb-4 p-3 border rounded shadow-sm bg-light">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="filter_origin" class="form-label fw-bold">Lugar de Salida (Origen)</label>
                            <select id="filter_origin" name="origin" class="form-select">
                                <option value="">— Todos los Orígenes —</option>
                                <!-- Opciones dinámicas -->
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_destination" class="form-label fw-bold">Lugar de Llegada (Destino)</label>
                            <select id="filter_destination" name="destination" class="form-select">
                                <option value="">— Todos los Destinos —</option>
                                <!-- Opciones dinámicas -->
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_date" class="form-label fw-bold">Fecha</label>
                            <input type="date" id="filter_date" name="date" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-secondary me-2">Buscar / Filtrar</button>
                        <a href="/index.php" class="btn btn-outline-secondary">Limpiar Filtros</a>
                    </div>
                </form>

                <!-- Table for Displaying Rides -->
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
                            <tr>
            
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    <footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
        <a href="#">Panel</a> |
        <a href="{{ url('/rides') }}" class="fw-bold">Rides</a> |
        <a href="#">Vehículos</a> |
        <a href="#">Reservas</a> |
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ url('/registration_driver') }}">Registro</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
</footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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

        <!-- HEADER -->
        <header class="main-header text-center my-3">
            <div class="header-box mt-3">
                <div
                    class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                    <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">

                        <a href="" class="hover-grow active fw-bold">Panel</a>
                        <a href="" class="hover-grow">Rides</a>
                        <a href="" class="hover-grow">Vehículos</a>
                        <a href="" class="hover-grow">Reservas</a>

                    </nav>

                    <div class="d-flex align-items-center gap-3">

                        <a href="" class="btn btn-sm btn-outline-secondary hover-grow">Perfil</a>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary hover-grow">Iniciar Sesión</a>


                    </div>

                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
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
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_destination" class="form-label fw-bold">Lugar de Llegada
                                (Destino)</label>
                            <select id="filter_destination" name="destination" class="form-select">
                                <option value="">— Todos los Destinos —</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_date" class="form-label fw-bold">Fecha</label>
                            <input type="date" id="filter_date" name="date" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-secondary me-2 hover-grow">Buscar / Filtrar</button>
                        <a href="/index.php" class="btn btn-outline-secondary hover-grow">Limpiar Filtros</a>
                    </div>
                </form>

                <!-- Tabla -->
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
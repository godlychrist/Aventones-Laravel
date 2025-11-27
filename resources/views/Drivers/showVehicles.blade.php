@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Vehículos - Aventones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vehicles.css') }}">
</head>

<body>
<div class="wrapper container-fluid px-3">

    <!-- HEADER -->
    <header class="main-header text-center my-3">
        <div class="header-box mt-3">
            <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
                    <a href="{{ route('/index') }}">Panel</a>
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

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Placa</th>
                    <th>Color</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Capacidad</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->id }}</td>
                        <td>{{ $vehicle->plateNum }}</td>
                        <td>{{ $vehicle->color }}</td>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ $vehicle->capacity }}</td>

                        <td>
                            @if ($vehicle->image)
                                <img src="{{ asset('storage/'.$vehicle->image) }}" width="80">
                            @else
                                <span class="text-muted">Sin foto</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar este vehículo?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No tienes vehículos registrados todavía.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="footer text-center mt-4">
        <nav class="footer-nav mb-2">
            <a href="{{ route('/index') }}">Panel</a> |
            <a href="{{ route('rides') }}">Rides</a> |
            <a href="{{ route('vehicles') }}" class="active">Vehículos</a> |
            <a href="#">Reservas</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>

</div>
</body>
</html>
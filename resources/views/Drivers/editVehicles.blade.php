@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehículo - Aventones</title>

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
                    <!-- Placeholder for bookings -->
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
        <h2 class="title text-center">Editar Vehículo</h2>
        <hr class="divider">

        <div class="card shadow p-4 mx-auto" style="max-width: 600px;">

            {{-- ERRORES --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="user_id" value="{{ $vehicle->user_id }}">

                <div class="mb-3">
                    <label class="form-label fw-bold">Número de Placa</label>
                    <input type="text" name="plateNum"
                           class="form-control" value="{{ $vehicle->plateNum }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Color</label>
                    <input type="text" name="color"
                           class="form-control" value="{{ $vehicle->color }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Marca</label>
                    <input type="text" name="brand"
                           class="form-control" value="{{ $vehicle->brand }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Modelo</label>
                    <input type="text" name="model"
                           class="form-control" value="{{ $vehicle->model }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Año</label>
                    <input type="date" name="year"
                           class="form-control" value="{{ $vehicle->year }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Capacidad</label>
                    <input type="number" name="capacity" min="1"
                           class="form-control" value="{{ $vehicle->capacity }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Foto actual</label><br>

                    @if ($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}"
                             style="width: 120px; height:auto; border-radius:6px;" class="mb-2">
                    @else
                        <p class="text-muted">Sin imagen registrada</p>
                    @endif

                    <input type="file" name="image" class="form-control mt-2">
                    <small class="text-muted">Si subes una nueva imagen, reemplazará la anterior.</small>
                </div>

                <button class="btn btn-primary w-100">Guardar Cambios</button>

                <a href="{{ route('vehicles') }}" class="btn btn-secondary w-100 mt-3">Cancelar</a>

            </form>

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
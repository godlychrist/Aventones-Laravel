@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehículo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <h2 class="text-center mb-4">Editar Vehículo</h2>

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

</div>

</body>
</html>

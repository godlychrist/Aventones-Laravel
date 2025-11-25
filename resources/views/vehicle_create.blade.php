@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Vehículo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <h2 class="text-center mb-4">Registrar Vehículo</h2>

    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->cedula }}">

            <div class="mb-3">
                <label class="form-label">Número de Placa</label>
                <input type="text" name="plateNum" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Marca</label>
                <input type="text" name="brand" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Modelo</label>
                <input type="text" name="model" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Año</label>
                <input type="date" name="year" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Capacidad de pasajeros</label>
                <input type="number" name="capacity" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto del vehículo (opcional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-success w-100">Guardar Vehículo</button>

            <a href="{{ route('vehicles') }}" class="btn btn-secondary mt-3 w-100">Cancelar</a>
        </form>
    </div>

</div>

</body>
</html>

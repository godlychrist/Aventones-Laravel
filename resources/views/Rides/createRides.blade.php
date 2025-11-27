@php 
    $user = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>



    <form action="{{ route('rides.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->cedula }}">
        <input type="hidden" name="status" value="active">
        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nombre">
        <input type="text" name="origin" value="{{ old('origin') }}" required placeholder="Origen">
        <input type="text" name="destination" value="{{ old('destination') }}" required placeholder="Destino">
        <input type="date" name="date" value="{{ old('date') }}" required>
        <input type="time" name="time" value="{{ old('time') }}" required>
        <input type="number" name="space" value="{{ old('space') }}" required placeholder="Asientos disponibles">
        <input type="number" name="space_cost" value="{{ old('space_cost') }}" required placeholder="Precio por asiento">
        <select name="vehicle_id" required>
            <option value="">Seleccione un vehículo</option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->plateNum }}">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plateNum }})</option>
            @endforeach
        </select>
        <button type="submit">Crear Viaje</button>





    </form>


</body>

</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <a href="{{ route('ride.create') }}"> Crear Ride Nuevo </a>

    @foreach ($rides as $ride)
        <div>
            <h2>{{ $ride->name }}</h2>
            <p>{{ $ride->origin }}</p>
            <p>{{ $ride->destination }}</p>
            <p>{{ $ride->date }}</p>
            <p>{{ $ride->time }}</p>
            <p>{{ $ride->space_cost }}</p>
            <p>{{ $ride->space }}</p>
            <p>{{ $ride->user_id }}</p>
            <p>{{ $ride->vehicle_id }}</p>
            <p>{{ $ride->status }}</p>
            <a href="{{ route('rides.edit', $ride->id) }}"> Editar </a>
            <a href="{{ route('rides.destroy', $ride->id) }}"> Eliminar </a>
        </div>
    @endforeach
</body>

</html>


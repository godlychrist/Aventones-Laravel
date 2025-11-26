<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Conductores</title>
    <link rel="stylesheet" href="{{ asset('css/showUsers.css') }}">
</head>

<body>

    <h1>Lista de Conductores</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($drivers as $driver)
            <tr>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->lastname }}</td>
                <td>{{ $driver->email }}</td>

                <td>
                    @if ($driver->image)
                    <img src="{{ asset('storage/' . $driver->image) }}"
                         alt="Imagen de {{ $driver->name }}">
                    @endif
                </td>

                <td class="acciones">

                    <!-- Botón Editar -->
                    <a href="{{ route('editDriver', $driver->cedula) }}" class="btn-edit">
                        Editar
                    </a>

                    <!-- Botón Eliminar -->
                    <form action="{{ route('deleteDriver', $driver->cedula) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn-delete"
                                onclick="return confirm('¿Seguro que quieres eliminar a este conductor?');">
                            Eliminar
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $drivers->links('pagination::simple-default') }}
    </div>

</body>

</html>

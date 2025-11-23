<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/showUsers.css') }}">
</head>

<body>

    <h1>Lista de Usuarios</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Imagen</th>
                <th>Acciones</th> <!-- ⭐ Nueva columna -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Imagen de {{ $user->name }}">
                    @endif
                </td>

                <td class="acciones">
                    <!-- Botón Editar -->
                    <a href="{{ route ('editUser', $user->cedula) }}" class="btn-edit">Editar</a>

                    <!-- Botón Eliminar -->
                    <form action="{{ route ('deleteUser', $user->cedula) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"
                            onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $users->links('pagination::simple-default') }}
    </div>

</body>

</html>
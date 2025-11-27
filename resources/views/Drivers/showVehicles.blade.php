<tbody>
@forelse ($vehicles as $vehicle)
    <tr>
        <td>{{ $vehicle->plateNum }}</td>
        <td>{{ $vehicle->brand }}</td>
        <td>{{ $vehicle->model }}</td>
        <td>{{ $vehicle->color }}</td>
        <td>{{ $vehicle->year }}</td>
        <td>{{ $vehicle->capacity }}</td>

        <td>
            @if ($vehicle->image)
                <img src="{{ asset('storage/' . $vehicle->image) }}"
                     alt="Vehículo {{ $vehicle->plateNum }}"
                     style="width: 80px; height: auto; border-radius: 6px;">
            @else
                <span class="text-muted">Sin imagen</span>
            @endif
        </td>

        <td>
            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-primary">
                Editar
            </a>

            <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                  method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('¿Seguro que quieres eliminar este vehículo?');">
                    Eliminar
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted py-4">
            No tienes vehículos registrados todavía.
        </td>
    </tr>
@endforelse
</tbody>

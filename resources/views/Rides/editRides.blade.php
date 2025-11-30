
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones | Editar Ride</title>
    <meta name="description" content="Edita tu ride en Aventones">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ride_form.css') }}">
</head>

<body>
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
        <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
        <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    </button>

    <div class="container py-5">
        <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
            <form action="{{ route('rides.update', $ride->id) }}"  method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ $user->cedula }}">
                <input type="hidden" name="status" value="{{ old('status', $ride->status) }}">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre del Ride</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $ride->name) }}" required>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Lugar de Salida (Origen)</label>
                    <input type="text" name="origin" class="form-control" value="{{ old('origin', $ride->origin) }}" required>
                    @error('origin')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Lugar de Llegada (Destino)</label>
                    <input type="text" name="destination" class="form-control" value="{{ old('destination', $ride->destination) }}" required>
                    @error('destination')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $ride->date) }}" required>
                    @error('date')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Hora</label>
                    <input type="time" name="time" class="form-control" value="{{ old('time', $ride->time) }}" required>
                    @error('time')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Espacios Disponibles</label>
                    <input type="number" name="space" class="form-control" value="{{ old('space', $ride->space) }}" min="1" required>
                    @error('space')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Costo por Espacio</label>
                    <input type="number" name="space_cost" class="form-control" value="{{ old('space_cost', $ride->space_cost) }}" step="0.01" min="0" required>
                    @error('space_cost')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Vehículo</label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">Seleccione un vehículo</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->plateNum }}" {{ old('vehicle_id', $ride->vehicle_id) == $vehicle->plateNum ? 'selected' : '' }}>
                                {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plateNum }})
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">Actualizar Viaje</button>
                <a href="{{ route('rides') }}" class="btn btn-secondary mt-3 w-100">Cancelar</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    const currentTheme = localStorage.getItem('theme') || 'light';
    if (currentTheme === 'dark') {
        body.classList.add('dark-mode');
    }

    themeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
    </script>
</body>

</html>
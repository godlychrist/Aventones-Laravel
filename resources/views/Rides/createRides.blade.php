@php 
    $user = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones | Crear Ride</title>
    <meta name="description" content="Crea un nuevo ride en Aventones">
    
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
        <h2 class="text-center mb-4">Crear Nuevo Ride</h2>

        <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
            <form action="{{ route('rides.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->cedula }}">
                <input type="hidden" name="status" value="active">
                
                <div class="mb-3">
                    <label class="form-label">Nombre del Ride</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Viaje a la universidad" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Origen</label>
                    <input type="text" name="origin" value="{{ old('origin') }}" class="form-control" placeholder="San José" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Destino</label>
                    <input type="text" name="destination" value="{{ old('destination') }}" class="form-control" placeholder="Heredia" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="date" value="{{ old('date') }}" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hora</label>
                        <input type="time" name="time" value="{{ old('time') }}" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Asientos disponibles</label>
                        <input type="number" name="space" value="{{ old('space') }}" class="form-control" placeholder="4" min="1" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio por asiento</label>
                        <input type="number" name="space_cost" value="{{ old('space_cost') }}" class="form-control" placeholder="1000" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehículo</label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">Seleccione un vehículo</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->plateNum }}">{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->plateNum }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">Crear Viaje</button>

                <a href="{{ route('rides') }}" class="btn btn-secondary mt-3 w-100">Cancelar</a>
            </form>
        </div>
    </div>

    <script>
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    if (currentTheme === 'dark') {
        body.classList.add('dark-mode');
    }

    themeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');

        // Save the theme preference
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
    </script>
</body>

</html>

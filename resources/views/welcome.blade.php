
// ...existing code...
@php
    $user = Auth::user();
    $user = $user?->name ?? 'Invitado';
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rides - Aventones</title>
    <meta name="description" content="Encuentra y comparte rides en Aventones">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
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
    <div class="wrapper container-fluid px-3">

        <!-- HEADER -->
        <header class="main-header text-center my-3">
            <div class="header-box mt-3">
                <div
                    class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                    <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">

                        <a href="" class="hover-grow active fw-bold">Panel</a>
                        <a href="" class="hover-grow">Rides</a>
                        <a href="" class="hover-grow">Vehículos</a>
                        <a href="" class="hover-grow">Reservas</a>

                    </nav>

                    <div class="d-flex align-items-center gap-3">

                        <a href="" class="btn btn-sm btn-outline-secondary hover-grow">Perfil</a>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary hover-grow">Iniciar Sesión</a>


                    </div>

                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="container">
            <div class="content-body">
                <h2 class="title text-center">Rides Disponibles</h2>
                <hr class="divider" />

                <!-- Search Form -->
                <form action="" method="get" class="mb-4 p-3 border rounded shadow-sm bg-light">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="filter_origin" class="form-label fw-bold">Lugar de Salida (Origen)</label>
                            <select id="filter_origin" name="origin" class="form-select">
                                <option value="">— Todos los Orígenes —</option>
                                @isset($origins)
                                    @foreach($origins as $origin)
                                        <option value="{{ $origin }}" {{ (request('origin') ?? ($selectedOrigin ?? '')) == $origin ? 'selected' : '' }}>
                                            {{ $origin }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_destination" class="form-label fw-bold">Lugar de Llegada
                                (Destino)</label>
                            <select id="filter_destination" name="destination" class="form-select">
                                <option value="">— Todos los Destinos —</option>
                                @isset($destinations)
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination }}" {{ (request('destination') ?? ($selectedDestination ?? '')) == $destination ? 'selected' : '' }}>
                                            {{ $destination }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_date" class="form-label fw-bold">Fecha</label>
                            <input type="date" id="filter_date" name="date" class="form-control" value="{{ request('date') ?? ($selectedDate ?? '') }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-secondary me-2 hover-grow">Buscar / Filtrar</button>
                        <a href="/index.php" class="btn btn-outline-secondary hover-grow">Limpiar Filtros</a>
                    </div>
                </form>

                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Nombre del Ride</th>
                                <th>Lugar de salida</th>
                                <th>Lugar de llegada</th>
                                <th>Fecha y hora</th>
                                <th>Espacios disponibles</th>
                                <th>Costo por espacio</th>
                                <th>Vehículo</th>
                                <th style="width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rides as $ride)
                                <tr>
                                    <td>{{ $ride->name }}</td>
                                    <td>{{ $ride->origin }}</td>
                                    <td>{{ $ride->destination }}</td>
                                    <td>{{ $ride->date }} {{ $ride->time }}</td>
                                    <td>{{ $ride->space }}</td>
                                    <td>₡{{ number_format($ride->space_cost, 0) }}</td>
                                    <td>{{ $ride->vehicle_id }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">Reservar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No hay rides disponibles en este momento.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </main>

        <!-- FOOTER -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
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
// ...existing code...
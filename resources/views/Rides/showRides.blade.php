<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones | Mis Rides</title>
    <meta name="description" content="Gestiona tus rides en Aventones">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ride_form.css') }}">
    
    <style>
        .ride-card {
            background: var(--color-bg-primary);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-md);
            transition: all var(--transition-base);
            border: 1px solid var(--color-border);
        }
        
        .ride-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .ride-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: var(--spacing-md);
        }
        
        .ride-title {
            font-size: var(--font-size-xl);
            font-weight: var(--font-weight-semibold);
            color: var(--color-text-primary);
            margin: 0;
        }
        
        .ride-status {
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: var(--font-size-xs);
            font-weight: var(--font-weight-medium);
        }
        
        .ride-status.active {
            background: #10b981;
            color: white;
        }
        
        .ride-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: var(--font-size-xs);
            color: var(--color-text-secondary);
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            font-size: var(--font-size-sm);
            color: var(--color-text-primary);
            font-weight: var(--font-weight-medium);
        }
        
        .ride-actions {
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }
        
        .empty-state {
            text-align: center;
            padding: var(--spacing-xl);
            color: var(--color-text-secondary);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: var(--spacing-md);
        }
        
        .dark-mode .ride-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center mb-0">Mis Rides</h2>
            <a href="{{ route('ride.create') }}" class="btn btn-success">
                ➕ Crear Ride Nuevo
            </a>
        </div>

        @forelse ($rides as $ride)
            <div class="ride-card">
                <div class="ride-header">
                    <h3 class="ride-title">{{ $ride->name }}</h3>
                    <span class="ride-status {{ strtolower($ride->status) }}">
                        {{ ucfirst($ride->status) }}
                    </span>
                </div>

                <div class="ride-info">
                    <div class="info-item">
                        <span class="info-label">📍 Origen</span>
                        <span class="info-value">{{ $ride->origin }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">🎯 Destino</span>
                        <span class="info-value">{{ $ride->destination }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">📅 Fecha</span>
                        <span class="info-value">{{ $ride->date }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">🕐 Hora</span>
                        <span class="info-value">{{ $ride->time }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">💺 Espacios</span>
                        <span class="info-value">{{ $ride->space }} disponibles</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">💰 Precio</span>
                        <span class="info-value">₡{{ number_format($ride->space_cost, 0) }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">🚗 Vehículo</span>
                        <span class="info-value">{{ $ride->vehicle_id }}</span>
                    </div>
                </div>

                <div class="ride-actions">
                    <a href="{{ route('rides.edit', $ride->id) }}" class="btn btn-secondary btn-sm">
                        ✏️ Editar
                    </a>
                    
                    <form action="{{ route('rides.destroy', $ride->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-secondary btn-sm"
                                onclick="return confirm('¿Estás seguro de eliminar este ride?')">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">🚗</div>
                <h3>No tienes rides creados todavía</h3>
                <p class="text-muted">Crea tu primer ride para comenzar a compartir viajes</p>
                <a href="{{ route('ride.create') }}" class="btn btn-success mt-3">
                    ➕ Crear Mi Primer Ride
                </a>
            </div>
        @endforelse

        <div class="mt-4">
            <a href="{{ route('index') }}" class="btn btn-outline-secondary">
                ← Volver al Panel
            </a>
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

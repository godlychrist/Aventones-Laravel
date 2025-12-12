<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reporte de Búsquedas - Aventones</title>
    <meta name="description" content="Reporte de búsquedas realizadas por usuarios">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
    
    <style>
        .stats-card {
            background: var(--color-bg-primary);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
            border: 1px solid var(--color-border);
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: var(--font-weight-bold);
            color: var(--color-primary);
        }
        
        .stats-label {
            font-size: var(--font-size-sm);
            color: var(--color-text-secondary);
            margin-top: var(--spacing-xs);
        }
        
        .export-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius-sm);
            font-weight: var(--font-weight-medium);
            transition: all var(--transition-base);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .filter-section {
            background: var(--color-bg-secondary);
            border-radius: var(--radius-md);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            border: 1px solid var(--color-border);
        }
        
        .badge-results {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: var(--font-weight-medium);
        }
        
        .badge-high {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        
        .badge-medium {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }
        
        .badge-low {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .dark-mode .stats-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .dark-mode .filter-section {
            background: rgba(255, 255, 255, 0.03);
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
    
    <div class="wrapper container-fluid px-3">
        <!-- HEADER -->
        <header class="main-header text-center my-3">
            <div class="header-box mt-3">
                <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
                        <a href="{{ route('index') }}" class="hover-grow">Panel</a>
                        <a href="{{ route('reports.search') }}" class="hover-grow active fw-bold">Reportes</a>
                    </nav>

                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-secondary hover-grow">Perfil</a>
                        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-secondary hover-grow">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENIDO -->
        <main class="container">
            <div class="content-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="title mb-0">Reporte de Búsquedas</h2>
                        <p class="text-muted mb-0">Análisis de búsquedas realizadas por usuarios</p>
                    </div>
                    
                    @if($movements->count() > 0)
                    <form action="{{ route('reports.search.export') }}" method="GET" class="d-inline">
                        @if($startDate)
                            <input type="hidden" name="start_date" value="{{ $startDate }}">
                        @endif
                        @if($endDate)
                            <input type="hidden" name="end_date" value="{{ $endDate }}">
                        @endif
                        <button type="submit" class="export-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16" style="display: inline-block; vertical-align: middle;">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                            Exportar a CSV
                        </button>
                    </form>
                    @endif
                </div>
                
                <hr class="divider" />

                <!-- Statistics Cards -->
                @if($movements->count() > 0)
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-number">{{ number_format($totalSearches) }}</div>
                            <div class="stats-label">Total de Búsquedas</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-number">{{ $avgResults }}</div>
                            <div class="stats-label">Promedio de Resultados</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Filter Form -->
                <div class="filter-section">
                    <form action="{{ route('reports.search') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-5">
                                <label for="start_date" class="form-label fw-bold">Fecha de Inicio</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                            </div>

                            <div class="col-12 col-md-5">
                                <label for="end_date" class="form-label fw-bold">Fecha de Fin</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                            </div>

                            <div class="col-12 col-md-2">
                                <button type="submit" class="btn btn-secondary w-100 hover-grow">Filtrar</button>
                            </div>
                        </div>

                        @if($startDate || $endDate)
                        <div class="mt-3">
                            <a href="{{ route('reports.search') }}" class="btn btn-sm btn-outline-secondary hover-grow">
                                Limpiar Filtros
                            </a>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Results Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Cédula</th>
                                <th>Lugar de Salida</th>
                                <th>Lugar de Llegada</th>
                                <th class="text-center">Resultados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $movement)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movement->date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($movement->user)
                                            {{ $movement->user->name }} {{ $movement->user->lastname }}
                                        @else
                                            <span class="text-muted">Usuario no encontrado</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->user_id }}</td>
                                    <td>
                                        @if($movement->leavePlace)
                                            {{ $movement->leavePlace }}
                                        @else
                                            <span class="text-muted fst-italic">Todos</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($movement->destinationPlace)
                                            {{ $movement->destinationPlace }}
                                        @else
                                            <span class="text-muted fst-italic">Todos</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = 'badge-low';
                                            if($movement->resultsNum > 5) {
                                                $badgeClass = 'badge-high';
                                            } elseif($movement->resultsNum > 0) {
                                                $badgeClass = 'badge-medium';
                                            }
                                        @endphp
                                        <span class="badge-results {{ $badgeClass }}">
                                            {{ $movement->resultsNum }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        @if($startDate || $endDate)
                                            No se encontraron búsquedas en el rango de fechas seleccionado.
                                        @else
                                            No hay búsquedas registradas en el sistema.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($movements->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $movements->appends(['start_date' => $startDate, 'end_date' => $endDate])->links() }}
                </div>
                @endif

            </div>
        </main>
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

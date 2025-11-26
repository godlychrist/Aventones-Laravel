<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mis Reservaciones - Aventones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mybookings.css') }}" />
</head>

<body>
<div class="wrapper container-fluid px-3">

    <!-- HEADER -->
    <header class="main-header text-center my-3">
        <div class="header-box mt-3">
            <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
                    <a href="{{ url('/main') }}">Panel</a>
                    <a href="{{ url('/rides') }}">Rides</a>
                    <a href="{{ url('/vehicles') }}">Vehículos</a>
                    <a href="{{ route('mybookings') }}" class="active fw-bold">Reservas</a>
                </nav>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/profile') }}" class="btn btn-sm btn-outline-secondary">Perfil</a>
                    <a href="{{ url('/logout') }}" class="btn btn-sm btn-outline-secondary">Cerrar Sesión</a>
                </div>

            </div>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main class="container">
        <div class="content-body">
            <h2 class="title text-center">Mis Reservaciones</h2>
            <hr class="divider" />

            @if(session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            @if(session('err'))
                <div class="alert alert-danger">{{ session('err') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre del Ride</th>
                            <th>Estado</th>
                            <th>Conductor</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(empty($bookings) || count($bookings) == 0)
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No tienes reservas para ver.
                            </td>
                        </tr>
                        @else
                            @foreach ($bookings as $b)
                            <tr>
                                <td>{{ $b['ride_name'] ?? '' }}</td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $b['booking_state'] ?? 'Desconocido' }}
                                    </span>

                                    {{-- ACCIONES DEL CONDUCTOR --}}
                                    @if($userType == 'driver' && ($b['booking_state'] ?? '') == 'pendiente')
                                        <div class="mt-2 d-flex gap-2">
                                            <form method="POST" action="{{ url('/bookings/edit') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $b['id'] }}">
                                                <input type="hidden" name="ride_id" value="{{ $b['ride_id'] }}">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="btn btn-sm btn-success">Aceptar</button>
                                            </form>

                                            <form method="POST" action="{{ url('/bookings/edit') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $b['id'] }}">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-sm btn-danger">Rechazar</button>
                                            </form>
                                        </div>
                                    @endif

                                    {{-- ACCIONES DEL PASAJERO --}}
                                    @if($userType == 'user' && in_array(($b['booking_state'] ?? ''), ['pendiente','accepted']))
                                        <div class="mt-2 d-flex gap-2">
                                            <form method="POST" action="{{ url('/bookings/edit') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $b['id'] }}">
                                                <input type="hidden" name="ride_id" value="{{ $b['ride_id'] }}">
                                                <input type="hidden" name="action" value="cancel">
                                                <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @if($userType == 'user')
                                        {{ $b['driver_name'] ?? 'Pendiente Asignar' }}
                                    @else
                                        {{ $b['user_name'] ?? 'N/A' }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer text-center mt-4">
        <nav class="footer-nav mb-2">
            <a href="{{ url('/main') }}">Panel</a> |
            <a href="{{ url('/rides') }}">Rides</a> |
            <a href="{{ url('/vehicles') }}">Vehículos</a> |
            <a href="{{ route('mybookings') }}" class="fw-bold">Reservas</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>

</div>
</body>

</html>

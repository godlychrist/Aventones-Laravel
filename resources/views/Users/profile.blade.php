<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Aventones | Mi Perfil</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- CSS del perfil --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
</head>

<body>
    <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="profile-wrapper shadow border rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3">
            <h1 class="brand-title fw-bold m-0">AVENTONES</h1>
            <h2 class="h5 text-secondary m-0">Mi Perfil</h2>

            {{-- FORMULARIO PERFIL --}}
            <form action="#" method="post" enctype="multipart/form-data" class="formulario-profile text-start w-100 mt-3">
                {{-- Si luego usas Laravel para guardar, aquí va @csrf --}}
                @csrf

                {{-- FOTO DE PERFIL --}}
                <div class="d-flex align-items-center gap-3 mb-3 avatar-row">
                    <div class="avatar-wrapper rounded-circle overflow-hidden">
                        <img src="/images/avatar_placeholder.png" alt="Foto de perfil">
                    </div>
                    <div class="flex-grow-1">
                        <label for="image" class="form-label fw-bold text-dark mb-1">Cambiar fotografía</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Deja vacío si no deseas cambiarla.</small>
                    </div>
                </div>

                {{-- NOMBRE / APELLIDOS --}}
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label fw-bold text-dark">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Juan" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="lastname" class="form-label fw-bold text-dark">Apellidos</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Pérez Solano" required>
                    </div>
                </div>

                {{-- CÉDULA / FECHA NACIMIENTO --}}
                <div class="row g-3 mt-1">
                    <div class="col-12 col-md-6">
                        <label for="cedula" class="form-label fw-bold text-dark">Cédula</label>
                        <input type="text" id="cedula" name="cedula" class="form-control" placeholder="1-2345-6789" readonly>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="birthDate" class="form-label fw-bold text-dark">Fecha de nacimiento</label>
                        <input type="date" id="birthDate" name="birthDate" class="form-control">
                    </div>
                </div>

                {{-- CORREO / TELÉFONO --}}
                <div class="row g-3 mt-1">
                    <div class="col-12 col-md-6">
                        <label for="mail" class="form-label fw-bold text-dark">Correo</label>
                        <input type="email" id="mail" name="mail" class="form-control" placeholder="tu@correo.com" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="phoneNum" class="form-label fw-bold text-dark">Teléfono</label>
                        <input type="tel" id="phoneNum" name="phoneNum" class="form-control" placeholder="8888-8888" required>
                    </div>
                </div>

                {{-- BOTÓN --}}
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="profile-btn btn w-100">Guardar cambios</button>
                </div>
                                {{-- LINK VOLVER --}}
                            <p class="profile-link text-center mt-3">
                    <a href="{{ url('/') }}" class="btn-return-panel">
                        ⬅ Volver al panel
                    </a>
                </p>      
            </form>
        </div>
    </main>

    {{-- Footer turquesa, igual estilo que login --}}
    <footer class="footer text-center mt-4">
        <nav class="footer-nav mb-2">
            <a href="{{ route('/index') }}">Rides</a> |
            <a href="{{ route('login') }}">Login</a> |
            <a href="{{ route('register') }}">Registro Pasajero</a> |
            <a href="{{ route('registerDriver') }}">Registro Conductor</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>
</body>
</html>

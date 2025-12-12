# 🚗 Aventones - Sistema de Carpooling

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

**Aventones** es una plataforma web moderna de carpooling que conecta conductores con pasajeros para compartir viajes de manera eficiente, segura y económica.

---

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Tecnologías](#-tecnologías)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Tipos de Usuario](#-tipos-de-usuario)
- [Funcionalidades Principales](#-funcionalidades-principales)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Comandos Artisan](#-comandos-artisan)
- [Documentación](#-documentación)
- [Contribución](#-contribución)
- [Licencia](#-licencia)

---

## ✨ Características

### 🎯 Funcionalidades Principales

- **Sistema de Autenticación** completo con roles (Admin, Conductor, Pasajero)
- **Gestión de Rides** - Crear, editar y eliminar viajes
- **Sistema de Reservas** - Solicitar, aceptar, rechazar y cancelar reservas
- **Gestión de Vehículos** - Registro y administración de vehículos
- **Búsqueda Avanzada** - Filtros por origen, destino y fecha
- **Reportes de Búsquedas** - Análisis de tendencias y comportamiento de usuarios
- **Notificaciones por Email** - Alertas automáticas para conductores
- **Tema Claro/Oscuro** - Interfaz adaptable a preferencias del usuario
- **Diseño Responsive** - Optimizado para móviles, tablets y desktop

### 🔐 Seguridad

- Middleware de autenticación y autorización
- Protección de rutas por tipo de usuario
- Validación de datos en frontend y backend
- Protección contra SQL Injection y XSS
- Gestión segura de sesiones

### 🎨 Interfaz de Usuario

- Diseño moderno con animaciones suaves
- Tema claro/oscuro persistente
- Componentes reutilizables
- Experiencia de usuario intuitiva
- Feedback visual en todas las acciones

---

## 🛠️ Tecnologías

### Backend
- **Laravel 11.x** - Framework PHP
- **PHP 8.2+** - Lenguaje de programación
- **MySQL 8.0+** - Base de datos relacional

### Frontend
- **Blade Templates** - Motor de plantillas de Laravel
- **Bootstrap 5.3** - Framework CSS
- **JavaScript Vanilla** - Interactividad
- **Google Fonts (Inter)** - Tipografía moderna

### Herramientas
- **Composer** - Gestor de dependencias PHP
- **NPM** - Gestor de paquetes JavaScript
- **XAMPP** - Entorno de desarrollo local
- **Git** - Control de versiones

---

## 📦 Requisitos

### Software Necesario

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0
- **Node.js** >= 18.x (opcional, para assets)
- **XAMPP** o servidor web compatible

### Extensiones PHP Requeridas

- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Fileinfo

---

## 🚀 Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/Aventones.git
cd Aventones
```

### 2. Instalar Dependencias

```bash
# Instalar dependencias de PHP
composer install

# (Opcional) Instalar dependencias de Node.js
npm install
```

### 3. Configurar Variables de Entorno

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar Base de Datos

Edita el archivo `.env` con tus credenciales:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aventones
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar Migraciones

```bash
# Crear las tablas en la base de datos
php artisan migrate

# (Opcional) Poblar con datos de prueba
php artisan db:seed
```

### 6. Configurar Storage

```bash
# Crear enlace simbólico para archivos públicos
php artisan storage:link
```

### 7. Iniciar Servidor de Desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

---

## ⚙️ Configuración

### Configuración de Email

Para habilitar notificaciones por correo, configura en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_contraseña_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="Aventones"
```

**Nota**: Para Gmail, necesitas crear una [contraseña de aplicación](https://myaccount.google.com/apppasswords).

### Configuración de Zona Horaria

En `config/app.php`:

```php
'timezone' => 'America/Costa_Rica',
'locale' => 'es',
```

---

## 📖 Uso

### Acceso a la Aplicación

1. **Página Principal**: `http://localhost:8000`
2. **Registro**: `http://localhost:8000/register`
3. **Login**: `http://localhost:8000/login`

### Crear Primer Usuario Administrador

```bash
# Opción 1: Desde la aplicación
# Registrarse normalmente, luego cambiar en la BD:
UPDATE users SET userType = 'admin', state = 'active' WHERE cedula = 'TU_CEDULA';

# Opción 2: Usar Tinker
php artisan tinker
>>> $user = \App\Models\User::find('CEDULA');
>>> $user->userType = 'admin';
>>> $user->state = 'active';
>>> $user->save();
```

---

## 👥 Tipos de Usuario

### 🔵 Usuario Normal (Pasajero)

**Permisos**:
- ✅ Buscar rides disponibles
- ✅ Hacer reservas
- ✅ Ver y cancelar sus reservas
- ✅ Gestionar su perfil

**Restricciones**:
- ❌ No puede crear rides
- ❌ No puede gestionar vehículos
- ❌ No puede acceder a panel de administración

---

### 🟢 Conductor (Driver)

**Permisos**:
- ✅ Todo lo que puede un pasajero
- ✅ Crear y gestionar rides
- ✅ Registrar y gestionar vehículos
- ✅ Aceptar/rechazar/cancelar reservas
- ✅ Ver reservas de sus rides

**Restricciones**:
- ❌ No puede acceder a panel de administración
- ❌ No puede gestionar otros usuarios

---

### 🟡 Administrador (Admin)

**Permisos**:
- ✅ **Acceso completo** a todas las funcionalidades
- ✅ Gestionar usuarios (activar/desactivar)
- ✅ Crear nuevos administradores
- ✅ Ver reportes de búsquedas
- ✅ Exportar datos a CSV
- ✅ Todas las funciones de conductor

---

## 🎯 Funcionalidades Principales

### 1. Gestión de Rides

**Crear Ride**:
- Nombre del viaje
- Origen y destino
- Fecha y hora
- Espacios disponibles
- Precio por espacio
- Vehículo asociado

**Editar/Eliminar**:
- Solo el conductor propietario puede modificar
- Validación de capacidad del vehículo

---

### 2. Sistema de Reservas

**Flujo de Reserva**:
1. Pasajero busca ride disponible
2. Solicita reserva (estado: `pending`)
3. Conductor recibe notificación
4. Conductor acepta/rechaza (estado: `confirmed`/`rejected`)
5. Ambos pueden cancelar (estado: `cancelled`)

**Características**:
- Cancelación flexible (incluso después de aceptar)
- Restauración automática de disponibilidad
- Notificaciones por email
- Historial completo

---

### 3. Gestión de Vehículos

**Información del Vehículo**:
- Número de placa (único)
- Marca y modelo
- Color y año
- Capacidad (1-4 pasajeros)
- Foto del vehículo

**Validaciones**:
- Placa única por vehículo
- Capacidad máxima de 4 pasajeros
- Solo el propietario puede modificar

---

### 4. Búsqueda de Rides

**Filtros Disponibles**:
- 📍 Origen
- 🎯 Destino
- 📅 Fecha

**Características**:
- Búsqueda en tiempo real
- Registro automático de búsquedas
- Resultados ordenados por fecha/hora

---

### 5. Reportes de Búsquedas (Solo Admin)

**Información Disponible**:
- Total de búsquedas realizadas
- Promedio de resultados por búsqueda
- Búsquedas por usuario
- Tendencias de rutas populares

**Funcionalidades**:
- Filtros por rango de fechas
- Exportación a CSV
- Estadísticas visuales
- Indicadores de color por resultados

---

### 6. Notificaciones Automáticas

**Sistema de Alertas**:
- Email a conductores sobre reservas pendientes
- Configurable por tiempo (minutos)
- Resumen de múltiples reservas
- Información detallada del pasajero

**Comando**:
```bash
php artisan bookings:notify-pending 30
```

---

## 📁 Estructura del Proyecto

```
Aventones/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── NotifyPendingBookings.php    # Comando de notificaciones
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BookingsController.php       # Gestión de reservas
│   │   │   ├── LoginController.php          # Autenticación
│   │   │   ├── ReportsController.php        # Reportes
│   │   │   ├── RidesController.php          # Gestión de rides
│   │   │   ├── UserController.php           # Gestión de usuarios
│   │   │   └── VehicleController.php        # Gestión de vehículos
│   │   └── Middleware/
│   │       ├── AdminOnly.php                # Protección admin
│   │       └── DriverOnly.php               # Protección conductor
│   ├── Mail/
│   │   └── PendingBookingsNotification.php  # Email de notificaciones
│   └── Models/
│       ├── Bookings.php                     # Modelo de reservas
│       ├── Movement.php                     # Modelo de búsquedas
│       ├── Ride.php                         # Modelo de rides
│       ├── User.php                         # Modelo de usuarios
│       └── Vehicle.php                      # Modelo de vehículos
├── database/
│   └── migrations/                          # Migraciones de BD
├── public/
│   ├── css/                                 # Estilos CSS
│   └── js/                                  # Scripts JavaScript
├── resources/
│   └── views/
│       ├── Admin/                           # Vistas de admin
│       ├── Bookings/                        # Vistas de reservas
│       ├── Drivers/                         # Vistas de vehículos
│       ├── Mail/                            # Plantillas de email
│       ├── Reports/                         # Vistas de reportes
│       ├── Rides/                           # Vistas de rides
│       ├── Users/                           # Vistas de usuarios
│       └── Welcome.blade.php                # Página principal
├── routes/
│   └── web.php                              # Definición de rutas
├── .env.example                             # Ejemplo de configuración
├── composer.json                            # Dependencias PHP
└── README.md                                # Este archivo
```

---

## 🔧 Comandos Artisan

### Comandos Personalizados

```bash
# Notificar sobre reservas pendientes (30 min por defecto)
php artisan bookings:notify-pending

# Notificar con tiempo personalizado
php artisan bookings:notify-pending 15
```

### Comandos de Laravel

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ver rutas
php artisan route:list

# Crear migración
php artisan make:migration create_table_name

# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Crear controlador
php artisan make:controller ControllerName

# Crear modelo
php artisan make:model ModelName

# Crear middleware
php artisan make:middleware MiddlewareName
```

---

## 📚 Documentación

El proyecto incluye documentación detallada en archivos Markdown:

- **`COMO_EJECUTAR_SCRIPT.md`** - Guía para ejecutar comandos Artisan
- **`FIX_CANCELACION.md`** - Solución de problemas de cancelación
- **`IMPLEMENTACION_COMPLETA.md`** - Resumen de implementación de reportes
- **`NAVEGACION_MEJORADA.md`** - Sistema de navegación adaptativa
- **`PERMISOS_USUARIOS.md`** - Sistema de permisos por tipo de usuario
- **`PROTECCION_ADMIN.md`** - Protección de rutas administrativas
- **`REPORTES_BUSQUEDAS.md`** - Sistema de reportes de búsquedas
- **`REPORTES_RESUMEN.md`** - Resumen rápido de reportes
- **`VERIFICACION_REPORTES.md`** - Checklist de verificación

---

## 🎨 Capturas de Pantalla

### Página Principal
![Búsqueda de Rides](docs/screenshots/home.png)

### Panel de Conductor
![Gestión de Rides](docs/screenshots/rides.png)

### Sistema de Reservas
![Reservas](docs/screenshots/bookings.png)

### Panel de Administración
![Admin Panel](docs/screenshots/admin.png)

---

## 🧪 Testing

### Ejecutar Tests

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests específicos
php artisan test --filter TestName

# Ejecutar con cobertura
php artisan test --coverage
```

---

## 🚀 Despliegue

### Preparación para Producción

```bash
# Optimizar autoload
composer install --optimize-autoloader --no-dev

# Cachear configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compilar assets
npm run build
```

### Variables de Entorno (Producción)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Configurar base de datos de producción
DB_CONNECTION=mysql
DB_HOST=tu-servidor-db
DB_PORT=3306
DB_DATABASE=aventones_prod
DB_USERNAME=usuario_prod
DB_PASSWORD=contraseña_segura
```

---

## 🤝 Contribución

¡Las contribuciones son bienvenidas! Si deseas contribuir:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### Guías de Contribución

- Sigue las convenciones de código de Laravel
- Escribe tests para nuevas funcionalidades
- Actualiza la documentación según sea necesario
- Usa commits descriptivos

---

## 🐛 Reportar Bugs

Si encuentras un bug, por favor:

1. Verifica que no esté ya reportado en [Issues](https://github.com/tu-usuario/Aventones/issues)
2. Crea un nuevo issue con:
   - Descripción clara del problema
   - Pasos para reproducirlo
   - Comportamiento esperado vs actual
   - Screenshots si es posible
   - Información del entorno (PHP, Laravel, etc.)

---

## 📝 Changelog

### [1.0.0] - 2025-12-11

#### Agregado
- Sistema completo de autenticación con roles
- Gestión de rides y vehículos
- Sistema de reservas con cancelación flexible
- Reportes de búsquedas para administradores
- Notificaciones automáticas por email
- Tema claro/oscuro
- Navegación adaptativa por tipo de usuario
- Protección de rutas con middleware
- Documentación completa

#### Mejorado
- Interfaz de usuario moderna y responsive
- Validaciones en frontend y backend
- Experiencia de usuario optimizada
- Seguridad con múltiples capas de protección

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 👨‍💻 Autores

- **Tu Nombre** - *Desarrollo Principal* - [GitHub](https://github.com/tu-usuario)

---

## 🙏 Agradecimientos

- Laravel Framework
- Bootstrap Team
- Google Fonts
- Comunidad de desarrolladores

---

## 📞 Contacto

- **Email**: tu-email@example.com
- **GitHub**: [@tu-usuario](https://github.com/tu-usuario)
- **LinkedIn**: [Tu Perfil](https://linkedin.com/in/tu-perfil)

---

## 🔗 Enlaces Útiles

- [Documentación de Laravel](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

<div align="center">

**Hecho con ❤️ usando Laravel**

⭐ Si te gusta este proyecto, dale una estrella en GitHub!

</div>

# 🚀 Guía de Ejecución - Script de Notificaciones

## 📍 UBICACIÓN Y NAVEGACIÓN

### Paso 1: Abrir la Terminal

**En Windows**:
1. Presiona `Win + R`
2. Escribe `cmd` o `powershell`
3. Presiona Enter

O simplemente:
- Abre **PowerShell** o **CMD** desde el menú de inicio

---

### Paso 2: Navegar al Directorio del Proyecto

```bash
cd C:\xampp\htdocs\Aventones
```

**Verificar que estás en el directorio correcto**:
```bash
dir
```

Deberías ver archivos como:
- `artisan`
- `composer.json`
- `package.json`
- Carpetas: `app`, `resources`, `routes`, etc.

---

## ⚡ EJECUTAR EL SCRIPT

### Comando Básico (30 minutos por defecto):

```bash
php artisan bookings:notify-pending
```

**Esto enviará notificaciones de reservas pendientes con más de 30 minutos.**

---

### Comando con Tiempo Personalizado:

```bash
# Para 15 minutos
php artisan bookings:notify-pending 15

# Para 60 minutos (1 hora)
php artisan bookings:notify-pending 60

# Para 5 minutos (pruebas)
php artisan bookings:notify-pending 5
```

---

## 📋 EJEMPLO COMPLETO PASO A PASO

### Opción 1: PowerShell (Recomendado)

```powershell
# 1. Abrir PowerShell

# 2. Navegar al proyecto
cd C:\xampp\htdocs\Aventones

# 3. Verificar ubicación
pwd
# Debería mostrar: C:\xampp\htdocs\Aventones

# 4. Ejecutar el script
php artisan bookings:notify-pending

# O con tiempo personalizado
php artisan bookings:notify-pending 15
```

---

### Opción 2: CMD (Símbolo del Sistema)

```cmd
:: 1. Abrir CMD

:: 2. Navegar al proyecto
cd C:\xampp\htdocs\Aventones

:: 3. Verificar ubicación
cd
:: Debería mostrar: C:\xampp\htdocs\Aventones

:: 4. Ejecutar el script
php artisan bookings:notify-pending

:: O con tiempo personalizado
php artisan bookings:notify-pending 15
```

---

## 📊 SALIDA ESPERADA

Cuando ejecutes el comando, verás algo como esto:

```
Buscando reservas pendientes con más de 30 minutos...
Se encontraron 3 reservas pendientes.
✓ Email enviado a Juan Pérez (juan@example.com) - 2 reserva(s)
✓ Email enviado a María López (maria@example.com) - 1 reserva(s)

========== RESUMEN ==========
Total de reservas pendientes: 3
Emails enviados exitosamente: 2
============================
```

---

## 🔍 CASOS ESPECIALES

### Caso 1: No Hay Reservas Pendientes

```
Buscando reservas pendientes con más de 30 minutos...
No se encontraron reservas pendientes.
```

**Esto es normal** si no hay reservas antiguas.

---

### Caso 2: Error de PHP

```
'php' no se reconoce como un comando interno o externo...
```

**Solución**: Agregar PHP al PATH o usar la ruta completa:

```bash
C:\xampp\php\php.exe artisan bookings:notify-pending
```

---

### Caso 3: Error de Artisan

```
Could not open input file: artisan
```

**Solución**: No estás en el directorio correcto. Navega a:

```bash
cd C:\xampp\htdocs\Aventones
```

---

## 🛠️ VERIFICAR REQUISITOS

### Antes de ejecutar, verifica:

#### 1. **XAMPP está corriendo**
- Apache: ✅ Activo
- MySQL: ✅ Activo

#### 2. **Configuración de Email (.env)**
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

#### 3. **Base de datos tiene datos**
- Tabla `bookings` con reservas pendientes
- Tabla `users` con conductores

---

## 🧪 PRUEBAS

### Prueba 1: Ver Ayuda del Comando

```bash
php artisan bookings:notify-pending --help
```

**Salida esperada**:
```
Description:
  Notifica a los choferes sobre solicitudes de reserva pendientes...

Usage:
  bookings:notify-pending [<minutes>]

Arguments:
  minutes    Número de minutos desde la creación [default: "30"]
```

---

### Prueba 2: Listar Todos los Comandos

```bash
php artisan list
```

Busca en la lista:
```
bookings
  bookings:notify-pending    Notifica a los choferes sobre solicitudes...
```

---

### Prueba 3: Ejecutar con 1 Minuto (Para Pruebas)

```bash
php artisan bookings:notify-pending 1
```

**Esto notificará sobre TODAS las reservas pendientes** (útil para probar).

---

## 📅 AUTOMATIZACIÓN (Opcional)

### Windows Task Scheduler

Si quieres que se ejecute automáticamente cada hora:

#### 1. Crear archivo `.bat`:

**Archivo**: `C:\xampp\htdocs\Aventones\notify-bookings.bat`

```batch
@echo off
cd C:\xampp\htdocs\Aventones
C:\xampp\php\php.exe artisan bookings:notify-pending 30
```

#### 2. Programar en Task Scheduler:

1. Abre **Programador de tareas** (Task Scheduler)
2. Clic en "Crear tarea básica"
3. Nombre: "Notificar Reservas Pendientes"
4. Desencadenador: Diariamente o cada hora
5. Acción: Iniciar programa
6. Programa: `C:\xampp\htdocs\Aventones\notify-bookings.bat`

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### Problema 1: "Class 'App\Models\Bookings' not found"

**Solución**:
```bash
composer dump-autoload
```

---

### Problema 2: "SQLSTATE[HY000] [2002] No connection"

**Solución**:
- Verifica que MySQL esté corriendo en XAMPP
- Verifica la configuración en `.env`:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=aventones
  ```

---

### Problema 3: "Swift_TransportException"

**Solución**:
- Verifica la configuración de email en `.env`
- Asegúrate de usar una contraseña de aplicación (no tu contraseña normal)
- Para Gmail: https://myaccount.google.com/apppasswords

---

## 📝 COMANDOS ÚTILES

### Ver logs de Laravel:
```bash
# Ver últimas líneas del log
Get-Content storage\logs\laravel.log -Tail 50
```

### Limpiar caché:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Ver todas las reservas pendientes (SQL):
```bash
php artisan tinker
```
Luego en tinker:
```php
\App\Models\Bookings::where('status', 'pending')->get();
exit
```

---

## ✅ CHECKLIST RÁPIDO

Antes de ejecutar:
- [ ] Estoy en `C:\xampp\htdocs\Aventones`
- [ ] XAMPP está corriendo (Apache + MySQL)
- [ ] Configuración de email en `.env` está correcta
- [ ] Hay reservas pendientes en la base de datos

Ejecutar:
```bash
php artisan bookings:notify-pending
```

---

## 🎯 RESUMEN RÁPIDO

### Pasos Mínimos:

1. **Abrir PowerShell/CMD**
2. **Navegar**:
   ```bash
   cd C:\xampp\htdocs\Aventones
   ```
3. **Ejecutar**:
   ```bash
   php artisan bookings:notify-pending
   ```

¡Eso es todo! 🎉

---

## 📞 ¿NECESITAS AYUDA?

Si encuentras algún error:

1. **Copia el mensaje de error completo**
2. **Verifica que XAMPP esté corriendo**
3. **Revisa el archivo** `storage/logs/laravel.log`
4. **Pregúntame** con el error específico

---

**Creado**: 11 de Diciembre, 2025  
**Proyecto**: Aventones  
**Comando**: `php artisan bookings:notify-pending`

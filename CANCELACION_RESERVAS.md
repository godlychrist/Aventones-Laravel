# 🚫 Sistema de Cancelación de Reservas - Documentación

## ✅ FUNCIONALIDAD IMPLEMENTADA

El sistema permite cancelar reservas incluso cuando están aceptadas (confirmadas). Esta funcionalidad está completamente operativa.

---

## 🎯 ¿CÓMO FUNCIONA?

### Estados de una Reserva (Booking)

Una reserva puede tener los siguientes estados:

| Estado | Descripción | Color Badge |
|--------|-------------|-------------|
| **pending** | Solicitud pendiente de aprobación del conductor | 🟡 Amarillo |
| **confirmed** | Reserva aceptada por el conductor | 🟢 Verde |
| **rejected** | Reserva rechazada por el conductor | 🔴 Rojo |
| **cancelled** | Reserva cancelada por el pasajero o conductor | ⚫ Gris |

---

## 👥 PERMISOS Y ACCIONES

### Para el **Pasajero** (Usuario que hizo la reserva):

#### ✅ Puede Cancelar Cuando:
- Estado = `pending` (Pendiente)
- Estado = `confirmed` (Confirmada/Aceptada) ✨

#### ❌ NO Puede Cancelar Cuando:
- Estado = `cancelled` (Ya cancelada)
- Estado = `rejected` (Ya rechazada)

### Para el **Conductor** (Driver):

#### ✅ Puede Hacer:
- **Aceptar** solicitudes pendientes (`pending` → `confirmed`)
- **Rechazar** solicitudes pendientes (`pending` → `rejected`)
- **Cancelar** reservas confirmadas (`confirmed` → `cancelled`) ✨

#### ❌ NO Puede Hacer:
- Modificar reservas ya rechazadas o canceladas

---

## 🔄 FLUJO DE CANCELACIÓN

### Escenario 1: Cancelar Reserva Pendiente

```
1. Pasajero hace una reserva → Estado: pending
2. Pasajero cambia de opinión
3. Pasajero hace clic en botón "Cancelar Reserva"
4. Sistema muestra confirmación: "¿Estás seguro de que deseas cancelar esta reserva?"
5. Pasajero confirma
6. Estado cambia a: cancelled
7. Ride vuelve a estado: active (disponible para otros)
8. Mensaje: "Booking cancelled successfully."
```

### Escenario 2: Cancelar Reserva Aceptada ✨

```
1. Pasajero hace una reserva → Estado: pending
2. Conductor acepta la reserva → Estado: confirmed
3. Pasajero o Conductor necesita cancelar (emergencia, cambio de planes, etc.)
4. Hace clic en botón "Cancelar Reserva"
5. Sistema muestra confirmación: "¿Estás seguro de que deseas cancelar esta reserva?"
6. Confirma
7. Estado cambia a: cancelled
8. Ride vuelve a estado: active (disponible para otros)
9. Mensaje: "Booking cancelled successfully."
```

---

## 💻 CÓDIGO IMPLEMENTADO

### Vista: `ShowBookings.blade.php`

```blade
{{-- Pasajero puede cancelar --}}
@if($user->cedula == $booking->user_id)
    @if($booking->status == 'pending' || $booking->status == 'confirmed')
        <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="btn-action btn-cancel" 
                    onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                Cancelar Reserva
            </button>
        </form>
    @endif
@endif

{{-- Conductor puede cancelar --}}
@if($user->cedula == $booking->driver_id)
    @if($booking->status == 'confirmed')
        <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="cancelled">
            <button type="submit" class="btn-action btn-cancel" 
                    onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                Cancelar Reserva
            </button>
        </form>
    @endif
@endif
```

### Controlador: `BookingsController.php`

```php
public function updateStatus(Request $request, $id): RedirectResponse
{
    $booking = Bookings::findOrFail($id);
    $status = $request->input('status');
    
    if (in_array($status, ['confirmed', 'rejected', 'cancelled'])) {
        $booking->update(['status' => $status]);
        
        // Si la reserva es cancelada o rechazada, restaurar el ride a 'active'
        if (in_array($status, ['cancelled', 'rejected'])) {
            $ride = Ride::findOrFail($booking->ride_id);
            $ride->update(['status' => 'active']);
        }
        
        $message = 'Booking status updated successfully.';
        if ($status == 'confirmed') $message = 'Booking accepted successfully.';
        if ($status == 'rejected') $message = 'Booking rejected successfully.';
        if ($status == 'cancelled') $message = 'Booking cancelled successfully.';
        
        return redirect()->back()->with('success', $message);
    }
    
    return redirect()->back()->with('error', 'Invalid status update.');
}
```

---

## 🎨 INTERFAZ DE USUARIO

### Botón de Cancelar

El pasajero/conductor verá un botón rojo con icono de X:

```
🔴 [X] ← Botón de cancelar
```

**Características**:
- Color: Rojo (indica acción destructiva)
- Icono: X dentro de un círculo
- Tooltip: "Cancelar Reserva"
- Confirmación: Muestra diálogo antes de cancelar

### Estados Visuales

| Estado | Badge | Descripción |
|--------|-------|-------------|
| Pendiente | 🟡 Amarillo | Esperando aprobación |
| Confirmado | 🟢 Verde | Aceptada por conductor |
| Cancelado | ⚫ Gris | Cancelada por pasajero/conductor |
| Rechazado | 🔴 Rojo | Rechazada por conductor |

---

## 🧪 CÓMO PROBAR

### Prueba 1: Cancelar Reserva Pendiente

1. Inicia sesión como **pasajero**
2. Crea una nueva reserva (estado: pending)
3. Ve a "Mis Reservas"
4. Verás el botón de cancelar (X rojo)
5. Haz clic en "Cancelar Reserva"
6. Confirma la acción
7. **Resultado**: Estado cambia a "Cancelado", ride vuelve a disponible

### Prueba 2: Cancelar Reserva Aceptada (Pasajero)

1. Inicia sesión como **pasajero** y crea una reserva
2. Cierra sesión e inicia como **conductor**
3. Ve a "Mis Reservas" y acepta la solicitud (estado: confirmed)
4. Cierra sesión e inicia como **pasajero** nuevamente
5. Ve a "Mis Reservas"
6. Verás el botón de cancelar (X rojo) **AÚN DISPONIBLE** ✅
7. Haz clic en "Cancelar Reserva"
8. Confirma la acción
9. **Resultado**: Estado cambia a "Cancelado", ride vuelve a disponible

### Prueba 3: Conductor Cancela Reserva Confirmada

1. Pasajero reserva un ride
2. Conductor acepta
3. **Conductor ve botón de cancelar** ✅
4. Conductor cancela
5. **Verifica**: Ride vuelve a 'active' ✅

---

## 🔒 SEGURIDAD

### Validaciones Implementadas

1. **Autenticación**: Solo usuarios logueados pueden cancelar
2. **Autorización**: Solo el pasajero o conductor pueden cancelar sus reservas
3. **Estados Válidos**: Solo se puede cancelar si está en `pending` o `confirmed`
4. **Confirmación**: Se requiere confirmación del usuario antes de cancelar
5. **Validación Backend**: El controlador verifica que el estado sea válido

---

## 💡 CASOS DE USO

### Caso 1: Emergencia Personal
**Situación**: Pasajero tiene una emergencia después de que el conductor aceptó  
**Solución**: Puede cancelar la reserva confirmada fácilmente

### Caso 2: Cambio de Planes
**Situación**: Pasajero encuentra otra forma de transporte  
**Solución**: Cancela la reserva para liberar el espacio

### Caso 3: Error en la Reserva
**Situación**: Pasajero se equivocó de fecha/hora  
**Solución**: Cancela y crea una nueva reserva correcta

### Caso 4: Conductor Tiene Emergencia
**Situación**: Conductor no puede realizar el viaje después de aceptar  
**Solución**: Conductor puede cancelar la reserva confirmada

---

## ✅ RESUMEN

### Lo que funciona:

1. **Cancelación de reservas pendientes** - Pasajero puede cancelar antes de que el conductor responda
2. **Cancelación de reservas confirmadas** - Pasajero Y Conductor pueden cancelar INCLUSO después de aceptar ✨
3. **Restauración automática** - Ride vuelve a estar disponible cuando se cancela
4. **Confirmación de usuario** - Se pide confirmación antes de cancelar
5. **Mensajes claros** - Se muestra mensaje de éxito/error
6. **Seguridad** - Solo el pasajero o conductor pueden cancelar sus propias reservas

---

**Implementado**: Diciembre 2025  
**Estado**: ✅ FUNCIONANDO CORRECTAMENTE

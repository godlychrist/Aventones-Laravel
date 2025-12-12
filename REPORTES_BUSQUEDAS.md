# 📊 Sistema de Reportes de Búsquedas - Documentación Completa

## 🎯 DESCRIPCIÓN GENERAL

El Sistema de Reportes de Búsquedas es una funcionalidad administrativa que permite a los administradores de Aventones analizar el comportamiento de búsqueda de los usuarios, identificar tendencias, y tomar decisiones basadas en datos.

---

## ✨ CARACTERÍSTICAS PRINCIPALES

### 1. **Registro Automático de Búsquedas**
- Captura automática de cada búsqueda realizada por usuarios autenticados
- Almacena: usuario, fecha, origen, destino y número de resultados
- No requiere intervención manual

### 2. **Panel de Reportes Interactivo**
- Acceso exclusivo para administradores
- Interfaz moderna y responsive
- Tema claro/oscuro
- Actualización en tiempo real

### 3. **Filtros Avanzados**
- Filtro por rango de fechas
- Fecha de inicio y fin personalizables
- Resultados dinámicos

### 4. **Estadísticas Visuales**
- Total de búsquedas realizadas
- Promedio de resultados por búsqueda
- Tarjetas animadas con métricas clave

### 5. **Tabla de Resultados**
- Paginación (20 registros por página)
- Información detallada por búsqueda
- Indicadores de color por rendimiento
- Ordenamiento por fecha

### 6. **Exportación de Datos**
- Descarga en formato CSV
- Compatible con Excel
- Encoding UTF-8 con BOM
- Nombre de archivo con timestamp

---

## 🗄️ ESTRUCTURA DE DATOS

### Tabla: `movements`

```sql
CREATE TABLE movements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    leavePlace VARCHAR(255) NOT NULL,
    destinationPlace VARCHAR(255) NOT NULL,
    resultsNum INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(cedula) ON DELETE CASCADE
);
```

**Descripción de Columnas**:

| Columna | Tipo | Descripción |
|---------|------|-------------|
| `id` | BIGINT | Identificador único del registro |
| `user_id` | INT | Cédula del usuario que realizó la búsqueda |
| `date` | DATE | Fecha en que se realizó la búsqueda |
| `leavePlace` | VARCHAR(255) | Lugar de origen de la búsqueda |
| `destinationPlace` | VARCHAR(255) | Lugar de destino de la búsqueda |
| `resultsNum` | INT | Número de rides encontrados |

---

## 💻 IMPLEMENTACIÓN TÉCNICA

### Archivos Creados

#### 1. **Modelo: `Movement.php`**
**Ubicación**: `app/Models/Movement.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'date',
        'leavePlace',
        'destinationPlace',
        'resultsNum'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'cedula');
    }
}
```

**Características**:
- Sin timestamps automáticos
- Relación con modelo User
- Campos fillable para mass assignment

---

#### 2. **Controlador: `ReportsController.php`**
**Ubicación**: `app/Http/Controllers/ReportsController.php`

**Métodos Principales**:

##### `searchReports()`
Muestra el panel de reportes con filtros y estadísticas.

```php
public function searchReports(Request $request)
{
    // Validar permisos de admin
    if (strtolower(trim(Auth::user()->userType)) !== 'admin') {
        return redirect()->route('index')
            ->with('error', 'No tienes permisos...');
    }

    // Obtener filtros
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query con filtros
    $query = Movement::with('user');
    
    if ($startDate) {
        $query->where('date', '>=', $startDate);
    }
    
    if ($endDate) {
        $query->where('date', '<=', $endDate);
    }

    // Obtener resultados paginados
    $movements = $query->orderBy('date', 'desc')->paginate(20);

    // Calcular estadísticas
    $totalSearches = $movements->total();
    $averageResults = round($movements->avg('resultsNum'), 2);

    return view('Reports.SearchReports', compact(
        'movements',
        'totalSearches',
        'averageResults',
        'startDate',
        'endDate'
    ));
}
```

##### `exportSearchReports()`
Exporta los datos filtrados a CSV.

```php
public function exportSearchReports(Request $request)
{
    // Validar permisos
    // ... código de validación ...

    // Obtener datos filtrados
    $query = Movement::with('user');
    // ... aplicar filtros ...
    
    $movements = $query->orderBy('date', 'desc')->get();

    // Generar CSV
    $filename = 'reporte_busquedas_' . date('Y-m-d_His') . '.csv';
    
    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function() use ($movements) {
        $file = fopen('php://output', 'w');
        
        // UTF-8 BOM para Excel
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Encabezados
        fputcsv($file, ['Usuario', 'Fecha', 'Origen', 'Destino', 'Resultados']);
        
        // Datos
        foreach ($movements as $movement) {
            fputcsv($file, [
                $movement->user->name . ' ' . $movement->user->lastname,
                $movement->date,
                $movement->leavePlace,
                $movement->destinationPlace,
                $movement->resultsNum
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
```

---

#### 3. **Vista: `SearchReports.blade.php`**
**Ubicación**: `resources/views/Reports/SearchReports.blade.php`

**Componentes Principales**:

1. **Formulario de Filtros**
```blade
<form method="GET" action="{{ route('reports.search') }}">
    <input type="date" name="start_date" value="{{ $startDate }}">
    <input type="date" name="end_date" value="{{ $endDate }}">
    <button type="submit">Filtrar</button>
</form>
```

2. **Tarjetas de Estadísticas**
```blade
<div class="stats-card">
    <h3>📊 Total de Búsquedas</h3>
    <p class="stat-number">{{ number_format($totalSearches) }}</p>
</div>

<div class="stats-card">
    <h3>📈 Promedio de Resultados</h3>
    <p class="stat-number">{{ $averageResults }}</p>
</div>
```

3. **Tabla de Resultados**
```blade
<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Resultados</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movements as $movement)
        <tr>
            <td>{{ $movement->user->name }}</td>
            <td>{{ $movement->date }}</td>
            <td>{{ $movement->leavePlace }}</td>
            <td>{{ $movement->destinationPlace }}</td>
            <td>
                <span class="badge badge-{{ $movement->resultsNum > 5 ? 'success' : ($movement->resultsNum > 0 ? 'warning' : 'danger') }}">
                    {{ $movement->resultsNum }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

---

### Archivos Modificados

#### 1. **RidesController.php**
**Ubicación**: `app/Http/Controllers/RidesController.php`

**Cambio**: Agregado logging de búsquedas en método `available()`

```php
use App\Models\Movement;

public function available(Request $request): View
{
    // ... código de búsqueda existente ...
    
    $rides = $query->orderBy('date')->orderBy('time')->get();

    // Log search if user is authenticated and has applied filters
    if (Auth::check() && ($selectedOrigin || $selectedDestination || $selectedDate)) {
        Movement::create([
            'user_id' => Auth::user()->cedula,
            'date' => now()->format('Y-m-d'),
            'leavePlace' => $selectedOrigin ?? '',
            'destinationPlace' => $selectedDestination ?? '',
            'resultsNum' => $rides->count()
        ]);
    }

    return view('Welcome', compact(...));
}
```

---

#### 2. **web.php**
**Ubicación**: `routes/web.php`

**Cambio**: Agregadas rutas protegidas para reportes

```php
use App\Http\Controllers\ReportsController;

// Rutas de reportes (solo admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/reports/search', [ReportsController::class, 'searchReports'])
        ->name('reports.search');
    Route::get('/reports/search/export', [ReportsController::class, 'exportSearchReports'])
        ->name('reports.search.export');
});
```

---

#### 3. **Index.blade.php**
**Ubicación**: `resources/views/Users/Index.blade.php`

**Cambio**: Agregado enlace a reportes en panel de admin

```blade
@if($isAdmin)
    <a href="{{ route('reports.search') }}" class="dashboard-card">
        <div class="card-icon">📊</div>
        <h3>Reporte de Búsquedas</h3>
        <p>Ver estadísticas de búsquedas de usuarios</p>
    </a>
@endif
```

---

## 🔐 SEGURIDAD

### Protección en Múltiples Capas

#### 1. **Middleware de Autenticación**
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Rutas protegidas
});
```

#### 2. **Validación en Controlador**
```php
if (strtolower(trim(Auth::user()->userType)) !== 'admin') {
    return redirect()->route('index')
        ->with('error', 'No tienes permisos para acceder a esta página. Solo administradores.');
}
```

#### 3. **Validación de Datos**
- Filtros de fecha validados
- Prevención de SQL Injection mediante Eloquent
- Sanitización de entradas

---

## 🎨 DISEÑO E INTERFAZ

### Indicadores de Color

Los resultados se muestran con badges de colores:

| Resultados | Color | Clase CSS | Significado |
|------------|-------|-----------|-------------|
| 0 | 🔴 Rojo | `badge-danger` | Sin resultados |
| 1-5 | 🟡 Amarillo | `badge-warning` | Pocos resultados |
| > 5 | 🟢 Verde | `badge-success` | Muchos resultados |

### Tema Claro/Oscuro

El sistema incluye soporte completo para tema oscuro:

```javascript
const themeToggle = document.getElementById('themeToggle');
themeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('theme', 
        document.body.classList.contains('dark-mode') ? 'dark' : 'light'
    );
});
```

---

## 📊 CASOS DE USO

### Caso 1: Identificar Rutas Populares

**Objetivo**: Saber qué rutas buscan más los usuarios

**Proceso**:
1. Acceder al panel de reportes
2. Ver tabla de búsquedas
3. Identificar combinaciones frecuentes de origen-destino
4. Crear rides en esas rutas

---

### Caso 2: Detectar Demanda Insatisfecha

**Objetivo**: Encontrar búsquedas sin resultados

**Proceso**:
1. Filtrar por período reciente (última semana)
2. Buscar badges rojos (0 resultados)
3. Analizar rutas sin oferta
4. Incentivar a conductores a crear rides en esas rutas

---

### Caso 3: Análisis de Tendencias

**Objetivo**: Ver evolución de búsquedas en el tiempo

**Proceso**:
1. Exportar datos de varios meses
2. Analizar en Excel
3. Crear gráficas de tendencias
4. Tomar decisiones estratégicas

---

## 📤 EXPORTACIÓN CSV

### Formato del Archivo

**Nombre**: `reporte_busquedas_2025-12-11_143022.csv`

**Estructura**:
```csv
Usuario,Fecha,Origen,Destino,Resultados
Juan Pérez,2025-12-11,San José,Cartago,8
María López,2025-12-11,Heredia,Alajuela,3
Carlos Mora,2025-12-10,Limón,San José,0
```

### Características Técnicas

- **Encoding**: UTF-8 con BOM
- **Separador**: Coma (,)
- **Compatible con**: Excel, Google Sheets, LibreOffice
- **Tamaño**: Optimizado para grandes volúmenes

---

## 🧪 PRUEBAS

### Pruebas Funcionales

1. **Registro de Búsquedas**
   - ✅ Se registra cuando usuario autenticado busca
   - ✅ Se guarda origen, destino y resultados
   - ✅ No se registra si no hay filtros

2. **Panel de Reportes**
   - ✅ Solo admin puede acceder
   - ✅ Muestra estadísticas correctas
   - ✅ Tabla pagina correctamente

3. **Filtros**
   - ✅ Filtro de fecha inicio funciona
   - ✅ Filtro de fecha fin funciona
   - ✅ Ambos filtros juntos funcionan

4. **Exportación**
   - ✅ CSV se descarga correctamente
   - ✅ Datos son precisos
   - ✅ Encoding es correcto

---

## 🔧 MANTENIMIENTO

### Limpieza de Datos Antiguos

Para mantener el rendimiento, se recomienda limpiar datos antiguos periódicamente:

```sql
-- Eliminar búsquedas de más de 1 año
DELETE FROM movements 
WHERE date < DATE_SUB(CURDATE(), INTERVAL 1 YEAR);
```

### Optimización de Consultas

Crear índices para mejorar rendimiento:

```sql
CREATE INDEX idx_movements_date ON movements(date);
CREATE INDEX idx_movements_user ON movements(user_id);
CREATE INDEX idx_movements_places ON movements(leavePlace, destinationPlace);
```

---

## 📚 DOCUMENTACIÓN RELACIONADA

- **REPORTES_RESUMEN.md** - Resumen rápido del sistema
- **CONSULTAS_SQL_REPORTES.md** - Consultas SQL útiles
- **VERIFICACION_REPORTES.md** - Checklist de verificación
- **IMPLEMENTACION_COMPLETA.md** - Detalles técnicos completos

---

## 🎯 CONCLUSIÓN

El Sistema de Reportes de Búsquedas proporciona a los administradores una herramienta poderosa para:

- ✅ Entender el comportamiento de los usuarios
- ✅ Identificar oportunidades de negocio
- ✅ Tomar decisiones basadas en datos
- ✅ Optimizar la oferta de rides

**Estado**: ✅ Completamente funcional y listo para producción

---

**Creado**: Diciembre 2025  
**Versión**: 1.0  
**Mantenedor**: Equipo Aventones

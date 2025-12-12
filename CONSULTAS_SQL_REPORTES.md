# 📊 Consultas SQL Útiles para Reportes - Aventones

Esta guía contiene consultas SQL útiles para analizar los datos de búsquedas y generar insights sobre el comportamiento de los usuarios.

---

## 📋 TABLA DE CONTENIDOS

1. [Consultas Básicas](#consultas-básicas)
2. [Análisis de Tendencias](#análisis-de-tendencias)
3. [Consultas de Usuarios](#consultas-de-usuarios)
4. [Consultas de Rutas](#consultas-de-rutas)
5. [Consultas de Mantenimiento](#consultas-de-mantenimiento)

---

## 🔍 CONSULTAS BÁSICAS

### 1. Ver todas las búsquedas

```sql
SELECT 
    m.id,
    m.date AS fecha_busqueda,
    u.name AS usuario,
    u.cedula,
    m.leavePlace AS origen,
    m.destinationPlace AS destino,
    m.resultsNum AS resultados
FROM movements m
LEFT JOIN users u ON m.user_id = u.cedula
ORDER BY m.date DESC
LIMIT 100;
```

---

### 2. Total de búsquedas por día

```sql
SELECT 
    DATE(date) AS fecha,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados
FROM movements
GROUP BY DATE(date)
ORDER BY fecha DESC;
```

---

### 3. Búsquedas sin resultados

```sql
SELECT 
    m.date,
    u.name AS usuario,
    m.leavePlace AS origen,
    m.destinationPlace AS destino
FROM movements m
LEFT JOIN users u ON m.user_id = u.cedula
WHERE m.resultsNum = 0
ORDER BY m.date DESC;
```

---

## 📈 ANÁLISIS DE TENDENCIAS

### 4. Rutas más buscadas

```sql
SELECT 
    CONCAT(leavePlace, ' → ', destinationPlace) AS ruta,
    COUNT(*) AS veces_buscada,
    AVG(resultsNum) AS promedio_resultados,
    SUM(CASE WHEN resultsNum = 0 THEN 1 ELSE 0 END) AS busquedas_sin_resultado
FROM movements
WHERE leavePlace IS NOT NULL 
  AND leavePlace != ''
  AND destinationPlace IS NOT NULL 
  AND destinationPlace != ''
GROUP BY leavePlace, destinationPlace
ORDER BY veces_buscada DESC
LIMIT 20;
```

---

### 5. Orígenes más populares

```sql
SELECT 
    leavePlace AS origen,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados
FROM movements
WHERE leavePlace IS NOT NULL AND leavePlace != ''
GROUP BY leavePlace
ORDER BY total_busquedas DESC
LIMIT 15;
```

---

### 6. Destinos más populares

```sql
SELECT 
    destinationPlace AS destino,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados
FROM movements
WHERE destinationPlace IS NOT NULL AND destinationPlace != ''
GROUP BY destinationPlace
ORDER BY total_busquedas DESC
LIMIT 15;
```

---

## 👥 CONSULTAS DE USUARIOS

### 7. Usuarios más activos

```sql
SELECT 
    u.cedula,
    u.name,
    u.lastname,
    u.userType AS tipo_usuario,
    COUNT(m.id) AS total_busquedas,
    AVG(m.resultsNum) AS promedio_resultados
FROM users u
LEFT JOIN movements m ON u.cedula = m.user_id
GROUP BY u.cedula, u.name, u.lastname, u.userType
HAVING total_busquedas > 0
ORDER BY total_busquedas DESC
LIMIT 20;
```

---

### 8. Búsquedas por tipo de usuario

```sql
SELECT 
    u.userType AS tipo_usuario,
    COUNT(m.id) AS total_busquedas,
    AVG(m.resultsNum) AS promedio_resultados,
    SUM(CASE WHEN m.resultsNum = 0 THEN 1 ELSE 0 END) AS busquedas_sin_resultado
FROM movements m
LEFT JOIN users u ON m.user_id = u.cedula
GROUP BY u.userType
ORDER BY total_busquedas DESC;
```

---

### 9. Usuarios sin búsquedas

```sql
SELECT 
    u.cedula,
    u.name,
    u.lastname,
    u.email,
    u.userType
FROM users u
LEFT JOIN movements m ON u.cedula = m.user_id
WHERE m.id IS NULL
  AND u.state = 'active'
ORDER BY u.name;
```

---

## 🗺️ CONSULTAS DE RUTAS

### 10. Rutas con demanda pero sin oferta

```sql
SELECT 
    m.leavePlace AS origen,
    m.destinationPlace AS destino,
    COUNT(*) AS veces_buscada,
    SUM(CASE WHEN m.resultsNum = 0 THEN 1 ELSE 0 END) AS busquedas_sin_resultado,
    ROUND(SUM(CASE WHEN m.resultsNum = 0 THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS porcentaje_sin_resultado
FROM movements m
WHERE m.leavePlace IS NOT NULL 
  AND m.leavePlace != ''
  AND m.destinationPlace IS NOT NULL 
  AND m.destinationPlace != ''
GROUP BY m.leavePlace, m.destinationPlace
HAVING busquedas_sin_resultado > 0
ORDER BY veces_buscada DESC, porcentaje_sin_resultado DESC
LIMIT 20;
```

---

### 11. Análisis de éxito de búsquedas por ruta

```sql
SELECT 
    CONCAT(leavePlace, ' → ', destinationPlace) AS ruta,
    COUNT(*) AS total_busquedas,
    SUM(CASE WHEN resultsNum > 0 THEN 1 ELSE 0 END) AS busquedas_exitosas,
    SUM(CASE WHEN resultsNum = 0 THEN 1 ELSE 0 END) AS busquedas_fallidas,
    ROUND(SUM(CASE WHEN resultsNum > 0 THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS tasa_exito,
    AVG(resultsNum) AS promedio_resultados
FROM movements
WHERE leavePlace IS NOT NULL 
  AND leavePlace != ''
  AND destinationPlace IS NOT NULL 
  AND destinationPlace != ''
GROUP BY leavePlace, destinationPlace
HAVING total_busquedas >= 3
ORDER BY total_busquedas DESC;
```

---

## 📅 CONSULTAS POR PERÍODO

### 12. Búsquedas del último mes

```sql
SELECT 
    DATE(m.date) AS fecha,
    COUNT(*) AS total_busquedas,
    AVG(m.resultsNum) AS promedio_resultados,
    COUNT(DISTINCT m.user_id) AS usuarios_unicos
FROM movements m
WHERE m.date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY DATE(m.date)
ORDER BY fecha DESC;
```

---

### 13. Búsquedas por semana

```sql
SELECT 
    YEARWEEK(date) AS semana,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados,
    COUNT(DISTINCT user_id) AS usuarios_unicos
FROM movements
GROUP BY YEARWEEK(date)
ORDER BY semana DESC
LIMIT 12;
```

---

### 14. Búsquedas por mes

```sql
SELECT 
    DATE_FORMAT(date, '%Y-%m') AS mes,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados,
    COUNT(DISTINCT user_id) AS usuarios_unicos
FROM movements
GROUP BY DATE_FORMAT(date, '%Y-%m')
ORDER BY mes DESC;
```

---

## 🔧 CONSULTAS DE MANTENIMIENTO

### 15. Limpiar búsquedas antiguas (más de 1 año)

```sql
-- ⚠️ PRECAUCIÓN: Esta consulta ELIMINA datos
-- Hacer backup antes de ejecutar

DELETE FROM movements
WHERE date < DATE_SUB(CURDATE(), INTERVAL 1 YEAR);
```

---

### 16. Verificar integridad de datos

```sql
-- Buscar movimientos con usuarios inexistentes
SELECT 
    m.id,
    m.user_id,
    m.date
FROM movements m
LEFT JOIN users u ON m.user_id = u.cedula
WHERE u.cedula IS NULL;
```

---

### 17. Estadísticas generales del sistema

```sql
SELECT 
    'Total Búsquedas' AS metrica,
    COUNT(*) AS valor
FROM movements

UNION ALL

SELECT 
    'Búsquedas Únicas (Usuarios)' AS metrica,
    COUNT(DISTINCT user_id) AS valor
FROM movements

UNION ALL

SELECT 
    'Promedio Resultados' AS metrica,
    ROUND(AVG(resultsNum), 2) AS valor
FROM movements

UNION ALL

SELECT 
    'Búsquedas Sin Resultados' AS metrica,
    SUM(CASE WHEN resultsNum = 0 THEN 1 ELSE 0 END) AS valor
FROM movements

UNION ALL

SELECT 
    'Rutas Únicas Buscadas' AS metrica,
    COUNT(DISTINCT CONCAT(leavePlace, '-', destinationPlace)) AS valor
FROM movements
WHERE leavePlace IS NOT NULL AND destinationPlace IS NOT NULL;
```

---

## 💡 CONSULTAS AVANZADAS

### 18. Análisis de comportamiento de usuario

```sql
SELECT 
    u.cedula,
    u.name,
    COUNT(m.id) AS total_busquedas,
    COUNT(DISTINCT DATE(m.date)) AS dias_activos,
    MIN(m.date) AS primera_busqueda,
    MAX(m.date) AS ultima_busqueda,
    AVG(m.resultsNum) AS promedio_resultados,
    SUM(CASE WHEN m.resultsNum = 0 THEN 1 ELSE 0 END) AS busquedas_sin_resultado
FROM users u
LEFT JOIN movements m ON u.cedula = m.user_id
WHERE m.id IS NOT NULL
GROUP BY u.cedula, u.name
HAVING total_busquedas >= 5
ORDER BY total_busquedas DESC;
```

---

### 19. Oportunidades de negocio (rutas con alta demanda)

```sql
SELECT 
    m.leavePlace AS origen,
    m.destinationPlace AS destino,
    COUNT(*) AS demanda_total,
    SUM(CASE WHEN m.resultsNum = 0 THEN 1 ELSE 0 END) AS demanda_insatisfecha,
    ROUND(SUM(CASE WHEN m.resultsNum = 0 THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS porcentaje_insatisfecho,
    COUNT(DISTINCT m.user_id) AS usuarios_interesados
FROM movements m
WHERE m.leavePlace IS NOT NULL 
  AND m.leavePlace != ''
  AND m.destinationPlace IS NOT NULL 
  AND m.destinationPlace != ''
  AND m.date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
GROUP BY m.leavePlace, m.destinationPlace
HAVING demanda_insatisfecha >= 3
ORDER BY demanda_insatisfecha DESC, demanda_total DESC
LIMIT 15;
```

---

### 20. Comparación mes actual vs mes anterior

```sql
SELECT 
    'Mes Actual' AS periodo,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados,
    COUNT(DISTINCT user_id) AS usuarios_unicos
FROM movements
WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')

UNION ALL

SELECT 
    'Mes Anterior' AS periodo,
    COUNT(*) AS total_busquedas,
    AVG(resultsNum) AS promedio_resultados,
    COUNT(DISTINCT user_id) AS usuarios_unicos
FROM movements
WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m');
```

---

## 📝 NOTAS IMPORTANTES

### Optimización de Consultas

1. **Índices**: Asegúrate de tener índices en:
   - `movements.user_id`
   - `movements.date`
   - `movements.leavePlace`
   - `movements.destinationPlace`

2. **Límites**: Usa `LIMIT` para consultas que pueden retornar muchos resultados

3. **Fechas**: Filtra por rangos de fechas para mejorar el rendimiento

### Backup

Antes de ejecutar consultas DELETE o UPDATE:
```sql
-- Crear backup de la tabla
CREATE TABLE movements_backup AS SELECT * FROM movements;
```

---

## 🎯 USO RECOMENDADO

### Para Análisis Diario:
- Consultas 1, 2, 3, 12

### Para Reportes Semanales:
- Consultas 4, 5, 6, 13

### Para Decisiones de Negocio:
- Consultas 10, 11, 19

### Para Mantenimiento:
- Consultas 15, 16, 17

---

**Creado**: Diciembre 2025  
**Base de Datos**: MySQL 8.0+  
**Tabla Principal**: `movements`

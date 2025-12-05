# Guía de Prueba de Endpoints - API Despacho

## Base URL
```
http://localhost/backend/public
```

---

## Endpoints GET (Funcionando)

### 1. Listar Clientes
```javascript
fetch('http://localhost/backend/public/despacho/lista', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
    }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### 2. Listar Abogados
```javascript
fetch('http://localhost/backend/public/despacho/abogados', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
    }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### 3. Listar Asuntos con Abogados
```javascript
fetch('http://localhost/backend/public/despacho/asuntos', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
    }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

---

## Endpoints POST (Probar)

### 1. Crear Nuevo Cliente
```javascript
fetch('http://localhost/backend/public/despacho/nuevo_cliente', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        nombre: 'Juan',
        apellido: 'Pérez',
        telefono: '123456789',
        email: 'juan@email.com'
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Respuesta esperada:**
```json
{
    "status": 201,
    "error": null,
    "messages": {
        "success": "Datos Guardados con exito"
    }
}
```

---

### 2. Asignar Abogado a Asunto (Caso)
```javascript
fetch('http://localhost/backend/public/despacho/casos_abogado', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        idasunto: 1,           // ID del asunto existente
        idabogado: 1,          // ID del abogado existente
        rol: 'Defensor',       // Rol del abogado en el caso
        fechassignacion: '2025-11-27'  // Fecha de asignación
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Respuesta esperada:**
```json
{
    "status": 201,
    "error": null,
    "messages": {
        "success": "Datos Guardados con exito"
    }
}
```

**Nota:** El campo en la solicitud es `fechassignacion` (sin caracteres especiales).

---

### 3. Crear Nuevo Asunto
```javascript
fetch('http://localhost/backend/public/despacho/nuevo_asunto', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        expediente: 'EXP-2025-001',
        fechainicio: '2025-11-27',
        estado: 'Activo',
        fechafin: '2026-11-27',
        descripcion: 'Caso de divorcio',
        idcliente: 1  // ID del cliente existente
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Respuesta esperada:**
```json
{
    "status": 201,
    "error": null,
    "messages": {
        "success": "Datos Guardados con exito"
    }
}
```

---

## Pruebas Recomendadas (Orden)

1. **Primero:** Verifica que los GET funcionan
   - `GET /despacho/lista`
   - `GET /despacho/abogados`

2. **Luego:** Crea un nuevo cliente si no existen
   - `POST /despacho/nuevo_cliente`

3. **Después:** Crea un nuevo asunto
   - `POST /despacho/nuevo_asunto` (usa un idcliente válido)

4. **Finalmente:** Asigna un abogado al asunto
   - `POST /despacho/casos_abogado` (usa idasunto e idabogado válidos)

5. **Verifica:** Lista los asuntos con sus abogados
   - `GET /despacho/asuntos`

---

## Notas Importantes

- Asegúrate de que la base de datos `despachoDB` esté activa
- Los IDs en las solicitudes POST deben existir en la base de datos
- La fecha debe estar en formato `YYYY-MM-DD`
- El campo `fechassignacion` usa 's' simple (no doble)
- CORS está habilitado para todas las origins

---

## Solución de Problemas

### Error 404
- Verifica que la URL es correcta
- Asegúrate de que las rutas en `app/Config/Routes.php` están definidas

### Error 400 o 422 (Validación)
- Verifica que todos los campos requeridos estén presentes
- Verifica que los tipos de datos sean correctos

### Error CORS
- CORS ya está configurado en `app/Config/Cors.php`
- Si aún hay problemas, verifica que Filters.php tenga habilitado el filtro CORS

### Error 500 (Server Error)
- Revisa los logs en `writable/logs/`
- Verifica que los modelos y controladores están correctos
- Asegúrate de que la base de datos está accesible

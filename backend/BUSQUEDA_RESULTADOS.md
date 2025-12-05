# Búsqueda de Código: Asignación de Abogados a Casos

## Resumen Ejecutivo

Se realizó una búsqueda exhaustiva del workspace `c:\xampp\htdocs\backend` para identificar archivos que contienen código relacionado con "asignar", "abogado", "caso", o "casos_abogado". Se encontraron **solicitudes fetch, configuración de rutas y modelos de datos** que manejan la asignación de abogados a casos, aunque **no se hallaron archivos HTML o JavaScript independientes** con formularios específicos en la estructura de directorios.

---

## Archivos Identificados

### 1. **Controlador Principal - API Despacho**
**Archivo:** `c:\xampp\htdocs\backend\app\Controllers\ApiDespacho.php`

**Código Relevante:** El método `abogadocaso()` (líneas 79-145)

```php
// vincular abogado a un caso
public function abogadocaso()
{        
    try {
        // Obtener datos del request
        $datos = $this->request->getJSON();
        
        // Validar que los datos no sean nulos
        if (!$datos) {
            return $this->respond([
                'status'   => 400,
                'error'    => 'No se enviaron datos',
                'message'  => 'El request body no contiene JSON válido'
            ], 400);
        }
        
        // Validar que existan los campos requeridos
        $camposRequeridos = ['idasunto', 'idabogado', 'rol', 'fechassignacion'];
        foreach ($camposRequeridos as $campo) {
            if (!isset($datos->$campo) || $datos->$campo === null || $datos->$campo === '') {
                return $this->respond([
                    'status'   => 400,
                    'error'    => "Campo requerido faltante: $campo",
                    'message'  => "El campo '$campo' es requerido"
                ], 400);
            }
        }
        
        $model = new AsuntoAbogadoModel();
        $data = [  
            'id_asunto' => $datos->idasunto,
            'id_abogado' => $datos->idabogado,
            'rol' => $datos->rol, 
            'fecha_asignacion' => $datos->fechassignacion,          
        ];
        
        // Intentar insertar
        if($model->insert($data)) {
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'Abogado asignado al caso con éxito'
                ],
                'id' => $model->getInsertID()
            ];
            return $this->respondCreated($response, 201);
        } else {
            $errors = $model->errors();
            return $this->respond([
                'status'   => 400,
                'error'    => 'Error de validación del modelo',
                'details'  => $errors,
                'data'     => $data
            ], 400);
        }
    } catch (\Exception $e) {
        return $this->respond([
            'status'   => 500,
            'error'    => 'Error del servidor',
            'message'  => $e->getMessage(),
            'file'     => $e->getFile(),
            'line'     => $e->getLine()
        ], 500);
    }
}
```

**Funcionalidad:**
- Valida que se envíen los 4 campos requeridos: `idasunto`, `idabogado`, `rol`, `fechassignacion`
- Inserta un registro en la tabla `asunto_abogado`
- Retorna el ID insertado
- Maneja excepciones y errores de validación

---

### 2. **Rutas - Configuración de Endpoints**
**Archivo:** `c:\xampp\htdocs\backend\app\Config\Routes.php` (líneas 53-70)

```php
//RUTAS DESPACHO
$routes->group('despacho', function ($routes) {
    $routes->get('lista', 'ApiDespacho::index');
    $routes->post('nuevo_cliente', 'ApiDespacho::nuevo');
    $routes->get('abogados', 'ApiDespacho::abogados');
    $routes->post('nuevo_abogado', 'ApiDespacho::nuevoabogado');
    $routes->post('casos_abogado', 'ApiDespacho::abogadocaso');      // ← ASIGNAR ABOGADO
    $routes->get('asuntos', 'ApiDespacho::asuntos');
    $routes->post('nuevo_asunto', 'ApiDespacho::asuntonuevo');  
    
    // Rutas duplicadas (legacy)
    $routes->get('despacho/lista', 'ApiDespacho::index');
    $routes->post('despacho/nuevo_cliente', 'ApiDespacho::nuevo');
    $routes->get('despacho/abogados', 'ApiDespacho::abogados');
    $routes->post('despacho/nuevo_abogado', 'ApiDespacho::nuevoabogado');
    $routes->post('despacho/casos_abogado', 'ApiDespacho::abogadocaso'); // ← ASIGNAR ABOGADO
    $routes->get('despacho/asuntos', 'ApiDespacho::asuntos');
    $routes->post('despacho/nuevo_asunto', 'ApiDespacho::asuntonuevo');
});
```

**Endpoint para Asignar Abogado:**
- **URL:** `/despacho/casos_abogado`
- **Método HTTP:** POST
- **Controller:** ApiDespacho::abogadocaso()

---

### 3. **Modelos de Datos**

#### 3.1 AsignarAbogadoCasoModel
**Archivo:** `c:\xampp\htdocs\backend\app\Models\despacho\AsignarAbogadoCasoModel.php`

```php
<?php
namespace App\Models\despacho;

use CodeIgniter\Model;

class AsignarAbogadoCasoModel extends Model
{
    protected $DBGroup = 'despachoDB';
    protected $table = 'asunto_abogado';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_asunto','id_abogado','rol','fecha_asignacion'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   
}
```

**Nota:** Este modelo es prácticamente idéntico a `AsuntoAbogadoModel` (ver abajo).

---

#### 3.2 AsuntoAbogadoModel
**Archivo:** `c:\xampp\htdocs\backend\app\Models\despacho\AsuntoAbogadoModel.php`

```php
<?php
namespace App\Models\despacho;

use CodeIgniter\Model;

class AsuntoAbogadoModel extends Model
{
    protected $DBGroup = 'despachoDB';
    protected $table = 'asunto_abogado';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_asunto','id_abogado','rol','fecha_asignacion'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    public function VerAsuntosAbogados($id_asunto)
    {
        $db = db_connect('despachoDB');       
        $sql = 'SELECT ab.*, aa.rol, aa.fecha_asignacion 
                FROM abogado ab        
                JOIN asunto_abogado aa on aa.id_abogado = ab.id
                JOIN asunto a on aa.id_asunto = a.id
                WHERE a.id = ?';        
        $query = $db->query($sql, [$id_asunto]);
        return $query->getResultArray();
    }
}
```

**Métodos:**
- Hereda de CodeIgniter Model (insert, update, delete, findAll, etc.)
- `VerAsuntosAbogados($id_asunto)`: Obtiene todos los abogados asignados a un asunto específico

---

#### 3.3 NuevoAbogadoModel
**Archivo:** `c:\xampp\htdocs\backend\app\Models\despacho\NuevoAbogadoModel.php`

```php
<?php
namespace App\Models\despacho;
use CodeIgniter\Model;

class NuevoAbogadoModel extends Model
{
    protected $DBGroup = 'despachoDB';
    protected $table      = 'abogado';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre', 'apellido','telefono','email'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   
}
```

---

### 4. **Otros Controladores Relacionados**
**Archivo:** `c:\xampp\htdocs\backend\app\Controllers\ApiDespacho.php`

Métodos adicionales en el mismo controlador:

```php
// listar abogados (GET /despacho/abogados)
public function abogados()
{       
    $model = new AbogadoModel();
    $data = $model->findAll();
    return $this->respond($data, 200);
}

// nuevo abogado (POST /despacho/nuevo_abogado)
public function nuevoabogado()
{        
    $model = new AbogadoModel();
    $datos = $this->request->getJSON(); 
    $data = [  
        'nombre' => $datos->nombre,
        'apellido' => $datos->apellido,
        'email' => $datos->email, 
        'telefono' => $datos->telefono,          
    ];  
    $model->insert($data);
    // ... respuesta
}

// listar casos (asuntos) (GET /despacho/asuntos)
public function asuntos()
{       
    $model = new AsuntoModel();
    $modelAA = new AsuntoAbogadoModel();
    $data = $model->VerAsuntos();
    
    // Convertir a array para modificar
    $respuesta = [];
    foreach($data as $d) {
        $item = (array)$d;
        $item['abogados'] = $modelAA->VerAsuntosAbogados($item['id']);
        $respuesta[] = $item;
    }
    return $this->respond($respuesta, 200);
}
```

---

## Ejemplos de Solicitudes (Fetch/AJAX)

### Asignar Abogado a un Caso
**URL Base:** `http://localhost/backend/public`

```javascript
fetch('http://localhost/backend/public/despacho/casos_abogado', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        idasunto: 1,                    // ID del asunto/caso existente
        idabogado: 1,                   // ID del abogado existente
        rol: 'Defensor',                // Rol del abogado en el caso
        fechassignacion: '2025-11-27'   // Fecha de asignación (YYYY-MM-DD)
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

**Respuesta Exitosa (201):**
```json
{
    "status": 201,
    "error": null,
    "messages": {
        "success": "Abogado asignado al caso con éxito"
    },
    "id": 5
}
```

---

### Listar Abogados
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

---

### Listar Asuntos con Abogados Asignados
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

### Crear Nuevo Asunto
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

---

## Estructura de Base de Datos

### Tabla: `asunto_abogado`
```sql
CREATE TABLE asunto_abogado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_asunto INT NOT NULL,
    id_abogado INT NOT NULL,
    rol VARCHAR(50),
    fecha_asignacion DATE,
    FOREIGN KEY (id_asunto) REFERENCES asunto(id) ON DELETE CASCADE,
    FOREIGN KEY (id_abogado) REFERENCES abogado(id) ON DELETE CASCADE,
    UNIQUE KEY unique_asunto_abogado (id_asunto, id_abogado)
);
```

### Tabla: `abogado`
- Campos: `id`, `nombre`, `apellido`, `email`, `telefono`

### Tabla: `asunto` (casos)
- Campos: `id`, `expediente`, `fecha_inicio`, `estado`, `fecha_fin`, `descripcion`, `id_cliente`

---

## Documentación de Pruebas

**Archivo:** `c:\xampp\htdocs\backend\PRUEBAS_ENDPOINTS.md`

Contiene ejemplos completos de solicitudes fetch para:
1. Listar clientes
2. **Asignar abogado a asunto** ← Principal
3. Crear nuevo asunto
4. Listar abogados
5. Listar asuntos con abogados

---

## Archivos HTML/JavaScript Encontrados

**Resultado:** No se encontraron archivos HTML o JavaScript independientes con formularios específicos para la asignación de abogados. Los únicos archivos JavaScript identificados son:
- `c:\xampp\htdocs\backend\system\Debug\Toolbar\Views\toolbarloader.js` (debug toolbar)
- `c:\xampp\htdocs\backend\system\Debug\Toolbar\Views\toolbar.js` (debug toolbar)
- `c:\xampp\htdocs\backend\app\Views\errors\html\debug.js` (error debug)

**Conclusión:** La API es RESTful y se consume probablemente desde un frontend separado (posiblemente en un repositorio diferente).

---

## Resumen de Endpoints

| Método | Endpoint | Función | Controlador |
|--------|----------|---------|-------------|
| POST | `/despacho/casos_abogado` | **Asignar abogado a caso** | `ApiDespacho::abogadocaso()` |
| GET | `/despacho/abogados` | Listar abogados | `ApiDespacho::abogados()` |
| GET | `/despacho/asuntos` | Listar asuntos con abogados | `ApiDespacho::asuntos()` |
| POST | `/despacho/nuevo_abogado` | Crear nuevo abogado | `ApiDespacho::nuevoabogado()` |
| POST | `/despacho/nuevo_asunto` | Crear nuevo asunto | `ApiDespacho::asuntonuevo()` |
| GET | `/despacho/lista` | Listar clientes | `ApiDespacho::index()` |
| POST | `/despacho/nuevo_cliente` | Crear nuevo cliente | `ApiDespacho::nuevo()` |

---

## Campos Requeridos para Asignar Abogado

```json
{
    "idasunto": "integer (ID del asunto/caso existente)",
    "idabogado": "integer (ID del abogado existente)",
    "rol": "string (ej: 'Defensor', 'Asesor', 'Principal')",
    "fechassignacion": "string (formato YYYY-MM-DD)"
}
```

**Nota Importante:** El campo es `fechassignacion` con una sola 's' (no `fechasAsignacion` o `fechassignación`).

---

## Logs de Solicitudes

**Archivo:** `c:\xampp\htdocs\backend\writable\logs\log-2025-12-05.log`

Se encontraron registros de:
- Múltiples solicitudes GET a `/despacho/abogados`
- Solicitudes POST a `/despacho/casos_abogado`

Los logs confirman que el endpoint está siendo utilizado activamente.

---

## Conclusiones

1. ✅ **El código de asignación de abogados a casos existe** y está completamente implementado
2. ✅ **El endpoint es:** `POST /despacho/casos_abogado`
3. ✅ **La validación** incluye verificación de campos requeridos
4. ✅ **Manejo de errores** para casos de validación y excepciones
5. ✅ **Documentación** disponible en `PRUEBAS_ENDPOINTS.md`
6. ⚠️ **No hay interfaces HTML/JS frontend** en este repositorio (probablemente en otro proyecto)
7. ✅ **Base de datos configurada** con tablas relacionadas y constraints adecuados


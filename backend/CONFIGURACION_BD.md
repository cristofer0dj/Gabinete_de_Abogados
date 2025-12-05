# Configuración de Base de Datos - API Despacho

## Estructura de Tablas Esperadas

### Tabla: `cliente`
```sql
CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefono VARCHAR(20)
);
```

**Ejemplo de inserción:**
```sql
INSERT INTO cliente (nombre, apellido, email, telefono) VALUES
('Juan', 'Pérez', 'juan@email.com', '123456789'),
('María', 'García', 'maria@email.com', '987654321');
```

---

### Tabla: `abogado`
```sql
CREATE TABLE abogado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(20)
);
```

**Ejemplo de inserción:**
```sql
INSERT INTO abogado (nombre, apellido, especialidad, email, telefono) VALUES
('Carlos', 'López', 'Derecho Civil', 'carlos@email.com', '111111111'),
('Ana', 'Martínez', 'Derecho Penal', 'ana@email.com', '222222222');
```

---

### Tabla: `asunto`
```sql
CREATE TABLE asunto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    expediente VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    estado VARCHAR(50),
    fecha_inicio DATE,
    fecha_fin DATE,
    id_cliente INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id) ON DELETE CASCADE
);
```

**Ejemplo de inserción:**
```sql
INSERT INTO asunto (expediente, descripcion, estado, fecha_inicio, fecha_fin, id_cliente) VALUES
('EXP-2025-001', 'Caso de divorcio', 'Activo', '2025-01-15', '2026-01-15', 1),
('EXP-2025-002', 'Herencia', 'Pendiente', '2025-02-20', '2025-12-20', 2);
```

---

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

**Ejemplo de inserción:**
```sql
INSERT INTO asunto_abogado (id_asunto, id_abogado, rol, fecha_asignacion) VALUES
(1, 1, 'Abogado Defensor', '2025-01-15'),
(1, 2, 'Abogado Asesor', '2025-01-20'),
(2, 1, 'Abogado Principal', '2025-02-20');
```

---

## Verificación de Configuración

### 1. Verificar que la base de datos existe
```sql
SHOW DATABASES;
-- Debe existir una base de datos llamada 'despachoDB'
```

### 2. Verificar que las tablas existen
```sql
USE despachoDB;
SHOW TABLES;
-- Debe mostrar: cliente, abogado, asunto, asunto_abogado
```

### 3. Verificar la configuración de conexión
En `app/Config/Database.php`, asegúrate de que existe una configuración para `despachoDB`:

```php
public array $despachoDB = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root', // Tu usuario de BD
    'password' => '', // Tu contraseña de BD
    'database' => 'despachoDB',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => (ENVIRONMENT !== 'production'),
    'cacheOn'  => false,
    'cacheDir' => '',
    'charset'  => 'utf8',
    'DBCollat' => 'utf8_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
];
```

---

## Prueba de Conectividad

### Desde el backend, ejecuta:
```bash
# En la carpeta backend/
php spark db:create despachoDB
```

O verifica manualmente con:
```php
// En un controlador de prueba
$db = db_connect('despachoDB');
if ($db->connect()) {
    echo "Conexión exitosa";
} else {
    echo "Error de conexión";
}
```

---

## Notas Importantes

1. **Foreign Keys:** Asegúrate de que MySQL soporta Foreign Keys y están habilitadas
2. **Charset:** Usa `utf8mb4` si trabajas con caracteres especiales
3. **Índices:** Los campos `expediente` en `asunto` tienen índice UNIQUE para evitar duplicados
4. **Relaciones:** Las tablas `asunto_abogado` referencia tanto `asunto` como `abogado`
5. **Campos de fecha:** Están en formato `DATE` (YYYY-MM-DD)

---

## Cambios Realizados en los Modelos

Se cambió `getResult()` por `getResultArray()` en:
- `AsuntoModel::VerAsuntos()` - Ahora devuelve un array de arrays
- `AsuntoAbogadoModel::VerAsuntosAbogados()` - Ahora devuelve un array de arrays

Esto asegura consistencia en los tipos de datos devueltos por los métodos.

---

## Estructura JSON Esperada en Respuestas

### GET /despacho/asuntos
```json
[
    {
        "id": 1,
        "expediente": "EXP-2025-001",
        "descripcion": "Caso de divorcio",
        "estado": "Activo",
        "fecha_inicio": "2025-01-15",
        "fecha_fin": "2026-01-15",
        "id_cliente": 1,
        "nombre": "Juan",
        "apellido": "Pérez",
        "email": "juan@email.com",
        "telefono": "123456789",
        "abogados": [
            {
                "id": 1,
                "nombre": "Carlos",
                "apellido": "López",
                "especialidad": "Derecho Civil",
                "email": "carlos@email.com",
                "telefono": "111111111"
            },
            {
                "id": 2,
                "nombre": "Ana",
                "apellido": "Martínez",
                "especialidad": "Derecho Penal",
                "email": "ana@email.com",
                "telefono": "222222222"
            }
        ]
    }
]
```

---

## Solución de Problemas

| Problema | Solución |
|----------|----------|
| Error 500 al llamar `/despacho/asuntos` | Verifica que la BD despachoDB existe y tiene datos |
| Error 404 en endpoints POST | Verifica que las rutas en `Routes.php` están configuradas |
| Error CORS | Verifica que `Cors.php` y `Filters.php` están configurados |
| Datos no aparecen en JSON | Verifica que `getResultArray()` está siendo usado en los modelos |
| Foreign Key constraint failed | Verifica que los IDs existen antes de insertar en `asunto_abogado` |

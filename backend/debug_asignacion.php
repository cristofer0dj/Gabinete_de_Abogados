<?php
require 'app/Config/Database.php';
require 'app/Models/despacho/AsuntoAbogadoModel.php';

use Config\Database;
use App\Models\despacho\AsuntoAbogadoModel;

// Conectar a la BD
$db = (new Database())->despachoDB;

// Ver la estructura de la tabla
echo "=== ESTRUCTURA DE LA TABLA asunto_abogado ===\n";
$tableInfo = $db->getFieldData('asunto_abogado');
foreach ($tableInfo as $field) {
    echo "Nombre: {$field->name}, Tipo: {$field->type}, Null: {$field->nullable}, Key: {$field->key}\n";
}

echo "\n=== INTENTANDO INSERTAR ===\n";
$model = new AsuntoAbogadoModel();
$data = [
    'id_asunto' => 1,
    'id_abogado' => 1,
    'rol' => 'Abogado Principal',
    'fecha_asignacion' => '2025-12-05'
];

if ($model->insert($data)) {
    echo "✓ Inserción exitosa. ID: " . $model->getInsertID() . "\n";
} else {
    echo "✗ Error en la inserción\n";
    echo "Errores del modelo: " . json_encode($model->errors()) . "\n";
    echo "Mensajes de validación: " . json_encode($model->getValidationMessages()) . "\n";
    
    // Intentar inserción directa para ver error de BD
    echo "\n=== INTENTANDO INSERT DIRECTO ===\n";
    $result = $db->table('asunto_abogado')->insert($data);
    if ($result) {
        echo "✓ Insert directo exitoso\n";
    } else {
        echo "✗ Error en insert directo: " . $db->error()['message'] . "\n";
    }
}

// Verificar que existan los registros
echo "\n=== VERIFICANDO REGISTROS EXISTENTES ===\n";
$asunto = $db->table('asunto')->where('id', 1)->get()->getRow();
echo "Asunto 1: " . ($asunto ? "✓ EXISTE" : "✗ NO EXISTE") . "\n";

$abogado = $db->table('abogado')->where('id', 1)->get()->getRow();
echo "Abogado 1: " . ($abogado ? "✓ EXISTE" : "✗ NO EXISTE") . "\n";

?>

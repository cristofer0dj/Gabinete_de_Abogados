<?php
namespace App\Models\despacho;

use CodeIgniter\Model;

class AsignarAbogadoCasoModel extends Model
{
    //seleccion de esquema de BD
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

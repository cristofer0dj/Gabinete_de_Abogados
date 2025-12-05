<?php

namespace App\Models\zoologico;

use CodeIgniter\Model;

class TrasladoModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'zooDB';
    protected $table      = 'traslado';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_zoo_origen', 'id_zoo_destino','motivo','id_animal','fecha_traslado'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
<?php

namespace App\Models\zoologico;

use CodeIgniter\Model;

class EspecieoModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'zooDB';
    protected $table      = 'especie';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre_vulgar','nombre_cientifico','familia','estado'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
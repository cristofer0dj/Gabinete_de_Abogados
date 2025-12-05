<?php

namespace App\Models\vuelos;

use CodeIgniter\Model;

class BaseModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'vuelosDB';
    protected $table      = 'base';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
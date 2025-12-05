<?php

namespace App\Models\zoologico;

use CodeIgniter\Model;

class ZoologicoModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'zooDB';
    protected $table      = 'zoologico';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'tamano','ciudad','pais','presupuesto'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
<?php

namespace App\Models\club;

use CodeIgniter\Model;

class CapitanModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'clubDB';
    protected $table      = 'capitan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellido','telefono'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
<?php

namespace App\Models\taller;

use CodeIgniter\Model;

class ClienteModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'tallerDB';
    protected $table      = 'cliente';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellido','telefono','email'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
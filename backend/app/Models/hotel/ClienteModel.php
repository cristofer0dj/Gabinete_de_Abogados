<?php

namespace App\Models\hotel;

use CodeIgniter\Model;

class ClienteModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'hotelDB';
    protected $table      = 'cliente';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellido'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
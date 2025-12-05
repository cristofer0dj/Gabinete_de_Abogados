<?php

namespace App\Models\club;

use CodeIgniter\Model;

class BarcoModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'clubDB';
    protected $table      = 'barco';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['matricula','nombre','numero_amarre','cuota','id_socio'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
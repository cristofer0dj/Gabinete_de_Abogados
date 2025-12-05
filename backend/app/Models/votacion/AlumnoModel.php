<?php

namespace App\Models\votacion;

use CodeIgniter\Model;

class AlumnoModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'votacionDB';
    protected $table      = 'alumno';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellido','genero','carnet','pass'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
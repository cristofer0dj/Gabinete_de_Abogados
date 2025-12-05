<?php

namespace App\Models\hotel;

use CodeIgniter\Model;

class HabitacionModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'hotelDB';
    protected $table      = 'habitacion';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['numero','tipo','precio_noche','estado'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    
}
<?php

namespace App\Models\vuelos;

use CodeIgniter\Model;

class AvionModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'vuelosDB';
    protected $table      = 'avion';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codigo','tipo','fecha_mantenimiento','id_base'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

      function VerAviones(){
        $db = db_connect('vuelosDB');       
        $sql = 'SELECT a.*, b.nombre as base FROM avion a        
        JOIN base b on a.id_base=b.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }
    
}
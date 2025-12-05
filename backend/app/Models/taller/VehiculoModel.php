<?php

namespace App\Models\taller;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'tallerDB';
    protected $table      = 'vehiculo';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['marca', 'modelo','anho','id_cliente'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

     function VerVehiculos(){
        $db = db_connect('tallerDB');       
        $sql = 'SELECT v.*,c.* FROM vehiculo v 
        JOIN cliente c on v.id_cliente=c.id ';        
        $query = $db->query($sql);
        return $query->getResult();
    }
}
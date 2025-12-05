<?php

namespace App\Models\taller;

use CodeIgniter\Model;

class ServicioModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'tallerDB';
    protected $table      = 'servicio';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_vehiculo', 'id_mecanico','costo','descripcion','estado','fecha_ingreso'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

     function VerServicios(){
        $db = db_connect('tallerDB');       
        $sql = 'SELECT * FROM servicio s 
        JOIN vehiculo v on s.id_vehiculo=v.id
        JOIN cliente c on v.id_cliente=c.id
        JOIN mecanico m on s.id_mecanico=m.id ';        
        $query = $db->query($sql);
        return $query->getResult();
    }
}
<?php

namespace App\Models\hotel;

use CodeIgniter\Model;

class ReservaModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'hotelDB';
    protected $table      = 'reserva';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_habitacion','id_cliente','fecha_entrada','fecha_salida','total'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerReservas(){
        $db = db_connect('hotelDB');       
        $sql = 'SELECT * FROM reserva r 
        JOIN habitacion h on r.id_habitacion=h.id
        JOIN cliente c on v.id_cliente=c.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }
}

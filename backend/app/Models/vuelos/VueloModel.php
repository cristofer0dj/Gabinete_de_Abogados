<?php

namespace App\Models\vuelos;

use CodeIgniter\Model;

class VueloModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'vuelosDB';
    protected $table      = 'vuelo';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['numero','origen','destino','hora_salida','fecha','id_avion'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerVuelos($origen, $destino, $fecha){
        $db = db_connect('vuelosDB');       
        $sql = 'SELECT v.id, v.fecha, v.hora_salida, v.numero, b1.nombre as origen, 
        b2.nombre as destino, a.codigo as avion FROM vuelo v  
        JOIN base b1 on v.origen=b1.id
        JOIN base b2 on v.destino=b2.id      
        JOIN avion a on v.id_avion=a.id
        WHERE b1.id = :origen: AND b2.id = :destino: AND v.fecha = :fecha:';    
        $data=["origen" => $origen, "destino" => $destino, "fecha" => $fecha];    
        $query = $db->query($sql, $data);
        return $query->getResult();
    }
    
}
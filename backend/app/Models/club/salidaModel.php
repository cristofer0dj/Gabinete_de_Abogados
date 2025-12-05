<?php

namespace App\Models\club;

use CodeIgniter\Model;

class SalidaModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'clubDB';
    protected $table      = 'salida';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_barco','id_capitan','fecha_salida','hora_salida','destino'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

     function VerSalidas(){
        $db = db_connect('clubDB');       
        $sql = 'SELECT * FROM salida s
        JOIN barco b on s.id_barco=b.id
        JOIN socio sc on b.id_socio=sc.id       
        JOIN capitan c on s.id_capitan=c.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }
}
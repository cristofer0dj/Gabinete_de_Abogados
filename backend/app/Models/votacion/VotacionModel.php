<?php

namespace App\Models\votacion;

use CodeIgniter\Model;

class VotacionModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'votacionDB';
    protected $table      = 'votacion';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_alumno','fecha','id_delegado'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerResultados(){
        $db = db_connect('votacionDB');       
        $sql = 'SELECT count(c.id) as votos, c.nombre as nombre_candidato, c.apellido as apellido_candidato, c.id FROM votacion v 
        JOIN alumno a on v.id_alumno=a.id
        JOIN alumno_rol ar on v.id_delegado=ar.id
        JOIN alumno c on ar.id_alumno=c.id
        Group by c.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }

    function VerDetallesResultado($id_candidato){
        $db = db_connect('votacionDB');       
        $sql = 'SELECT a.nombre, a.apellido, v.fecha, c.nombre as nombre_candidato, c.apellido as apellido_candidato, c.id FROM votacion v 
        JOIN alumno a on v.id_alumno=a.id
        JOIN alumno_rol ar on v.id_delegado=ar.id
        JOIN alumno c on ar.id_alumno=c.id
        WHERE c.id = :id: ';        
        $query = $db->query($sql,['id'=>$id_candidato]);
        return $query->getResult();
    }

    
}
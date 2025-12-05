<?php

namespace App\Models\votacion;

use CodeIgniter\Model;

class AlumnoRolModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'votacionDB';
    protected $table      = 'alumno_rol';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_alumno','id_rol'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerCandidatos(){
        $db = db_connect('votacionDB');       
        $sql = 'SELECT c.nombre as nombre_candidato, c.apellido as apellido_candidato, c.id FROM alumno_rol ar
        JOIN alumno c on ar.id_alumno=c.id
        JOIN rol r on ar.id_rol=r.id
        WHERE r.nombre=:rol:';        
        $query = $db->query($sql,['rol'=>"Candidato"]);
        return $query->getResult();
    }
}
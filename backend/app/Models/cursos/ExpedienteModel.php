<?php

namespace App\Models\cursos;

use CodeIgniter\Model;

class ExpedienteModel extends Model
{
    //seleccion de esquema de BD
    protected $DBGroup = 'cursosDB';
    protected $table      = 'expediente';
   // protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_curso','id_estudiante', 'nota_final'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerNotas($id_curso){
        $db = db_connect('cursosDB');       
        $sql = 'SELECT a.*,e.* FROM expediente e 
        JOIN curso c on e.id_curso=c.id
        JOIN estudiante a on e.id_estudiante=a.id        
        WHERE c.id=:curso: ';        
        $query = $db->query($sql,["curso" => $id_curso]);
        return $query->getResult();
    }

     function CargarExpediente($id_curso, $id_estudiante){
        $db = db_connect('cursosDB');       
        $sql = 'SELECT e.* FROM expediente e 
        JOIN curso c on e.id_curso=c.id
        JOIN estudiante a on e.id_estudiante=a.id        
        WHERE c.id=:curso: AND a.id=:estudiante:';        
        $query = $db->query($sql,[
            "curso" => $id_curso, 
            "estudiante"=>$id_estudiante
        ]);
        return $query->getResult();
    }
}
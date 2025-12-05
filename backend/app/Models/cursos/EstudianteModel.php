<?php

namespace App\Models\cursos;

use CodeIgniter\Model;

class EstudianteModel extends Model
{
    //seleccion de esquema de BD
    protected $DBGroup = 'cursosDB';
    protected $table      = 'estudiante';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellido','email','ingreso','carrera'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function EstudianteCurso($id_curso){
        $db = db_connect('cursosDB');       
        $sql = 'SELECT e.* FROM estudiante e 
        JOIN expediente ex on ex.id_estudiante=p.id
        JOIN curso c on ex.id_curso=c.id        
        WHERE c.id=:curso: ';        
        $query = $db->query($sql,["curso" => $id_curso]);
        return $query->getResult();
    }
}
<?php

namespace App\Models\cursos;

use CodeIgniter\Model;

class ProfesorModel extends Model
{
    //seleccion de esquema de BD
    protected $DBGroup = 'cursosDB';
    protected $table      = 'profesor';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'apellido','email'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function ProfesorCurso($id_curso){
        $db = db_connect('cursosDB');       
        $sql = 'SELECT p.* FROM profesor p 
        JOIN curso_profesor cp on cp.id_profesor=p.id
        JOIN curso c on cp.id_curso=c.id        
        WHERE c.id=:curso: ';        
        $query = $db->query($sql,["curso" => $id_curso]);
        return $query->getResult();
    }
}
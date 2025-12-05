<?php

namespace App\Models\cursos;

use CodeIgniter\Model;

class CursoModel extends Model
{
    //seleccion de esquema de BD
    protected $DBGroup = 'cursosDB';
    protected $table      = 'curso';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codigo','nombre', 'creditos','carrera','semestre','id_profesor'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerCursos(){
        $db = db_connect('cursosDB');       
        $sql = 'SELECT a.*, b.nombre as profesor FROM curso a        
        JOIN profesor b on a.id_profesor=b.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }
}
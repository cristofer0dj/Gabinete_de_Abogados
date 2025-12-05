<?php

namespace App\Models\vuelos;

use CodeIgniter\Model;

class PersonaModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'vuelosDB';
    protected $table      = 'persona';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codigo','nombre','apellido','id_base','horas'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerPersonas(){
        $db = db_connect('vuelosDB');       
        $sql = 'SELECT p.*, b.nombre as base FROM persona p        
        JOIN base b on p.id_base=b.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }
}
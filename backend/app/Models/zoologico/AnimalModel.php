<?php

namespace App\Models\zoologico;

use CodeIgniter\Model;

class AnimalModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'zooDB';
    protected $table      = 'animal';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['identificacion','id_especie','sexo','nacimiento','pais','id_zoologico'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

     function VerAnimales(){
        $db = db_connect('zooDB');       
        $sql = 'SELECT * FROM animal a        
        JOIN especie e on a.id_especie=e.id 
        JOIN zoologico z on a.id_zoologico=z.id';       
        $query = $db->query($sql);
        return $query->getResult();
    }
}
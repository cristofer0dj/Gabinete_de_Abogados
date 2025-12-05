<?php

namespace App\Models\vuelos;

use CodeIgniter\Model;

class VueloPersonaModel extends Model
{
     //seleccion de esquema de BD
    protected $DBGroup = 'vuelosDB';
    protected $table      = 'vuelo_persona';
   // protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_vuelo','id_persona_rol'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    function VerPersonaVuelo($id_vuelo){
        $db = db_connect('vuelosDB');       
        $sql = 'SELECT p.*,r.nombre as rol  FROM persona p 
        JOIN persona_rol pr on pr.id_persona=p.id   
        JOIN rol r on pr.id_rol=r.id      
        JOIN vuelo_persona vp on vp.id_persona_rol=pr.id
        JOIN vuelo v on vp.id_vuelo=v.id
        WHERE v.id=:vuelo:';        
        $query = $db->query($sql,["vuelo"=>$id_vuelo]);
        return $query->getResult();
    }

    function VerPersonaRol(){
        $db = db_connect('vuelosDB');       
        $sql = 'SELECT pr.id, p.nombre, p.apellido, r.nombre as rol  FROM persona p 
        JOIN persona_rol pr on pr.id_persona=p.id   
        JOIN rol r on pr.id_rol=r.id';        
        $query = $db->query($sql);
        return $query->getResult();
    }
    
    
}
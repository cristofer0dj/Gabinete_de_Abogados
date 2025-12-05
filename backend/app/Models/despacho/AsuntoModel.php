<?php
namespace App\Models\despacho;

use CodeIgniter\Model;

class AsuntoModel extends Model
{
    protected $DBGroup = 'despachoDB';
    protected $table = 'asunto';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['expediente','descripcion','estado','fecha_inicio','fecha_fin','id_cliente'];
   
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;   

    public function VerAsuntos()
    {
        $db = db_connect('despachoDB');       
        $sql = 'SELECT a.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido 
                FROM asunto a        
                JOIN cliente c on a.id_cliente = c.id';        
        $query = $db->query($sql);
        return $query->getResultArray(); // Cambiado a getResultArray()
    }
}
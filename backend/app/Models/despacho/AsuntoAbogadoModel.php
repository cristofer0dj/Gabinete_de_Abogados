<?php
namespace App\Models\despacho;

use CodeIgniter\Model;

class AsuntoAbogadoModel extends Model
{
    //seleccion de esquema de BD
    protected $DBGroup = 'despachoDB';
    protected $table = 'asunto_abogado';
    protected $primaryKey = 'id_asunto';

    protected $useAutoIncrement = false;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_asunto','id_abogado','rol','fecha_asignacion'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    
    // Desactivar validaciones
    protected $skipValidation = true;

    public function VerAsuntosAbogados($id_asunto)
    {
        $db = db_connect('despachoDB');       
        $sql = 'SELECT ab.*, aa.rol, aa.fecha_asignacion 
                FROM abogado ab        
                JOIN asunto_abogado aa on aa.id_abogado = ab.id
                JOIN asunto a on aa.id_asunto = a.id
                WHERE a.id = ?';        
        $query = $db->query($sql, [$id_asunto]);
        return $query->getResultArray();
    }
}
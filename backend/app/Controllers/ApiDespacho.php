<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\despacho\ClienteModel;
use App\Models\despacho\AbogadoModel;
use App\Models\despacho\AsuntoModel;
use App\Models\despacho\AsuntoAbogadoModel;

class ApiDespacho extends ResourceController
{
    use ResponseTrait;
    
    // listar clientes
    public function index()
    {       
        $model = new ClienteModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    // nuevo cliente
    public function nuevo()
    {        
        $model = new ClienteModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'email' => $datos->email, 
            'telefono' => $datos->telefono,          
        ];  
      
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Cliente creado con éxito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

    // listar abogados
    public function abogados()
    {       
        $model = new AbogadoModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    // nuevo abogado
    public function nuevoabogado()
    {        
        $model = new AbogadoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'email' => $datos->email, 
            'telefono' => $datos->telefono,          
        ];  
      
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Abogado creado con éxito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

    // vincular abogado a un caso
    public function abogadocaso()
    {        
        try {
            // Intentar obtener datos como JSON (POST)
            $datos = $this->request->getJSON();
            
            // Debug: Log what we received
            log_message('error', 'Datos recibidos: ' . json_encode($datos));
            
            // Si no hay JSON, intentar desde query string (GET) o POST form data
            if (!$datos || !isset($datos->idasunto)) {
                $idasunto = $this->request->getVar('idasunto');
                $idabogado = $this->request->getVar('idabogado');
                $rol = $this->request->getVar('rol');
                $fechassignacion = $this->request->getVar('fechassignacion');
                
                $datos = (object)[
                    'idasunto' => $idasunto,
                    'idabogado' => $idabogado,
                    'rol' => $rol,
                    'fechassignacion' => $fechassignacion
                ];
            }
            
            log_message('error', 'Datos después de procesar: ' . json_encode($datos));
            
            // Si idasunto o idabogado vienen como texto (nombre), buscar el ID
            $idasuntoOriginal = $datos->idasunto;
            $idabogadoOriginal = $datos->idabogado;
            
            $datos->idasunto = $this->buscarIdAsunto($datos->idasunto);
            $datos->idabogado = $this->buscarIdAbogado($datos->idabogado);
            
            log_message('error', 'IDs después de buscar - Asunto: ' . $datos->idasunto . ', Abogado: ' . $datos->idabogado);
            
            // Validar que existan los campos requeridos
            $camposRequeridos = ['idasunto', 'idabogado', 'rol', 'fechassignacion'];
            foreach ($camposRequeridos as $campo) {
                if (!isset($datos->$campo) || $datos->$campo === null || $datos->$campo === '') {
                    return $this->respond([
                        'status'   => 400,
                        'error'    => "Campo requerido faltante: $campo",
                        'message'  => "El campo '$campo' es requerido",
                        'recibido' => (array)$datos,
                        'original' => [
                            'idasunto' => $idasuntoOriginal,
                            'idabogado' => $idabogadoOriginal
                        ]
                    ], 400);
                }
            }
            
            // Usar consulta directa para insertar
            $db = db_connect('despachoDB');
            try {
                $result = $db->table('asunto_abogado')->insert([
                    'id_asunto' => $datos->idasunto,
                    'id_abogado' => $datos->idabogado,
                    'rol' => $datos->rol,
                    'fecha_asignacion' => $datos->fechassignacion
                ]);
                
                if ($result) {
                    $response = [
                        'status'   => 201,
                        'success'  => true,
                        'message'  => 'Abogado asignado al caso con éxito'
                    ];
                    return $this->respond($response, 201);
                } else {
                    return $this->respond([
                        'status'   => 400,
                        'success'  => false,
                        'error'    => 'Error al insertar en la BD',
                        'details'  => $db->error(),
                        'data'     => [
                            'id_asunto' => $datos->idasunto,
                            'id_abogado' => $datos->idabogado,
                            'rol' => $datos->rol,
                            'fecha_asignacion' => $datos->fechassignacion
                        ]
                    ], 400);
                }
            } catch (\Exception $e) {
                return $this->respond([
                    'status'   => 500,
                    'success'  => false,
                    'error'    => 'Excepción en la BD',
                    'message'  => $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            return $this->respond([
                'status'   => 500,
                'error'    => 'Error del servidor',
                'message'  => $e->getMessage(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine()
            ], 500);
        }
    }
    
    // Función auxiliar para buscar ID de asunto por nombre o expediente
    private function buscarIdAsunto($asunto)
    {
        // Si ya es un número, retornarlo
        if (is_numeric($asunto)) {
            return (int)$asunto;
        }
        
        // Si es texto, buscar por expediente
        if (is_string($asunto) && !empty($asunto)) {
            $model = new AsuntoModel();
            $resultado = $model->where('expediente', 'LIKE', '%' . $asunto . '%')
                               ->first();
            if ($resultado) {
                return $resultado['id'];
            }
        }
        
        return null;
    }
    
    // Función auxiliar para buscar ID de abogado por nombre
    private function buscarIdAbogado($abogado)
    {
        // Si ya es un número, retornarlo
        if (is_numeric($abogado)) {
            return (int)$abogado;
        }
        
        // Si es texto, buscar por nombre completo
        if (is_string($abogado) && !empty($abogado)) {
            $model = new AbogadoModel();
            // Buscar por nombre o apellido
            $resultado = $model->where('CONCAT(nombre, " ", apellido)', 'LIKE', '%' . $abogado . '%')
                               ->first();
            if ($resultado) {
                return $resultado['id'];
            }
            
            // Si no encuentra, intentar solo por nombre
            $resultado = $model->where('nombre', 'LIKE', '%' . $abogado . '%')
                               ->first();
            if ($resultado) {
                return $resultado['id'];
            }
        }
        
        return null;
    }
    
    // listar casos (asuntos)
    public function asuntos()
    {       
        $model = new AsuntoModel();
        $modelAA = new AsuntoAbogadoModel();
        $data = $model->VerAsuntos();
        
        // Convertir a array para modificar
        $respuesta = [];
        foreach($data as $d) {
            $item = (array)$d;
            $item['abogados'] = $modelAA->VerAsuntosAbogados($item['id']);
            $respuesta[] = $item;
        }
        return $this->respond($respuesta, 200);
    }

    // nuevo caso (asunto)
    public function asuntonuevo()
    {        
        $model = new AsuntoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'expediente' => $datos->expediente,
            'fecha_inicio' => $datos->fechainicio,
            'estado' => $datos->estado, 
            'fecha_fin' => $datos->fechafin,    
            'descripcion' => $datos->descripcion, 
            'id_cliente' => $datos->idcliente,       
        ];  
       
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Caso creado con éxito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

    // DEBUG: Verificar asuntos y abogados
    public function debugAsignacion()
    {
        $asuntoModel = new AsuntoModel();
        $abogadoModel = new AbogadoModel();
        $modelAA = new AsuntoAbogadoModel();

        $asuntos = $asuntoModel->findAll();
        $abogados = $abogadoModel->findAll();
        $asignaciones = $modelAA->findAll();

        // Ver estructura de tabla
        $db = db_connect('despachoDB');
        $tableInfo = $db->getFieldData('asunto_abogado');

        return $this->respond([
            'asuntos' => $asuntos,
            'abogados' => $abogados,
            'asignaciones_actuales' => $asignaciones,
            'estructura_tabla' => $tableInfo
        ], 200);
    }
}
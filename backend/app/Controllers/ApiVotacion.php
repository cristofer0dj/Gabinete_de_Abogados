<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\votacion\AlumnoModel;
use App\Models\votacion\RolModel;
use App\Models\votacion\AlumnoRolModel;
use App\Models\votacion\VotacionModel;


class ApiVotacion extends ResourceController
{
    use ResponseTrait;
    // listar alumnos
    public function index()
    {       
        $model = new AlumnoModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    //nuevo alumno
    public function nuevo()
    {        
        $model = new AlumnoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'genero' => $datos->genero,
            'carnet' => $datos->carnet,
            'pass' => $datos->pass,           
        ];  
      
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

    //nuevo candidato
    public function candidato()
    {
        $model = new AlumnoModel();
        $modelAR = new AlumnoRolModel();
        $modelR = new RolModel();
        $rol = $modelR->where('nombre', "Candidato")->first();     
        $datos = $this->request->getJSON();  
        $data = [
            'id_alumno' => $datos->idalumno,
            'id_rol' => $rol["id"],            
        ];
        $modelAR->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

     //nuevo candidato
    public function validar()
    {
        $model = new AlumnoModel();   
        $datos = $this->request->getJSON(); 
        $alumno = $model->where("pass",$datos->pass)->first;
        if($alumno){
            $modelV = new VotacionModel(); 
            $voto = $modelV->where("idalumno",$alumno->id)->first;
            if(!$voto){
                $messages = [
                    'success' => 'verificado'
                ];   
            }else{
                $messages = [
                    'error' => 'El alumno ya emitio su voto'
                ];  
            }
        }else{
            $messages = [
                'error' => 'No existe el alumno'
            ];            
        }
         $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => $messages
        ];
         
        return $this->respondCreated($response, 201);
    }

     //nuevo candidato
    public function votar()
    {
        $model = new VotacionModel();   
        $datos = $this->request->getJSON();      
        $data = [
            'id_alumno' => $datos->idalumno,
            'id_delegado' => $datos->idcandidato,            
        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Se ha procesado su voto con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
   
    // listar resultados
    public function resultado()
    {       
        $model = new VotacionModel();
        $data = $model->VerResultados();
        return $this->respond($data, 200);
    }

     // listar resultados
    public function resultadoDetalle()
    {       
        $model = new VotacionModel();
        $datos = $this->request->getJSON();       
        $data = $model->VerDetallesResultado($datos->idcandidato);
        return $this->respond($data, 200);
    }

     // listar candidatos
    public function candidatoListar()
    {       
        $model = new AlumnoRolModel();
        $data = $model->VerCandidatos();
        return $this->respond($data, 200);
    }
    
}
<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\cursos\CursoModel;
use App\Models\cursos\EstudianteModel;
use App\Models\cursos\ExpedienteModel;
use App\Models\cursos\ProfesorModel;


class ApiCurso extends ResourceController
{
    use ResponseTrait;
    // get all product
   
    public function index()
    {       
        $model = new CursoModel();
        $data = $model->verCursos();
        return $this->respond($data, 200);
    }

     //nuevo curso
    public function nuevo()
    {        
        $model = new CursoModel(); 
        $datos = $this->request->getJSON();   
        $data = [            
            'codigo' => $datos->codigo,           
            'nombre' => $datos->nombre,
            'creditos' => $datos->creditos,
            'carrera' => $datos->carrera,
            'semestre' => $datos->semestre,
            'id_profesor' => $datos->id_profesor,
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

    //listar profesores 
    public function profesores()
    {       
        $model = new ProfesorModel();
        $datos = $this->request->getJSON();   
       
        if($datos){
            $data = $model->ProfesorCurso($datos->curso);    
        }else{
            $data = $model->findAll();
        }
        
        return $this->respond($data, 200);
    }

      //nuevo profesor
    public function nuevoprofesor()
    {        
        $model = new ProfesorModel();       
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'email' => $datos->email,           
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

   

    //listar estudiantes 
    public function estudiantes()
    {       
        $model = new EstudiantesModel();
        $datos = $this->request->getJSON();  
        
        if($datos){
            $data = $model->EstudianteCurso($datos->curso);    
        }else{
            $data = $model->findAll();
        }        
        return $this->respond($data, 200);
    }

      //nuevo estudiante
    public function nuevoestudiante()
    {        
        $model = new EstudianteModel();
        $modelEx = new ExpedienteModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'email' => $datos->email,
            'carrera' => $datos->carrera,
            'ingreso' => $datos->ingreso,
        ];   
       
        $model->insert($data);
        $idcurso = $model->getInsertID();
        $data = [
            'id_estudiante' => $datos->idestudiante,
            'id_curso' => $idcurso,  

        ];
        $modelEx->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
   

    //nuevo expediente
    public function nuevoexpediente()
    {        
        $model = new ExpedienteModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'id_estudiante' => $datos->idestudiante,
            'id_curso' => $datos->idcurso,           
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

    //nuevo nota
    public function nuevanota()
    {        
        $model = new ExpedienteModel();
        $datos = $this->request->getJSON(); 
        $exp = $model->CargarExpediente($datos->idcurso, $datos->idestudiante);
        $data = [
            'nota' => $datos->nota,  
        ];
        $model->update($exp[0]->id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
    //listar profesores 
    public function notas()
    {       
        $model = new ExpedienteModel();
        $datos = $this->request->getJSON();       
        $data = $model->VerNotas($datos->curso);   
       
        return $this->respond($data, 200);
    }
}
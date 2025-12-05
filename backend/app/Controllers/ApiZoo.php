<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\zoologico\ZoologicoModel;
use App\Models\zoologico\AnimalModel;
use App\Models\zoologico\EspecieModel;
use App\Models\zoologico\TrasladoModel;


class ApiZoo extends ResourceController
{
    use ResponseTrait;
    // listar alumnos
    public function index()
    {       
        $model = new ZoologicoModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    //nuevo cliente
    public function nuevozoo()
    {        
        $model = new ZoologicoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'tamano' => $datos->tamano,
            'ciudad' => $datos->ciudad, 
            'pais' => $datos->pais, 
            'presupuesto' => $datos->presupuesto,         
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

   // listar habitaciones
    public function animales()
    {       
        $model = new AnimalModel();
        $data = $model->VerAnimales();
        return $this->respond($data, 200);
    }

  //nuevo vehiculo
    public function nuevo()
    {        
        $model = new AnimalModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'id_especie' => $datos->idespecie,
            'id_zoologico' => $datos->idzoologico,
            'sexo' => $datos->sexo, 
            'nacimiento' => $datos->nacimiento, 
            'pais' => $datos->pais,  
            'identificacion' => $datos->identificacion,       
        ];         
       
        $model->inser($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
    


    //nuevo traslado
    public function traslado()
    {        
        $model = new TrasladoModel();
        $modelA = new AnimalModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'id_zoo_origen' => $datos->idorigen,
            'id_zoo_destinp' => $datos->iddestino,
            'motivo' => $datos->motivo, 
            'id_animal' => $datos->idanimal, 
            'fecha_traslado' => $datos->fechatraslado,                  
        ];   
       
        $model->insert($data);
         $dat = [
            'id_zoologico' => $datos->iddestino,  
        ];
        $modelA->update($datos->idanimal, $dat);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
}
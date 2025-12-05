<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\vuelos\PersonaModel;
use App\Models\vuelos\PersonaRolModel;
use App\Models\vuelos\RolModel;
use App\Models\vuelos\BaseModel;
use App\Models\vuelos\AvionModel;
use App\Models\vuelos\VueloModel;
use App\Models\vuelos\VueloPersonaModel;


class ApiVuelo extends ResourceController
{
    use ResponseTrait;
    // listar personas
    public function index()
    {       
        $model = new PersonaModel();
        $data = $model->VerPersonas();
        return $this->respond($data, 200);
    }

    //nuevo cliente
    public function nuevo()
    {        
        $model = new PersonaModel();
        $datos = $this->request->getJSON();  
      
        $data = [
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,
            'codigo' => $datos->codigo,           
            'horas' => $datos->horas,
            'id_base' => $datos->base,
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

   // listar aviones
    public function aviones()
    {       
        $model = new AvionModel();
        $data = $model->verAviones();
        return $this->respond($data, 200);
    }

     //nuevo cliente
    public function nuevoAvion()
    {        
        $model = new AvionModel();
        $datos = $this->request->getJSON();  
      
        $data = [            
            'codigo' => $datos->codigo,           
            'tipo' => $datos->tipo,
            'fecha_mantenimiento' => $datos->fecha,
            'id_base' => $datos->base,
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

     // listar roles
    public function roles()
    {       
        $model = new RolModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

     // listar aviones
    public function bases()
    {       
        $model = new BaseModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

  //nuevo vehiculo
    public function tripulacion()
    {        
        $model = new VueloPersonaModel();
        $datos = $this->request->getJSON(); 
        $data = $model->VerPersonaVuelo($datos);
        return $this->respond($data, 200);
    }

     public function personaTripulacion()
    {        
        $model = new VueloPersonaModel();
        $datos = $this->request->getJSON(); 
        $data = $model->VerPersonaRol($datos);
        return $this->respond($data, 200);
    }
    
     // listar servicios
    public function vuelo()
    {       
        $model = new VueloModel(); 
        $datos = $this->request->getJSON(); 
        $data = $model->VerVuelos($datos->origen, $datos->destino,$datos->fecha);  
          
        return $this->respond($data, 200);
    }

    //nuevo servicio
    public function salidanueva()
    {        
        $model = new VueloModel();
        $modelVP = new VueloPersonaModel();
        $datos = $this->request->getJSON();        
        $data = [            
            'numero' => $datos->numero,           
            'origen' => $datos->origen,
            'destino' => $datos->destino,
            'fecha' => $datos->fecha,
            'hora_salida' => $datos->hora_salida,
            'id_avion' => $datos->avion,
        ];
        $model->insert($data);
        $vuelo = $model->getInsertID();
        foreach($datos->personas as $p){             
            $data = [            
                'id_vuelo' => $vuelo,           
                'id_persona_rol' => $p,           
            ];
            $modelVP->insert($data);
        }
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

    //funcion eliminar
    public function eliminar(){
        $model = new PersonaModel();
        $datos = $this->request->getJSON(); 
        $model->delete($datos); 
         $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Eiminados'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }

     //funcion eliminar
    public function eliminarAvion(){
        $model = new AvionModel();
        $datos = $this->request->getJSON(); 
        $model->delete($datos); 
         $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Eiminados'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
}
<?php
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\hotel\ClienteModel;
use App\Models\hotel\HabitacionModel;
use App\Models\hotel\ReservaModel;


class ApiHotel extends ResourceController
{
    use ResponseTrait;
    // listar alumnos
    public function index()
    {       
        $model = new ClienteModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    //nuevo cliente
    public function nuevo()
    {        
        $model = new ClienteModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'nombre' => $datos->nombre,
            'apellido' => $datos->apellido,                 
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
    public function habitaciones()
    {       
        $model = new HabitacionModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

  //nuevo vehiculo
    public function habitacionedicion()
    {        
        $model = new VehiculoModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'numero' => $datos->numero,
            'tipo' => $datos->tipo,
            'precio_noche' => $datos->precionoche, 
            'estado' => $datos->estado,          
        ];  
       
        $model->update($this->request->getPost('id'), $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Datos Guardados con exito'
            ]
        ];
         
        return $this->respondCreated($response, 201);
    }
    
     // listar servicios
    public function reservas()
    {       
        $model = new ReservaModel();
        $data = $model->VerReservas();
        return $this->respond($data, 200);
    }

    //nuevo servicio
    public function nuevareserva()
    {        
        $model = new ReservaModel();
        $datos = $this->request->getJSON(); 
        $data = [  
            'total' => $datos->total,
            'fecha_salida' => $datos->fechasalida,           
            'fecha_ingreso' => $datos->fechaingreso, 
            'id_habitacion' => $datos->idhabitacion, 
            'id_cliente' => $datos->idcliente,          
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
}
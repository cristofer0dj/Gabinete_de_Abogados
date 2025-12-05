<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
//RUTAS DE VOTACION API
$routes->group('votacion',  function ($routes) {
    $routes->get('alumno', 'ApiVotacion::index');
    $routes->post('nuevo_alumno', 'ApiVotacion::nuevo');
    $routes->post('candidato', 'ApiVotacion::candidato');
    $routes->get('candidato_listar', 'ApiVotacion::candidatoListar');
    $routes->post('votar', 'ApiVotacion::votar');
    $routes->post('validar_voto', 'ApiVotacion::validar');
    $routes->get('resultado', 'ApiVotacion::resultado');
    $routes->get('resultado_detalle', 'ApiVotacion::resultadoDetalle');
});
//RUTAS DE CURSO
$routes->group('cursos', function ($routes) {
    $routes->get('lista', 'ApiCurso::index');
    $routes->post('nuevo_curso', 'ApiCurso::nuevo');
    $routes->get('profesores', 'ApiCurso::profesores');   
    $routes->post('nuevo_profesor', 'ApiCurso::nuevoprofesor');
    $routes->get('estudiantes', 'ApiCurso::estudiantes');
    $routes->post('nuevo_estudiante', 'ApiCurso::nuevoestudiante');
    $routes->post('estudiante_curso', 'ApiCurso::nuevoexpediente');
    $routes->get('nueva_nota', 'ApiCurso::nuevanota');
    $routes->get('notas', 'ApiCurso::notas');
});
//RUTAS DE TALLER
$routes->group('taller', function ($routes) {
    $routes->get('lista', 'ApiTaller::index');
    $routes->post('nuevo_cliente', 'ApiTaller::nuevo');
    $routes->get('vehiculos', 'ApiTaller::vehiculos');
    $routes->post('nuevo_vehiculo', 'ApiTaller::nuevovehiculo');
    $routes->get('servicios', 'ApiTaller::servicios');
    $routes->post('nuevo_servicio', 'ApiTaller::nuevoservicio');    
});

//RUTAS HOTEL
$routes->group('hotel', function ($routes) {
    $routes->get('lista', 'ApiHotel::index');
    $routes->post('nuevo_cliente', 'ApiHotel::nuevo');
    $routes->get('habitaciones', 'ApiHotel::habitaciones');
    $routes->post('edicion_habitacion', 'ApiHotel::habitacionedicion');
    $routes->get('reservas', 'ApiHotel::reservas');
    $routes->post('nueva_reserva', 'ApiHotel::nuevareserva');    
});

//RUTAS DESPACHO
$routes->group('despacho', function ($routes) {
    $routes->get('lista', 'ApiDespacho::index');
    $routes->post('nuevo_cliente', 'ApiDespacho::nuevo');
    $routes->get('abogados', 'ApiDespacho::abogados');
    $routes->post('nuevo_abogado', 'ApiDespacho::nuevoabogado');
    $routes->post('casos_abogado', 'ApiDespacho::abogadocaso');
    $routes->get('casos_abogado', 'ApiDespacho::abogadocaso');
    $routes->get('asuntos', 'ApiDespacho::asuntos');
    $routes->post('nuevo_asunto', 'ApiDespacho::asuntonuevo');  
    $routes->get('debug', 'ApiDespacho::debugAsignacion');
    
    
    $routes->get('despacho/lista', 'ApiDespacho::index');
    $routes->post('despacho/nuevo_cliente', 'ApiDespacho::nuevo');
    $routes->get('despacho/abogados', 'ApiDespacho::abogados');
    $routes->post('despacho/nuevo_abogado', 'ApiDespacho::nuevoabogado');
    $routes->post('despacho/casos_abogado', 'ApiDespacho::abogadocaso');
    $routes->get('despacho/casos_abogado', 'ApiDespacho::abogadocaso');
    $routes->get('despacho/asuntos', 'ApiDespacho::asuntos');
    $routes->post('despacho/nuevo_asunto', 'ApiDespacho::asuntonuevo');
});

//RUTAS ZOOLOGICO
$routes->group('zoo', function ($routes) {
    $routes->get('lista', 'ApiZoo::index');
    $routes->post('nuevo_animal', 'ApiZoo::nuevo');
    $routes->get('animales', 'ApiZoo::animales');
    $routes->post('traslado', 'ApiZoo::traslado');
    $routes->post('nueva_zoo', 'ApiZoo::nuevozoo');    
});

//RUTAS CLUB
$routes->group('club', function ($routes) {
    $routes->get('lista', 'ApiClub::index');
    $routes->post('nuevo_socio', 'ApiClub::nuevo');
    $routes->get('barcos', 'ApiClub::barcos');
    $routes->post('nuevo_barco', 'ApiClub::barconuevo');
    $routes->get('salidas', 'ApiClub::salidas');
    $routes->post('nueva_salida', 'ApiClub:salidanueva');    
});

//RUTAS VUELOS
$routes->group('vuelo', function ($routes) {
    $routes->get('lista', 'ApiVuelo::index');
    $routes->post('nueva_persona', 'ApiVuelo::nuevo');
    $routes->get('aviones', 'ApiVuelo::aviones');
    $routes->post('tripulacion', 'ApiVuelo::tripulacion');
    $routes->post('vuelo', 'ApiVuelo::vuelo');
    $routes->post('nuevo_vuelo', 'ApiVuelo::salidanueva'); 
    $routes->get('roles', 'ApiVuelo::roles');
    $routes->get('bases', 'ApiVuelo::bases');   
    $routes->get('persona_tripulacion', 'ApiVuelo::personaTripulacion');   
    $routes->post('eliminar_persona', 'ApiVuelo::eliminar');
    $routes->post('eliminar_avion', 'ApiVuelo::eliminarAvion');
    $routes->post('nuevo_avion', 'ApiVuelo::nuevoAvion');
});

// DEBUG ROUTES
$routes->get('debug/asignacion', 'ApiDespacho::debugAsignacion');
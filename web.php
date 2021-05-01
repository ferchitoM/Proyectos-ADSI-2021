<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\VotacionController;
use App\Http\Controllers\appController;
use App\Http\Controllers\Auth\perfil;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\exportarPDF;
use App\Http\Controllers\FiscalizarController;
use App\Http\Controllers\GanadorController;
use App\Http\Controllers\GrupoController;



//REDIRECCION DEL USUARIO ADMIN O APRENDIZ
Route::get('/', [perfil::class, 'index'])
    ->middleware('guest')
    ->name('index');

//ENRUTAMOS EL USUARIO DESDE LA DASHBOARD A ADMINISTRACION O A APP
Route::get('/dashboard', [perfil::class, 'enrutarUsuario'])
    ->middleware(['auth']) //'verified'
    ->name('enrutar-usuario');

require __DIR__ . '/auth.php';




//PERFIL USUARIO
Route::match(['get', 'post'], '/perfil', [perfil::class, 'perfil'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('perfil');

//ACTUALIZAR DATOS USUARIO
Route::match(['get', 'post'], '/perfil/actualizar/info', [perfil::class, 'actualizarDatos'])
    ->middleware(['auth', 'Roles:admin,aprendiz']) //'verified'
    ->name('perfil-datos');

//ACTUALIZAR PASSWORD USUARIO
Route::match(['get', 'post'], '/perfil/actualizar/password', [perfil::class, 'actualizarPassword'])
    ->middleware(['auth', 'Roles:admin,aprendiz']) //'verified'
    ->name('perfil-password');




//PERFIL ADMIN
Route::match(['get', 'post'], '/perfil-admin', [perfil::class, 'perfil_admin'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('perfil-admin');

//REGISTRAR ADMIN
Route::match(['get', 'post'], '/Administracion/registrar/admin', [RegisteredUserController::class, 'crearAdmin'])
    ->middleware('guest')
    ->name('admin-registrar');

//ACTUALIZAR DATOS ADMIM
Route::match(['get', 'post'], '/perfil/actualizar/info-admin', [perfil::class, 'actualizarDatos_admin'])
    ->middleware(['auth']) //'verified'
    ->name('perfil-datos-admin');




//APP MOBILE
Route::match(['get', 'post'], '/app/index', [appController::class, 'index'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-index');

Route::match(['get', 'post'], '/app/selec_grupo', [GrupoController::class, 'index'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-grupo');

Route::match(['get', 'post'], '/app/actualizar_grupo/{aprendiz}/{grupo}', [appController::class, 'grupo'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-actualizarGrupo');

Route::match(['get', 'post'], '/app/candidatos', [appController::class, 'candidatos'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-candidatos');

Route::match(['get', 'post'], '/app/propuesta', [appController::class, 'propuesta'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-propuesta');

Route::match(['get', 'post'], '/app/votar', [appController::class, 'votar'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-votar');

Route::match(['get', 'post'], '/app/certificado', [exportarPDF::class, 'generarCertificado'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-certificado');

Route::match(['get', 'post'], '/app/ganador', [appController::class, 'ganador'])
    ->middleware(['auth', 'Roles:NULL,aprendiz']) // 'verified'
    ->name('app-ganador');






//ADMINSTRACION

//Bienestar
Route::match(['get', 'post'], '/Administracion', function () {
    return view('Administracion.Bienestar');
})
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-bienestar');

//Candidatos lista
Route::match(['get', 'post'], '/Administracion/Candidatos', [CandidatoController::class, 'index'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-candidatos');

//Candidatos Crear
Route::match(['get', 'post'], '/Administracion/Crear', [CandidatoController::class, 'create'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-Crear');

//Candidatos Crear-Ruta
Route::match(['get', 'post'], '/Administracion/Guardar', [CandidatoController::class, 'store'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('Guardar-candidato');

//Candidatos Editar 
Route::match(['get', 'post'], '/Administracion/editar', [CandidatoController::class, 'edit'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('editar-candidato');

//Candidatos Modificar
Route::match(['get', 'post'], '/Administracion/modificar/{Candidato}', [CandidatoController::class, 'update'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('modificar-candidato');


//Candidatos eliminar 
Route::match(['get', 'post'], '/Administracion/eliminar', [CandidatoController::class, 'destroy'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('eliminar-candidatos');


//Lista Aprendices
Route::get('/Administracion/ListaAprendiz', [AprendizController::class, 'index'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-ListaAprendiz');


//Tabla Votacion
Route::match(['get', 'post'], '/Administracion/Votacion', [VotacionController::class, 'index'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-Votacion');

// Crear Votacion
Route::match(['get', 'post'], '/Administracion/CrearVotacion', [VotacionController::class, 'create'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-CrearVotacion');

//Guardar Crear
Route::match(['get', 'post'], '/Administracion/GuardarVotacion', [VotacionController::class, 'store'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-GuardaVotacion');

// Edictar votacion 
Route::match(['get', 'post'], '/Administracion/editarVotacion/{Votacion}', [VotacionController::class, 'edit'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('editar-Votacion');

// Modificar votacion
Route::match(['get', 'post'], '/Administracion/modificarVotacion/{datos_Votacion}', [VotacionController::class, 'update'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('modificar-Votacion');

// eliminar votacion 
Route::match(['get', 'post'], '/Administracion/eliminarVotacion/{Votacion}', [VotacionController::class, 'destroy'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('eliminar-Votacion');

//Tabla Regional
Route::match(['get', 'post'], '/Administracion/Regional', [RegionalController::class, 'index'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-Regional');

//Crear Regional
Route::match(['get', 'post'], '/Administracion/CrearRegional', [RegionalController::class, 'create'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('Crear-Regional');

//Guardar  Regional
Route::match(['get', 'post'], '/Administracion/GuardarRegional', [RegionalController::class, 'store'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('Guardar-Regional');

// Edictar Regional 
Route::match(['get', 'post'], '/Administracion/editarRegional/{regional}', [RegionalController::class, 'edit'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('editar-Regional');

// Modificar Regional
Route::match(['get', 'post'], '/Administracion/modificarRegional/{regional}', [RegionalController::class, 'update'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('modificar-Regional');


//Tabla Ganador 
Route::match(['get', 'post'], '/Administracion/Ganador', [GanadorController::class, 'index'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-Ganador');

//Fiscalizar votos
Route::match(['get', 'post'], '/Administracion/Fiscalizar', [FiscalizarController::class, 'index'])
    ->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-Fiscalizar');


//Eleccion
Route::get('/Administracion/Eleccion', function () {
    return view('Administracion.Eleccion');
})->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-eleccion');

//Votos
Route::get('/Administracion/Votos', function () {
    return view('Administracion.Votos');
})->middleware(['auth', 'Roles:admin,NULL']) // 'verified'
    ->name('admin-votos');

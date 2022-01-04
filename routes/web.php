<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\TratamientosController;
use App\Http\Livewire\PagosController;
use App\Http\Livewire\EstadosController;
use App\Http\Livewire\MedicosController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\CitasController;
use App\Http\Livewire\ClinicaController;
use App\Http\Livewire\PacientesController;
use App\Http\Livewire\CalendarController;
use App\Http\Livewire\PagosExtrasController;
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\ReportsFechasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function(){

   // Route::get('/home', [App\Http\Livewire\PacientesController::class, 'countPaciente'])->name('home'); // ESTADISTICAS
   Route::get('home', [\App\Http\Controllers\DashController::class, 'data'])->name('dash');
    Route::get('/calendario', CalendarController::class); //AGENDA
    Route::get('citas', CitasController::class);
    Route::get('/pacientes', PacientesController::class);
    Route::get('/tratamientos', TratamientosController::class);
    Route::get('/estados', EstadosController::class);
    Route::get('/pagos', PagosController::class); // TIPOS PAGOS
    Route::get('/medicos', MedicosController::class);
    Route::get('/usuarios', UsersController::class);
    Route::get('roles', RolesController::class);
    Route::get('permisos', PermisosController::class);
    Route::get('asignar', AsignarController::class);
    Route::get('clinica', ClinicaController::class);
    Route::get('/pagosextras', PagosExtrasController::class);


    Route::get('dash', [\App\Http\Controllers\DashController::class, 'data']);


//reporte borrado
//Route::get('/reportes', ReportsController::class);

//reportesfechas
// ruta  para mostrar en vista lo que se va a reportar (pilas ctm)
Route::get('/reportesfechas', ReportsFechasController::class);

// reporte borrado
//Route::get('report/pdf/{medico}', [App\Http\Controllers\ExportController::class, 'reportPDF']); // por dia

// de vuelta desde la vista para crear el pdf
Route::get('crearpdf/pdf/{medico_id}/{type}/{f1}/{f2}', [\App\Http\Controllers\CreatePdfController::class,'crearPdf']);
Route::get('crearpdf/pdf/{medico_id}/{type}', [\App\Http\Controllers\CreatePdfController::class,'crearPdf']);
Route::get('detpaciente/{idpaciente}', [\App\Http\Controllers\CreatePdfController::class,'detallePacientePDF']);

});









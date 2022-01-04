<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(){

        $events = Cita::join('pacientes as p', 'p.id','citas.paciente_id')
        ->join('tratamientos as t', 't.id','citas.tratamiento_id')
        //->join('pagos as pa', 'pa.id','citas.pago_id')
        ->join('estados as e', 'e.id','citas.estado_id')
        ->select('p.nombre as title','citas.id as id_cita','fecha_ini AS start','fecha_fin AS end', 'estado_pago as estado_pago',
                't.nombre as tratamiento', 'e.nombre as estado')->get();
        // $events = json_encode($events);
        // return $events;
        return response()->json($events);
    }
}

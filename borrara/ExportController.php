<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\PagoExtra;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportController extends Controller
{


    public function reportPDF($medico_id)
    {
        $data = [];
        $total_diario = 0;
        $extras = 0;
        $from =  Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
        $to =  Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        $pagosextras = PagoExtra::whereBetween('created_at',[$from,$to])->get();
        if($medico_id == 0) // si no se elige el usuario se muestra las ventas de todos ls usuarios
        {

            $data =  Cita::join('medicos as m', 'm.id', 'citas.medico_id')
            ->select('citas.*','m.nombre as medico')
            ->where(function($query) use ($from, $to)
                    {
                        $query->whereBetween('citas.created_at', [$from,$to])
                               ->orwhereBetween('citas.updated_at', [$from,$to]);
                    })
                    ->where('citas.pago_id',1)
                     ->get();
                    // dd($this->data);
        }
        else{
            $data = Cita::join('medicos as m', 'm.id', 'citas.medico_id')
            ->select('citas.*','m.nombre as medico')
            ->where(function($query) use ($from, $to)
            {
                $query->whereBetween('citas.created_at', [$from,$to])
                       ->orwhereBetween('citas.updated_at', [$from,$to]);
            })
            ->where('medico_id', $medico_id)
            ->where('citas.pago_id',1)
            ->get();
        }
        $medico = $medico_id == 0 ? 'Todos' : Medico::find($medico_id)->nombre;
        $pdf = PDF::loadView('pdf.reporte', compact('data','medico_id','total_diario','extras','pagosextras'));
         //visaualizar en el navegador
         return $pdf->stream('reporteVentas.pdf');

         //descargar
         // return $pdf->download('reporteVentas.pdf');

    }

}

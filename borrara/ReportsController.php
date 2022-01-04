<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Medico;
use App\Models\Cita;
use App\Models\Pago;
use App\Models\PagoExtra;
use Carbon\Carbon;


class ReportsController extends Component
{

    public $componentName, $data,$medico_id, $dateFrom, $dateTo, $cita_id, $pago_id, $total_diario, $extras;

    public function mount()
    {

         $this->componentName = 'Reportes de Citas';
         $this->data = [];
         $this->details = [];
         $this->sumDetails =0;
         $this->countDetails =0;
         $this->reportType =0; // por defecto para que el reporte sea venta del dia
         $this->medico_id =0;
         $this->cita_id =0;

            }
    public function render()
    {
        $this->citasPorFecha();

        // para sacqar pagos extras
        $fi =  Carbon::parse( Carbon::today())->format('Y-m-d') . ' 00:00:00';
        $ff =  Carbon::parse( Carbon::today())->format('Y-m-d') . ' 23:59:59';
        $pagosextras = PagoExtra::whereBetween('created_at',[$fi,$ff])->get();
        //dd($pagosextras);

        return view('livewire.reportes.component', [
            'medicos' => Medico::orderBy('nombre','asc')->get(),
            'pagos' => Pago::orderBy('nombre','asc')->get(),
            'pagosextras' => $pagosextras

        ])->extends('layouts.theme.app')
        ->section('content');
    }

    function citasPorFecha()
    {
        // ventas del dia

        $from =  Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
        $to =  Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';


        if($this->medico_id == 0) // si no se elige el usuario se muestra las ventas de todos ls usuarios
        {

            $this->data =  Cita::join('medicos as m', 'm.id', 'citas.medico_id')
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
            $this->data = Cita::join('medicos as m', 'm.id', 'citas.medico_id')
            ->select('citas.*','m.nombre as medico')
            ->where(function($query) use ($from, $to)
            {
                $query->whereBetween('citas.created_at', [$from,$to])
                       ->orwhereBetween('citas.updated_at', [$from,$to]);
            })
            ->where('medico_id', $this->medico_id)
            ->where('citas.pago_id',1)
            ->get();
        }
    }


}

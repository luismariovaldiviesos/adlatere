<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Medico;
use App\Models\Cita;
use App\Models\Pago;
use App\Models\PagoExtra;
use Carbon\Carbon;

class ReportsFechasController extends Component
{



    public $componentName, $citas, $pagosextras, $sumCitas, $sumExtras,
    $reportType, $medico_id, $dateFrom, $dateTo, $doctores;

    public function mount()
    {
        $this->componentName ='Reporte entre fechas';
        $this->citas =[];
        $this->pagosextras =[];
        $this->sumCitas =0;
        $this->sumExtras =0;
        $this->reportType =0;
        $this->userId =0;
        $this->reportType =0;
        $this->medico_id =0;
        $this->doctores = Medico::all();


    }

    public function render()
    {

        $this->reportFechas();

        return view('livewire.reportes.componentreportefechas'

        )->extends('layouts.theme.app')
        ->section('content');
    }

    public function reportFechas()
    {
        if($this->reportType == 0) // ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';

        } else {
             $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
             $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        if($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo =='')) {
            return;
        }

        if($this->medico_id == 0)
        {
            $this->citas= Cita::join('medicos as m', 'm.id', 'citas.medico_id')
            ->select('citas.*','m.nombre as medico')
            ->where(function($query) use ($from,$to)
                    {
                        $query->whereBetween('citas.created_at', [$from,$to])
                               ->orwhereBetween('citas.updated_at', [$from,$to]);
                    })
                    ->where('citas.estado_pago','PAGADO')
                     ->get();
                     $this->pagosextras = PagoExtra::whereBetween('created_at',[$from,$to])->get();
                    // dd('todos');

        } else {
            $this->citas = Cita::join('medicos as m', 'm.id', 'citas.medico_id')
                ->select('citas.*','m.nombre as medico')
                ->where(function($query) use ($from,$to)
                {
                    $query->whereBetween('citas.created_at', [$from,$to])
                           ->orwhereBetween('citas.updated_at', [$from,$to]);
                })
                ->where('medico_id', $this->medico_id)
                ->where('citas.estado_pago','PAGADO')
                ->get();
                $this->pagosextras = PagoExtra::whereBetween('created_at',[$from,$to])->get();
                //dd('por medicos');
        }

    }

//     //variables de la vista
//     public $medico_id, $fechainicio,$fechafin, $citas,$pagosextras, $totalcitas, $totalextras, $medicos;

//    public function  mount()
//    {
//        $this->citas = [];
//        $this->pagosextras =[];
//        $this->totalcitas =0;
//        $this->totalextras =0;
//        $this->medicos = Medico::all();

//    }



//     public function render()
//     {
//         $this->reportCitas();
//         return view('livewire.reportes.componentreportefechas',
//         [
//             'citas' => $this->citas,
//             'pagosextras' => $this->pagosextras

//         ]

//         )->extends('layouts.theme.app')
//         ->section('content');
//     }


//     public function reportCitas()
//     {

//         if($this->fechainicio == null || $this->fechafin == null){
//             $f1 =Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
//             $f2 = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
//         }
//         else{
//             $f1 =Carbon::parse($this->fechainicio)->format('Y-m-d') . ' 00:00:00';
//             $f2 = Carbon::parse($this->fechafin)->format('Y-m-d')   . ' 23:59:59';
//         }

//         if($this->medico_id == null) // todos
//         {
//             $this->citas= Cita::join('medicos as m', 'm.id', 'citas.medico_id')
//             ->select('citas.*','m.nombre as medico')
//             ->where(function($query) use ($f1,$f2)
//                     {
//                         $query->whereBetween('citas.created_at', [$f1,$f2])
//                                ->orwhereBetween('citas.updated_at', [$f1,$f2]);
//                     })
//                     ->where('citas.pago_id',1)
//                      ->get();
//                      $this->pagosextras = PagoExtra::whereBetween('created_at',[$f1,$f2])->get();
//                     // dd('todos');
//         }
//         else{

//             $this->data = Cita::join('medicos as m', 'm.id', 'citas.medico_id')
//                 ->select('citas.*','m.nombre as medico')
//                 ->where(function($query) use ($f1,$f2)
//                 {
//                     $query->whereBetween('citas.created_at', [$f1,$f2])
//                            ->orwhereBetween('citas.updated_at', [$f1,$f2]);
//                 })
//                 ->where('medico_id', $this->medico_id)
//                 ->where('citas.pago_id',1)
//                 ->get();
//                 //dd('por medicos');


//         }

//     }
}

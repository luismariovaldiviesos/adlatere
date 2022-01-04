<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Tratamiento;
use App\Models\Estado;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\PagoExtra;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class DashController extends Controller
{
    public $listCitas, $listpagos, $balance;




    public function data()
    {

        return view('dash');

    //     $currentYear =  date('Y');
    //     $start =  date('Y-m-d', strtotime('monday this week')); // lunes
    //     $finish =  date('Y-m-d', strtotime('sunday this week'));// domingo

    //     $d1 =  strtotime($start);
    //     $d2 = strtotime($finish);
    //     $array =  array();
    //     for($currentDate =  $d1; $currentDate <= $d2; $currentDate +=(86400))  // se suma un dia (86400 segundos)
    //     {
    //         $dia = date('Y-m-d', $currentDate); // convertir dia en formato unix  a formato ingles standard
    //         $inicio = $dia. ' 00:00:00';
    //         $fin = $dia. ' 23:59:59';

    //         $array[] = $dia; //lunes masrtes etc
    //     }

    //     $sql =  "SELECT c.fecha, IFNULL(c.total,0) as total FROM(
    //         SELECT '$array[0]' as fecha
    //         UNION
    //         SELECT '$array[1]' as fecha
    //         UNION
    //         SELECT '$array[2]' as fecha
    //         UNION
    //         SELECT '$array[3]' as fecha
    //         UNION
    //         SELECT '$array[4]' as fecha
    //         UNION
    //         SELECT '$array[5]' as fecha
    //         UNION
    //         SELECT '$array[6]' as fecha
    //         ) d
    //         LEFT JOIN (
    //         SELECT SUM(total) as total, DATE(created_at) as
    //         fecha FROM citas WHERE created_at BETWEEN '$start' AND '$finish'
    //         AND estado_pago ='PAGADO' GROUP BY DATE(created_at)) c ON d.fecha =  c.fecha";


    //         $weekSales = DB::select(DB::raw($sql));
    //         //dd($weekSales);

    //         $chartVentasxSemana = new LarapexChart();
    //         $chartVentasxSemana->setTitle('CITAS AGENDADAS Y  PAGADAS DE ESTA SEMANA')
    //         ->setLabels(['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','Sabado','Domingo'])
    //         ->setType('donut')
    //         ->setDataSet([intval($weekSales[0]->total),
    //                 intval($weekSales[1]->total),
    //                 intval($weekSales[2]->total),
    //                 intval($weekSales[3]->total),
    //                 intval($weekSales[4]->total),
    //                 intval($weekSales[5]->total),
    //                 intval($weekSales[6]->total),
    //                       ]);





    //      //GRAIFCO VENTAS POR MES

    //    // $anioActual =  date('Y');
    //     $mesActual = date('m');

    //     $arrayMes = array();
    //     for($i = 1; $i<=12; $i++)
    //     {
    //         //$cita =  Cita::whereMonth('created_at', '=', $i)->where('estado_pago','PAGADO');
    //         $cita = Cita::where(function($query) use ($i)
    //         {
    //             $query->whereMonth('created_at', '=', $i)
    //                     ->orwhereMonth('updated_at', '=', $i);
    //         })->where('estado_pago','PAGADO');
    //         $arrayMes[] = $cita->sum('total');


    //     }
    //     //dd($arrayMes);
    //    $enero = $arrayMes[0];
    //    $febrero = $arrayMes[1];
    //    $marzo = $arrayMes[2];
    //    $abril = $arrayMes[3];
    //    $mayo = $arrayMes[4];
    //    $junio = $arrayMes[5];
    //    $julio = $arrayMes[6];
    //    $agosto = $arrayMes[7];
    //    $septiembre = $arrayMes[8];
    //    $octubre = $arrayMes[9];
    //    $noviembre = $arrayMes[10];
    //    $diciembre = $arrayMes[11];
    //    //dd($arrayMes);
    //    $chartVentasxMes = (new LarapexChart)->setType('area')
    //    ->setTitle('TOTAL RECAUDADO SOLO CITAS POR MES')
    //    ->setSubtitle('Por mes')
    //    ->setGrid(true)
    //    ->setXAxis(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
    //    'Agosto','Septiembre','Octubre','Noviembre','Diciembre',])
    //    ->setDataSet([
    //        [
    //            'name' => 'Citas Pagadas:',
    //            'data' =>
    //            [
    //               $enero,
    //               $febrero,
    //               $marzo,
    //               $abril,
    //               $mayo,
    //               $junio,
    //               $julio,
    //               $agosto,
    //               $septiembre,
    //               $octubre,
    //               $noviembre,
    //               $diciembre,
    //            ]
    //        ]
    //    ]);


    //    // balance


    //     for($i=0; $i<12; $i++)
    //     {

    //         $this->listCitas[$i]=Cita::whereMonth('created_at', $i+1)->whereYear('created_at', $currentYear)->sum('total');

    //     }


    //     for($i=0; $i<12; $i++)
    //     {

    //         $this->listpagos[$i]=PagoExtra::whereMonth('created_at', $i+1)->whereYear('created_at', $currentYear)->sum('monto');

    //     }

    //     for($i=0; $i<12; $i++)
    //     {

    //         $this->balance[$i]= $this->listCitas[$i] + $this->listpagos[$i];

    //     }

    //     $chartBalancexMes = (new LarapexChart)->setTitle('BALANCE ANUAL CITAS Y PAGOS EXTRAS')
    //     ->setType('bar')
    //     ->setXAxis(['Ene','Feb','Mar','Abr','May','Jun','Jul',
    //         'Ago','Sep','Oct','Nov','Dic',])
    //     ->setGrid(true)
    //     ->setDataset([
    //         [
    //             'name' => 'Citas',
    //             'data' => $this->listCitas
    //         ],
    //         [
    //             'name' => 'Pagos',
    //             'data' => $this->listpagos
    //         ],
    //         [
    //             'name' => 'Balance',
    //             'data' => $this->balance
    //         ]

    //     ]);


    //     $usuarios = (new LarapexChart)->pieChart()
    //                 ->setTitle('USUARIOS DEL SISTEMA')
    //                 ->setDataset([
    //                     \App\Models\User::where('status','=','ACTIVE')->count(),
    //                     \App\Models\User::where('status','=','LOCKED')->count(),
    //                 ])->setColors(['#ffc63b','#FF6384'])->setLabels(['USUARIOS ACTIVOS','USUARIOS SUSPENDIDOS']);






    //     // citas

    //     $atendidas  = Cita::where('estado_id',1)->whereYear('created_at',$currentYear)->count();
    //     $pendientes  = Cita::where('estado_id',2)->whereYear('created_at',$currentYear)->count();
    //     $canceladas  = Cita::where('estado_id',3)->whereYear('created_at',$currentYear)->count();
    //     $noasiste  = Cita::where('estado_id',4)->whereYear('created_at',$currentYear)->count();
    //     $totalcitas = $atendidas+$pendientes+$canceladas+$noasiste;
    //    // dd($atendidas);



    //     // for($i=0; $i<12; $i++)
    //     // {

    //     //    $this->atendidas[$i]=Cita::whereMonth('created_at', $i+1)->whereYear('created_at', $currentYear)->where('estado_id','=',1)->count();
    //     //    $this->pendientes[$i]=Cita::whereMonth('created_at', $i+1)->whereYear('created_at', $currentYear)->where('estado_id','=',2)->count();
    //     //    $this->canceladas[$i]=Cita::whereMonth('created_at', $i+1)->whereYear('created_at', $currentYear)->where('estado_id','=',3)->count();
    //     //    $this->noasiste[$i]=Cita::whereMonth('created_at', $i+1)->whereYear('created_at', $currentYear)->where('estado_id','=',4)->count();
    //     // }
    //     // $citas =  Cita::all();
    //     // for($i = 0; $i++; $i<= $citas->count())
    //     // {
    //     //     //dd($c->estado->nombre);

    //     //      if($citas->estado->nombre = 'ATENDIDO'){
    //     //         $this->atendidas ++;
    //     //      }
    //     //      elseif($citas->estado->nombre == 'PENDIENTE'){
    //     //         $this->pendientes ++;
    //     //      }
    //     //      elseif($citas->estado->nombre == 'CANCELADO'){
    //     //         $this->canceladas ++;
    //     //      }
    //     //      else{
    //     //          $this->noasiste ++;
    //     //      }

    //     //     dd($this->atendidas);
    //     // }
    //     //$totalcitas = $atendidas+$pendientes+$canceladas+$noasiste;


    //     //dd($this->atendidas);

    //     //        $estadoscitas =  (new LarapexChart)->polarAreaChart()
    //     //             ->setTitle('NUMERO DE CITAS POR ESTADO')
    //     //             ->setSubtitle('año 2001')
    //     //             ->setDataset([$this->atendidas, $this->pendientes, $this->canceladas,$this->noasiste])
    //     //             ->setLabels(['Citas Atendidas', 'Pendientes', 'canceladas','No asiste']);



    //     //USUARIOS POR MES
    //        $arrayMes = array();
    //         for($i = 1; $i<=12; $i++)
    //         {
    //             $paciente =  Paciente::whereMonth('created_at', '=', $i);
    //              $arrayMes[] = $paciente->count();
    //         }
    //    //dd($arrayMes);
    //   $enero = $arrayMes[0];
    //   $febrero = $arrayMes[1];
    //   $marzo = $arrayMes[2];
    //   $abril = $arrayMes[3];
    //   $mayo = $arrayMes[4];
    //   $junio = $arrayMes[5];
    //   $julio = $arrayMes[6];
    //   $agosto = $arrayMes[7];
    //   $septiembre = $arrayMes[8];
    //   $octubre = $arrayMes[9];
    //   $noviembre = $arrayMes[10];
    //   $diciembre = $arrayMes[11];
    //   //dd($arrayMes);

    // $chartpacientesxmes = (new LarapexChart)->pieChart()
    // ->addData([$enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre, $noviembre, $diciembre])
    // ->setTitle('PACIENTES NUEVOS REGISTRADOS POR MES')
    // ->setLabels(['Enero','Febrero','MArzo','Abril','MAyo','Junio','Julio','Agosto','Septiembre','Octubre', 'Noviembre', 'Diciembre']);

    // return view('dash', compact('chartVentasxSemana',
    // 'chartVentasxMes','chartBalancexMes','usuarios','chartpacientesxmes',
    // 'atendidas','pendientes','canceladas','noasiste','totalcitas'));


    }
}

<?php

namespace App\Charts;

use App\Models\Paciente;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PacientesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {

        $anioActual =  date('Y');
        $mesActual = date('m');

        $array = array();
        for($i = 1; $i<=12; $i++)
        {
            $paciente =  Paciente::whereMonth('created_at', '=', $i);
            $array[] = $paciente->count();

        }
       $enero = $array[0];
       $febrero = $array[1];
       $marzo = $array[2];
       $abril = $array[3];
       $mayo = $array[4];
       $junio = $array[5];
       $julio = $array[6];
       $agosto = $array[7];
       $septiembre = $array[8];
       $octubre = $array[9];
       $noviembre = $array[10];
       $diciembre = $array[11];
       //dd($octubre);

        //$paciente =  Paciente::whereMonth('created_at', '=', $mesActual -2);

       // dd($paciente->count());



        return $this->chart->pieChart()
            ->addData([$enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre, $noviembre, $diciembre])
            ->setLabels(['Enero','Febrero','MArzo','Abril','MAyo','Junio','Julio','Agosto','Septiembre','Octubre', 'Noviembre', 'Diciembre']);
    }
}

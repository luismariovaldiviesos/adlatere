<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Tratamiento;
use App\Models\Estado;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $currentYear = date('Y');
        $start = date('Y-m-d', strtotime('monday this week')); //obtener el dia lunes semana actual
        $finish = date('Y-m-d', strtotime('sunday this week')); // obtener el domingo semana actual
        $d1 = strtotime($start); // convertir fecha a formato unix
        $d2 = strtotime($finish);


        return view('home');
    }


}

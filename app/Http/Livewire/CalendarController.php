<?php

namespace App\Http\Livewire;

use App\Models\Cita;
use App\Models\Estado;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CalendarController extends Component
{
    use WithPagination, WithFileUploads;
    public $events ;
    public $title, $start, $end, $tratamiento, $pago, $estado , $id_cita;


    // para agendar
    public $fecha_ini, $fecha_fin, $descripcion, $medico_id, $receta, $tratamiento_id, $estado_pago, $estado_id, $paciente_id, $total;

    // datos para cita
    public $medicos, $tratamientos, $pagos, $estados, $pacientes;

    public $editar ="si", $hoy;


    public function mount()
    {

    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        $this->medicos = Medico::all();
        $this->tratamientos = Tratamiento::all();

        $this->estados =Estado::all();
        $this->pacientes = Paciente::all();
        return view('livewire.calendario.component')->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store()
    {
        // dd(  $this->descripcion,$this->fecha_ini, $this->fecha_fin, $this->paciente_id, $this->medico_id, $this->receta,
        //         $this->tratamiento_id, $this->estado_pago,$this->estado
        //     );


        $this->validaFechas();

        $rules = [
            'paciente_id' => 'required',
            'medico_id' => 'required',
            'tratamiento_id' => 'required',
            'estado_pago' => 'required',
            'estado' => 'required'

        ];
        $messages =[
            'paciente_id.required' => 'Ingresa un paciente',
            'medico_id.required' => 'Ingresa un medico',
            'tratamiento_id.required' => 'Ingresa un tratamiento',
            'estado_pago.required' => 'Ingresa un pago',
            'estado.required' => 'Ingresa un estado'

        ];

        $this->validate($rules,$messages);
        $tratamiento =  Tratamiento::find($this->tratamiento_id);
        $cita = Cita::create([
            'descripcion' => $this->descripcion,
            'fecha_ini' => $this->fecha_ini,
            'fecha_fin' => $this->fecha_fin,
            'paciente_id' => $this->paciente_id,
            'medico_id' => $this->medico_id,
            'receta' => $this->receta,
            'user_id' => Auth::user()->id,
            'tratamiento_id' => $this->tratamiento_id,
            'total' => $tratamiento->precio,
            'estado_pago' => $this->estado_pago,
            'estado_id' => $this->estado
        ]);
        $cita->save();
        $this->resetUI();
        session()->flash('message', 'CITA AGENDADA CORRECTAMENTE');
         return redirect()->to('/calendario');
        //$this->emit('cita-added','cita registrada correctamente');



    }




    public function Update()
    {

            $cita = Cita::find($this->id_cita);
            //dd($cita) ;
            if($this->tratamiento_id == null || $this->tratamiento_id == 'Elegir')
            {
                $this->tratamiento_id = $cita->tratamiento_id;
                $this->total  = $cita->total;
            }
            if($this->estado_pago == null || $this->estado_pago == 'Elegir')
            {
                $this->estado_pago = $cita->estado_pago;
            }
            if($this->estado_id == null || $this->estado_id == 'Elegir')
            {
                $this->estado_id = $cita->estado_id;
            }

            $total  =   Tratamiento::find($this->tratamiento_id);
            $this->total = $total->precio;
            $cita->update([
                'descripcion' => $this->title,
                'fecha_ini' => $cita->fecha_ini,
                'fecha_fin' => $cita->fecha_fin,
                'paciente_id' => $cita->paciente_id,
                'medico_id' => $cita->medico_id,
                'receta' => $this->receta,
                'user_id' => Auth::user()->id,
                'tratamiento_id' => $this->tratamiento_id,
                'total' => $this->total,
                'estado_pago' => $this->estado_pago,
                'estado_id' => $this->estado_id
            ]);
            $this->resetUI();
            session()->flash('message', 'CITA ACTUALIZADA CORRECTAMENTE');
            return redirect()->to('/calendario');
    }

    public function resetUI(){

        $this->descripcion ='';
        $this->fecha_ini = '';
        $this->fecha_fin = '';
        $this->medico_id ='';
        $this->receta = "";
        $this->tratamiento_id ='';
        $this->estado_pago='';
        $this->estado='';
        $this->resetValidation();
        $this->resetPage();

    }

    public function validaFechas()
    {
        if($this->fecha_ini == null || $this->fecha_fin == null)
       {
        $this->emit('cita-error','Selecciona una fecha válida');
        return;
       }
       else
       {
        if($this->fecha_fin <= $this->fecha_ini)
        {
            $this->emit('cita-error','Fecha final debe ser mayor a fecha inicial');
            return;
        }

       }
    }




}

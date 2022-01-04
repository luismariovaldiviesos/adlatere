<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\User;
use App\Models\Tratamiento;
use App\Models\Pago;
use App\Models\Estado;
use Carbon\Carbon;
use App\Models\Cita;
use Illuminate\Support\Facades\Auth;

class CitasController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $descripcion, $fecha_ini, $fecha_fin, $medico_id, $receta, $user_id, $buscar_paciente,
    $tratamiento_id, $estado_pago, $total ;
    public $pageTitle, $componentName, $search, $selected_id;

    //VARIABLES PARA LA  BUSQUEDA PAGINA PRINCIPAL
    public  $estado_id ,$fechasearch;

    //para la cita
    public $estado;

    private $pagination = 15;

    // para guardar paciente si hace falta
    public $paciente_id, $nombre, $ci, $telefono, $email, $image, $direccion, $enfermedad, $medicamentos, $alergias;

    // para validar el boton paciente en actualizar cita
    // para no crear paciente en esa actualizacion de cita
    public $editar ="no";

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle ='Listado';
        $this->componentName ='Citas';
        $this->estado_id = 0;
        $this->citas = [];


    }


    public function render()
    {
        $this->citasTipo();
        return view('livewire.citas.component', [
            'estados' => Estado::orderBy('id','asc')->get(),
            'citas' => $this->citas,
            'pacientesSearch' => Paciente::all(),
            'pacientes' => Paciente::where('nombre','like','%'.$this->buscar_paciente.'%')->get(),
            'medicos' => Medico::all(),
            'tratamientos' => Tratamiento::all(),
            'estados' => Estado::all()

        ])->extends('layouts.theme.app')
        ->section('content');
    }

    public function cargarPaciente($paciente)
    {
        $pacienteJson =json_decode($paciente);
        $this->buscar_paciente = $pacienteJson->nombre;
        $this->paciente_id = $pacienteJson->id;

        //dd($paciente);


    }

    public function Limpiar()
    {
        $this->estado_id =0;
        $this->fechasearch = null;
        return redirect('citas');

    }

    public function citasTipo()
    {


        if($this->estado_id == 0  && $this->fechasearch == null) // todas las citas
        {

            $date = Carbon::now();
            $fi =  Carbon::parse($date)->format('Y-m-01') . ' 00:00:00';
            $this->citas =  Cita::where('fecha_ini','>=',$fi)->orderBy('fecha_ini','asc')
             ->paginate($this->pagination);
             $this->resetPage();


        }
        elseif($this->estado_id != 0 )
        {
            $this->citas =  Cita::where('estado_id', $this->estado_id)
                                ->orderBy('fecha_ini','asc')
                                    ->paginate($this->pagination);
             $this->resetPage();
        }

        if( $this->fechasearch != null)
        {

            $fi =  Carbon::parse($this->fechasearch)->format('Y-m-d') . ' 00:00:00';
             $ff =  Carbon::parse($this->fechasearch)->format('Y-m-d') . ' 23:59:59';
             $this->citas = Cita::whereBetween('fecha_ini',[$fi,$ff])
                                ->orderBy('fecha_ini','asc')
                                    ->paginate($this->pagination);
             $this->resetPage();

        }



    }
    public function  pacienteNombre()
    {

    }

    public function resetUI()
    {
        $this->descripcion ='';
        $this->fecha_ini = '';
        $this->fecha_fin = '';
        $this->buscar_paciente ='';
        $this->medico_id ='';
        $this->receta = "";
        $this->tratamiento_id ='';
        $this->estado_pago='';
        $this->estado_id='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation();
        $this->resetPage();
    }


    public function Store()
    {
        $this->validaFechas();
        //descripcion, fecha_ini, fecha_fin, paciente_id, medico_id, receta,
        //user_id, tratamiento_id, estado_pago, estado_id

        $rules = [
           'buscar_paciente' => 'required',
            'medico_id' => 'required',
            'tratamiento_id' => 'required',
            'estado_pago' => 'required',
            'estado' => 'required'

        ];
        $messages =[
           'buscar_paciente.required' => 'Ingresa un paciente',
            'medico_id.required' => 'Ingresa un medico',
            'tratamiento_id.required' => 'Ingresa un tratamiento',
            'estado_pago.required' => 'Ingresa un pago',
            'estado.required' => 'Ingresa un estado'

        ];

        $this->validate($rules, $messages);


            // dd($this->fecha_ini,
            // $this->fecha_fin,
            // $this->descripcion,
            // $this->paciente_id,
            // $this->medico_id,
            // Auth::user()->id,
            // $this->tratamiento_id,
            // $this->estado_pago,
            // $this->estado
            // );

            $tratamiento =  Tratamiento::find($this->tratamiento_id);
           // dd($tratamiento->precio);

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
        $this->emit('cita-added','cita registrada correctamente');


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



    public function guardarPaciente()
    {
         $paciente =  Paciente::create([
            'nombre' => $this->nombre,
            'ci' => $this->ci,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'enfermedad' => $this->enfermedad,
            'medicamentos' => $this->medicamentos,
            'alergias' => $this->alergias
        ]);



        if($this->image)
        {
            $customFileName = uniqid() . ' _.' . $this->image->extension();
            $this->image->storeAs('public/pacientes', $customFileName);
            $paciente->image = $customFileName;
            $paciente->save();
        }

        $this->resetUI();
        $this->emit('cargarPaciente');
        $this->emit('paciente-added','Paciente Registrado');

    }

    public function edit($id)
    {
        $cita = Cita::find($id);
        $this->descripcion =  $cita->descripcion;
        $this->fecha_ini =  $cita->fecha_ini;
        $this->fecha_fin =  $cita->fecha_fin;
        $this->paciente_id = $cita->paciente_id;
        $this->medico_id = $cita->medico_id;
        $this->receta = $cita->receta;
        $this->user_id = $cita->user_id;
        $this->tratamiento_id = $cita->tratamiento_id;
        $this->total  =  $cita->total;
        $this->estado_pago = $cita->estado_pago;
        $this->estado = $cita->estado_id;
        $this->selected_id = $cita->id;
        // aqui sacamos el nombre del paciente a traves de las relaciones en el modelo
        $this->buscar_paciente =  $cita->paciente->nombre;
        $this->editar = "si";
        $this->emit('show-modal', 'editar elemento');
    }

    public  function  Update()
    {
        $rules = [
            'buscar_paciente' => 'required',
            'medico_id' => 'required',
            'tratamiento_id' => 'required',
            'estado_pago' => 'required',
            'estado' => 'required'

        ];
        $messages =[
            'buscar_paciente.required' => 'Ingresa un paciente',
            'medico_id.required' => 'Ingresa un medico',
            'tratamiento_id.required' => 'Ingresa un tratamiento',
            'estado_pago.required' => 'Ingresa un pago',
            'estado.required' => 'Ingresa un estado'

        ];

        $this->validate($rules, $messages);
        $cita = Cita::find($this->selected_id);
        $cita->update([
            'descripcion' => $this->descripcion,
            'fecha_ini' => $this->fecha_ini,
            'fecha_fin' => $this->fecha_fin,
            'paciente_id' => $this->paciente_id,
            'medico_id' => $this->medico_id,
            'receta' => $this->receta,
            'user_id' => Auth::user()->id,
            'tratamiento_id' => $this->tratamiento_id,
            'total' => $this->total,
            'estado_pago' => $this->estado_pago,
            'estado_id' => $this->estado
        ]);
        $this->resetUI();
        $this->emit('cita-updated', 'Cita Actualizada ');

    }



}

<?php

namespace App\Http\Livewire;

use App\Charts\PacientesChart;
use App\Models\Cita;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Paciente;

use Livewire\Component;

class PacientesController extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $nombre,$ci,$telefono,$email,$image,$direccion,$enfermedad,$medicamentos,$alergias,$selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public $citas = [];
    public $pagos = [];

    public $total = 0;
    public $pendiente = 0;
    public $pacientes = 0;

    public $sumExtras = 0;

    public $saldoPendiente=0;

    public $saldoFavor =0;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle ='Listado';
        $this->componentName ='Pacientes';
        $this->status ='Elegir';



    }
    public function render()
    {
        $total = Paciente::all();
        $this->pacientes = count($total);

        if(strlen($this->search) > 0)
            $data = Paciente::where('nombre', 'like', '%' . $this->search . '%')
            ->select('*')->orderBy('id','asc')->paginate($this->pagination);
        else
           $data = Paciente::select('*')->orderBy('id','asc')->paginate($this->pagination);
           $total =  $data->count();


        return view('livewire.pacientes.component', [
            'data' => $data
        ])
        ->extends('layouts.theme.app')->section('content');

        //dd($total);
    }

    public function resetUI()
    {
        $this->nombre ='';
        $this->ci='';
        $this->telefono='';
        $this->email='';
        $this->image ='';
        $this->direccion ='';
        $this->enfermedad ='';
        $this->medicamentos ='';
        $this->alergias ='';
        $this->search ='';
        $this->selected_id =0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function Store()
    {
        $rules =[
            'nombre' => 'required|min:3',
            'ci' => 'required|unique:pacientes',
            'telefono' => 'required|max:10',
            'email' => 'unique:pacientes|email'
        ];

        $messages =[
            'nombre.required' => 'Ingresa el nombre',
            'nombre.min' => 'El nombre del paciente debe tener al menos 3 caracteres',
            'ci.unique' => 'El núemro de cédula ya existe en sistema',
            'ci.required' => 'Ingresa número de cédula',
            'telefono.required' => 'Ingresa el telefono',
            'telefono.max' => 'El teléfono debe tener máximo 10 caracteres',
            'email.unique' => 'El email ya existe en sistema',
            'email.email' => 'Ingresa una dirección de correo válida'
        ];

      $this->validate($rules,$messages);

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
        $this->emit('paciente-added','Paciente Registrado');


    }

    public function edit(Paciente $paciente)
    {
        $this->selected_id = $paciente->id;
        $this->nombre = $paciente->nombre;
        $this->ci = $paciente->ci;
        $this->telefono = $paciente->telefono;
        $this->email = $paciente->email;
        $this->direccion = $paciente->direccion;
        $this->enfermedad = $paciente->enfermedad;
        $this->medicamentos = $paciente->medicamentos;
        $this->alergias = $paciente->alergias;
       // dd($paciente);
        $this->emit('show-modal','open!');

    }

    protected $listeners =[
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'

    ];

    public function detallePaciente (Paciente $paciente)
    {
        $cit = $paciente->citas;
        $pag = $paciente->pagoextras;
        //dd($pag);
        $this->pagos = $pag;
        $this->citas = $cit;
        $this->emit('show-detail','details loaded');


    }

    public function Update()
    {
            $rules =[
                'nombre' => 'required|min:3',
                'ci' => "unique:pacientes,ci,{$this->selected_id}",
                'telefono' => 'required|max:10',
                'email' => "unique:pacientes,email,{$this->selected_id}"

            ];
            $messages =[
                'nombre.required' => 'Ingresa el nombre',
                'nombre.min' => 'El nombre del paciente debe tener al menos 3 caracteres',
                'ci.unique' => 'El núemro de cédula ya existe en sistema',
                'ci.required' => 'Ingresa número de cédula',
                'telefono.required' => 'Ingresa el telefono',
                'telefono.max' => 'El teléfono debe tener máximo 10 caracteres',
                'email.unique' => 'El email ya existe en sistema',
                'email.email' => 'Ingresa una dirección de correo válida'
            ];

            $this->validate($rules,$messages);

            $paciente =  Paciente::find($this->selected_id);
            //dd($paciente);
            $paciente->update([
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
            $imageTemp = $paciente->image;

            $paciente->image = $customFileName;
            $paciente->save();

            if($imageTemp !=null)
            {
                if(file_exists('storage/pacientes/' . $imageTemp)) {
                    unlink('storage/pacientes/' . $imageTemp);
                }
            }


        }

        $this->resetUI();
        $this->emit('paciente-updated','Paciente Actualizado');

    }

    public  function destroy(Paciente $paciente)
        {

        $paciente->delete();
        $this->resetUI();
        $this->emit('paciente-deleted','Paciente Eliminado');

    }




}

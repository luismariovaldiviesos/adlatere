<?php

namespace App\Http\Livewire;

use App\Models\Medico;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class MedicosController extends Component
{

    use WithPagination;
    use WithFileUploads;

    public  $nombre, $ci, $telefono, $email, $direccion;
    public  $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Medicos/as";
    }


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->search)> 0)
        {
            $data = Medico::where('nombre','like', '%'. $this->search .'%')
            ->paginate($this->pagination);
        }
        else
        {
            $data = Medico::orderBy('id','asc')
            ->paginate($this->pagination);
        }

        return view('livewire.medicos.medicos', ['medicos' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {


        $record = Medico::find($id, ['id','nombre','ci', 'telefono',  'email','direccion']);
          $this->nombre = $record->nombre;
            $this->ci = $record->ci;
            $this->telefono = $record->telefono;
            $this->email = $record->email;
            $this->direccion = $record->direccion;
            $this->selected_id = $record->id;
            $this->emit('show-modal', 'editar elemento');



        // notificar al fornt que la info ya esta cargada en las propiedaddes y que
        // puede mostrar el modal
        // para eso se emite el evento :


    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:medicos,nombre|min:3',
            'telefono' => 'required|max:10'

        ];

        $messages = [
            'nombre.required' => 'El nombre del medic@ es requerido',
            'nombre.unique' => 'El nombre del medic@ ya esta en uso ',
            'nombre.min' => 'El nombre del medic@ debe tener mínimo tres caracteres',

            'telefono.required' => 'El telefono del medic@ es requerido',
            'telefono.max' => 'El telefono del medic@ debe tener máximo diez caracteres'
        ];

        $this->validate($rules,$messages);
        $medico = Medico::create([

            'nombre' => $this->nombre,
            'ci' => $this->ci,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion

        ]);

       $medico->save();
        $this->resetUI();
        $this->emit('medico-added','medic@ registrado correctamente');

    }

    public function  Update()
    {
        $rules = [
            'nombre' => "required|min:3|unique:medicos,nombre,{$this->selected_id}",
            'telefono' => 'required|max:10'
        ];
        $messages = [
            'nombre.required' => 'Nombre del medic@ es requerido',
            'nombre.unique' => 'Nombre del medic@ ya existe',
            'nombre.min' => 'Nombre del medic@ debe tener al menos tres caracteres'
        ];

        $this->validate($rules,$messages);

        $medico= Medico::find($this->selected_id);
        $medico->update([
            'nombre' =>$this->nombre,
            'ci' =>$this->ci,
            'telefono' =>$this->telefono,
            'email' =>$this->email,
            'direccion' =>$this->direccion,
        ]);


        $this->resetUI();
        $this->emit('medico-updated', 'Medico Actualizada ');


    }

    public function resetUI()
    {
        $this->nombre ='';
        $this->ci ='';
        $this->telefono ='';
        $this->email ='';
        $this->direccion ='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation();
        $this->resetPage();
    }

    protected $listeners = [

        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Medico $medico)
    {
        //$tratamiento = Tratamiento::find($id);
        $numcitas = count($medico->citas);
        //dd($numcitas);
        if($numcitas < 1)
        {
            $medico->delete();
            $this->resetUI();
            $this->emit('medico-deleted','Medic@ eliminado correctamente');
        }
        else
        {
            $this->emit('medico-noelimina', 'no se puede eliminar el medic@, tiene citas agendadas');
        }
    }


}



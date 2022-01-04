<?php

namespace App\Http\Livewire;

use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;

class EstadosController extends Component
{

    use WithPagination;

    public  $nombre, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Estados de las citas";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->search)> 0)
        {
            $data = Estado::where('nombre','like', '%'. $this->search .'%')
            ->paginate($this->pagination);
        }
        else
        {
            $data = Estado::orderBy('id','asc')
            ->paginate($this->pagination);
        }

        return view('livewire.estados.estados', ['estados' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {

        $record = Estado::find($id, ['id','nombre']);

        $numestados = count($record->citas);
        if($numestados < 1)
        {
        $this->nombre = $record->nombre;
        $this->selected_id = $record->id;
        $this->emit('show-modal', 'editar elemento');
        }

        else{
            $this->emit('estado-noedita', 'no se puede editar el estado, tiene citas relacionadas');
        }

        // notificar al fornt que la info ya esta cargada en las propiedaddes y que
        // puede mostrar el modal
        // para eso se emite el evento :


    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:estados|min:3'

        ];

        $messages = [
            'nombre.required' => 'El nombre del estado es requerido',
            'nombre.unique' => 'El nombre del estado ya esta en uso ',
            'nombre.min' => 'El nombre del estado debe tener mínimo tres caracteres'
        ];

        $this->validate($rules,$messages);
        $estado = Estado::create([

            'nombre' => $this->nombre
        ]);

        $estado->save();
        $this->resetUI();
        $this->emit('estado-added','estado registrado correctamente');

    }

    public function Update()
    {
        $rules = [
            'nombre' => 'required|unique:estados|min:3'

        ];

        $messages = [
            'nombre' => "required|unique:estados,nombre,{$this->selected_id}|min:3",
            'nombre.unique' => 'El nombre del estado ya esta en uso ',
            'nombre.min' => 'El nombre del estado debe tener mínimo tres caracteres'
        ];


        $estado =  Estado::find($this->selected_id);
        //dd($estado);
        $estado->update([
            'nombre' => $this->nombre

        ]);

        $this->resetUI();
        $this->emit('estado-updated','estado actualizado correctamente');


    }
    public function resetUI()
    {
        $this->nombre ='';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [

        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Estado $estado)
    {
        //$tratamiento = Tratamiento::find($id);
        $estado->delete();
        $this->resetUI();
        $this->emit('estado-deleted','Tratamiento eliminado correctamente');
    }
}

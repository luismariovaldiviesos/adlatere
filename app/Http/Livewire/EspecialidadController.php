<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Especialidad;
use Livewire\WithPagination;

class EspecialidadController extends Component
{

    use WithPagination;


    public  $nombre, $precio, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Materias Despacho";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->search)> 0)
        {
            $data = Especialidad::where('nombre','like', '%'. $this->search .'%')
            ->paginate($this->pagination);
        }
        else
        {
            $data = Especialidad::orderBy('id','asc')
            ->paginate($this->pagination);
        }

        return view('livewire.especialidades.component', ['especialidades' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function resetUI()
    {
        $this->nombre ='';
        $this->search='';
        $this->selected_id=0;
        $this->resetValidation();
        $this->resetPage();
    }


    public function CreateEspecialidad()
    {
        $rules = [
            'nombre' => 'required|unique:especialidads,nombre'
        ];
         $messages = [
             'nombre.required' => 'Ingrese nombre de la materia despacho ',
             'nombre.unique' => 'El nombre de la materia despacho ya existe'
         ];

         $this->validate($rules,$messages);

         $especialidad =  Especialidad::create([
             'nombre' => $this->nombre
         ]);

         $especialidad->save();
         $this->resetUI();
         $this->emit('especialidad_agregada','Materia despacho registrada correctamente');
    }


    public function  Edit(Especialidad $especialidad)
    {
        $this->nombre = $especialidad->nombre;
        $this->selected_id = $especialidad->id;
        $this->emit('show-modal', 'editar elemento');
    }

    public function UpdateEspecialidad()
    {
        $rules = [
            'nombre' => "required|unique:especialidads,nombre,{$this->selected_id}|min:3"

        ];

        $messages = [
            'nombre.required' => 'El nombre del tratamiento es requerido',
            'nombre.unique' => 'El nombre del tratamiento ya esta en uso '

        ];
        $this->validate($rules,$messages);
        $especialidad =  Especialidad::find($this->selected_id);
        //dd($tratamiento);
        $especialidad->update([
            'nombre' => $this->nombre

        ]);

        $this->resetUI();
        $this->emit('especialidad_actualizada','Materia despacho actualizada correctamente');
    }

    protected $listeners = [
        'deleteRow' => 'EliminaEspe'
    ] ;

    public function EliminaEspe(Especialidad $especialidad)
    {
        $especialidad->delete();
        $this->resetUI();
        $this->emit('especialidad_eliminada','Materia despacho eliminada correctamente');
    }
}

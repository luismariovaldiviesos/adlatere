<?php

namespace App\Http\Livewire;
use App\Models\Tratamiento;
use Livewire\WithPagination;
use Livewire\WithFileUploads;  // para imagenes subir
use Illuminate\Support\Facades\Storage; // para almacenar archivos

use Livewire\Component;


class TratamientosController extends Component
{
    use WithPagination;

    public  $nombre, $precio, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Tratamientos";
    }


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }



    public function render()
    {
        if(strlen($this->search)> 0)
        {
            $data = Tratamiento::where('nombre','like', '%'. $this->search .'%')
            ->paginate($this->pagination);
        }
        else
        {
            $data = Tratamiento::orderBy('id','asc')
            ->paginate($this->pagination);
        }

        return view('livewire.tratamientos.tratamientos', ['tratamientos' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {


        $record = Tratamiento::find($id, ['id','nombre','precio']);
        $numcitas = count($record->citas);
        if($numcitas < 1)
        {
            $this->nombre = $record->nombre;
            $this->precio = $record->precio;
            $this->selected_id = $record->id;
            $this->emit('show-modal', 'editar elemento');
        }
        else{
            $this->emit('tratamiento-noedita', 'no se puede editar el tratamiento, tiene citas relacionadas');
        }

        // notificar al fornt que la info ya esta cargada en las propiedaddes y que
        // puede mostrar el modal
        // para eso se emite el evento :


    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:tratamientos|min:3',
            'precio' => 'required|numeric|between:0,99'
        ];

        $messages = [
            'nombre.required' => 'El nombre del tratamiento es requerido',
            'nombre.unique' => 'El nombre del tratamiento ya esta en uso ',
            'nombre.min' => 'El nombre del tratamiento debe tener mínimo tres caracteres',

            'precio.required' => 'El precio del tratamiento es requerido',
            'precio.numeric' => 'El precio del tratamiento debe ser un valor númerico ',
            'precio.between' => 'El precio del tratamiento debe estar entre 0.99'
        ];

        $this->validate($rules,$messages);
        $tratamiento = Tratamiento::create([

            'nombre' => $this->nombre,
            'precio' => $this->precio

        ]);
        $tratamiento->save();
        $this->resetUI();
        $this->emit('tratamiento-added','Tratamiento registrado correctamente');

    }

     public function Update()
    {
        $rules = [
            'nombre' => "required|unique:tratamientos,nombre,{$this->selected_id}|min:3",
            'precio' => 'required|numeric|between:0,99'
        ];

        $messages = [
            'nombre.required' => 'El nombre del tratamiento es requerido',
            'nombre.unique' => 'El nombre del tratamiento ya esta en uso ',
            'nombre.min' => 'El nombre del tratamiento debe tener mínimo tres caracteres',

            'precio.required' => 'El precio del tratamiento es requerido',
            'precio.numeric' => 'El precio del tratamiento debe ser un valor númerico ',
            'precio.between' => 'El precio del tratamiento debe estar entre 0.99'
        ];
        $this->validate($rules,$messages);


        $tratamiento =  Tratamiento::find($this->selected_id);
        //dd($tratamiento);
        $tratamiento->update([
            'nombre' => $this->nombre,
            'precio' => $this->precio
        ]);

        $this->resetUI();
        $this->emit('tratamiento-updated','Tratamiento actualizado correctamente');


    }

    public function resetUI()
    {
        $this->nombre ='';
        $this->precio ='';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [

        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Tratamiento $tratamiento)
    {
        //$tratamiento = Tratamiento::find($id);
        $tratamiento->delete();
        $this->resetUI();
        $this->emit('tratamiento-deleted','Tratamiento eliminado correctamente');
    }
}

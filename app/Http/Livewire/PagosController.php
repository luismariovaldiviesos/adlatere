<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pago;

class PagosController extends Component
{
    use WithPagination;
    public  $nombre, $observaciones, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Tipos de Pagos";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->search)> 0)
        {
            $data = Pago::where('nombre','like', '%'. $this->search .'%')
            ->paginate($this->pagination);
        }
        else
        {
            $data = Pago::orderBy('id','asc')
            ->paginate($this->pagination);
        }

        return view('livewire.pagos.pagos', ['pagos' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {

        $record = Pago::find($id, ['id','nombre','observaciones']);
        $this->nombre = $record->nombre;
        $this->observaciones = $record->observaciones;
        $this->selected_id = $record->id;

        // notificar al fornt que la info ya esta cargada en las propiedaddes y que
        // puede mostrar el modal
        // para eso se emite el evento :

        $this->emit('show-modal', 'editar elemento');
    }

    public function Store()
    {

        $rules = [
            'nombre' => 'required|unique:pagos|min:3'


        ];

        $messages = [
            'nombre.required' => 'El nombre del pago es requerido',
            'nombre.unique' => 'El nombre del pago ya esta en uso ',
            'nombre.min' => 'El nombre del pago debe tener mínimo tres caracteres'

        ];

        $this->validate($rules,$messages);

        $pago = Pago::create([

            'nombre' => $this->nombre,
            'observaciones' => $this->observaciones

        ]);
        //dd($pago);
        $pago->save();
        $this->resetUI();
        $this->emit('pago-added','pago registrado correctamente');

    }

     public function Update()
    {
        $rules = [
            'nombre' => "required|unique:pagos,nombre,{$this->selected_id}|min:3"

        ];

        $messages = [
            'nombre.required' => 'El nombre del tratamiento es requerido',
            'nombre.unique' => 'El nombre del tratamiento ya esta en uso ',
            'nombre.min' => 'El nombre del tratamiento debe tener mínimo tres caracteres'

        ];
        $this->validate($rules,$messages);


        $pago =  Pago::find($this->selected_id);
        //dd($tratamiento);
        $pago->update([
            'nombre' => $this->nombre,
            'observaciones' => $this->observaciones
        ]);

        $this->resetUI();
        $this->emit('pago-updated','Pago actualizado correctamente');


    }
    public function resetUI()
    {
        $this->nombre ='';
        $this->observaciones ='';
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [

        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Pago $pago)
    {
        //$tratamiento = Tratamiento::find($id);
        $pago->delete();
        $this->resetUI();
        $this->emit('pago-deleted','Pago eliminado correctamente');
    }

}

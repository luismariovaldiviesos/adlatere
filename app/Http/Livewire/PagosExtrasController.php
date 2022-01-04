<?php

namespace App\Http\Livewire;

use App\Models\Paciente;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PagoExtra;
use Carbon\Carbon;

class PagosExtrasController extends Component
{
    use WithPagination;
    public  $descripcion, $monto, $paciente_id, $fechasearch, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Pagos Extras";
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if($this->fechasearch != null)
        {
            $fi =  Carbon::parse($this->fechasearch)->format('Y-m-d') . ' 00:00:00';
             $ff =  Carbon::parse($this->fechasearch)->format('Y-m-d') . ' 23:59:59';

            $data = PagoExtra::whereBetween('created_at',[$fi,$ff])
            ->paginate($this->pagination);
        }
        else
        {
            $data = PagoExtra::orderBy('id','asc')
            ->paginate($this->pagination);
        }
        $pacientes = Paciente::all();

        return view('livewire.pagosextras.component', ['pagosextras' => $data, 'pacientes' => $pacientes])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store()
    {

        $rules = [
            'descripcion' => 'required',
            'paciente_id'=> 'required',
            'monto'=> 'required'


        ];

        $messages = [
            'descripcion.required' => 'La descripción dle pago es requerida',
            'paciente_id.required' => 'El paciente que paga  es requerido',
            'monto.required' => 'El monto es requerido'

        ];

        $this->validate($rules,$messages);

        $pagoextra = PagoExtra::create([

            'descripcion' => $this->descripcion,
            'paciente_id' => $this->paciente_id,
            'monto' => $this->monto,

        ]);
        //dd($pago);
        $pagoextra->save();
        $this->resetUI();
        $this->emit('pagoextra-added','pago registrado correctamente');

    }
    public function Edit($id)
    {

        $record = PagoExtra::find($id, ['id','descripcion','paciente_id','monto']);
        $this->descripcion = $record->descripcion;
        $this->paciente_id = $record->paciente_id;
        $this->monto = $record->monto;
        $this->selected_id = $record->id;

        // notificar al fornt que la info ya esta cargada en las propiedaddes y que
        // puede mostrar el modal
        // para eso se emite el evento :

        $this->emit('show-modal', 'editar elemento');
    }


    public function resetUI()
    {
        $this->descripcion ='';
        $this->paciente_id ='';
        $this->monto = "";
        $this->search='';
        $this->selected_id=0;
    }


    public function Update()
    {
        $rules = [
            'descripcion' => 'required',
            'paciente_id'=> 'required',
            'monto'=> 'required'
        ];

        $messages = [
            'descripcion.required' => 'La descripción dle pago es requerida',
            'paciente_id.required' => 'El paciente que paga  es requerido',
            'monto.required' => 'El monto es requerido'

        ];

        $this->validate($rules,$messages);


        $pagoextra =  PagoExtra::find($this->selected_id);
        //dd($tratamiento);
        $pagoextra->update([
            'descripcion' => $this->descripcion,
            'paciente_id' => $this->paciente_id,
            'monto' => $this->monto,
        ]);

        $this->resetUI();
        $this->emit('pagoextra-updated','Pago actualizado correctamente');


    }
    protected $listeners = [

        'deleteRow' => 'Destroy'
    ];

    public function Destroy(PagoExtra $pago)
    {
        //$tratamiento = Tratamiento::find($id);
        $pago->delete();
        $this->resetUI();
        $this->emit('pagoextra-deleted','Pago eliminado correctamente');
    }
}

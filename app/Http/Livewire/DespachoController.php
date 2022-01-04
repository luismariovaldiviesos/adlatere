<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Despacho;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DespachoController extends Component
{
    use WithFileUploads;

    public $nombre, $direccion, $telefono, $ruc, $email, $image, $selected_id;

    public  function  mount()
    {
        $despacho = Despacho::all();
        if ($despacho->count()> 0)
        {
            //dd($clinica);
           $this->selected_id = $despacho[0]->id;
            $this->nombre = $despacho[0]->nombre;
            $this->direccion = $despacho[0]->direccion;
            $this->telefono = $despacho[0]->telefono;
            $this->ruc = $despacho[0]->ruc;
            $this->email = $despacho[0]->email;
            $this->image = $despacho[0]->imagen;
        }

    }

    public function render()
    {
        return view('livewire.despacho.component')->extends('layouts.theme.app')
        ->section('content');;
    }

    public function Guardar()
    {
        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'ruc' => 'required',
            'email' => "required|email|unique:despachos,email,{$this->selected_id}"

        ];

        $messages =[
            'nombre.required' => 'Ingresa el nombre',
            'direccion.required' => 'Ingresa una direccion ',
            'telefono.required' => 'Ingresa un telefono ',
            'ruc.required' => 'Ingresa un ruc ',
            'email.required' => 'Ingresa el correo ',
            'email.email' => 'Ingresa un correo válido',
        ];

        $this->validate($rules, $messages);

        $despacho = Despacho::find($this->selected_id);
        $despacho->update([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'ruc' => $this->ruc,
            'email' => $this->email,
            'image'=>$this->image
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . ' _.' . $this->image->extension();
            $this->image->storeAs('public/despacho', $customFileName);
            $imageTemp = $despacho->image;
            $despacho->image = $customFileName;
            $despacho->save();

            if($imageTemp != null)
            {
                if(file_exists('storage/despacho/' . $imageTemp)) {
                    unlink('storage/despacho/' . $imageTemp);
                }
            }

        }


        $this->emit('despacho-added','Datos Del DEspacho  guardados correctamente');

    }
}

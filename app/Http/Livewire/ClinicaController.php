<?php

namespace App\Http\Livewire;

use App\Models\Clinica;
use Livewire\Component;
use DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ClinicaController extends Component
{

    use WithFileUploads;

    public $nombre, $direccion, $telefono, $ruc, $email, $image, $selected_id;

    public  function  mount()
    {
        $clinica = Clinica::all();
        if ($clinica->count()> 0)
        {
            //dd($clinica);
           $this->selected_id = $clinica[0]->id;
            $this->nombre = $clinica[0]->nombre;
            $this->direccion = $clinica[0]->direccion;
            $this->telefono = $clinica[0]->telefono;
            $this->ruc = $clinica[0]->ruc;
            $this->email = $clinica[0]->email;
            $this->image = $clinica[0]->imagen;
        }

    }

    public function render()
    {
        return view('livewire.clinica.component')
        ->extends('layouts.theme.app')
        ->section('content');
    }


    public function Guardar()
    {
       // $this->selected_id = $this->id;
      //    dd($this->imagen);
        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'ruc' => 'required',
            'email' => "required|email|unique:clinicas,email,{$this->selected_id}"

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

       // DB::table('clinicas')->truncate(); // eliminando la info de la tabla
       $clinica = Clinica::find($this->selected_id);
       //dd($clinica);
        $clinica->update([
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
            $this->image->storeAs('public/clinica', $customFileName);
            $imageTemp = $clinica->image;
            $clinica->image = $customFileName;
            $clinica->save();

            if($imageTemp != null)
            {
                if(file_exists('storage/clinica/' . $imageTemp)) {
                    unlink('storage/clinica/' . $imageTemp);
                }
            }

        }


        $this->emit('clinica-added','Datos de Empresa guardadodcorrectamente');

    }
}

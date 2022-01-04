<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','ci','telefono','email','image','direccion','enfermedad','medicamentos','alergias'];

    public function getImagenAttribute()
    {
        if($this->image != null)
        return (file_exists('storage/pacientes/' . $this->image) ? $this->image : 'noimg.jpg');
        else
        return 'noimg.jpg';

                //método 2
                /*
                if($this->image == null)
                {
                if(file_exists('storage/categories/' . $this->image))
                    return $this->image;
                else
                    return 'noimg.jpg';
                } else {
                return 'noimg.jpg';
                }
                */

    }

     // un  paciente pued estar en muchas citas
     public function citas()
     {
         return $this->hasMany(Cita::class);
     }

     public function pagoextras()
     {
        return $this->hasMany(PagoExtra::class);
     }



}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'descripcion','fecha_ini','fecha_fin','paciente_id','medico_id',
        'receta','user_id','tratamiento_id','total','estado_pago','estado_id'
    ];

    //tien ujn tratamiento
    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }

    //tien un pago
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

     //tien un estado
     public function estado()
     {
         return $this->belongsTo(Estado::class);
     }

     // TIENE UN PACIENTE

     public function paciente()
     {
         return $this->belongsTo(Paciente::class);
     }

      // TIENE UN USUARIO

      public function user()
      {
          return $this->belongsTo(User::class);
      }

       // TIENE UN medico

       public function medico()
       {
           return $this->belongsTo(Medico::class);
       }

    //   public function citasPendientes()
    //   {
    //       $estadoCita =  $this->estado();
    //       //$citPendiente =  Cita::where('estado_id','=',$this->estado)->orderBy('id','asc')->paginate(10);
    //       //return $citPendiente;
    //       dd($estadoCita) ;
    //   }
}

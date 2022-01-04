<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoExtra extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion','paciente_id','monto'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

}

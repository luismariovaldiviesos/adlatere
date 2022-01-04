<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','observaciones'];


    // un  pago pued estar en muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}

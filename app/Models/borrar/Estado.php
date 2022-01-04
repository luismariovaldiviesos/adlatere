<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // un  estado pued estar en muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}

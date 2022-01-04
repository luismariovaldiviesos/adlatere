<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255);
            $table->string('ci',13)->unique()->nullable();
            $table->string('telefono',10);
            $table->string('email',255)->unique()->nullable();
            $table->string('image',255)->nullable();
            $table->string('direccion',255)->nullable();
            $table->string('enfermedad',255)->nullable();
            $table->string('medicamentos',255)->nullable();
            $table->string('alergias',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}

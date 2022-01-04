@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Paciente</label>
            <input wire:model="buscar_paciente" type="search" class="form-control" placeholder="Buscar paciente en el sistema ">
            @error('buscar_paciente') <span class="text-danger er">{{ $message }}</span> @enderror
            @if ($buscar_paciente != '')
            <ul class="list-group" >
                @if (!$pacientes->isEmpty())
                    @foreach($pacientes as $p)
                        <li wire:click="cargarPaciente('{{$p}}')"
                            class="list-group lis-group-action"
                         >
                            {{ $p->nombre }}</li>
                    @endforeach
                @else
                    @if ($editar == 'si')
                        <p>Ups! No hay resultados </p>
                    @else
                        <p>Ups! No hay resultados </p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Crear Paciente
                        </button>
                    @endif
                @endif

            </ul>
        @else
            <p>No hay consulta </p>
        @endif
        </div>
    </div>
   <div wire:ignore class="mt-2 col-sm-6">
        <h6>Fecha Inicio</h6>
        <div class="form-group">
            <input type="text" wire:model='fecha_ini'
            class="form-control flatpickr"
            placeholder="Click para elegir">
        </div>
    </div>

    <div wire:ignore class="mt-2 col-sm-6">
        <h6>Fecha Final</h6>
        <div class="form-group">
            <input type="text" wire:model='fecha_fin'
            class="form-control flatpickr"
            placeholder="Click para elegir">
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Descripción</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control" >
            @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>



    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Medico</label>
            <select wire:model.lazy="medico_id" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($medicos as $m )
                <option value="{{ $m->id }}" >{{ $m->nombre }}</option>
                @endforeach
            </select>
            @error('medico_id') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Receta</label>
            <textarea wire:model.lazy='receta' class="form-control"  rows="3"></textarea>

        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Tratamiento</label>
            <select wire:model.lazy="tratamiento_id" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($tratamientos as $t )
                <option value="{{ $t->id }}" >{{ $t->nombre }}</option>
                @endforeach
            </select>
            @error('tratamiento_id') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Pagos</label>
            <select wire:model.lazy="estado_pago" class="form-control">
                <option value="Elegir" selected>Elegir</option>
               <option value="PAGADO">PAGADO</option>
               <option value="PENDIENTE">PENDIENTE</option>
            </select>
            @error('estado_pago') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Estado Cita</label>
            <select wire:model.lazy="estado" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($estados as $e)
                <option value="{{ $e->id }}" >{{ $e->nombre }}</option>
                @endforeach
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')


{{-- ***********************MODAL PARA CREAR PACIENTE *********************** --}}

<div wire:ignore.self class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    {{-- aqui abajo cqambiar el tamaño de la ventana modal  --}}
    <div class="modal-dialog modal-xl " role="document">

        <div class="modal-content ">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Nuevo Paciente</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                     <span aria-hidden="true close-btn">×</span>

                </button>

            </div>

           <div class="modal-body ">

                <form>

                    <div class="mt-4 row ">


                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Nombre</h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div  class="input-group-text"><i class="la la-info-circle la-lg"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="nombre"  class="form-control"   placeholder="ESTE DATO ES REQUERIDO">

                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h7 class="text-info">Número CI/RUC* </h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div  class="input-group-text"><i class="la la-info-circle la-lg"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="ci"  class="form-control" maxlength="13">

                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <h7 class="text-info">Teléfono</h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-phone la-lg"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="telefono" required class="form-control" maxlength="10"  placeholder="ESTE DATO ES REQUERIDO">
                                @error('telefono') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <h7 class="text-info">Mail</h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-envelope la-lg"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="email" class="form-control">

                            </div>
                        </div>

                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <h7 class="text-info">Imagen de perfil</h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-envelope la-lg"></i></div>
                                </div>
                                <input type="file" wire:model="image" accept="image/x-png, image/jpeg, image/gif" class="form-control">

                            </div>
                        </div>

                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <h7 class="text-info">Dirección*</h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-home la-lg"></i></div>
                                    @error('direccion') <span class="text-danger er">{{ $message }}</span> @enderror
                                </div>
                                <input type="text" wire:model.lazy="direccion" class="form-control" maxlength="255">

                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <h7 class="text-info">Enfermedad</h7>
                            <div class="mb-2 input-group mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-phone la-lg"></i></div>
                                </div>
                                <textarea wire:model.lazy='enfermedad' class="form-control"  rows="3"></textarea>

                            </div>
                        </div>
                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                <h7 class="text-info">Medicamentos</h7>
                                <div class="mb-2 input-group mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="la la-mobile la-lg"></i></div>
                                    </div>
                                    <textarea wire:model.lazy='medicamentos' class="form-control"  rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                <h7 class="text-info">Alergias</h7>
                                <div class="mb-2 input-group mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="la la-mobile la-lg"></i></div>
                                    </div>
                                    <textarea wire:model.lazy='alergias' class="form-control"  rows="3"></textarea>
                                </div>
                            </div>





                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"  class="btn btn-dark close-btn" data-dismiss="modal">Cerrar</button>

                @if ($nombre != null && $telefono != null)
                <button type="button" wire:click.prevent="guardarPaciente()" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                @endif


            </div>

        </div>

    </div>

</div>



{{-- *********************** FIN MODAL PARA CREAR PACIENTE *********************** --}}



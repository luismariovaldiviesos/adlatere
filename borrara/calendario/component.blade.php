<div wire:ignore>

    <div class="container" id="calendar">
    </div>

    {{-- MODAL --}}



    <div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Angendar Cita</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form wire:submit.prevent='save'>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label >Paciente</label>
                            <input wire:model="buscar_paciente" type="search" class="form-control" placeholder="Buscar paciente en el sistema ">
                            @error('buscar_paciente') <span class="text-danger er">{{ $message }}</span> @enderror
                            {{-- @if ($buscar_paciente != '')
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
                        @endif --}}
                        </div>
                    </div>
                       <div class="mt-2 col-sm-6">
                            <h6>Fecha Inicio</h6>
                            <div class="form-group">
                                <input type="text" wire:model='fecha_ini'
                                class="form-control flatpickr"
                                placeholder="Click para elegir">
                            </div>
                        </div>

                        <div class="mt-2 col-sm-6">
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
                                    <select wire:model.lazy="pago_id" class="form-control">
                                        <option value="Elegir" selected>Elegir</option>
                                        @foreach ($pagos as $p)
                                        <option value="{{ $p->id }}" >{{ $p->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('pago_id') <span class="text-danger er">{{ $message }}</span> @enderror
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Registrar</button>

            </form>
            </div>

        </div>
        </div>
    </div>


    {{-- MODAL --}}

</div>
@push('script')

<script>
    // $('#theModal').on("hidden.bs.modal", function(){
    //     @this.title = '';
    //     @this.start = '';
    //     @this.end = '';
    // })
    document.addEventListener('DOMContentLoaded', function(){
        const calendarEL =  document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEL, {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable:true,
            select: function({startStr, endStr, buscar_paciente, descripcion, medico_id, receta, user_id, tratamiento_id, pago_id }){
                @this.fecha_ini = startStr;
                @this.fecha_fin = endStr;
                @this.buscar_paciente = buscar_paciente;
                @this.descripcion = descripcion;
                @this.medico_id = medico_id;
                @this.receta =  receta;
                @this.user_id = user_id;
                @this.tratamiento_id = tratamiento_id;
                @this.pago_id =  pago_id;
               $('#theModal').modal('toggle');
            }
        });
        calendar.render();
        // document.addEventListener('event', event => {

        //     alert('Name updated to: ' + event.detail.newName);
        // })
        // detail es el nombre de la variable que esta dentro del objeto event y que tiene un valor
        // 'closeModalCreate' => true definido en el metodo del controller
        document.addEventListener('eventoEnviar', function({detail}) {

           //console.log(detail);
           if(detail.closeModalCreate){
            $('#theModal').modal('toggle');
           }

        })
      })



      flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            locale: {
                firtsDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Miércoles",
                    "Jueves",
                    "Viernes",
                    "Sábado",
                    ],
                },
                    months: {
                    shorthand: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                    ],
                    longhand: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                    ],
                },
            }
        })






</script>


@endpush

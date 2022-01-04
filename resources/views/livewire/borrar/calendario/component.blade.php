
  @can('ver_calendario')



<div class="container"  wire:ignore>

    <style>
        .pendiente {
            background-color: #17771723  !important;
        }
        .parcialmente {
            background-color: #bdd456  !important;
        }
        .finalizado {
            background-color: #101011  !important;
        }



    </style>


    <div id='calendar-container'>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <br>
        <br>
        <div id='calendar'>

        </div>
        {{-- MODAL --}}

        <!-- Modal ver citas -->
        {{-- <div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informacion de cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <label for="" >PACIENTE</label>
                    <input type="text" wire:model.defer="title" class="form-control" >
                    <label for="" >HORA INICIO:</label>
                    <input type="text" wire:model.defer="start" disabled class="form-control" >
                    <label for="" >HORA FIN:</label>
                    <input type="text" wire:model.defer="end" disabled class="form-control" >
                    <label for="" >tratamiento</label>
                    <input type="text" wire:model.defer="tratamiento" disabled class="form-control" >
                    <label for="" >pago</label>
                    <input type="text" wire:model.defer="pago" disabled class="form-control" >
                    <label for="" >estado</label>
                    <input type="text" wire:model.defer="estado" disabled class="form-control" >


                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
            </div>
        </div> --}}
        <div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header bg-dark">
                  <h5 class="text-white modal-title">
                      <b>Información de cita</b>
                  </h5>

                </div>
                <div class="modal-body">

                    <div class="row">
                        {{-- <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label >id cita</label>
                                <div class="form-group">
                                    <input type="text" wire:model.defer="id_cita" class="form-control" disabled >
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label >Paciente</label>
                                <div class="form-group">
                                    <input type="text" wire:model.defer="title" class="form-control" disabled >
                                </div>
                            </div>
                        </div>
                           <div class="mt-2 col-sm-6">
                                <h6>Hora Inicio</h6>
                                <div class="form-group">
                                    <input type="text" wire:model.defer="start" disabled class="form-control" >
                                </div>
                            </div>

                            <div class="mt-2 col-sm-6">
                                <h6>Hora Fin</h6>
                                <div class="form-group">
                                    <input type="text" wire:model.defer="end" disabled class="form-control" >
                                </div>
                            </div>

                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Tratamiento actual:</label>
                                        <input type="text" wire:model.defer="tratamiento" disabled class="form-control" >
                                        <br>
                                        <label for="">CAMBIAR TRATAMIENTO:</label>
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
                                        <label for="">Estado pago:</label>
                                        <input type="text" wire:model.defer="estado_pago" disabled class="form-control" >
                                        <br>
                                        <label for="">CAMBIAR PAGO:</label>
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
                                        <label for="">Estado cita:</label>
                                        <input type="text" wire:model.defer="estado" disabled class="form-control" >
                                        <br>
                                        <label for="">CAMBIAR ESTADO:</label>
                                        <select wire:model.lazy="estado_id" class="form-control">
                                            <option value="Elegir" selected>Elegir</option>
                                            @foreach ($estados as $e)
                                            <option value="{{ $e->id }}" >{{ $e->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal">
                        CERRAR
                    </button>

                    {{-- @if ($selected_id < 1) --}}
                        <button type="button" id="buttonEditar" wire:click.prevent="Update()" class="btn btn-dark close-modal">
                            EDITAR
                        </button>
                </div>
            </div>
            </div>
        </div>


        <!-- Modal agnedar citas -->

        <div wire:ignore.self class="modal fade" id="modalAgendar" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header bg-dark">
                  <h5 class="text-white modal-title">
                      <b>Agendar cita</b>
                  </h5>

                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label >Paciente</label>
                                <div class="form-group">

                                    <select wire:model="paciente_id" class="form-control">
                                        <option value="Elegir" selected>Elegir</option>
                                        @foreach ($pacientes as $p )
                                        <option value="{{ $p->id }}" >{{ $p->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('paciente_id') <span class="error">{{ $message }}</span> @enderror
                                </div>
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

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal">
                        CERRAR
                    </button>

                    {{-- @if ($selected_id < 1) --}}
                        <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">
                            GUARDAR
                        </button>
                </div>
            </div>
            </div>
        </div>




      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>


      <script>

            window.addEventListener('livewire:load', function() {
                var Calendar = FullCalendar.Calendar;
                var Draggable = FullCalendar.Draggable;
                var calendarEl = document.getElementById('calendar');
                var data =   @this.events;

                var calendar = new Calendar(calendarEl,
                 {

                   initialView: 'dayGridMonth',  //dayGridMonth timeGridWeek
                   locale: "es",
                   timeZone: 'local',
                   headerToolbar: {
                       left: 'prev,next today',
                       center: 'title',
                       right: 'dayGridMonth, timeGridWeek,listWeek,timeGridDay'
                   },
                   dayMaxEventRows: true,
                   views: {
                       timeGrid: {
                        dayMaxEventRows: 1
                       }
                   },

                   hiddenDays: [ 0 ], //oculta domingo
                   businessHours: {
                    daysOfWeek: [ 1, 2, 3, 5, 6, 7 ], // Monday, Tuesday, Wednesday
                    startTime: '08:00', // 8am
                    endTime: '18:00' // 6pm
                    },
                    allDaySlot: false,
                    slotDuration: '00:30' ,// 2 hours
                   selectable:true,

                   //***** FORMA UNO QUE FUNCIONO ****///
                  // events: JSON.parse(data), // carga data del metodo

                   //***** FORMA DOS QUE FUNCIONO ****///

                  eventSources: [{
                    url: '/api/calendario/citas',
                  }],

                 //***** FORMA TRES QUE FUNCIONO ****///

                // events: "http://citas.test/api/calendario/citas",

                //    select: function(){
                //     $('#modalAgendar').modal('toggle');
                //     console.log(startStr);

                //    },

                select: function(date, allDay, jsEvent, view,startStr) {
                    var hoy = new Date();
                    var seleccionado = date.start;
                    hoy.setHours(0,0,0,0);
                    seleccionado.setHours(0,0,0,0);


                    if ( seleccionado < hoy ) {
                        //alert("NO SE PUEDE AGENDAR EN ESTA FECHA");

                    }

                    if (seleccionado.getTime() == hoy.getTime()) {
                        $('#modalAgendar').modal('toggle');
                    }

                    if (seleccionado > hoy) {
                        $('#modalAgendar').modal('toggle');
                    }

                    },


                   dateClick(info) {
                        //  var titulo = prompt('ingrese el titulo');
                        //  var date = new Date(info.dateStr + 'T00:00:00');
                            // var actual = new Date();
                            // if(info.date >= actual){
                            //     info.dayEl.style.backgroundColor = 'yellow';
                            //     $("#exampleModal").modal();
                            //     document.getElementById("dia").innerHTML= info.dateStr;
                            // }else{
                            //     alert("Error: No se puede solicitar una cita en una fecha vencida");
                            // }
                    },
                    eventClick: function(info, date){


                        var inicio = dayjs(info.event.start).format('HH:mm');
                        var fin = dayjs(info.event.end).format('HH:mm');
                        var fecha_ini = dayjs(info.event.start).format('YYYY:mm:dd');
                        var fin = dayjs(info.event.end).format('HH:mm');
                        var id_cita;
                        @this.fecha_ini = info.event.start;
                        @this.fecha_fin = info.event.end;
                        @this.title =  info.event.title;
                        @this.start = inicio;
                        @this.end =  fin;
                        @this.tratamiento =  info.event.extendedProps.tratamiento;
                        @this.estado_pago =  info.event.extendedProps.estado_pago;
                        @this.estado =  info.event.extendedProps.estado;
                        @this.id_cita = info.event.extendedProps.id_cita;
                        $('#theModal').modal('toggle');
                        // $('#buttonEditar').prop('disabled', true);
                        // date = Date.now();
                        //console.log(date);
                    },

             });

            calendar.render();

            });



            //
    document.addEventListener('DOMContentLoaded', function(){

                flatpickr(document.getElementsByClassName('flatpickr'), {
                    enableTime: true,
                    static: true,
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

//eventos

window.livewire.on('cita-added', Msg =>{
    $('#modalAgendar').modal('hide')
    noty(Msg)
})
window.livewire.on('cita-updated', Msg =>{
    $('#theModal').modal('hide')
    noty(Msg)
})
window.livewire.on('user-updated', Msg =>{
    $('#theModal').modal('hide')
    noty(Msg)
})
window.livewire.on('user-deleted', Msg =>{
   noty(Msg)
})
window.livewire.on('hide-modal', Msg =>{
    $('#theModal').modal('hide')


})
window.livewire.on('show-modal', Msg =>{
    $('#theModal').modal('show')
})

window.livewire.on('sin-resultados', Msg =>{
    noty(Msg)
})
window.livewire.on('cita-error', Msg =>{
    noty(Msg)
})

});



      </script>
      <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
       <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />


    </div>

</div>
@endcan






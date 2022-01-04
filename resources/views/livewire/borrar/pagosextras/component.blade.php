
<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            @can('ver_pagoextra')
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
               @can('crear_pagoextra')
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                    </li>
                </ul>
               @endcan
            </div>
            <div class="col-sm-12 col-md-3">
                @can('buscar_pagoextra')
                <div class="form-group">
                    <h6>Fecha cita</h6>
                    @include('livewire.citas.fechasearch')
                </div>
                @endcan
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th">ID</th>
                                <th class="text-white table-th">DESCRIPCION</th>
                                <th class="text-white table-th">PACIENTE</th>
                                <th class="text-white table-th">MONTO</th>
                                <th class="text-white table-th">FECHA</th>
                                <th class="text-white table-th">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach($pagosextras as $pago)
                                    <tr>
                                        <td><h6>{{$pago->id}}</h6></td>
                                        <td><h6>{{$pago->descripcion}}</h6></td>
                                        <td><h6>{{$pago->paciente->nombre}}</h6></td>
                                        <td><h6>{{\Carbon\Carbon::parse($pago->created_at)->isoFormat('LL')}}</h6></td>
                                        <td><h6>{{$pago->monto}}</h6></td>
                                        <td>


                                        @can('editar_pagoextra')
                                            <a href="javascript:void(0)"
                                            wire:click="Edit({{$pago->id}})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('eliminar_pagoextra')
                                        <a href="javascript:void(0)"
                                        onClick="Confirm({{ $pago->id }})"
                                        class="btn btn-dark " title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan

                                        </td>
                                    </tr>
                            @endforeach



                        </tbody>
                    </table>
                    {{$pagosextras->links()}}
                </div>

            </div>
            @endcan
        </div>

    </div>

    @include('livewire.pagosextras.form')

</div>


<script>

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

        window.livewire.on('pagoextra-added', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('pagoextra-updated', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('pagoextra-deleted', Msg =>{
           noty(Msg)
        })
        window.livewire.on('hide-modal', Msg =>{
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg =>{
            $('#theModal').modal('show')
        })

        window.livewire.on('show-detail', Msg =>{
            $('#modalDetails').modal('show')
        })

    });

     // para eliminar envia un emit con el id al fornt donde se debe cachar en los listeners

     function Confirm(id, pagos)
     {

         swal({
             title: 'CONFIRMAR',
             text: '¿ DESEA ELIMINAR EL REGISTRO ?',
             type: 'warning',
             showCancelButton: true,
             cancelButtonText: 'Cerrar',
             cancelButtonColor: '#fff',
             confirmButtonColor: '#3B3F5C',
             confirmButtonText: 'Aceptar'
         }).then(function(result){
             if(result.value)
             {
                 window.livewire.emit('deleteRow', id) //deleteRow va al listener del controller
                 swal.close()
             }
         })
     }

</script>


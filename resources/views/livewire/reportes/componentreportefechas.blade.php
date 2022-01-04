<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>
            @can('ver_reporte')
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el usuario</h6>
                                <div class="form-group">
                                    <select wire:model="medico_id" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach($doctores as $medico)
                                        <option value="{{$medico->id}}">{{$medico->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas del día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button>

                                <a class="btn btn-dark btn-block {{count($citas)  <1 && count($pagosextras) <1 ? 'disabled' : '' }}"
                                href="{{ url('crearpdf/pdf' . '/' . $medico_id . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">Generar PDF</a>

                                {{-- <a  class="btn btn-dark btn-block {{count($citas) <1 ? 'disabled' : '' }}"
                                href="{{ url('report/excel' . '/' . $medico_id . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">Exportar a Excel</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <!--TABLAE-->
                        <div class="table-responsive">
                            <table class="table table-bordered table striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="text-white table-th text-center">PACIENTE</th>
                                            <th class="text-white table-th text-center">TRATAMIENTO</th>
                                            <th class="text-white table-th text-center">MÉDIC@</th>
                                            <th class="text-white table-th text-center">VALOR TRATAMIENTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($citas) <1)
                                    <tr><td colspan="7"><h5>Sin Resultados</h5></td></tr>
                                    @endif
                                    @foreach ($citas as $c )
                                        <tr>
                                            <td class="text-center"><h6>{{$c->paciente->nombre}}</h6></td>
                                            <td class="text-center"><h6>{{$c->tratamiento->nombre}}</h6></td>
                                            <td hidden><h6>{{$sumCitas = $sumCitas+$c->tratamiento->precio }}</h6></td>
                                           <td class="text-center"><h6>{{$c->medico}}</h6></td>
                                           <td class="text-center"><h6>{{$c->tratamiento->precio}}</h6></td>

                                       </tr>
                                        @endforeach
                                </tbody>
                                <tfoot class="p-3 mb-2 bg-white text-dark">
                                    <tr>
                                        {{-- <th><h3 class="badge badge-primary">CAJA:  {{$total_diario}}</h3></th> --}}
                                        <th>
                                            <h4 class="">total citas:  {{$sumCitas}} </h4>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                         {{-- TABLA DE PAGOS --}}

                         <div class="table-responsive">
                            <table class="table mt-1 table-bordered table-striped">
                                <h4 class="card-title text-center"><b>Pagos extras</b></h4>
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="text-white table-th text-center">DESCRIPCION DEL PAGO</th>
                                        <th class="text-white table-th text-center">PACIENTE</th>
                                        <th class="text-white table-th text-center">MONTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($pagosextras) <1 )
                                        <tr><td colspan="7"><h5>Sin pagos extras</h5></td></tr>
                                    @endif
                                    @foreach ($pagosextras as $pe )
                                    <tr>
                                         <td class="text-center"><h6>{{$pe->descripcion}}</h6></td>
                                         <td class="text-center"><h6>{{$pe->paciente->nombre}}</h6></td>
                                         <td class="text-center"><h6>{{$pe->monto}}</h6></td>
                                         <td hidden><h6>{{$sumExtras = $sumExtras+$pe->monto }}</h6></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="p-3 mb-2 bg-white text-dark">
                                    <tr>
                                        <th>
                                            <h4 class="">pagos extras:  {{$sumExtras}} </h4>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        <h2>TOTAL: {{ $sumCitas + $sumExtras }}</h2>

                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        flatpickr(document.getElementsByClassName('flatpickr'),{
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
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
        window.livewire.on('show-modal', Msg =>{
            $('#modalDetails').modal('show')
        })
    })

    function rePrint(saleId)
    {
        window.open("print://" + saleId,  '_self').close()
    }
</script>






<script>

    document.addEventListener('DOMContentLoaded', function(){
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
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
        window.livewire.on('show-modal', Msg => {
            $('#modalDetails').modal('show')
        })
    })
</script>

<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige un Médico</h6>
                                <div class="form-group">
                                    <select wire:model="medico_id" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach ($medicos as $medico )
                                        <option value="{{$medico->id}}">{{$medico->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
{{--
                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas del día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div> --}}

                            {{-- <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model='dateFrom'
                                    class="form-control flatpickr"
                                    placeholder="Click para elegir">
                                </div>
                            </div> --}}

                            {{-- <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model='dateTo'
                                    class="form-control flatpickr"
                                    placeholder="Click para elegir">
                                </div>
                            </div> --}}
                            <div class="col-sm-12">
                                {{-- <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button> --}}

                               <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disable' : '' }}"
                                href="{{ url('report/pdf' . '/' . $medico_id) }}" target="_blank">
                                Generar PDF
                                </a>
                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disable' : '' }}"
                                href="{{ url('report/excel' . '/' . $medico_id . '/'  . $dateFrom . '/' . $dateTo) }}" target="_blank">
                                Generar EXCEL
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-9">
                      <!--TABLA -->
                        <div class="table-responsive">
                            <table class="table mt-1 table-bordered table-striped">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="text-white table-th text-center">PACIENTE</th>
                                        <th class="text-white table-th text-center">TRATAMIENTO</th>
                                        <th class="text-white table-th text-center">MÉDIC@</th>
                                        <th class="text-white table-th text-center">VALOR TRATAMIENTO</th>
                                        {{-- <th class="text-white table-th text-center">USUARIO</th>
                                        <th class="text-white table-th text-center">FECHA</th>
                                        <th class="text-white table-th text-center" width="50px">ACTIONS</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) <1)
                                        <tr><td colspan="7"><h5>Sin Resultados</h5></td></tr>
                                    @endif
                                    @foreach ($data as $d )
                                        <tr>
                                             <td class="text-center"><h6>{{$d->paciente->nombre}}</h6></td>
                                             <td class="text-center"><h6>{{$d->tratamiento->nombre}}</h6></td>
                                             <td hidden><h6>{{$total_diario = $total_diario+$d->tratamiento->precio }}</h6></td>
                                            <td class="text-center"><h6>{{$d->medico}}</h6></td>
                                            <td class="text-center"><h6>{{$d->tratamiento->precio}}</h6></td>
                                            {{-- <td class="text-center"><h6>{{$d->items}}</h6></td>
                                            <td class="text-center"><h6>{{$d->status}}</h6></td>
                                            <td class="text-center"><h6>{{$d->user}}</h6></td> --}}
                                            {{-- <td class="text-center">
                                                <h6>
                                                    {{\Carbon\Carbon::parse($d->created_at)->format('d-m-Y')}}
                                                </h6>
                                            </td> --}}
                                            {{-- <td class="text-center" width="50px">
                                               <button wire:click.prevent="getDetails({{$d->id}})"
                                               class="btn btn-dark btn-sm">
                                                   <i class="fas fa-list"></i>
                                               </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="p-3 mb-2 bg-white text-dark">
                                    <tr>
                                        {{-- <th><h3 class="badge badge-primary">CAJA:  {{$total_diario}}</h3></th> --}}
                                        <th>
                                            <h4 class="">CAJA:  {{$total_diario}} </h4>

                                        </th>


                                    </tr>

                                </tfoot>
                            </table>

                        </div>
                         <!--TABLA PAGOS EXTRAS  -->
                        <div class="table-responsive">
                            <table class="table mt-1 table-bordered table-striped">
                                <h4 class="card-title text-center"><b>Pagos extras</b></h4>
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="text-white table-th text-center">DESCRIPCION DEL PAGO</th>
                                        <th class="text-white table-th text-center">PACIENTE</th>
                                        <th class="text-white table-th text-center">MONTO</th>
                                        {{-- <th class="text-white table-th text-center">USUARIO</th>
                                        <th class="text-white table-th text-center">FECHA</th>
                                        <th class="text-white table-th text-center" width="50px">ACTIONS</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) <1)
                                        <tr><td colspan="7"><h5>Sin Resultados</h5></td></tr>
                                    @endif
                                    @foreach ($pagosextras as $pe )
                                        <tr>
                                             <td class="text-center"><h6>{{$pe->descripcion}}</h6></td>
                                             <td class="text-center"><h6>{{$pe->paciente->nombre}}</h6></td>
                                             <td class="text-center"><h6>{{$pe->monto}}</h6></td>
                                             <td hidden><h6>{{$extras = $extras+$pe->monto }}</h6></td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="p-3 mb-2 bg-white text-dark">
                                    <tr>

                                        <th>
                                            <h4 class="">PAGOS EXTRAS:  {{$extras}} </h4>
                                        </th>

                                    </tr>

                                </tfoot>
                            </table>

                            <h2>TOTAL HOY: {{ $total_diario + $extras }}</h2>

                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
    {{-- @include('livewire.reports.sales-detail') --}}
</div>

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

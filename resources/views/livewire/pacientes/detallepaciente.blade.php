<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg"  role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="text-white modal-title">
              <b>historial de citas  </b>
          </h5>
          <h6 class="text-center text warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">

            @if(count($citas) <1)
                 <tr><td colspan="7"><h4>El paciente no registra citas médicas</h4></td></tr>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-1">
                    <thead class="text-white" style="background: #3B3F5C">
                        <tr>
                            <th class="table-th text-white text-center">FECHA</th>
                            <th class="table-th text-white text-center">TRATAMIENTO</th>
                            <th class="table-th text-white text-center">CITA</th>
                            <th class="table-th text-white text-center">VALOR</th>
                            <th class="table-th text-white text-center">ESTADO</th>
                            <th class="table-th text-white text-center">MEDICO</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($citas as $c )
                         <tr>

                             <td class="text-center"><h6>{{\Carbon\Carbon::parse($c->fecha_ini)->isoFormat('LL')}}</h6></td>
                             <td><h6>{{$c->tratamiento->nombre}}</h6></td>
                             <td><h6>{{$c->estado->nombre}}</h6></td>
                             <td><h6>{{$c->tratamiento->precio}}</h6></td>
                             <td><h6>{{$c->estado_pago}}</h6></td>
                             <td><h6>{{$c->medico->nombre}}</h6></td>
                             <td hidden><h6>{{$idpaciente = $c->paciente->id }}</h6></td>
                             @if ($c->estado_pago == 'PAGADO')
                                 <td hidden><h6>{{$total = $total+$c->tratamiento->precio }}</h6></td>

                             @elseif ($c->estado_pago == 'PENDIENTE')
                                 <td hidden><h6>{{$pendiente = $pendiente+$c->tratamiento->precio }}</h6></td>
                             @endif
                         </tr>
                        @endforeach
                        <a class="btn btn-dark "
                             href="{{ url('detpaciente' . '/'.$idpaciente) }}"  target="_blank">Imprimir Historial</a>
                     </tbody>
                     <tfoot>
                         <tr>
                             <td colspan="2"><h5 class="text-center font-weight-bold"><span class="badge badge-success">ABONADO</span></h5></td>
                             <td><h5 class="text-center">{{$total}}</h5></td>



                         </tr>
                         <tr>
                             <td colspan="2"><h5 class="text-center font-weight-bold"><span class="badge badge-danger">DEUDA</span></h5></td>
                             <td><h5 class="text-center">{{$pendiente}}</h5></td>
                         </tr>

                         <tr>
                             <td colspan="2"><h5 class="text-center font-weight-bold"><span class="badge badge-primary">TOTAL</span></h5></td>
                             <td><h5 class="text-center">{{$total + $pendiente}}</h5></td>
                             {{-- <td><h5 class="text-center">{{$idpaciente}}</h5></td> --}}

                         </tr>

                     </tfoot>
                </table>


                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <h4 class="card-title text-center"><b>Pagos extras</b></h4>
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th text-center">DESCRIPCION DEL PAGO</th>
                                <th class="text-white table-th text-center">FECHA DEL PAGO</th>
                                <th class="text-white table-th text-center">MONTO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($pagos) <1 )
                                <tr><td colspan="7"><h5>Sin pagos extras</h5></td></tr>
                            @endif
                            @foreach ($pagos as $pe )
                            <tr>
                                 <td class="text-center"><h6>{{$pe->descripcion}}</h6></td>
                                 <td class="text-center"><h6>{{\Carbon\Carbon::parse($pe->created_at)->isoFormat('LL')}}</h6></td>
                                 <td class="text-center"><h6>{{$pe->monto}}</h6></td>
                                 <td hidden><h6>{{$sumExtras = $sumExtras+$pe->monto }}</h6></td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="p-3 mb-2 bg-white text-dark">
                            <tr>
                                <th>
                                    <h4 class="">Aportes:  {{$sumExtras}} </h4>
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

                @if ($pendiente < $sumExtras)
                    @php
                        $saldoPendiente = $sumExtras - $pendiente
                    @endphp
                @else
                    @php
                        $saldoPendiente = $pendiente - $sumExtras
                     @endphp
                @endif


                @if ($sumExtras < $pendiente )
                    <h5>Saldo pendiente: {{ $saldoPendiente}}</h5>
                @else ()
                <h5>Saldo a favor: {{ $saldoPendiente}}</h5>
                @endif


            </div>
            @endif



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark close-btn text-info"
                data-dismiss="modal">
                CERRAR
            </button>


        </div>

    </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial paciente</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
</head>
<body>

        {{-- encabezado --}}

        <section class="header" style="top: -287px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td colspan="2" class="text-center">
                        <span style="font-size: 25px; font-weight: bold;">Historia clínica {{ $nombrepaciente }}</span>
                    </td>
                </tr>
                <tr>
                    <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative; ">
                        {{-- <img src="{{ asset('assets/img/logo.jpg') }}" alt="" class="invoice-logo"> --}}
                        <img src="{{ asset('storage/clinica/' . $logo ) }}" alt="imagen de ejemplo" height="80" width="90" class="rounded">
                    </td>
                        <td width="70%"  class="text-left text-company"  style="vertical-align: top; padding-top: 10px;">
                    </td>
                </tr>
            </table>
        </section>

          {{-- table --}}
        <section style="margin-top: -120px">
            <h2 class="card-title text-center">Citas:</h2>
            <table border="2px" cellpadding ="2" cellspacing="2" class="table-items" width="100%">
                <thead>
                    <tr>
                        <th width="25%">FECHA</th>
                        <th width="15%">TRATAMIENTO</th>
                        <th width="15%">CITA</th>
                        <th width="15%">VALOR</th>
                        <th width="15%">ESTADO</th>
                        <th width="15%">MEDICO</th>

                    </tr>
                </thead>
                <tbody >
                    @foreach ($citas as $c )
                    <tr>
                        <td align="center">{{\Carbon\Carbon::parse($c->fecha_ini)->isoFormat('LL')}}</td>
                        <td align="center">{{$c->tratamiento->nombre}}</td>
                        <td align="center">{{$c->estado->nombre}}</td>
                        <td align="center">{{$c->tratamiento->precio}}</td>
                        <td align="center">{{$c->estado_pago}}</td>
                        <td align="center">{{$c->medico->nombre}}</td>

                        @if ($c->estado_pago == 'PAGADO')
                            @php
                                $totalpagadopaciente = $totalpagadopaciente+$c->tratamiento->precio
                            @endphp


                        @elseif ($c->estado_pago == 'PENDIENTE')
                            @php
                                $totalpendientepaciente = $totalpendientepaciente+$c->tratamiento->precio
                            @endphp
                         @endif

                    </tr>
                    @endforeach
                </tbody >

            </table>

            <h3>Abonado : {{$totalpagadopaciente}}</h3>
            <h3>Deuda : {{$totalpendientepaciente}}</h3>
            <h3>Total: {{$totalcitas = $totalpendientepaciente + $totalpagadopaciente}}</h3>


            <h2 class="card-title text-center">Pagos extras</h2>
                <table border="2px" cellpadding ="2" cellspacing="2" class="table-items" width="100%">
                    <thead>
                        <tr>
                            <th width="33%">DESCRIPCION DEL PAGO</th>
                            <th width="34%">FECHA PAGO</th>
                            <th width="33%">MONTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($pagos) <1 )
                            <tr><td colspan="7"><h5>Sin pagos extras</h5></td></tr>
                        @endif
                        @foreach ($pagos as $pe )
                        <tr>
                            <td align="center">{{$pe->descripcion}}</td>
                            <td align="center">{{\Carbon\Carbon::parse($pe->created_at)->isoFormat('LL')}}</td>
                            <td align="center">{{$pe->monto}}</td>
                            {{-- <td hidden align="center">{{$sumExtras = $sumExtras+$pe->monto }}</td> --}}
                            @php
                                $sumExtras = $sumExtras+$pe->monto
                            @endphp

                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <h3>Aportes:  {{$sumExtras}}</h3>


              @if ($totalpendientepaciente < $sumExtras)
                  @php
                      $saldoPendiente = $sumExtras - $totalpendientepaciente
                  @endphp
            @else
                @php
                    $saldoPendiente = $totalpendientepaciente - $sumExtras
                @endphp
              @endif

              @if ($sumExtras < $totalpendientepaciente )
              <h2>Saldo pendiente: {{ $saldoPendiente}}</h2>
          @else ()
                <h2>Saldo a favor: {{ $saldoPendiente}}</h2>
          @endif
            {{-- <h2>TOTAL: $ {{ $total_diario + $extras }}</h2> --}}

        </section>

        <section class="footer">
            <table cellpadding ="0" cellspacing="0" class="table-items" width="100%">
                <tr>
                    <td width="20%">
                        <span>Sistema de ventas Khipu v1</span>
                    </td>
                    <td width="60%" class="text-center">
                        <link rel="stylesheet" href="https://khipuweb.herokuapp.com">
                        <a href="https://khipuweb.herokuapp.com">Sitio web</a>
                    </td>
                    <td  width="20%"  class="text-center">
                        página <span class="pagenum"></span>
                    </td>
                </tr>
            </table>
        </section>

</body>
</html>

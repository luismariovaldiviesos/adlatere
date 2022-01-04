@extends('layouts.theme.app')
@section('content')

{{-- @can('ver_estadistica') --}}

<div id="dash" class="main-content">

    estadisticas
    {{-- <div class="row">
        <div class="col-12">
            <div class="card card-statistics">
              <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="statistics-item">
                      <p class="text-dark">
                        <i class="icon-sm fa fa-user mr-2"></i>
                       CITAS ATENDIDAS
                      </p>
                      <h2>{{ $atendidas }}</h2>
                      <label class="badge badge-outline-success badge-pill">2.7% increase</label>
                    </div>
                    <div class="statistics-item">
                      <p class="text-dark">
                        <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                       CITAS PENDIENTES
                      </p>
                      <h2>{{ $pendientes }}</h2>
                      <label class="badge badge-outline-danger badge-pill">30% decrease</label>
                    </div>
                    <div class="statistics-item">
                      <p class="text-dark">
                        <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                        CANCELDAS POR EL PACIENTE
                      </p>
                      <h2>{{ $canceladas }}</h2>
                      <label class="badge badge-outline-success badge-pill">12% increase</label>
                    </div>
                    <div class="statistics-item">
                      <p class="text-dark">
                        <i class="icon-sm fas fa-check-circle mr-2"></i>
                        NO ASISTE
                      </p>
                      <h2>{{ $noasiste }}</h2>
                      <label class="badge badge-outline-success badge-pill">57% increase</label>
                    </div>
                    <div class="statistics-item">
                      <p class="text-dark">
                        <i class="icon-sm fas fa-chart-line mr-2"></i>
                        TOTAL CITAS AÑO {{ date('Y') }}
                      </p>
                      <h2>{{ $totalcitas }}</h2>
                      <label class="badge badge-outline-success badge-pill">10% increase</label>
                    </div>
                    {{-- <div class="statistics-item">
                      <p>
                        <i class="icon-sm fas fa-circle-notch mr-2"></i>
                        Pending
                      </p>
                      <h2>7500</h2>
                      <label class="badge badge-outline-danger badge-pill">16% decrease</label>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <div class="col-lg-8">
            <div class="layout-px">
                <div class="widget-content-area">
                       <div class="">
                            <h1>Estadísticas Generales</h1>

                            {!! $chartBalancexMes->container() !!}
                            <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
                            {{ $chartBalancexMes->script() }}


                        </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="layout-px">
                <div class="widget-content-area">
                       <div class="">

                        {!! $chartVentasxSemana->container() !!}

                        {{ $chartVentasxSemana->script() }}


                        </div>
                </div>
            </div>
        </div>



        <div class="col-ms-12 col-md-12 col-lg-12 mt-2">
            <div class="layout-px">
                <div class="widget-content-area">
                       <div class="">
                        {!! $chartVentasxMes->container() !!}
                        {{ $chartVentasxMes->script() }}
                        </div>
                </div>
            </div>
        </div>




        <div class="col-lg-6">
            <div class="layout-px">
                <div class="widget-content-area">
                       <div class="">
                        {!! $usuarios->container() !!}
                        {{ $usuarios->script() }}
                        </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="layout-px">
                <div class="widget-content-area">
                       <div class="">
                        {!! $chartpacientesxmes->container() !!}
                        {{ $chartpacientesxmes->script() }}
                        </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-ms-12 col-md-12 col-lg-12 mt-2">
            <div class="layout-px">
                <div class="widget-content-area">
                       <div class="">
                        {!! $estadoscitas->container() !!}

                        {{ $estadoscitas->script() }}
                        </div>
                </div>
            </div>
        </div> --}}

    </div>

</div>

{{--
@endcan --}}




@push('script')





@endpush

@endsection



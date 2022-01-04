
<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            @can('ver_paciente')
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName}} registrados: {{$pacientes}} | {{$pageTitle}}</b>
                </h4>

                @can('crear_paciente')
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                         data-target="#theModal">Agregar</a>

                    </li>
                </ul>
                @endcan


            </div>
            @can('buscar_paciente')
             @include('common.searchbox')
            @endcan

            @include('livewire.pacientes.detallepaciente')

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th">NOMBRE</th>
                                <th class="text-center text-white table-th">TELÉFONO</th>
                                <th class="text-center text-white table-th">EMAIL</th>
                                <th class="text-center text-white table-th">IMÁGEN</th>
                                <th class="text-center text-white table-th">DIRECCION</th>
                                <th class="text-center text-white table-th">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $r )

                                  <tr>
                                    <td><h6>{{$r->nombre}}</h6></td>
                                    <td class="text-center"><h6>{{$r->telefono}}</h6></td>
                                    <td class="text-center"><h6>{{$r->email}}</h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/pacientes/' . $r->imagen ) }}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                     </td>
                                    <td class="text-center"><h6>{{$r->direccion}}</h6></td>



                                    <td class="text-center">

                                       @can('editar_paciente')
                                        <a href="javascript:void(0)"
                                        wire:click="edit({{$r->id}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                       @endcan

                                        @can('eliminar_paciente')
                                            <a href="javascript:void(0)"
                                            onclick="Confirm({{$r->id}} ,  {{ $r->citas->count() }})"
                                            class="btn btn-dark " title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan

                                        @can('detalle_paciente')
                                        <a href="javascript:void(0)"
                                        wire:click="detallePaciente({{$r->id}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-list"></i>
                                        </a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>

            </div>
            @endcan

        </div>

    </div>

  @include('livewire.pacientes.form')


</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('paciente-added', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('paciente-updated', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('paciente-deleted', Msg =>{
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

    function Confirm(id, citas)
     {
         if(citas > 0)
         {
            swal('NO SE PUEDE ELIMINAR EL PACIENTE, TIENE CITAS ASIGNADAS')
             return ;
         }

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

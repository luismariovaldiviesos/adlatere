<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            @can('ver_rol')
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName}} | {{$pageTitle}}</b>
                </h4>
               @can('crear_rol')
               <ul class="tabs tab-pills">
                <li>
                    <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                     data-target="#theModal">Agregar</a>
                </li>
            </ul>
               @endcan
            </div>
           @can('buscar_rol')
               @include('common.searchbox')
           @endcan
            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">DESCRIPCION</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol )

                                 <tr>
                                    <td><h6>{{$rol->id}}</h6></td>
                                    <td class="text-center">
                                      <h6> {{$rol->name}}</h6>
                                    </td>

                                    <td class="text-center">
                                        @can('editar_rol')
                                        <a href="javascript:void(0)"
                                        wire:click="Edit({{$rol->id}})"
                                        class="btn btn-dark mtmobile" title="Editar Registro">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                       @can('eliminar_rol')
                                       <a href="javascript:void(0)"
                                       onclick="Confirm('{{$rol->id}}')"
                                       class="btn btn-dark " title="Eliminar Registro">
                                           <i class="fas fa-trash"></i>
                                       </a>
                                       @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$roles->links()}}
                </div>

            </div>
            @endcan
        </div>

    </div>

   @include('livewire.roles.form')

</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('role-added', Msg=> {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('role-updated', Msg=> {
            $('#theModal').modal('hide')
            noty(Msg)
        })

        window.livewire.on('role-deleted', Msg=> {
            noty(Msg)
        })

        window.livewire.on('role-exists', Msg=> {
            noty(Msg)
        })
        window.livewire.on('role-error', Msg=> {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg=> {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg=> {
            $('#theModal').modal('show')
        })

    });

    function Confirm(id)
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
                 window.livewire.emit('destroy', id) //deleteRow va al listener del controller
                 swal.close()
             }
         })
     }

</script>

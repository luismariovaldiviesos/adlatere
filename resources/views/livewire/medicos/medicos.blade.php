<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        @can('ver_medico')
        <div class="widget widget-chart-one">

            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                   @can('crear_medico')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                    </li>
                   @endcan
                </ul>
            </div>
            @can('buscar_medico')
            @include('common.searchbox')
            @endcan


            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th">ID</th>
                                <th class="text-white table-th">NOMBRE</th>
                                <th class="text-white table-th">TELÉFONO</th>
                                <th class="text-white table-th">CORREO</th>
                                <th class="text-white table-th">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($medicos as $medico)
                                <tr>
                                    <td><h6>{{$medico->id}}</h6></td>
                                    <td><h6> {{$medico->nombre}}</h6></td>
                                    <td><h6> {{$medico->telefono}}</h6></td>
                                    <td><h6> {{$medico->email}}</h6></td>

                                    <td>
                                      @can('editar_medico')
                                        <a href="javascript:void(0)"
                                        wire:click="Edit({{$medico->id}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                      @endcan

                                        @can('eliminar_medico')
                                        <a href="javascript:void(0)"
                                        onClick="Confirm({{ $medico->id }})"
                                        class="btn btn-dark " title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$medicos->links()}}
                </div>

            </div>

        </div>
        @endcan
    </div>

    @include('livewire.medicos.form')

</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){

        // evento que viene desde el Edit
        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show');
        });

        window.livewire.on('medico-noedita', Msg=> {
            noty(Msg)
        })
        window.livewire.on('medico-noelimina', Msg=> {
            noty(Msg)
        })

        // evento que viene desde el Store
        window.livewire.on('medico-added', msg=>{
            $('#theModal').modal('hide');
        });

         // evento que viene desde el Update
         window.livewire.on('medico-updated', msg=>{
            $('#theModal').modal('hide');
        });

    });

     // para eliminar envia un emit con el id al fornt donde se debe cachar en los listeners

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
                 window.livewire.emit('deleteRow', id) //deleteRow va al listener del controller
                 swal.close()
             }
         })
     }

</script>

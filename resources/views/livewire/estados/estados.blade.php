<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            @can('ver_estado')
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @can('crear_estado')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                         data-target="#theModal">Agregar</a>
                    </li>
                    @endcan

                </ul>
            </div>
            @can('buscar_estado')
                @include('common.searchbox')
            @endcan


            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th">ID</th>
                                <th class="text-white table-th">NOMBRE</th>
                                <th class="text-white table-th">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estados as $estado)

                              <tr>
                                    <td><h6>{{$estado->id}}</h6></td>
                                    <td><h6> {{$estado->nombre}}</h6></td>

                                    <td>
                                        @can('editar_estado')
                                            <a href="javascript:void(0)"
                                            wire:click="Edit({{$estado->id}})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('eliminar_estado')
                                            <a href="javascript:void(0)"
                                            onClick="Confirm({{ $estado->id }}, '{{ $estado->citas->count() }}')"
                                            class="btn btn-dark " title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$estados->links()}}
                </div>

            </div>
            @endcan
        </div>

    </div>

    @include('livewire.estados.form')

</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){

        // evento que viene desde el Edit
        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show');
        });

        window.livewire.on('estado-noedita', Msg=> {
            noty(Msg)
        })

        // evento que viene desde el Store
        window.livewire.on('estado-added', msg=>{
            $('#theModal').modal('hide');
        });

         // evento que viene desde el Update
         window.livewire.on('estado-updated', msg=>{
            $('#theModal').modal('hide');
        });

    });

     // para eliminar envia un emit con el id al fornt donde se debe cachar en los listeners

     function Confirm(id, estados)
     {
         if(estados > 0){
            swal('NO SE PUEDE ELIMINAR EL ESTADO, TIENE CITAS RELACIONADAS ');
             return;
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

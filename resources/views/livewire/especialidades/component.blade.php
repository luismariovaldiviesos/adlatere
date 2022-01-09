<div class="row sales layout-top-spacing">

    <div class="col-sm-12">

        @hasrole('administrador')



        <div class="widget widget-chart-one">
            {{-- @can('ver_tratamiento') --}}
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>

                {{-- @can('crear_tratamiento') --}}
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                         data-target="#theModal">Agregar</a>
                    </li>
                </ul>
                {{-- @endcan --}}

            </div>

            {{-- @can('buscar_tratamiento') --}}
            @include('common.searchbox')
            {{-- @endcan --}}


            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th">NOMBRE</th>

                                <th class="text-white table-th">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($especialidades as $espe)

                                    <tr>
                                            <td><h6>{{$espe->nombre}}</h6></td>


                                        <td>


                                           {{-- @can('editar_tratamiento') --}}
                                            <a href="javascript:void(0)"
                                            wire:click="Edit({{$espe->id}})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                           {{-- @endcan --}}

                                           {{-- @can('eliminar_tratamiento') --}}
                                            <a href="javascript:void(0)"
                                            onClick="Confirm({{ $espe->id }})"
                                            class="btn btn-dark " title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                           {{-- @endcan --}}

                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$especialidades->links()}}
                </div>

            </div>
            {{-- @endcan --}}

        </div>

        @endhasrole

    </div>

    @include('livewire.especialidades.form')

</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){

        // evento que viene desde el Edit
        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show');
        });
        window.livewire.on('tratamiento-noedita', Msg=> {
            noty(Msg)
        })


        // evento que viene desde el Store
        window.livewire.on('especialidad_agregada', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })

         // evento que viene desde el Update
         window.livewire.on('especialidad_actualizada', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
          // evento que viene desde el Update
          window.livewire.on('especialidad_eliminada', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })


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

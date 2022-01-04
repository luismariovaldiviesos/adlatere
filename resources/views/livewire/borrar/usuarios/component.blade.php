
<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        {{-- @can('ver_usuario') --}}


        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                         data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-white table-th">USUARIO</th>
                                <th class="text-center text-white table-th">TELÉFONO</th>
                                <th class="text-center text-white table-th">EMAIL</th>
                                <th class="text-center text-white table-th">PERFIL</th>
                                <th class="text-center text-white table-th">ESTATUS</th>
                                <th class="text-center text-white table-th">IMÁGEN</th>
                                <th class="text-center text-white table-th">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $r )
                                <tr>
                                    <td><h6>{{$r->name}}</h6></td>
                                    <td class="text-center"><h6>{{$r->phone}}</h6></td>
                                    <td class="text-center"><h6>{{$r->email}}</h6></td>
                                    <td class="text-center"><h6>{{$r->profile}}</h6></td>
                                    <td class="text-center">
                                        <span class="badge {{$r->status == 'ACTIVE' ? 'badge-success' : 'badge-danger'}} text-uppercase">
                                            {{$r->status}}
                                        </span>

                                    </td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/users/' . $r->imagen ) }}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                     </td>
                                    <td class="text-center">
                                        {{-- @can('editar_usuario') --}}
                                            <a href="javascript:void(0)"
                                            wire:click="edit({{$r->id}})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        {{-- @endcan --}}

                                        @can('eliminar_usuario')
                                            <a href="javascript:void(0)"
                                            onclick="Confirm('{{$r->id}}')"
                                            class="btn btn-dark " title="Delete">
                                                <i class="fas fa-trash"></i>
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

        </div>
        {{-- @endcan --}}
    </div>

  @include('livewire.usuarios.form')

</div>


<script>

    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('user-added', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('user-updated', Msg =>{
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('user-deleted', Msg =>{
           noty(Msg)
        })
        window.livewire.on('user-nodeleted', Msg =>{
           noty(Msg)
        })
        window.livewire.on('hide-modal', Msg =>{
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg =>{
            $('#theModal').modal('show')
        })

        window.livewire.on('user-withsales', Msg =>{
            noty(Msg)
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
                 window.livewire.emit('deleteRow', id) //deleteRow va al listener del controller
                 swal.close()
             }
         })
     }

</script>

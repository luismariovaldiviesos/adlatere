<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="text-white modal-title">
              <b>{{$componentName}}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
          </h5>
          <h6 class="text-center text warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">


            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-edit">

                            </span>
                        </span>
                    </div>
                    <input type="text" wire:model.lazy="roleName" class="form-control" placeholder="ej:Admin">
                    @error('roleName') <span class="text-danger er">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                data-dismiss="modal">
                CERRAR
            </button>

            @if ($selected_id < 1)
                <button type="button" wire:click.prevent="CreateRol()" class="btn btn-dark close-modal">
                    GUARDAR
                </button>
            @else
                <button type="button" wire:click.prevent="UpdateRol()" class="btn btn-dark close-modal">
                    ACTUALIZAR
                </button>
            @endif

        </div>
    </div>
    </div>
</div>


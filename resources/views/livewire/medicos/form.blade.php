@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 ">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="nombre">
             @error('nombre') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="ci">
             @error('ci') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="telefono" siz="10">
             @error('telefono') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="email" wire:model.lazy="email" class="form-control" placeholder="email">
             @error('email') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="direccion" class="form-control" placeholder="direccion">
             @error('direccion') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

</div>
@include('common.modalFooter')

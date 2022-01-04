@include('common.modalHead')
<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="nuevo estado de cita">
             @error('nombre') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

</div>
@include('common.modalFooter')

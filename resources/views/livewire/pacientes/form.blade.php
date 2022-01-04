@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Luis Mario">
            @error('nombre') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Cédula-Ruc</label>
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="ej: 0101111">
            @error('ci') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Teléfono</label>
            <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="ej:099999999" maxlength="10">
            @error('telefono') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Email</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej:mails@mail.com" >
            @error('email') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Imagén de perfil</label>
            <input type="file" wire:model="image" accept="image/x-png, image/jpeg, image/gif" class="form-control">
            @error('image') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Direccion</label>
            <input type="text" wire:model.lazy="direccion" class="form-control" >
            @error('direccion') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Enfermedad</label>
            <textarea wire:model.lazy='enfermedad' class="form-control"  rows="3"></textarea>
            @error('enfermedad') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Medicamentos</label>
            <textarea wire:model.lazy='medicamentos' class="form-control"  rows="3"></textarea>
            @error('medicamentos') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label >Alergias</label>
            <textarea wire:model.lazy='alergias' class="form-control"  rows="3"></textarea>
            @error('alergias') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>



</div>

@include('common.modalFooter')

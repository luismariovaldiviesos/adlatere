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
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="Descripción">
             @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>

    <br><br><br>

    <div class="col-sm-12">
        <div class="input-group">
            <select wire:model.lazy="paciente_id" class="form-control">
                <option value="Elegir" selected>Elegir Paciente</option>
                @foreach ($pacientes as $m )
                <option value="{{ $m->id }}" >{{ $m->nombre }}</option>
                @endforeach
            </select>
            @error('medico_id') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <br><br><br>
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>
            <input type="number" wire:model.lazy="monto" class="form-control" placeholder="monto">
             @error('monto') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')


<div class="row justify-content-between">
    <div class="col-lg-12 col-md-4 col-sm-12">
        <h6>Elige un Estado</h6>
        <div class="mb-4 input-group">
            <select wire:model="estado_id" class="form-control">
                <option value="">TODOS</option>
                @foreach ($estados as $estado)
                <option value="{{ $estado->id }}">{{$estado->nombre}}</option>
                @endforeach
            </select>

        </div>
    </div>
</div>





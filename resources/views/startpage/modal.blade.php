<div wire:ignore.self class="modal fade" id="modalAgendar" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="text-white modal-title">
              <b>Componente</b>
          </h5>
          <h6 class="text-center text warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">

			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="form-group">
						<label >Paciente</label>
						<input wire:model="buscar_paciente" type="search" class="form-control" placeholder="Buscar paciente en el sistema ">
						@error('buscar_paciente') <span class="text-danger er">{{ $message }}</span> @enderror
						{{-- @if ($buscar_paciente != '')
						<ul class="list-group" >
							@if (!$pacientes->isEmpty())
								@foreach($pacientes as $p)
									<li wire:click="cargarPaciente('{{$p}}')"
										class="list-group lis-group-action"
									 >
										{{ $p->nombre }}</li>
								@endforeach
							@else
								@if ($editar == 'si')
									<p>Ups! No hay resultados </p>
								@else
									<p>Ups! No hay resultados </p>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										Crear Paciente
									</button>
								@endif
							@endif

						</ul>
					@else
						<p>No hay consulta </p>
					@endif --}}
					</div>
				</div>
				   <div class="mt-2 col-sm-6">
						<h6>Fecha Inicio</h6>
						<div class="form-group">
							<input type="text" wire:model='fecha_ini'
							class="form-control flatpickr"
							placeholder="Click para elegir">
						</div>
					</div>

					<div class="mt-2 col-sm-6">
						<h6>Fecha Final</h6>
						<div class="form-group">
							<input type="text" wire:model='fecha_fin'
							class="form-control flatpickr"
							placeholder="Click para elegir">
						</div>
					</div>

					<div class="col-sm-12 col-md-12">
						<div class="form-group">
							<label >Descripción</label>
							<input type="text" wire:model.lazy="descripcion" class="form-control" >
							@error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
						</div>
					</div>



					<div class="col-sm-12 col-md-6">
						<div class="form-group">
							<label >Medico</label>
							<select wire:model.lazy="medico_id" class="form-control">
								{{-- <option value="Elegir" selected>Elegir</option>
								@foreach ($medicos as $m )
								<option value="{{ $m->id }}" >{{ $m->nombre }}</option>
								@endforeach --}}
							</select>
							@error('medico_id') <span class="text-danger er">{{ $message }}</span> @enderror
						</div>
					</div>

						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label >Receta</label>
								<textarea wire:model.lazy='receta' class="form-control"  rows="3"></textarea>

							</div>
						</div>

						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label >Tratamiento</label>
								<select wire:model.lazy="tratamiento_id" class="form-control">
									<option value="Elegir" selected>Elegir</option>
									{{-- @foreach ($tratamientos as $t )
									<option value="{{ $t->id }}" >{{ $t->nombre }}</option>
									@endforeach --}}
								</select>
								@error('tratamiento_id') <span class="text-danger er">{{ $message }}</span> @enderror
							</div>
						</div>

						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label >Pagos</label>
								<select wire:model.lazy="pago_id" class="form-control">
									<option value="Elegir" selected>Elegir</option>
									{{-- @foreach ($pagos as $p)
									<option value="{{ $p->id }}" >{{ $p->nombre }}</option>
									@endforeach --}}
								</select>
								@error('pago_id') <span class="text-danger er">{{ $message }}</span> @enderror
							</div>
						</div>

						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label >Estado Cita</label>
								<select wire:model.lazy="estado" class="form-control">
									<option value="Elegir" selected>Elegir</option>
									{{-- @foreach ($estados as $e)
									<option value="{{ $e->id }}" >{{ $e->nombre }}</option>
									@endforeach --}}
								</select>
								@error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
							</div>
						</div>

			</div>

		</div>
        <div class="modal-footer">
            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                data-dismiss="modal">
                CERRAR
            </button>

            {{-- @if ($selected_id < 1) --}}
                <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">
                    GUARDAR
                </button>
            {{-- @else --}}
                <button type="button" wire:click.prevent="Update()" class="btn btn-dark close-modal">
                    ACTUALIZAR
                </button>
            {{-- @endif --}}

        </div>
    </div>
    </div>
</div>

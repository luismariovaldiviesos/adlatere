<div class="intro-y box p-5">
    <h2 class="font-medium text-base mr-auto mb-2">Correo de la empresa</h2>
    <p class="text-gray-600 mb-5">
        Configure el correo desde el cual se enviarán las facturas. Para Gmail, Hotmail o Yahoo debe usar una contraseña de aplicación, no la contraseña normal de la cuenta.
    </p>

    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12 sm:col-span-6">
            <label class="form-label">Correo de empresa</label>
            <input wire:model.lazy="email" type="email" class="form-control" placeholder="facturacion@empresa.com">
            @error('email') <span class="text-theme-6">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-12 sm:col-span-6">
            <label class="form-label">Contraseña de aplicación</label>
            <input wire:model.defer="password" type="password" class="form-control" placeholder="{{ $config_id ? 'Dejar vacío para conservar la actual' : 'Contraseña de aplicación' }}">
            @error('password') <span class="text-theme-6">{{ $message }}</span> @enderror
            <p class="text-xs text-gray-500 mt-1">
                Gmail: activa la verificación en dos pasos y crea una contraseña de aplicación de 16 caracteres. No uses la contraseña normal de Gmail. Outlook/Hotmail: usa una contraseña de aplicación si tu cuenta la requiere.
            </p>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <label class="form-label">Nombre del remitente</label>
            <input wire:model.defer="from_name" type="text" class="form-control" placeholder="Nombre de la empresa">
            @error('from_name') <span class="text-theme-6">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mt-5">
        <button type="button" wire:click="$toggle('showAdvanced')" class="text-primary font-medium">
            {{ $showAdvanced ? 'Ocultar configuración avanzada' : 'Configuración avanzada (solo si la detección automática falla)' }}
        </button>
    </div>

    @if($showAdvanced)
    <div class="grid grid-cols-12 gap-5 mt-5 border-t border-gray-200 pt-5">
        <div class="col-span-12 sm:col-span-4">
            <label class="form-label">Servidor SMTP</label>
            <input wire:model.defer="host" type="text" class="form-control" placeholder="smtp.empresa.com">
            @error('host') <span class="text-theme-6">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-12 sm:col-span-4">
            <label class="form-label">Puerto</label>
            <input wire:model.defer="port" type="number" class="form-control" placeholder="587">
            @error('port') <span class="text-theme-6">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-12 sm:col-span-4">
            <label class="form-label">Cifrado</label>
            <select wire:model.defer="encryption" class="form-select">
                <option value="tls">TLS / STARTTLS</option>
                <option value="ssl">SSL</option>
            </select>
            @error('encryption') <span class="text-theme-6">{{ $message }}</span> @enderror
        </div>
    </div>
    @endif

    <div class="text-right mt-5">
        <button wire:click="save" class="btn btn-primary px-6 py-2.5" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Guardar correo</span>
            <span wire:loading wire:target="save">Guardando...</span>
        </button>
    </div>
</div>

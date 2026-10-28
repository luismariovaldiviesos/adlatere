<?php

namespace App\Http\Livewire;

use App\Models\MailConfiguration;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class MailSettings extends Component
{
    public $email = '';
    public $password = '';
    public $from_name = '';
    public $host = '';
    public $port = 587;
    public $encryption = 'tls';
    public $showAdvanced = false;
    public $config_id = null;

    public function mount()
    {
        $config = MailConfiguration::first();
        $settings = Setting::first();

        $this->from_name = $settings->razonSocial ?? $settings->nombreComercial ?? '';

        if ($config) {
            $this->config_id = $config->id;
            $this->email = $config->from_address ?: $config->username;
            $this->from_name = $config->from_name ?: $this->from_name;
            $this->host = $config->host;
            $this->port = $config->port;
            $this->encryption = $config->encryption;
            $this->password = '';
        }
    }

    public function updatedEmail($value)
    {
        $this->autocompletar($value);
    }

    private function autocompletar($email): void
    {
        $email = strtolower(trim((string) $email));
        if (!str_contains($email, '@')) {
            return;
        }

        $domain = substr(strrchr($email, '@'), 1);
        $map = [
            'gmail.com' => ['smtp.gmail.com', 587, 'tls'],
            'googlemail.com' => ['smtp.gmail.com', 587, 'tls'],
            'hotmail.com' => ['smtp-mail.outlook.com', 587, 'tls'],
            'outlook.com' => ['smtp-mail.outlook.com', 587, 'tls'],
            'live.com' => ['smtp-mail.outlook.com', 587, 'tls'],
            'msn.com' => ['smtp-mail.outlook.com', 587, 'tls'],
            'yahoo.com' => ['smtp.mail.yahoo.com', 465, 'ssl'],
            'yahoo.es' => ['smtp.mail.yahoo.com', 465, 'ssl'],
            'icloud.com' => ['smtp.mail.me.com', 587, 'tls'],
            'me.com' => ['smtp.mail.me.com', 587, 'tls'],
        ];

        if (isset($map[$domain])) {
            [$this->host, $this->port, $this->encryption] = $map[$domain];
            return;
        }

        // Mejor esfuerzo para dominios propios. El usuario puede ajustar
        // host/puerto en la sección avanzada si su proveedor usa otro servidor.
        $this->host = 'smtp.' . $domain;
        $this->port = 587;
        $this->encryption = 'tls';
    }

    public function save()
    {
        $this->autocompletar($this->email);

        if ($this->password !== '') {
            $this->password = preg_replace('/\s+/', '', trim($this->password));
            $domain = strtolower(substr(strrchr($this->email, '@') ?: '', 1));

            if (in_array($domain, ['gmail.com', 'googlemail.com'], true) && strlen($this->password) !== 16) {
                $this->addError('password', 'Gmail exige una contraseña de aplicación de 16 caracteres. No uses la contraseña normal de la cuenta.');
                return;
            }
        }

        $rules = [
            'email' => 'required|email',
            'password' => $this->config_id ? 'nullable|string' : 'required|string',
            'host' => 'required|string',
            'port' => 'required|integer|between:1,65535',
            'encryption' => 'required|in:tls,ssl,starttls',
            'from_name' => 'nullable|string|max:255',
        ];

        $this->validate($rules, [
            'email.required' => 'Ingrese el correo de la empresa.',
            'email.email' => 'Ingrese un correo válido.',
            'password.required' => 'Ingrese la contraseña de aplicación del correo.',
            'host.required' => 'No se pudo detectar el servidor SMTP. Revise la configuración avanzada.',
            'port.required' => 'Ingrese el puerto SMTP.',
            'encryption.in' => 'Seleccione TLS o SSL.',
        ]);

        $data = [
            'driver' => 'smtp',
            'host' => $this->host,
            'port' => (int) $this->port,
            'username' => $this->email,
            'encryption' => $this->encryption === 'starttls' ? 'tls' : $this->encryption,
            'from_address' => $this->email,
            'from_name' => $this->from_name ?: (Setting::first()->razonSocial ?? ''),
        ];

        if ($this->password !== '') {
            $data['password'] = $this->password;
        }

        if ($this->config_id) {
            $config = MailConfiguration::find($this->config_id);
            if ($config) {
                $config->update($data);
            }
        } else {
            MailConfiguration::create($data);
        }

        Cache::forget('mail_config');
        $this->password = '';

        $this->dispatchBrowserEvent('noty', [
            'msg' => 'Correo de empresa guardado correctamente.',
            'type' => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.mail-settings.component')
            ->layout('layouts.theme.app');
    }
}

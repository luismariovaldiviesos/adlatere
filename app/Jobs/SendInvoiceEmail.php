<?php

namespace App\Jobs;

use App\Mail\FacturaMail;
use App\Models\Factura;
use App\Models\MailConfiguration;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $factura;

    public function __construct(Factura $factura)
    {
        $this->factura = $factura;
    }

    public function handle()
    {
        Log::info('[DEBUG_JOB] Iniciando envío de correo para factura: ' . $this->factura->secuencial);

        try {
            $settings = Setting::first();

            $pdf_name = $this->factura->customer->businame . '_' . $this->factura->secuencial;
            $xml_name = $this->factura->customer->valueidenti . '_' . $this->factura->secuencial;

            if ($this->factura->codDoc == '04') {
                $pdf_name .= '_NC';
                $xml_name .= '_NC';
            }

            $datePath = $this->factura->created_at->format('Y/m/');

            $pdfRelative = $datePath . $pdf_name . '.pdf';
            $pdfPath = Storage::disk('comprobantes/pdfs')->path($pdfRelative);

            if (!file_exists($pdfPath)) {
                $pdfPath = Storage::disk('comprobantes/pdfs')->path($pdf_name . '.pdf');
            }

            if (!file_exists($pdfPath)) {
                throw new \Exception('No se encontró el PDF de la factura ' . $this->factura->secuencial . '.');
            }

            $xml_file = $xml_name . '.xml';
            $xmlPath = null;
            $disks = ['comprobantes/autorizados', 'comprobantes/firmados', 'comprobantes/enviados'];

            foreach ($disks as $disk) {
                $tempPath = Storage::disk($disk)->path($datePath . $xml_file);
                if (file_exists($tempPath)) {
                    $xmlPath = $tempPath;
                    break;
                }

                $tempPath = Storage::disk($disk)->path($xml_file);
                if (file_exists($tempPath)) {
                    $xmlPath = $tempPath;
                    break;
                }
            }

            if (!$xmlPath) {
                Log::warning('[DEBUG_JOB] No se encontró el XML de la factura ' . $this->factura->secuencial . '. Se enviará solo el PDF.');
            }

            $mailConfig = MailConfiguration::first();

            if (!$mailConfig || empty($mailConfig->password)) {
                throw new \Exception('Configure el correo de la empresa en Configuración > Correo antes de enviar facturas.');
            }

            $fromEmail = $mailConfig->from_address ?: $mailConfig->username;
            $fromName = $mailConfig->from_name ?: ($settings->razonSocial ?? 'Sistema de Facturación');

            if (!$fromEmail) {
                throw new \Exception('El correo de empresa no tiene una dirección remitente configurada.');
            }

            $domain = strtolower(substr(strrchr($fromEmail, '@') ?: '', 1));
            $mailPassword = trim((string) $mailConfig->password);

            if (in_array($domain, ['gmail.com', 'googlemail.com'], true)) {
                $mailPassword = preg_replace('/\s+/', '', $mailPassword);

                if (strlen($mailPassword) !== 16) {
                    throw new \Exception('Gmail requiere una contraseña de aplicación de 16 caracteres. La contraseña guardada no tiene ese formato: vuelva a Configuración > Correo y reemplácela.');
                }
            }

            config([
                'mail.mailers.smtp_tenant' => [
                    'transport' => 'smtp',
                    'host' => $mailConfig->host,
                    'port' => (int) $mailConfig->port,
                    'encryption' => $mailConfig->encryption === 'starttls' ? 'tls' : $mailConfig->encryption,
                    'username' => $mailConfig->username,
                    'password' => $mailPassword,
                    'timeout' => 30,
                ],
                'mail.from.address' => $fromEmail,
                'mail.from.name' => $fromName,
            ]);

            Mail::purge('smtp_tenant');
            Mail::mailer('smtp_tenant')
                ->to($this->factura->customer->email)
                ->send(new FacturaMail($this->factura, $pdfPath, $xmlPath));

            Log::info('[DEBUG_JOB] Correo enviado con SMTP de empresa. From: ' . $fromEmail);
        } catch (\Exception $e) {
            Log::error('[DEBUG_JOB] Error enviando correo: ' . $e->getMessage());

            if (str_contains($e->getMessage(), '535-5.7.8') || str_contains($e->getMessage(), 'BadCredentials')) {
                throw new \Exception('No se pudo autenticar el correo de la empresa. En Gmail debe usar una contraseña de aplicación de 16 caracteres, no la contraseña normal de la cuenta.');
            }

            throw $e;
        }
    }
}

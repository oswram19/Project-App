<?php

namespace App\Console\Commands;

use App\Mail\ContactanosMailable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestContactEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-contact-email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending contact email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $testEmail = $this->argument('email') ?? 'test@example.com';

        $testData = [
            'nombre' => 'Usuario de Prueba',
            'correo' => 'usuario@test.com',
            'mensaje' => 'Este es un mensaje de prueba para verificar el envío de emails.'
        ];

        $this->info('Enviando email de prueba a: ' . $testEmail);

        try {
            Mail::to($testEmail)->send(new ContactanosMailable($testData));
            $this->info('✅ Email enviado exitosamente!');
        } catch (\Exception $e) {
            $this->error('❌ Error al enviar email: ' . $e->getMessage());
        }
    }
}

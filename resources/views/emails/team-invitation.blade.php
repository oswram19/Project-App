@component('mail::message')
{{ __('¡Has sido invitado a unirte al equipo :team!', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('Si no tienes una cuenta, puedes crear una haciendo clic en el botón de abajo. Después de crear tu cuenta, haz clic en el botón de aceptación de invitación de este correo para unirte al equipo:') }}

@component('mail::button', ['url' => route('register')])
{{ __('Crear Cuenta') }}
@endcomponent

{{ __('Si ya tienes una cuenta, puedes aceptar esta invitación haciendo clic en el botón de abajo:') }}

@else
{{ __('Puedes aceptar esta invitación haciendo clic en el botón de abajo:') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('Aceptar Invitación') }}
@endcomponent

{{ __('Si no esperabas recibir una invitación a este equipo, puedes ignorar este correo electrónico.') }}
@endcomponent

@component('mail::message')
    # Bienvenido a nuestra Aplicación

    Hola, {{ $user->name }}.

    Gracias por unirte a nosotros. Tu contraseña inicial es: `{{$pwd}}`. Por favor, inicia sesión y verifica tu cuenta.

    @component('mail::button', ['url' => config('app.url') . '/login'])
        Iniciar Sesión
    @endcomponent

    Gracias,<br>
    {{ config('app.name') }}
@endcomponent

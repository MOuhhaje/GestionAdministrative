@component('mail::message')
# Bonjour

{{ $Body }}

@if ($Passwrd!=null)
    Username: {{ $Email }}
    Password: {{ $Password }}

    @component('mail::button', ['url' => route('Etudiant') ])
    Login
    @endcomponent
@else
    
@endif


Thanks,<br>
{{ config('app.name') }}
@endcomponent

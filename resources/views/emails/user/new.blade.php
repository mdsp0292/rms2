@component('mail::message')
Hi {{ $userName }},

You are receiving this email because a user account was created for you in {{ config('app.name') }}.
Please click on the link below and set your initial password.

@component('mail::button', ['url' => $welcomeUrl, 'color' => 'success'])
    Set initial password
@endcomponent

This welcome link will expire in {{ $urlExpiresIn }} minutes.

@lang('Thanks'),<br>
{{ config('app.name') }}

@isset($welcomeUrl)
@slot('subcopy')
@lang(
"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
'into your web browser:',
[
    'actionText' => "Set initial password",
]
) <span class="break-all">[{{ $welcomeUrl }}]({{ $welcomeUrl }})</span>
@endslot
@endisset
@endcomponent

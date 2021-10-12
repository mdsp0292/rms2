@component('mail::message')

    Opportunity Status changed from blah to blah

@component('mail::button', ['url' => ''])
    {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

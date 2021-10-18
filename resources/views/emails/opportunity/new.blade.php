@component('mail::message')
A New Opportunity is created in {{ config('app.name') }}

<div>
Opportunity Name: {{ $opportunityName }} <br>
Amount: {{ $opportunityAmount }} <br>
Account: {{ $accountName }} <br>
</div>

@component('mail::button', ['url' => config('app.url')])
Check in APP
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

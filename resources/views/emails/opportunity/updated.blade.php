@component('mail::message')
Hello,

Opportunity {{ $opportunityName }} stage changed in {{ config('app.name') }}


@component('mail::table')
    |  |    |
    | ------------- | -------------:|
    | Opportunity Name  | {{ $opportunityName }}      |
    | Amount      | {{ $opportunityAmount }} |
    | Account     | {{ $accountName }} |
    | Old stage   | {{ $oldStatus }} |
    | New stage   | {{ $newStatus }} |
@endcomponent

@component('mail::button', ['url' => ''])
    View in {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

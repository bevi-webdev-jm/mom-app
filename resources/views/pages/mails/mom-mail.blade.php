@component('mail::message')
# Hello!

A new MOM **[{{ $mom->mom_number }}]** has been submitted and requires your attention.

Here are the MOM details:

@component('mail::table')
| Field         | Value                         |
|---------------|-------------------------------|
| MOM Number    | {{ $mom->mom_number }}        |
| Submitted By  | {{ $mom->submitted_by->name ?? 'N/A' }} |
| Date          | {{ \Carbon\Carbon::parse($mom->submitted_at)->format('F j, Y') }} |
| Project       | {{ $mom->project->name ?? 'N/A' }}      |
@endcomponent

@component('mail::button', ['url' => url('mom/' . encrypt($mom->id))])
View MOM
@endcomponent

Please review the MOM at your earliest convenience.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
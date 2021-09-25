@component('mail::message')
{{ trans_choice('mail.project_expiring_alert', $projects->count(), ['count'=>$projects->count(), 'threshold' => $threshold]) }}
@component('mail::table')

<table width="100%">
<tr><td>&nbsp;</td><td>{{ trans('mail.name') }}</td><td>{{ trans('mail.Days') }}</td><td>{{ trans('mail.expires') }}</td></tr>
@foreach ($projects as $project)
@php
$expires = \App\Helpers\Helper::getFormattedDateObject($project->end_date, 'date');
$diff = round(abs(strtotime($project->end_date->format('Y-m-d')) - strtotime(date('Y-m-d')))/86400);
$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');
@endphp
<tr><td>{{ $icon }} </td><td> <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a> </td><td> {{ $diff }} {{ trans('mail.Days') }}  </td><td>{{ $expires['formatted'] }}</td></tr>
@endforeach
</table>
@endcomponent
@endcomponent
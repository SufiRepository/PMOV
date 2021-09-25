@component('mail::message')
{{ trans_choice('mail.subtask_expiring_alert', $subtasks->count(), ['count'=>$subtasks->count(), 'threshold' => $threshold]) }}
@component('mail::table')

<table width="100%">
<tr><td>&nbsp;</td><td>{{ trans('mail.name') }}</td><td>{{ trans('mail.Days') }}</td><td>{{ trans('mail.expires') }}</td></tr>
@foreach ($subtasks as $subtask)
@php
$expires = \App\Helpers\Helper::getFormattedDateObject($license->contract_end_date, 'date');
$diff = round(abs(strtotime($subtask->contract_end_date->format('Y-m-d')) - strtotime(date('Y-m-d')))/86400);
$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');
@endphp
<tr><td>{{ $icon }} </td><td> <a href="{{ route('subtasks.show', $subtask->id) }}">{{ $subtask->name }}</a> </td><td> {{ $diff }} {{ trans('mail.Days') }}  </td><td>{{ $expires['formatted'] }}</td></tr>
@endforeach
</table>
@endcomponent
@endcomponent
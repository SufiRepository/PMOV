@component('mail::message')
{{ trans_choice('mail.task_expiring_alert', $tasks->count(), ['count'=>$tasks->count(), 'threshold' => $threshold]) }}
@component('mail::table')

<table width="100%">
<tr><td>&nbsp;</td><td>{{ trans('mail.name') }}</td><td>{{ trans('mail.Days') }}</td><td>{{ trans('mail.expires') }}</td></tr>
@foreach ($tasks as $task)
@php
$expires = \App\Helpers\Helper::getFormattedDateObject($task->contract_end_date, 'date');
$diff = round(abs(strtotime($task->contract_end_date->format('Y-m-d')) - strtotime(date('Y-m-d')))/86400);
$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');
@endphp
<tr><td>{{ $icon }} </td><td> <a href="{{ route('tasks.show', $task->id) }}">{{ $task->name }}</a> </td><td> {{ $diff }} {{ trans('mail.Days') }}  </td><td>{{ $expires['formatted'] }}</td></tr>
@endforeach
</table>
@endcomponent
@endcomponent
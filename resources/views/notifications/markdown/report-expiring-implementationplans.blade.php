@component('mail::message')
{{ trans_choice('mail.implementationplan_expiring_alert', $implementationplans->count(), ['count'=>$implementationplans->count(), 'threshold' => $threshold]) }}
@component('mail::table')

<table width="100%">
<tr><td>&nbsp;</td><td>{{ trans('mail.name') }}</td><td>{{ trans('mail.Days') }}</td><td>{{ trans('mail.expires') }}</td></tr>
@foreach ($implementationplans as $implementationplan)
@php
$expires = \App\Helpers\Helper::getFormattedDateObject($implementationplan->contract_end_date, 'date');
$diff = round(abs(strtotime($implementationplan->contract_end_date->format('Y-m-d')) - strtotime(date('Y-m-d')))/86400);
$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');
@endphp
<tr><td>{{ $icon }} </td><td> <a href="{{ route('implementationplans.show', $implementationplan->id) }}">{{ $implementationplan->name }}</a> </td><td> {{ $diff }} {{ trans('mail.Days') }}  </td><td>{{ $expires['formatted'] }}</td></tr>
@endforeach
</table>
@endcomponent
@endcomponent
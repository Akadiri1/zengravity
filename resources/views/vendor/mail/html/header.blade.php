@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'ZENGRAVITY')
<span style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: -1px;">
    ZEN<span style="color: #6366f1;">GRAVITY</span>
</span>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>

<table class="properties">
	<tr>
		<td class="propheader" style="width:20%">{t}Events{/t}:</td>
		<td class="propheader" style="width:15%" />
		<td class="propheader" style="width:20%" />
		<td class="propheader" style="width:45%" />
	</tr>
	<tr>
		<td class="proptitle"><strong>{t}Date{/t}</strong></td>
		<td class="proptitle"><strong>{t}Event{/t}</strong></td>
		<td class="proptitle"><strong>{t}Name{/t}</strong></td>
		<td class="proptitle"><strong>{t}Note{/t}</strong></td>
	</tr>
	{foreach from=$dvd->Events item=event key=sch}
		<tr>
			<td class="propvalue">{$event->date|date_format:$pmp_dateformat}{if $pmp_events_showtime == 1 && $event->time != '00:00:00'} - {$event->time}{/if}</td>
			<td class="propvalue">{t}{$event->eventtype}{/t}</td>
			<td class="propvalue">
				{*if $event->email != ''*}
					{*assign var="name" value="{$event->firstname} {$event->lastname}"*}
					{*mailto address=$event->email encode="javascript" text=$name*}
				{*else*}
					{$event->firstname}&nbsp;{$event->lastname}
				{*/if*}
			</td>
			<td class="propvalue">{$event->note}</td>
		</tr>
	{/foreach}
</table>

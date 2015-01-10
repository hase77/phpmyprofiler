{assign var="last_value" value=""}
{assign var="last_type" value=""}
{if !empty($dvd->Cast)}
	<table class="properties">
		<tr>
			<td class="propheader"  style="width: 45%;">{t}Cast{/t}:</td>
			<td class="propheader"  style="width: 10%;" />
			<td class="propheader"  style="width: 45%;" />
		</tr>

		{foreach from=$dvd->Cast item=value key=sch}

			{if $value->full != '[DIVIDER]'}
				<tr>
					{strip}
					<td class="td{$sch%2}">
						{if $last_value != $value->full}
							<a href="index.php?content=searchperson&amp;pname={$value->full_encoded}&amp;nowildcards{if $value->birthyear != ''}&amp;pbirthyear={$value->birthyear}{/if}">{if $value->creditedas != ''}{$value->creditedas}{else}{$value->full|colorname:$value->firstname:$value->middlename:$value->lastname}{/if}</a>
						{/if}
					</td>
					<td class="td{$sch%2}">
						{if $value->pic}
							<a href="javascript:void(0);" onmouseover="return overlib('<img src={$pmp_dir_cast}{$value->picname} />', WIDTH, '100', MOUSEOFF);" onmouseout="return nd();">
							<img src="themes/default/images/photo.gif" alt="Photo" /></a>
						{/if}
					</td>
					<td class="td{$sch%2}">
						{$value->role}{if $value->uncredited || $value->voice}&nbsp;({if $value->uncredited}{t}uncredited{/t}{if $value->voice},&nbsp;{/if}{/if}{if $value->voice}{t}voice{/t}{/if}){/if}
					</td>
					{assign var="last_value" value=$value->full}
					{/strip}
				</tr>
			{else}
				<tr>
					{if $value->role == 'Group'}
						<td class="group-title" style="height:12px;font-size:10px;padding:4px;" colspan="5">
					{elseif $value->role == 'EndDiv'}
						<td class="group-title" style="height:6px;font-size:10px;padding:1px;" colspan="5">
					{else}
						<td class="window-title" style="height:12px;font-size:10px;padding:4px;" colspan="5">
					{/if}
						{$value->creditedas}
					</td>
				</tr>
			{/if}

		{/foreach}

	</table>
{/if}

{if !empty($dvd->Credits)}
	<table class="properties">
		<tr>
			<td class="propheader"  style="width: 45%;">{t}Crew{/t}:</td>
			<td class="propheader"  style="width: 10%;" />
			<td class="propheader"  style="width: 45%;" />
		</tr>

		{assign var="sch" value="0"}

		{foreach from=$dvd->Credits item=value}

			{if $value->full != '[DIVIDER]'}
				{if $last_type != $value->type}
					<tr>
						<td class="td{$sch%2}" style="width: 40%;">
							<strong>{t}{$value->type}{/t}</strong>
						</td>
						<td class="td{$sch%2}"></td>
						<td class="td{$sch%2}"></td>
						{assign var="sch" value=$sch+1}
					</tr>
				{/if}
				<tr>
					<td class="td{$sch%2}" style="width: 40%;">
						<a href="index.php?content=searchperson&amp;pname={$value->full_encoded}&amp;nowildcards{if $value->birthyear != ''}&amp;pbirthyear={$value->birthyear}{/if}">{if $value->creditedas != ''}{$value->creditedas}{else}{$value->full|colorname:$value->firstname:$value->middlename:$value->lastname}{/if}</a>
					</td>
					<td class="td{$sch%2}">
						{if $value->pic}
							<a href="javascript:void(0);" onmouseover="return overlib('<img src={$pmp_dir_cast}{$value->picname} />', WIDTH, '100', MOUSEOFF);" onmouseout="return nd();">
							<img src="themes/{$pmp_theme}/images/photo.gif" alt="Photo" /></a>
						{/if}
					</td>
					<td class="td{$sch%2}">{t}{$value->subtype}{/t}</td>
				</tr>
				{assign var="last_type" value=$value->type}
			{else}
				<tr>
					{if $value->type == 'Group'}
						<td class="group-title" style="height:12px;font-size:10px;padding:4px;" colspan="3">
					{elseif $value->type == 'EndDiv'}
						<td class="group-title" style="height:6px;font-size:10px;padding:1px;" colspan="3">
					{else}
						<td class="window-title" style="height:12px;font-size:10px;padding:4px;" colspan="3">
					{/if}

						{$value->creditedas}
					</td>
				</tr>
			{/if}
			{assign var="sch" value=$sch+1}

		{/foreach}
	</table>
{/if}

<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value=$report.title}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Result{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<table style="width: 98%; margin: 0px; padding: 0px; border-collapse: collapse;"> 
					<tr>
						{foreach from=$report.column item=th name=foo} 
							{if $smarty.foreach.foo.index < 3}
								<th>{t}{$th}{/t}</th>
							{/if}
						{/foreach}
					</tr>
					{foreach from=$data item=row key=sch}
						<tr valign="top" > 
							{foreach from=$row item=col name=cols} 
								{if $smarty.foreach.cols.index < 3}
									<td class="td{$sch%2}">{if in_array($smarty.foreach.cols.iteration, $report.translate)}{t}{$col}{/t}{else}{$col}{/if}</td>
									{*<td class="td{$sch%2}">{t}{$col}{/t}</td>*}
								{/if}
							{/foreach}
						</tr> 
					{/foreach}
				</table>
			</td>
		</tr>
	</table>							

	{include file="window-end.inc.tpl"}

</div>

</td>

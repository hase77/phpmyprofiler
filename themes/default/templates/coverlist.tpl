<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Cover Gallery"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Information{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{t}Number of covers{/t}: {$count}
			</td>
		</tr>
	</table>

	<table class="cover">
		<tr>
			{assign var="counter" value="0"}
			{foreach from=$cover item=c name=cover}	
				{assign var="counter" value="$counter+1"}
				{assign var="hundred" value="100"}
				<td class="cover" style="width: {$hundred/$pmp_cover_per_row}%;">
					<a href="index.php?content=filmprofile&amp;id={$c->id}">{$c->Title}<br /><br />
					<img src="thumbnail.php?id={$c->id}&amp;type=front&amp;width=120" alt="{$c->Title}" width="120" /></a>
					<br />&nbsp;
				</td>
				{if $smarty.foreach.cover.iteration%$pmp_cover_per_row == '0'}
					</tr>
					<tr>
					{assign var="counter" value="0"}	
				{/if}
			{/foreach}
			{if $counter != $pmp_cover_per_row}<td colspan="{$pmp_cover_per_row-$counter}" style="background-color: inherit;">&nbsp;</td>{/if}</tr>
	</table>

	{if $pages > '1'}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Navigation{/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content-center">
					{if $page > '1'}<a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$page-1}">&lt;&lt;</a>{/if} 
					{t}Page{/t} {$page} {t}of{/t} {$pages}
					{if $page < $pages}<a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$page+1}">&gt;&gt;</a>{/if}<br />
					{section name="Pages" start="1" loop=$pages+1}
					{if $page == $smarty.section.Pages.index}
						<strong>
					{else}
						<a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$smarty.section.Pages.index}">
					{/if}
					{$smarty.section.Pages.index}
					{if $page == $smarty.section.Pages.index}
						</strong>
					{else}
						</a> 
					{/if}
					{/section}
				</td>
			</tr>
		</table>
	{/if}

	{include file="window-end.inc.tpl"}

</div>

</td>

<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="News Archive"}
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
				{t}Number of news{/t}:&nbsp;{$count}
			</td>
		</tr>
	</table>

	<table class="cover">
		<tr>
			<td class="cover">
				{foreach from=$news item=n}
					{$n->date|date_format:$pmp_dateformat}:&nbsp;<strong>{$n->title|stripslashes}</strong><br />
					{$n->text|stripslashes|nl2br}
					<br />
					<hr />
				{/foreach}
			</td>
		</tr>
	</table>

	{if $pages > 1}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Navigation{/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content-center">
					{if $page > 1}<a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$page-1}">&lt;&lt;</a>{/if} 
					{t}Page{/t} {$page} {t}of{/t} {$pages}
					{if $page < $pages}<a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$page+1}">&gt;&gt;</a>{/if}<br />
					{section name="Pages" start=1 loop=$pages+1}
						{if $page == $smarty.section.Pages.index}
							<strong>
						{else}
							<a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$smarty.section.Pages.index}">
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

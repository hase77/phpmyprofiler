<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Picture Gallery"}
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
				{t}Number of pictures{/t}: {$count}
			</td>
		</tr>
	</table>

	<table class="cover">
		<tr>
			<td class="cover">
				{foreach from=$pictures item=picture}
					<strong>{$picture->title}</strong><br />
					<img src="pictures/{$picture->filename}" alt="{$picture->title}" />
					<br />
					<br />
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
					{if $page > 1}<a href="{$smarty.server.SCRIPT_NAME}?content=picturelist&amp;page={$page-1}">&lt;&lt;</a>{/if} 
					{t}Page{/t} {$page} {t}of{/t} {$pages}
					{if $page < $pages}<a href="{$smarty.server.SCRIPT_NAME}?content=picturelist&amp;page={$page+1}">&gt;&gt;</a>{/if}<br />
					{section name="Pages" start=1 loop=$pages+1}
						{if $page == $smarty.section.Pages.index}
							<strong>
						{else}
							<a href="{$smarty.server.SCRIPT_NAME}?content=picturelist&amp;page={$smarty.section.Pages.index}">
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

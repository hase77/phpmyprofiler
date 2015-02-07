<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="People Gallery"}
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
				{$count}&nbsp;{t}Cast and Crew Images{/t}{if $pletter!=''}&nbsp;{t}starting with{/t}&nbsp;{$pletter}{/if}
			</td>
		</tr>
	</table>
   
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Filter{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content-center">
				{foreach from=$alphabet item=l}
					<a href="index.php?content=peoplelist&amp;pletter={$l}">{$l}</a>&nbsp;&nbsp;
				{/foreach}
			</td>
		</tr>
	</table>
                     
	<table class="cover">
		<tr>
			{assign var="hundred" value=100}
			{assign var="counter" value=0}   
			{foreach from=$person item=p name=person}   
				{assign var="counter" value=$counter+1}   
				<td class="cover" style="width: {$hundred/$pmp_people_per_row}%; vertical-align: top;">
					<a href="index.php?content=searchperson&amp;pname={$p.Name|rawurlencode}&amp;nowildcards{if isset($p.Birthyear)}&amp;pbirthyear={$p.Birthyear}{/if}">{$p.Name} {if isset($p.Birthyear)} ({$p.Birthyear}){/if}<br /><br />
					<img src="{$pmp_dir_cast}{$p.File|rawurlencode}" width="100" alt="{$p.File}" title="{$p.File}" /></a>
					<br />&nbsp;
				</td>
				{if $smarty.foreach.person.iteration%$pmp_people_per_row == 0}
					</tr>
					<tr>
					{assign var="counter" value=0}   
				{/if} 
			{/foreach}
			{if $counter!=$pmp_people_per_row}<td colspan="{$pmp_people_per_row-$counter}" style="background-color: inherit;">&nbsp;</td>{/if}</tr>
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
					{if $page > 1}<a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$page-1}&amp;pletter={$pletter}">&lt;&lt;</a>{/if} 
					{t}Page{/t} {$page} {t}of{/t} {$pages}
					{if $page < $pages}<a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$page+1}&amp;pletter={$pletter}">&gt;&gt;</a>{/if}<br />
					{section name="Pages" start=1 loop=$pages+1}
						{if $page == $smarty.section.Pages.index}
							<strong>
						{else}
							<a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$smarty.section.Pages.index}&amp;pletter={$pletter}">
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

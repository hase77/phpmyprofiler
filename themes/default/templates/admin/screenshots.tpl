{include file="admin/header.tpl"}

<div id="mainerror">
    {if isset($Error)}
	<div class="error_box">
	    <div class="error_headline">{t}Sorry, an error has occurred{/t}:</div>
	    <div class="error_msg">{$Error}</div>&nbsp;
	</div>
    {/if}

    {if isset($Success)}
	<div class="success_box">
	    <div class="success_headline">{t}Success{/t}</div>
	    <div class="success_msg">{$Success}</div>&nbsp;
	</div>
    {/if}

    {if isset($Info)}
	<div class="info_box">
	    <div class="info_headline">{t}Information{/t}</div>
	    <div class="info_msg">{$Info}</div>&nbsp;
	</div>
    {/if}
</div>

{if !isset($show) || $show == 0}
	<div id="mainpanel">
		<div align="left" style="text-align: left;">
			<form enctype="multipart/form-data" action="screenshots.php?action=upload&amp;{$session}" method="post" target="_self" style="display: inline" accept-charset="utf-8">
				<table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 800px;">
					<tr>
						<th style="width: 250px;">{t}Upload{/t}</th>
						<th style="width: 300px;">&nbsp;</th>
						<th style="width: 100px;">{if isset($indb)}{t}Function{/t}{else}&nbsp;{/if}</th>
						<th style="width: 150px;">&nbsp;</th>
					</tr>

					<tr>
						<td><input name="file" type="file" /></td>
						<td><input type="submit" value="{t}Upload file{/t}" name="send" /></td>
						<td align="left" style="text-align: left;" colspan="2">
							{if isset($indb)}
								<a class="button" href="screenshots.php?action=buildtags&amp;{$session}"><img src="../themes/{$pmp_theme}/images/tag.png" border="0" alt="{t}Build tag{/t}" />{t}Build tags{/t}</a>
							{else}&nbsp;{/if}
						</td>
					</tr>
				</table>
			</form>
		</div>

		{if !empty($notindb)}
			<h3>{t}Not linked to profiles{/t}</h3>
			<div align="left" style="text-align: left;">
				<table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 800px">
					<tr>
						<th style="width: 165px;">{t}ID{/t}</th>
						<th style="width: 400px;">&nbsp;</th>
						<th style="width: 100px;">{t}Function{/t}</th>
						<th style="width: 150px;">&nbsp;</th>
					</tr>

					{assign var=i value=0}
					{foreach from=$notindb item=id}
						<tr>
							<td class="td{$i%2}">{if isset($link.$id)}<img src="../themes/{$pmp_theme}/images/link.png" border="0" alt="{t}SymLink{/t}" />&nbsp;{/if}{$id}</td>
							<td class="td{$i%2}">&nbsp</td>
							<td class="td{$i%2}">
								<a class="button" style="display: inline;" href="screenshots.php?action=delete&amp;id={$id|escape:"url"}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" border="0" alt="{t}Delete{/t}" />{t}Delete{/t}</a>
							</td>
							<td class="td{$i%2}">
								<a class="button" style="display: inline;" href="screenshots.php?action=show&amp;id={$id|escape:"url"}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/show.png" border="0" alt="{t}Show{/t}" />{t}Show{/t}</a>
							</td>
						</tr>
						{assign var=i value=$i+1}
					{/foreach}
				</table>
			</div>
		{/if}

		{if !empty($indb)}
			<h3>{t}Linked to profiles{/t}</h3>
			<div align="left" style="text-align: left;">
				<table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 800px">
					<tr>
						<th style="width: 165px;">{t}ID{/t}</th>
						<th style="width: 400px;">{t}Title{/t}</th>
						<th style="width: 100px;">{t}Function{/t}</th>
						<th style="width: 150px;" />
					</tr>

					{assign var=i value=0}
					{foreach from=$indb item=id}
						{assign var=tmp value=$id.id}
						<tr>
							<td class="td{$i%2}">{if isset($link.$tmp)}<img src="../themes/{$pmp_theme}/images/link.png" border="0" alt="{t}SymLink{/t}" />&nbsp;{/if}{$id.id}</td>
							<td class="td{$i%2}">{$id.title}</td>
							<td class="td{$i%2}">
								<a class="button" style="display: inline;" href="screenshots.php?action=delete&amp;id={$id.id|escape:"url"}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" border="0" alt="{t}Delete{/t}" />{t}Delete{/t}</a>
							</td>
							<td class="td{$i%2}">
								<a class="button" style="display: inline;" href="screenshots.php?action=show&amp;id={$id.id|escape:"url"}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/show.png" border="0" alt="{t}Show{/t}" />{t}Show{/t}</a>
							</td>
						</tr>
						{assign var=i value=$i+1}
					{/foreach}
				</table>
			</div>
		{/if}
	</div>
{else}
	<div id="mainpanel">
		<form action="screenshots.php?action=relink&amp;id={$id|escape:"url"}&amp;{$session}" method="post" target="_self" style="display: inline" accept-charset="utf-8">
			<table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 830px">
				<tr>
					<th style="width:130px;">{t}Actions{/t}</th>
					<th style="width:600px;">&nbsp;</th>
					<th style="width:100px;">&nbsp;</th>
				</tr>
				<tr>
					<td align="left" style="text-align: left;">{t}Relink to ID{/t}</td>
					<td align="left" style="text-align: left;">
						<input type="text" name="relink" value="" tabindex="1" />
					</td>
					<td align="right" style="text-align: right;">
						<a class="button" style="display: inline;" href="screenshots.php?action=delete&amp;id={$id|escape:"url"}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" border="0" alt="{t}Delete{/t}" />{t}Delete{/t}</a>
					</td>
				</tr>
				<tr>
					{if isset($symlinks)}
						<td align="left" style="text-align: left;">{t}Symlink to ID{/t}</td>
						<td align="left" style="text-align: left;">
							<input type="text" name="symlink" value="" tabindex="2" />
						</td>
					{else}
						<td /><td />
					{/if}
					<td align="right" style="text-align: right;">
						<input type="submit" value="{t}Send{/t}" name="send" tabindex="3" />
					</td>
				</tr>
			</table>
		</form>

		<table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 830px">
			{if isset( $screenshots )}
				<tr><th class="propheader">{t}Screenshots{/t}:</th></tr>
				<tr><td class="propvalue">
					<table class="screen">
						{foreach from=$screenshots item=fname key=sch name=list}
							{if !($sch%8)}<tr>{/if}
							<td class="screen"><a href="../screenshots/{$id}/{$fname}" rel="gallery" class="fancybox"><img src="../screenshots/thumbs/{$id}/{$fname}" alt="{$fname}" /></a></td>
							{if !(($sch+1)%8)}</tr>{elseif $smarty.foreach.list.last}</tr>{/if}
						{/foreach}
					</table>
				</td></tr>
			{/if}
		</table>
	</div>
{/if}
{literal}
	<script type="text/javascript">
		//<![CDATA[
		$(document).ready(function() {
			$('.fancybox').fancybox({'type':'image'});
		});
		//]]>
	</script>
{/literal}

{include file="admin/footer.tpl"}

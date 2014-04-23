{include file="admin/header.tpl"}

<div id="mainerror">
    {include file="admin/mainerror.tpl"}
</div>

<div id="mainpanel">
    {if $pending|@count > 0}
	<table class="tabelle" cellpadding="0" cellspacing="0" border="0">
	    <tr>
		<td colspan="4"><h2>{t}Pending reviews{/t}</h2></td>
		{if $pending|@count > 1}
		    <td colspan="2" align="center" style="text-align: center; vertical-align: bottom">
			<a class="button" href="reviews.php?action=allactivate&amp;{$session}">{t}Activate all review entries{/t}</a>
		    </td>
		{/if}
	    </tr>
	    <tr>
		<th style="width: 180px">{t}From{/t}</th>
		<th style="width: 250px">{t}Movie{/t}</th>
		<th style="width: 120px">{t}Title{/t}</th>
		<th>{t}Text{/t}</th>
		<th style="width: 50px">{t}Review{/t}</th>
		<th style="width: 120px">{t}Function{/t}</th>
	    </tr>
	    {foreach from=$pending item=review key=sch}
		<tr>
		    <td class="td{$sch%2}" style="vertical-align: top">
			{$review->name}<br /><br />
			<img src="../themes/{$pmp_theme}/images/clock.png" border="0" alt="{t}Date{/t}" />&nbsp;{$review->date}
			{if $review->email}<br /><img src="../themes/{$pmp_theme}/images/mail.png" border="0" alt="E-Mail" />&nbsp;<a href="mailto:{$review->email}">{$review->email}</a>{/if}
		    </td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$review->dvd->Title}</td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$review->title}</td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$review->text}</td>
		    <td class="td{$sch%2}" style="vertical-align: top; text-align: center">{$review->vote}</td>
		    <td class="td{$sch%2}" style="vertical-align: top">
			<a class="button" href="reviews.php?action=activate&amp;id={$review->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/action.png" alt="{t}Activate{/t}" border="0" />{t}Activate{/t}</a>
			<a class="button" href="reviews.php?action=delete&amp;id={$review->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" alt="{t}Delete{/t}" border="0" />{t}Delete{/t}</a>
		    </td>
		</tr>
	    {/foreach}
	</table>
    {else}
	<h2>{t}Pending reviews{/t}</h2>
	{t}There are no pending reviews.{/t}
    {/if}

    <br />
    <br />
    <h2>{t}Active reviews{/t}</h2>

    {if $active|@count > 0}
	<table class="tabelle" cellpadding="0" cellspacing="0" border="0">
	    <tr>
		<th style="width: 180px">{t}From{/t}</th>
		<th style="width: 250px">{t}Movie{/t}</th>
		<th style="width: 120px">{t}Title{/t}</th>
		<th>{t}Text{/t}</th>
		<th style="width: 50px">{t}Review{/t}</th>
		<th style="width: 120px">{t}Function{/t}</th>
	    </tr>
	    {foreach from=$active item=review key=sch}
		<tr>
		    <td class="td{$sch%2}" style="vertical-align: top">
			{$review->name}<br /><br />
			<img src="../themes/{$pmp_theme}/images/clock.png" border="0" alt="{t}Date{/t}" />&nbsp;{$review->date}
			{if $review->email}<br /><img src="../themes/{$pmp_theme}/images/mail.png" border="0" alt="E-Mail" />&nbsp;<a href="mailto:{$review->email}">{$review->email}</a>{/if}
		    </td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$review->dvd->Title}</td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$review->title}</td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$review->text}</td>
		    <td class="td{$sch%2}" style="vertical-align: top; text-align: center">{$review->vote}</td>
		    <td class="td{$sch%2}" style="vertical-align: top">
			<a class="button" href="reviews.php?action=delete&amp;id={$review->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" alt="{t}Delete{/t}" border="0" />{t}Delete{/t}</a>
		    </td>
		</tr>
	    {/foreach}
	</table>
    {else}
	{t}There are no active reviews.{/t}
    {/if}
</div>

{include file="admin/footer.tpl"}

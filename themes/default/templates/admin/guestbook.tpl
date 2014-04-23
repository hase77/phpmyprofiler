{include file="admin/header.tpl"}

<div id="mainerror">
    {include file="admin/mainerror.tpl"}
</div>

<div id="mainpanel">

    {if $pending|@count > 0}
	<table class="tabelle" cellpadding="0" cellspacing="0" border="0">
	    <tr>
		<td colspan="3"><h2>{t}Pending guestbook entries{/t}</h2></td>
		{if $pending|@count > 1}
		    <td colspan="2" align="center" style="text-align: center; vertical-align: bottom">
			<a class="button" href="guestbook.php?action=allactivate&amp;{$session}">{t}Activate all guestbook entries{/t}</a>
		    </td>
		{/if}
	    </tr>
	    <tr>
		<th style="width: 200px">{t}From{/t}</th>
		<th>{t}Text{/t}</th>
		<th style="width: 220px">{t}Comment{/t}</th>
		<th style="width: 120px">{t}Function{/t}</th>
	    </tr>
	    {foreach from=$pending item=gbentry key=sch}
		<tr>
		    <td class="td{$sch%2}" style="vertical-align: top">
			{$gbentry->name|stripslashes}<br /><br />
			<img src="../themes/{$pmp_theme}/images/clock.png" border="0" alt="{t}Date{/t}" />&nbsp;{$gbentry->date}
			{if $gbentry->email}<br /><img src="../themes/{$pmp_theme}/images/mail.png" border="0" alt="E-Mail" />&nbsp;<a href="mailto:{$gbentry->email}">{$gbentry->email}</a>{/if}
			{if $gbentry->url}<br /><img src="../themes/{$pmp_theme}/images/homepage.png" border="0" alt="Homepage" />&nbsp;<a href="{$gbentry->url}">{$gbentry->url}</a>{/if}
		    </td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$gbentry->text|stripslashes}</td>
		    <td class="td{$sch%2}">
			<form action="guestbook.php?action=comment&amp;id={$gbentry->id}&amp;{$session}" method="post" style="visibility: inline" accept-charset="utf-8">
			    <textarea name="comment" cols="30" rows="2">{$gbentry->comment|stripslashes}</textarea><br />
			    <input type="submit" value="{t}OK{/t}" />
			</form>
		    </td>
		    <td class="td{$sch%2}" style="vertical-align: top">
			<a class="button" href="guestbook.php?action=activate&amp;id={$gbentry->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/action.png" alt="{t}Activate{/t}" border="0" />{t}Activate{/t}</a>
			<a class="button" href="guestbook.php?action=delete&amp;id={$gbentry->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" alt="{t}Delete{/t}" border="0" />{t}Delete{/t}</a>
		    </td>
		</tr>
	    {/foreach}
	</table>
    {else}
	<h2>{t}Pending guestbook entries{/t}</h2>
	{t}There are no pending guestbook entries.{/t}
    {/if}

    <br />
    <br />
    <h2>{t}Active guestbook entries{/t}</h2>

    {if $active|@count > 0}
	<table class="tabelle" cellpadding="0" cellspacing="0" border="0">
	    <tr>
		<th style="width: 200px">{t}From{/t}</th>
		<th>{t}Text{/t}</th>
		<th style="width: 220px">{t}Comment{/t}</th>
		<th style="width: 120px">{t}Function{/t}</th>
	    </tr>
	    {foreach from=$active item=gbentry key=sch}
		<tr>
		    <td class="td{$sch%2}" style="vertical-align: top">
			{$gbentry->name|stripslashes}<br /><br />
			<img src="../themes/{$pmp_theme}/images/clock.png" border="0" alt="{t}Date{/t}" />&nbsp;{$gbentry->date}
			{if $gbentry->email}<br /><img src="../themes/{$pmp_theme}/images/mail.png" border="0" alt="E-Mail" />&nbsp;<a href="mailto:{$gbentry->email}">{$gbentry->email}</a>{/if}
			{if $gbentry->url}<br /><img src="../themes/{$pmp_theme}/images/homepage.png" border="0" alt="Homepage" />&nbsp;<a href="{$gbentry->url}">{$gbentry->url}</a>{/if}
		    </td>
		    <td class="td{$sch%2}" style="vertical-align: top">{$gbentry->text|stripslashes}</td>
		    <td class="td{$sch%2}">
			<form action="guestbook.php?action=comment&amp;id={$gbentry->id}&amp;{$session}" method="post" style="visibility: inline" accept-charset="utf-8">
			    <textarea name="comment" cols="30" rows="2">{$gbentry->comment|stripslashes}</textarea><br />
			    <input type="submit" value="{t}OK{/t}" />
			</form>
		    </td>
		    <td class="td{$sch%2}" style="vertical-align: top">
			<a class="button" href="guestbook.php?action=delete&amp;id={$gbentry->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" alt="{t}Delete{/t}" border="0" />{t}Delete{/t}</a>
		    </td>
		</tr>
	    {/foreach}
	</table>
    {else}
	{t}There are no active guestbook entries.{/t}
    {/if}
</div>

{include file="admin/footer.tpl"}

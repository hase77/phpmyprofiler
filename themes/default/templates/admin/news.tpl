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

    {if !isset($editadd)}
	{if isset($Info)}
	    <div class="info_box">
		<div class="info_headline">{t}Information{/t}</div>
		<div class="info_msg">{$Info}</div>&nbsp;
	    </div>
	{/if}
    {/if}
</div>

<div id="mainpanel">
    {if !isset($editadd)}
	<div align="center" style="text-align: center"><input type="button" value="{t}Add news{/t}" onclick="location.href='news.php?action=add&amp;{$session}';" /></div>

	{if !isset($Info)}
	    <br />
	    <br />
	    <table class="tabelle" cellpadding="0" cellspacing="0">
		<tr>
		    <th>{t}Title{/t}</th>
		    <th>{t}Date{/t}</th>
		    <th>{t}Text{/t}</th>
		    <th>{t}Function{/t}</th>
		</tr>
		{foreach from=$news item=new key=sch}
		    <tr>
			<td class="td{$sch%2}" valign="top" width="10%">{$new->title|stripslashes}</td>
			<td class="td{$sch%2}" valign="top" style="width: 80px">{$new->date}</td>
			<td class="td{$sch%2}" valign="top">{$new->text|stripslashes}</td>
			<td class="td{$sch%2}" valign="top" style="width: 150px">
			    <a class="button" href="news.php?action=edit&amp;id={$new->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/edit.gif" alt="{t}Edit{/t}" border="0" />{t}Edit{/t}</a>
			    <a class="button" href="news.php?action=delete&amp;id={$new->id}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" alt="{t}Delete{/t}" border="0" />{t}Delete{/t}</a>
			</td>
		    </tr>
		{/foreach}
	    </table>
	{/if}
    {else}
	{if $editadd == 'add'}
	    <form enctype="multipart/form-data" method="post" action="news.php?action=addsave&amp;{$session}" name="formular" accept-charset="utf-8">
		<div align="center">
		    <table>
			<tr>
			    <td colspan="2"><h2>{t}Add new news{/t}</h2></td>
			</tr>
			<tr>
			    <td>{t}Title{/t}</td>
			    <td><input type="text" name="title" size="45" style="width: 450px" {if isset($title) && $title}value="{$title|stripslashes}"{/if} /></td>
			</tr>
			<tr>
			    <td valign="top">{t}Text{/t}</td>
			    <td><textarea name="text" cols="35" rows="15" style="width: 450px">{if isset($text) && $text}{$text|stripslashes}{/if}</textarea></td>
			</tr>
			<tr>
			    <td colspan="2" align="center"><input type="submit" value="{t}Add news{/t}" name="send" /></td>
			</tr>
		    </table>
		</div>
	    </form>
	{/if}

	{if $editadd == 'edit'}
	    {foreach from=$edit item=change}
		<form enctype="multipart/form-data" method="post" action="news.php?action=editsave&amp;id={$change->id}&amp;{$session}" accept-charset="utf-8">
		    <div align="center">
			<table>
			    <tr>
				<td colspan="2"><h2>{t}Edit news{/t}</h2></td>
			    </tr>
			    <tr>
				<td>{t}Title{/t}</td>
				<td><input type="text" name="title" size="45" style="width: 450px" value="{$change->title|stripslashes}" /></td>
			    </tr>
			    <tr>
				<td valign="top">{t}Text{/t}</td>
				<td><textarea name="text" cols="35" rows="15" style="width: 450px">{$change->text|stripslashes}</textarea></td>
			    </tr>
			    <tr>
				<td colspan="2" align="center"><input type="submit" value="{t}Apply Changes{/t}" name="send" /></td>
			    </tr>
			</table>
		    </div>
		</form>
	    {/foreach}
	{/if}
    {/if}
</div>

{include file="admin/footer.tpl"}

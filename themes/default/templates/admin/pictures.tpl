{include file="admin/header.tpl"}

<div id="mainerror">
    {include file="admin/mainerror.tpl"}
</div>

<div id="mainpanel">

    <div align="center" style="text-align: center">
	<div class="box" style="text-align:left; margin-left:auto; margin-right:auto; width: 460px; margin-bottom: 15px">
	    <form enctype="multipart/form-data" method="post" action="pictures.php?action=add&amp;{$session}" style="visibility: inline" accept-charset="utf-8">
		<table cellpadding="0" cellspacing="0" border="0">
		    <tr>
			<td><img src="../themes/{$pmp_theme}/images/menu/upload.png" alt="{t}Upload pictures{/t}" border="0" /></td>
			<td colspan="2" valign="middle" style="vertical-align: baseline"><h2>{t}Upload pictures{/t}</h2></td>
		    </tr>
		    <tr>
			<td>&nbsp;</td>
			<td align="left">{t}Filename{/t}</td>
			<td align="left"><input type="text" name="filename" size="32" style="width:250px;" /></td>
		    </tr>
		    <tr>
			<td>&nbsp;</td>
			<td align="left">{t}Comment{/t}</td>
			<td align="left"><input type="text" name="title" size="32" style="width:250px;" /></td>
		    </tr>
		    <tr>
			<td>&nbsp;</td>
			<td align="left">{t}File{/t}</td>
			<td align="left"><input name="picture" type="file" /></td>
		    </tr>
		    <tr>
			<td colspan="2">&nbsp;</td>
			<td align="left" style="text-align: left; padding-top: 20px"><input type="submit" value="{t}Upload picture{/t}" name="send" /></td>
		    </tr>
		</table>
	    </form>
	</div>
    </div>

    {if $pics}
	<table class="tabelle" cellspacing="0" cellpadding="3" border="0">
	    <tr>
		<th style="width: 20%; text-align: left">{t}Filename{/t}</th>
		<th>{t}Comment{/t}</th>
		<th style="width: 60px; text-align: left">{t}Size{/t}</th>
		<th style="width: 70px; text-align: left">{t}Dimension{/t}</th>
		<th style="width: 150px">{t}Function{/t}</th>
	    </tr>
	    {foreach from=$pics item=pic key=sch}
		<tr>
		    <td class="td{$sch%2}">
			{if $pic->fileexist}
			    <a href="javascript:void(0);" onmouseover="return overlib('&lt;img width=300 src=../pictures/{$pic->image} /&gt;', CAPTION, '{$pic->filename}{if $pic->title} - {$pic->title}{/if}', MOUSEOFF);" onmouseout="return nd();">{$pic->filename}</a>
			{else}
			    <span style="text-decoration:line-through;">{$pic->filename}</span>
			{/if}
		    </td>
		    <td class="td{$sch%2}">{$pic->title}</td>
		    <td class="td{$sch%2}" align="center" style="text-align:center">{if $pic->fileexist}{$pic->size/1024|round|number_format:0:',':'.'} kB{/if}</td>
		    <td class="td{$sch%2}" align="center" style="text-align:center">{if $pic->fileexist}{$pic->x}x{$pic->y}{/if}</td>
		    <td class="td{$sch%2}">
			<a href="pictures.php?action=delete&amp;id={$pic->id}&amp;{$session}" class="button"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" alt="{t}Delete{/t}" border="0" />{t}Delete{/t}</a>
		    </td>
		</tr>
	    {/foreach}
	</table>
    {/if}
</div>

{include file="admin/footer.tpl"}

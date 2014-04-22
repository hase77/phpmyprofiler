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

<div id="mainpanel">

    {* Files to Parse *}
    {if isset($Files)}
	<h3>{t}Parse{/t}</h3>
	<table cellpadding="0" cellspacing="0" border="0" class="tabelle">
	    <tr>
		<th style="vertical-align: top; width: 100px;">{t}Term{/t}</th>
		<th>{t}Description{/t}</th>
	    </tr>
	    <tr>
		<td style="vertical-align: top; width: 100px;"><strong>{t}Parse{/t}</strong></td>
		<td>{t}Parse file into awards table.{/t}</td>
	    </tr>
	    <tr>
		<td style="vertical-align: top; width: 100px;"><strong>{t}Delete{/t}</strong></td>
		<td>{t}Use this to delete uneeded files.{/t}</td>
	    </tr>
	</table>

	<br />
	<br />

	<div align="left" style="text-align: left;">
	    <table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 550px;">
		<tr>
		    <th style="width: 100px;">{t}File{/t}</th>
		    <th style="width: 100px;">{t}Size{/t}</th>
		    <th>{t}Function{/t}</th>
		</tr>

		{foreach from=$Files item=file}
		    <tr>
			<td align="left" style="text-align: left;">{$file.name}</td>
			<td align="center" style="text-align: center;">{$file.size}</td>
			<td align="left" style="text-align: left;">
			    <a class="button" href="updateawards.php?action=parse&amp;file={$file.name|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/parse.gif" border="0" alt="{t}Parse{/t}" />{t}Parse{/t}</a>
			    <a class="button" href="updateawards.php?action=delete&amp;file={$file.name|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" border="0" alt="{t}Delete{/t}" />{t}Delete{/t}</a>
			</td>
		    </tr>
		{/foreach}
	    </table>
	</div>
    {/if}

    {if $Types}
	<h3>{t}Awards{/t}</h3>
	<div align="left" style="text-align: left;">
	    <table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 550px">
		<tr>
		    <th style="width: 300px;">{t}Award{/t}</th>
		    <th style="width: 100px;">{t}Function{/t}</th>
			<th />
		</tr>

		{foreach from=$Types item=type}
		    <tr>
			<td align="left" style="text-align: left;">{$type}</td>
			<td align="left" style="text-align: left;">
			    <a class="button" style="display: inline;" href="updateawards.php?action=deleteaward&amp;award={$type|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" border="0" alt="{t}Delete{/t}" />{t}Delete{/t}</a>
			</td>
			<td align="left" style="text-align: left;">
			    <a class="button" style="display: inline;" href="updateawards.php?action=buildtags&amp;award={$type|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/tag.png" border="0" alt="{t}Build tags{/t}" />{t}Build tags{/t}</a>
			</td>
		    </tr>
		{/foreach}
	    </table>
	</div>
    {/if}
    <br />
    <br />

    {* Upload *}
    <h3>{t}Upload compressed (zip or bz2) or uncompressed award file{/t}:</h3>
    <form enctype="multipart/form-data" method="post" action="uploadaward.php?{$session}" style="visibility: inline" accept-charset="utf-8">
	<table cellpadding="0" cellspacing="0" border="0">
	    <tr>
		<td><input name="file" type="file" /></td>
		<td><input type="submit" value="{t}Upload file{/t}" name="send" /></td>
	    </tr>
	</table>
    </form>

</div>

{include file="admin/footer.tpl"}

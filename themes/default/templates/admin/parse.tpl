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

    {if isset($Warning)}
	<div class="warn_box">
	    <div class="warn_headline">{t}Warning{/t}</div>
	    <div class="warn_msg">{$Info}</div>&nbsp;
	</div>
    {/if}

    {if isset($count)}
	<div class="success_box">
	    <div class="success_headline">{t}Parsed Finish{/t}</div>
	    <div class="success_msg">
		{if isset($split)}{t split=$split}The Collection was splitted in %split pieces.{/t}<br /><br />{/if}
		{t dvd=$count sec=$time|string_format:"%04.2f"} Parsed %dvd DVDs in %sec seconds.{/t}
		{if $deleted != '0'}<br /><br />{t del=$deleted}Deleted %del unneeded thumbnails.{/t}{/if}
		<br />
		{if isset($profiles.new)}{$profiles.new} {t}new Profiles{/t}<br />{/if}
		{if isset($profiles.unaltered)}{$profiles.unaltered} {t}unaltered Profiles{/t}<br />{/if}
		{if isset($profiles.altered)}{$profiles.altered} {t}altered Profiles{/t}<br />{/if}
		{if isset($profiles.deleted) && $profiles.deleted != 0}{$profiles.deleted} {t}deleted Profiles{/t}<br />{/if}
	    </div>&nbsp;
	</div>
    {/if}
</div>

<div id="mainpanel">
    {* Files to Parse *}
    {if isset($Files)}
	<h3>{t}Parse{/t}</h3>

	<table cellpadding="0" cellspacing="0" border="0" class="tabelle">
	    <tr>
		<th style="vertical-align: top; width: 100px">{t}Term{/t}</th>
		<th>{t}Description{/t}</th>
	    </tr>
	    <tr>
		<td style="vertical-align: top; width: 100px"><strong>{t}Parse{/t}</strong></td>
		<td>{t split=$pmp_splitxmlafter}Empty the database and parse the XML-file into the database. For parsing the XML-file will be split in pieces. If you have a large amount of DVDs or your web server is a little bit slow, the parsing may fail (timeout-error or blank page). When the parsing fails you can decrease the number of DVDs for every split file on the preferences page. With the current setting phpMyprofiler will split after every %split DVDs.{/t}</td>
	    </tr>
	    <tr>
		<td style="vertical-align: top; width: 100px"><strong>{t}Delete{/t}</strong></td>
		<td>{t}Use this to delete uneeded files.{/t}</td>
	    </tr>
	</table>

	<br />
	<table cellpadding="0" cellspacing="0" border="0" class="tabelle">
		<tr><th style="vertical-align: top; width: 100px">
		{if $pmp_parser_mode == 0}
			{t}Parser Mode is{/t} <strong>{t}Build from scratch{/t}.</strong>
		{elseif $pmp_parser_mode == 1}
			{t}Parser Mode is{/t} <strong>{t}Update with delete{/t}.</strong>
		{else}
			{t}Parser Mode is{/t} <strong>{t}Update without delete{/t}.</strong>
		{/if}
		</th></tr>
		<tr><td style="vertical-align: top; width: 100px">
		{if $pmp_parser_mode == 0}
			{t}This mode will delete all profiles before importing all data from xml-file.{/t}<br />
			{t}You should use this mode if you don't have any data in your database or if your xml-file contains a lot of updated or new profiles.{/t}
		{elseif $pmp_parser_mode == 1}
			{t}This mode will import only update and new profiles, while profiles missing in xml-file will be deleted.{/t}<br />
			{t}You should use this mode if you have data in your database and you want to get rid of some profiles.{/t}
		{else}
			{t}This mode will import only update and new profiles, while profiles missing in xml-file will not be deleted.{/t}<br />
			{t}You should use this mode if you have data in your database and you want to keep all profiles.{/t}
		{/if}
		</td></tr>
	</table>
	<br />

	<div align="left" style="text-align: left">
	    <table cellpadding="0" cellspacing="0" border="0" class="tabelle" style="width: 550px">
		<tr>
		    <th style="width: 200px">{t}File{/t}</th>
		    <th style="width: 100px">{t}Size{/t}</th>
		    <th>{t}Function{/t}</th>
		</tr>

		{foreach from=$Files item=file}
		    <tr>
			<td align="left" style="text-align: left;">{$file.name}</td>
			<td align="center" style="text-align: left;">{$file.size}</td>
			<td align="left" style="text-align: left;">
			    {if $pmp_parser_mode == 0}
					<a class="button" href="parse.php?action=split&amp;file={$file.name|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/parse.gif" border="0" alt="{t}Parse{/t}" />{t}Parse{/t}</a>
				{else}
					<a class="button" href="parse.php?action=parse&amp;file={$file.name|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/parse.gif" border="0" alt="{t}Parse{/t}" />{t}Parse{/t}</a>
				{/if}
				<a class="button" href="parse.php?action=delete&amp;file={$file.name|rawurlencode}&amp;{$session}"><img src="../themes/{$pmp_theme}/images/recyclebin.gif" border="0" alt="{t}Delete{/t}" />{t}Delete{/t}</a>
			</td>
		    </tr>
		{/foreach}
	    </table>
	</div>

	<br />
	<br />
    {/if}

    {* Upload *}
    <h3>{t}Upload compressed (zip or bz2) or uncompressed Collection XML file{/t}:</h3>
    <form enctype="multipart/form-data" method="post" action="uploadxml.php?{$session}" style="visibility: inline" accept-charset="utf-8">
	<table cellpadding="0" cellspacing="0" border="0">
	    <tr>
		<td><input name="file" type="file" /></td>
		<td><input type="submit" value="{t}Upload file{/t}" name="send" /></td>
	    </tr>
	</table>
    </form>
</div>

{include file="admin/footer.tpl"}

{include file="admin/header.tpl"}

<div id="mainpanel">

    {t}Choose language to check:{/t}
    {foreach from=$getLangs item=Lang}
	<a href="checklang.php?LG={$Lang}&amp;{$session}">{$Lang|flag}</a>
    {/foreach}
    <br />

    <ul>
	<li><a href="#detailed">{t}Detailed overview{/t}</a></li>
	<li><a href="#unused">{t}Unused Translations{/t}</a></li>
    </ul>
    <br />

    {* Detailed overview *}
    <a name="detailed"></a><h2>{t}Detailed overview{/t}</h2>
    {foreach from=$templates item=templ key=templname}
	{if (isset($templ.missing) && $templ.missing|count) || (isset($templ.used) && $templ.used|count)}
	    <div class="box">
		<h3>{$templ.module}</h3>
		{if isset($templ.files) && $templ.files|count}
		    <ul>
			{foreach from=$templ.files item=str key=string}<li>{$str}</li>{/foreach}
		    </ul>
		{/if}
		<br />
		<table cellpadding="0" cellspacing="0" border="0" class="tabelle">
		    {if isset($templ.missing) && $templ.missing|count}
			<tr>
			    <th colspan="2">{t}Missing Translations{/t}</th>
			</tr>
			{foreach from=$templ.missing item=str key=string}
			    {foreach from=$str item=str2 key=str1}
				<tr bgcolor="#{if $string%2 == 0}f4f4f4{else}dddddd{/if}" onmouseover="this.bgColor='#c3c3c3'" onmouseout="this.bgColor='#{if $string%2 == 0}f4f4f4{else}dddddd{/if}'">
				    <td class="td{$string%2}_over" colspan="2" style="width:50%; vertical-align: top">{$str1}</td>
				</tr>
			    {/foreach}
			{/foreach}
		    {/if}

		    {if (isset($templ.missing) && $templ.missing|count) || (isset($templ.used) && $templ.used|count)}
			<tr>
			    <td colspan="2">&nbsp;</td>
			</tr>
		    {/if}

		    {if isset($templ.used) && $templ.used|count}
			<tr>
			    <th colspan="2">{t}Used Translations{/t}</th>
			</tr>
			{foreach from=$templ.used item=str key=string}
			    {foreach from=$str item=str2 key=str1}
				<tr bgcolor="#{if $string%2 == 0}f4f4f4{else}dddddd{/if}" onmouseover="this.bgColor='#c3c3c3'" onmouseout="this.bgColor='#{if $string%2 == 0}f4f4f4{else}dddddd{/if}'">
				    <td class="td{$string%2}_over" style="width:50%; vertical-align: top">{$str1}</td>
				    <td class="td{$string%2}_over" style="width:50%; vertical-align: top">{$str2}</td>
				</tr>
			    {/foreach}
			{/foreach}
		    {/if}
		</table>
	    </div>
	    <br />
	{/if}
    {/foreach}

    {* Unused Translations *}
	{*
    <a name="unused"></a><h2>{t}Unused Translations{/t}</h2>
    <div class="box">
	<table cellpadding="0" cellspacing="0" border="0" class="tabelle">
	    {foreach from=$unused item=str key=string}
		{foreach from=$str item=str2 key=str1}
		    <tr bgcolor="#{if $string%2 == 0}f4f4f4{else}dddddd{/if}" onmouseover="this.bgColor='#c3c3c3'" onmouseout="this.bgColor='#{if $string%2 == 0}f4f4f4{else}dddddd{/if}'">
			<td class="td{$string%2}_over" style="width:50%">{$str1}</td>
			<td class="td{$string%2}_over" style="width:50%">{$str2}</td>
		    </tr>
		{/foreach}
	    {/foreach}
	</table>
    </div>
	*}
</div>

{include file="admin/footer.tpl"}

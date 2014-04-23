{include file="admin/header.tpl"}

<div id="mainpanel" align="center">
    <div class="box" style="text-align: left; width: 400px">
	<p>{t}Please select the columns that will appear in the report:{/t}</p>
	<form action="report.php?{$session}" method="post" target="_self" accept-charset="utf-8">
	    <table border="0" cellpadding="0" cellspacing="2" width="100%">
		{foreach item=Option from=$columns key=sch}
		    <tr>
			<td>
			    {t}{$Option->Name}{/t}
			</td>
			<td style="text-align: right">
			    <select name="{$Option->Var}">
				{foreach item=Value from=$Option->Optionlist key=value}
				    <option value="{$value}" {if $value==$Option->Value}selected="selected"{/if}>{t}{$Value}{/t}</option>
				{/foreach}
			    </select>
			</td>
		    </tr>
		{/foreach}
		<tr>
		    <td>
			{t}Sort Order{/t}
		    </td>
		    <td style="text-align: right">
			<select name="sortby">
			    {foreach item=Value from=$Option->Optionlist key=value}
				<option value="{$value}" {if $value==$pmp_menue_sortby}selected="selected"{/if}>{t}{$Value}{/t}</option>
			    {/foreach}
			</select>
		    </td>
		</tr>
		<tr>
		    <td>
			{t}Sort Order Direction{/t}
		    </td>
		    <td style="text-align: right">
			<select name="sortdir">
			    <option value="asc" {if $pmp_menue_sortdir==asc}selected="selected"{/if}>{t}Ascending{/t}</option>
			    <option value="desc" {if $pmp_menue_sortdir==desc}selected="selected"{/if}>{t}Descending{/t}</option>
			</select>
		    </td>
		</tr>
		<tr>
		    <td>
			{t}Owned, Ordered, WishList or all DVDs{/t}
		    </td>
		    <td style="text-align: right">
			<select name="where">
			    <option value="Owned" selected="selected">{t}Owned{/t}</option>
			    <option value="Ordered">{t}Ordered{/t}</option>
			    <option value="WishList">{t}WishList{/t}</option>
			    <option value="All">{t}All{/t}</option>
			</select>
		    </td>
		</tr>
	    </table>
	    <br />
	    <input type="radio" name="report" value="pdf" style="border: 0px" checked="checked" /> {t}Generate PDF-Report{/t}<br />
	    <input type="radio" name="report" value="html" style="border: 0px" /> {t}Generate HTML-Report{/t}<br />
	    <br />
	    <input type="checkbox" name="usequery" value="true" {if isset($smarty.get.usequery) && $smarty.get.usequery == 'true'}checked="checked"{/if} /> {t}Use filters from main list{/t}<br />
	    <br />
	    <div style="text-align: center"><input type="submit" value="{t}Generate Report{/t}" /></div>
	</form>
    </div>
</div>

{include file="admin/footer.tpl"}

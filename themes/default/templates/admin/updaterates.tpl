{include file="admin/header.tpl"}

<div id="mainerror">
    {include file="admin/mainerror.tpl"}
</div>

<div id="mainpanel">
    <h2>{t}Actual Rates (Base: Euro){/t}</h2>

    {if $rates|@count > 0}
	<table cellpadding="0" cellspacing="0" border="0" class="tabelle">
	    <tr>
		<th>{t}Currency{/t}</th>
		<th>{t}Rate{/t}</th>
	    </tr>
	    {foreach from=$rates item=rate key=sch}
		<tr bgcolor="#{if $sch%2 == 0}f4f4f4{else}dddddd{/if}" onmouseover="this.bgColor='#c3c3c3'" onmouseout="this.bgColor='#{if $sch%2 == 0}f4f4f4{else}dddddd{/if}'">
		    <td class="td{$sch%2}_over">{$rate->id}</td>
		    <td class="td{$sch%2}_over">{$rate->rate}</td>
		</tr>
	    {/foreach}
	</table>
	<br />
	{t}Rates last updated:{/t} {$rate->date|date_format:$pmp_dateformat}
    {else}
	{t}Found no rates in database. Please update with the button below.{/t}
    {/if}
    <br />
    <br />
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="text-align: center" class="box">
	<tr>
	    <td>
		<table cellpadding="0" cellspacing="0" border="0" style="width: 450px">
		    <tr>
			<td>
			    <a class="button" href="updaterates.php?action=update&amp;{$session}">{t}Click here to update your rates.{/t}</a>
			    <a class="button" href="http://www.ecb.int/stats/exchange/eurofxref/html/index.en.html">{t}We're using rates from the European Central Bank (ECB).{/t}</a>
			</td>
		    </tr>
		</table>
	    </td>
	</tr>
    </table>
</div>

{include file="admin/footer.tpl"}

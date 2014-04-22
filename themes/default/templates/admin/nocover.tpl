{include file="admin/header.tpl"}

<div id="mainpanel">
    {t}Click on{/t} {0|getpic:boolean}{t}-symbol to load missing covers from the Invelos server.{/t}<br /><br />

    <table cellpadding="0" cellspacing="0" border="0" class="tabelle">
	<tr>
	    <th>{t}DVD{/t}</th>
	    <th style="text-align: center">{t}Front{/t}</th>
	    <th style="text-align: center">{t}Back{/t}</th>
	</tr>
	{foreach from=$dvds item=dvd key=sch}
	    <tr bgcolor="#{if $sch%2 == 0}f4f4f4{else}dddddd{/if}" onmouseover="this.bgColor='#c3c3c3'" onmouseout="this.bgColor='#{if $sch%2 == 0}f4f4f4{else}dddddd{/if}'">
		<td class="td{$sch%2}_over">{$dvd->Title}</td>
		<td class="td{$sch%2}_over" style="text-align: center">
		    {if $dvd->frontpic}
			<a href="javascript:void(0);" onmouseover="return overlib('&lt;div style=&quot;text-align: center&quot;&gt; &lt;img src=../thumbnail.php?id={$dvd->id}&amp;type=front&amp;width=100&amp;local=true /&gt; &lt;div&gt;', CAPTION, '{$dvd->Title}', MOUSEOFF);" onmouseout="return nd();">{$dvd->frontpic|getpic:boolean}</a>
		    {else}
			<a onclick="javascript:window.open('getcover.php?cover={$dvd->id}f&amp;nohead=true&amp;{$session}', 'getcover','resizable=1,location=0,directories=0,status=0,menubar=0,scrollbars=0,toolbar=0,width=450,height=400');return false;" href="getcover.php?cover={$dvd->id}f&amp;{$session}">{$dvd->frontpic|getpic:boolean}</a>
		    {/if}
		</td>
		<td class="td{$sch%2}_over" style="text-align: center">
		  {if $dvd->backpic}
		      <a href="javascript:void(0);" onmouseover="return overlib('&lt;div style=&quot;text-align: center&quot;&gt; &lt;img src=../thumbnail.php?id={$dvd->id}&amp;type=back&amp;width=100&amp;local=true /&gt; &lt;div&gt;', CAPTION, '{$dvd->Title}', MOUSEOFF);" onmouseout="return nd();">{$dvd->backpic|getpic:boolean}</a>
		  {else}
		      <a onclick="javascript:window.open('getcover.php?cover={$dvd->id}b&amp;nohead=true&amp;{$session}', 'getcover','resizable=1,location=0,directories=0,status=0,menubar=0,scrollbars=0,toolbar=0,width=450,height=400');return false;" href="getcover.php?cover={$dvd->id}b&amp;{$session}">{$dvd->backpic|getpic:boolean}</a>
		  {/if}
		</td>
	    </tr>
	{/foreach}
    </table>
</div>

{include file="admin/footer.tpl"}

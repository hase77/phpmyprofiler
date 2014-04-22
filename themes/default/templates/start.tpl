<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">
<div>

	{assign var="windowtitle" value="Summary"}
	{include file="window-start.inc.tpl"}

	{if $news|@count > 0}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}News{/t} <a href="index.php?content=news">{t}News Archive{/t}</a>&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
					<table class="profil">
						{foreach from=$news item=n}
							<tr><td class="header" align="left"><strong>{$n->date|date_format:$pmp_dateformat}&nbsp;:&nbsp;{$n->title|stripslashes}</strong></td></tr>
							<tr><td class="bright" align="left" valign="top">{$n->text|stripslashes|nl2br}</td></tr>
						{/foreach}
					</table>
				</td>
			</tr>
		</table>
	{/if}

	{if $new|@count > 0}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t c=$new|@count}The %c latest DVDs{/t}&nbsp;&nbsp;</div>
				</td>
			<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
					<table class="profil">
						<tr class="listheader">
							<th class="listheader" style="width: 72px">{t}Cover{/t}</th>
							<th class="listheaderleft">{t}Movie Information{/t}</th>
							<th class="listheaderleft" style="width: 210px;">{t}Purchase Information{/t}</th>
						</tr>
						{foreach from=$new item=Film key=sch}
							<tr>
								<td class="td{$sch%2}c title_select_sub" id="ie{$Film->id}"><a href="index.php?content=filmprofile&amp;id={$Film->id}"><img alt="" src="thumbnail.php?id={$Film->id}&amp;type=front&amp;width=50" width="50" /></a></td>

								<td class="td{$sch%2} title_select_sub" id="ia{$Film->id}"><a href="index.php?content=filmprofile&amp;id={$Film->id}"><strong>{$Film->Title|trunc}</strong></a><br />{if $Film->Edition}<i>{$Film->Edition}</i>{/if}<br /><br />{t}Year of Production{/t}: {$Film->Year}<br />{t}Running Time{/t}: {$Film->Length} {t}Minutes{/t}</td>

								<td class="td{$sch%2}">{t}Bought{/t} {if $Film->PurchPlace != ''} {t}at{/t}<b> {$Film->PurchPlace}</b><br />{/if}{if $pmp_statistic_showprice == 1}{if $Film->ConvPrice != '0.00'}{t}for{/t} {$Film->ConvPrice} {$Film->ConvCurrency} {if $Film->PurchCurrencyID != $Film->ConvCurrency}({$Film->PurchPrice} {$Film->PurchCurrencyID}){/if}{/if} {/if}{t}on{/t} {$Film->PurchDate}<br /><br />({t}Release Date{/t}: {$Film->Released})</td>
							</tr>
						{/foreach}
					</table>
				</td>
			</tr>
		</table>
	{/if}

	{if $ordered|@count > 0}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t c=$ordered|@count}The %c last ordered DVDs{/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
					<table class="profil">
						<tr class="listheader">
							<th class="listheader" style="width: 72px;">{t}Cover{/t}</th>
							<th class="listheaderleft">{t}Movie Information{/t}</th>
							<th class="listheaderleft" style="width: 210px;">{t}Purchase Information{/t}</th>
						</tr>
						{foreach from=$ordered item=Film key=sch}
							<tr>
								<td class="td{$sch%2}c title_select_sub" id="ie{$Film->id}" style="text-align:center"><a href="index.php?content=filmprofile&amp;id={$Film->id}"><img alt="" src="thumbnail.php?id={$Film->id}&amp;type=front&amp;width=50" width="50" /></a></td>

								<td class="td{$sch%2} title_select_sub" id="ia{$Film->id}"><a href="index.php?content=filmprofile&amp;id={$Film->id}"><strong>{$Film->Title|trunc}</strong></a><br />{if $Film->Edition}<i>{$Film->Edition}</i>{/if}<br /><br />{t}Year of Production{/t}: {$Film->Year}<br />{t}Running Time{/t}: {$Film->Length} {t}Minutes{/t}</td>

								<td class="td{$sch%2}">{t}Ordered {/t} {if $Film->PurchPlace != ''}{t}at{/t}<b> {$Film->PurchPlace}</b><br />{/if}{if $pmp_statistic_showprice == 1}{if $Film->ConvPrice != '0.00'}{t}for{/t} {$Film->ConvPrice} {$Film->ConvCurrency} {if $Film->PurchCurrencyID != $Film->ConvCurrency}({$Film->PurchPrice} {$Film->PurchCurrencyID}){/if}{/if} {/if}{t}the{/t} {$Film->PurchDate}<br /><br />({t}Release Date{/t}: {$Film->Released})</td>
							</tr>
						{/foreach}
					</table>
				</td>
			</tr>
		</table>
	{/if}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Information{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<strong>{$counter.all}</strong> {t}Visitors{/t}&nbsp;({$counter.today}&nbsp;{t}today{/t})&nbsp;-&nbsp;<strong>{$count}</strong> {t}DVDs{/t}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td colspan="2" class="frame-content">
				{t}Built by{/t}&nbsp;<a href="http://www.phpmyprofiler.de">phpMyProfiler&nbsp;{$pmp_version}</a>&nbsp;-&nbsp;{t}published under General Public License (GPL){/t}{if isset($last_update)}&nbsp;-&nbsp;{t}Last update{/t}&nbsp;{$last_update}{/if}
			</td>
		</tr>
	</table>

	{include file="window-end.inc.tpl"}

</div>
</td>


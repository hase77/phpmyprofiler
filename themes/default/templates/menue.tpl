<td valign="top" style="width: 34%; padding-left: 4px; padding-right: 2px;" id="left-frame">

{if isset($Error) && $Error != ''}
	<div class="error_box">
		<div class="error_headline">{t}Sorry, an error has occurred{/t}:</div>
		<div class="error_msg">{$Error}</div>
	</div>
{/if}

<div style="height: 100%; overflow: auto;">
   
	{assign var="windowtitle" value="DVD Collection"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Active Filters{/t} <span style="font-weight: normal">{t}(click filter to remove){/t}</span>&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<a href="index.php?content=search">{t}Add{/t}</a>&nbsp;|&nbsp;<a href="index.php?reset=1">{t}Remove all{/t}</a><br /><br />
				{foreach from=$locations item=loc name=loc}
					{getfilter filter="locality" value=$loc caption=$loc|flag show_inactive='False' class='flagfilter'} 
				{/foreach}
				{foreach from=$origins item=origin name=origin}
					{assign var="country" value="country[dot]$origin"}
					{getfilter filter="pmp_countries_of_origin[dot]id" value=$country caption=$origin|flag show_inactive='False' class='flagfilter'} 
				{/foreach}
				{if $extFilter|count > 0}
					{foreach from=$extFilter item=extFlt name=extFilter}
						{getfilter filter=$extFlt.field value=$extFlt.value caption=$extFlt.caption show_inactive='False'}
					{/foreach}
				{/if}
			</td>
		</tr>
	</table>

	<div class="tabs">
		{if isset($pmp_collections)}
			{foreach from=$pmp_collections item=collection}
				{getfilter filter=collectiontype value=$collection caption=$collection class='liste' switch='True' show_inactive="True"}
			{/foreach}
		{/if}
	</div>
	
	<table class="list">
		<tr class="listheader">
			{strip}
			{if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<th class="listheader">#</th>{/if}
			{if isset($pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<th class="listheaderleft">{getheader column=$pmp_menue_column_1.Sort caption=$pmp_menue_column_1.Header}</th>{/if}
			{if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<th class="listheader">{getheader column=$pmp_menue_column_2.Sort caption=$pmp_menue_column_2.Header}</th>{/if}
			{if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<th class="listheader">{getheader column=$pmp_menue_column_3.Sort caption=$pmp_menue_column_3.Header}</th>{/if}
			{if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<th class="listheader">{getheader column=$pmp_menue_column_4.Sort caption=$pmp_menue_column_4.Header}</th>{/if}
			{if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<th class="listheader">{getheader column=$pmp_menue_column_5.Sort caption=$pmp_menue_column_5.Header}</th>{/if}
			{if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<th class="listheader">{getheader column=$pmp_menue_column_6.Sort caption=$pmp_menue_column_6.Header}</th>{/if}
			{/strip}
		</tr>
		
		{foreach from=$dvds item=dvd key=sch}
			<tr valign="top">
				{strip}
				{if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<td class="td{$sch%2}" style="text-align:right">{$page*$pmp_dvd_menue+$sch+1-$pmp_dvd_menue})</td>{/if}
				{if isset($pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<td class="td{$sch%2}" style="text-align:left">{if isset($dvd->isBoxset) && $dvd->isBoxset == true && $sort == 1}<img onclick="javascript:expandBoxset('row_{$dvd->id}','img_{$dvd->id}', '{$pmp_theme}');" id="img_{$dvd->id}" style="padding-right:5px; vertical-align: middle" src="themes/{$pmp_theme}/images/plus.gif" alt="" />{/if}<a class="title_select" id="id{$dvd->id}" href="index.php?content=filmprofile&amp;id={$dvd->id}">{$dvd->get($pmp_menue_column_1.Output)}</a></td>{/if}
				{if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<td class="td{$sch%2}c">{$dvd->get($pmp_menue_column_2.Output)}</td>{/if}
				{if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<td class="td{$sch%2}c">{$dvd->get($pmp_menue_column_3.Output)}</td>{/if}
				{if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<td class="td{$sch%2}c">{$dvd->get($pmp_menue_column_4.Output)}</td>{/if}
				{if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<td class="td{$sch%2}c">{$dvd->get($pmp_menue_column_5.Output)}</td>{/if}
				{if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<td class="td{$sch%2}c">{$dvd->get($pmp_menue_column_6.Output)}</td>{/if}
				{/strip}
			</tr>
      
			{if isset($dvd->isBoxset) && $dvd->isBoxset == true && $sort == 1}
				<tr id="row_{$dvd->id}" style="display:none;">
					<td class="td{$sch%2}" colspan="{$menue_columns}">
						<table style="width:100%; border-style:none; border-spacing:0px; border-width:0px;">

							{foreach from=$dvd->Boxset_childs item=child}
								<tr>
									{strip}
										{if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<td class="td{$sch%2}"></td>{/if}
										{if isset( $pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<td class="td{$sch%2}" style="padding-left:18px;">{if isset($child->isBoxset) && $child->isBoxset == true && $sort == 1}<img onclick="javascript:expandBoxset('row_{$child->id}','img_{$child->id}', '{$pmp_theme}');" id="img_{$child->id}" style="padding-right:5px; vertical-align: middle" src="themes/{$pmp_theme}/images/plus.gif" alt="" />{/if}<a class="title_select" id="id{$child->id}" href="index.php?content=filmprofile&amp;id={$child->id}">{$child->get($pmp_menue_column_1.Output)}</a></td>{/if}
										{if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<td class="td{$sch%2}c">{$child->get($pmp_menue_column_2.Output)}</td>{/if}
										{if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<td class="td{$sch%2}c">{$child->get($pmp_menue_column_3.Output)}</td>{/if}
										{if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<td class="td{$sch%2}c">{$child->get($pmp_menue_column_4.Output)}</td>{/if}
										{if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<td class="td{$sch%2}c">{$child->get($pmp_menue_column_5.Output)}</td>{/if}
										{if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<td class="td{$sch%2}c">{$child->get($pmp_menue_column_6.Output)}</td>{/if}
									{/strip}
								</tr>

								{if isset($child->isBoxset) && $child->isBoxset == true}
									<tr id="row_{$child->id}" style="display:none;">
										<td class="td{$sch%2}" colspan="{$menue_columns}">
											<table style="width:100%; border-style:none; border-spacing:0px; border-width:0px;">
												{foreach from=$child->Boxset_childs item=grandchild}
													<tr>
														{strip}
															{if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<td class="td{$sch%2}"></td>{/if}
															{if isset( $pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<td class="td{$sch%2}" style="padding-left:36px;"><a class="title_select" id="id{$grandchild->id}" href="index.php?content=filmprofile&amp;id={$grandchild->id}">{$grandchild->get($pmp_menue_column_1.Output)}</a></td>{/if}
															{if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<td class="td{$sch%2}c">{$grandchild->get($pmp_menue_column_2.Output)}</td>{/if}
															{if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<td class="td{$sch%2}c">{$grandchild->get($pmp_menue_column_3.Output)}</td>{/if}
															{if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<td class="td{$sch%2}c">{$grandchild->get($pmp_menue_column_4.Output)}</td>{/if}
															{if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<td class="td{$sch%2}c">{$grandchild->get($pmp_menue_column_5.Output)}</td>{/if}
															{if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<td class="td{$sch%2}c">{$grandchild->get($pmp_menue_column_6.Output)}</td>{/if}
														{/strip}
													</tr>
												{/foreach}
											</table>
										</td>
									</tr>
								{/if}
							{/foreach}
						</table>
					</td>
				</tr>
			{/if}
      
		{/foreach}
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Information{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{t}Number of DVDs{/t} {$count}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Navigation{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content-center">
				{if isset($letter)}
					<a href="{$smarty.server.SCRIPT_NAME}?letter=off&amp;list_page=1">{t}All{/t}</a>&nbsp;
				{else}
					<strong>{t}All{/t}</strong>&nbsp;
				{/if}
				{foreach from=$letters item=letts}
					{if isset($letter) && $letts == $letter}
						<strong>{$letts}</strong>
					{else}
						{if $letts == '#'}
							<a href="{$smarty.server.SCRIPT_NAME}?letter=0&amp;list_page=1">{$letts}</a>
						{else}
							<a href="{$smarty.server.SCRIPT_NAME}?letter={$letts}&amp;list_page=1">{$letts}</a>
						{/if}
					{/if}
				{/foreach}
			</td>
		</tr>
		{if $pages > 1}
			<tr>
				<td colspan="2" class="frame-content-center">
					{if $page > 1}
						<a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page=1">&lt;&lt;</a>&nbsp;
						<a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$page-1}">&lt;</a>&nbsp;
					{/if}
					{section name="Pages" start=1 loop=$pages+1}
						{if ( $smarty.section.Pages.index == 1 ) || ( $page == $smarty.section.Pages.index - 3 ) || ( $page == $smarty.section.Pages.index - 2 ) || ( $page == $smarty.section.Pages.index - 1 ) || ( $page == $smarty.section.Pages.index ) || ( $page == $smarty.section.Pages.index + 1 ) || ( $page == $smarty.section.Pages.index + 2 ) || ( $page == $smarty.section.Pages.index + 3 ) || ( $smarty.section.Pages.index == $pages )}
							{if ( $smarty.section.Pages.index == $pages ) && ( $page < $smarty.section.Pages.index - 4 )}
								...
							{/if}
							{if $page == $smarty.section.Pages.index}
								<strong>{$smarty.section.Pages.index}</strong>
							{else}
								<a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$smarty.section.Pages.index}">{$smarty.section.Pages.index}</a>
							{/if}
							{if ( $smarty.section.Pages.index == 1 ) && ( $page > 5 )}
								...
							{/if}
						{/if}
					{/section}
					{if $page < $pages}
						&nbsp;<a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$page+1}">&gt;</a>
						&nbsp;<a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$pages}">&gt;&gt;</a>
					{/if}
				</td>
			</tr>
		{/if}
	</table>

	{include file="window-end.inc.tpl"}

</div>
</td>

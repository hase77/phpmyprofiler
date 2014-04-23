<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Statistics"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Other Statistics{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ul class="noindent">
					<li><a href="index.php?content=statisticsdetail&amp;id=6">{t}Director Statistic{/t}</a></li>
					<li><a href="index.php?content=statisticsdetail&amp;id=7">{t}Producer Statistic{/t}</a></li>
					<li><a href="index.php?content=statisticsdetail&amp;id=8">{t}Writer &amp; Screenwriter Statistic{/t}</a></li>
					<li><a href="index.php?content=statisticsdetail&amp;id=9">{t}Composer Statistic{/t}</a></li>
					<li><a href="index.php?content=statisticsdetail&amp;id=5">{t}Actor Statistic{/t}</a></li>
					<li><a href="index.php?content=watched">{t}What's been watched{/t}</a></li>
				</ul>
			</td>
		</tr>
	</table>
         
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Number of DVDs{/t}: {$count_all|number_format:0:$pmp_dec_point:$pmp_thousands_sep}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ul class="noindent">
					{if $pmp_statistic_showprice == 1}<li>{t}With Pricing Information{/t}: {$count_price|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>{/if}
					<li>{t}DVDs without a Child Profile{/t}: {$withoutchilds|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>
					<li>{t}Boxset Profiles{/t}: {$boxsets|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>
					<li>{t}Child Profiles{/t}: {$childs|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>
					<li>{t}DVDs with Collection Number{/t}: {$count_number|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>
					<li>{t}DVDs with Rating Information{/t}: {$count_rating|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>
				</ul>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_lists.php" alt="{t}Number of DVDs{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>
         
	{if $pmp_statistic_showprice == 1}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Price of all DVDs{/t}: {$price_sum} {$pmp_usecurrency}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
					{if $count_price > 0}
						<ul class="noindent">
							<li>{t}Average price{/t}: {$average} {$pmp_usecurrency}</li>
							<li>{t}Most expensive DVDs{/t}:
								<ol>
									{foreach from=$expensive item=exp}
										<li><a href="index.php?content=filmprofile&amp;id={$exp->id}">{$exp->Title}</a>: {$exp->ConvPrice} {$exp->ConvCurrency} {if $exp->PurchCurrencyID != $exp->ConvCurrency}({$exp->PurchPrice} {$exp->PurchCurrencyID}){/if}</li>
									{/foreach}
								</ol>
							</li>
							<li>{t}Cheapest DVDs{/t}:
								<ol>
									{foreach from=$cheapest item=cheap}
										<li><a href="index.php?content=filmprofile&amp;id={$cheap->id}">{$cheap->Title}</a>: {$cheap->ConvPrice} {$cheap->ConvCurrency} {if $cheap->PurchCurrencyID != $cheap->ConvCurrency}({$cheap->PurchPrice} {$cheap->PurchCurrencyID}){/if}</li>
									{/foreach}
								</ol>
							</li>
						</ul>
					{/if}
				</td>
			</tr>
		</table>
	{/if}
            
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Length of all DVDs{/t}: {$length_sum|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}minutes{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ul class="noindent">
					<li>{t}DVDs with Length Information{/t}: {$length_count|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</li>
					<li>{t}Hours: about{/t} {$length_sum_hours|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}hours{/t}</li>
					<li>{t}Days: about{/t} {$length_sum_days|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}days{/t}</li>
					<li>{t}Weeks: about{/t} {$length_sum_weeks|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}weeks{/t}</li>
					<li>{t}Months: about{/t} {$length_sum_months|round|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}months{/t}</li>
					<li>{t}Years: about{/t} {$length_sum_years|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}years{/t}</li>
					{if $length_sum}<li>{t}Average Length{/t}: {$length_avg|round} {t}minutes{/t}</li>{/if}
					<li>{t}Longest DVDs{/t}:
						<ol>
							{foreach from=$longest item=long}
								<li><a href="index.php?content=filmprofile&amp;id={$long->id}">{$long->Title}</a>: {$long->Length|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}minutes{/t}</li>
							{/foreach}
						</ol>
					</li>
					<li>{t}Shortest DVDs{/t}:
						<ol>
							{foreach from=$shortest item=short}
								<li><a href="index.php?content=filmprofile&amp;id={$short->id}">{$short->Title}</a>: {$short->Length|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}minutes{/t}</li>
							{/foreach}
						</ol>
					</li>
				</ul>
			</td>
		</tr>
	</table>
            
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Regions{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$regions item=region}
						<li><a href="index.php?addwhere=pmp_regions[dot]id&amp;whereval=region[dot]{$region->name|rawurlencode}&amp;caption=Region:%20{$region->name|rawurlencode}">{t}Regioncode{/t} {$region->name}</a>: {$region->data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_regions.php" alt="{t}Regions{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Localities of DVDs{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$localities item=locality}
						<li><a href="index.php?addwhere=locality&amp;whereval={$locality->name|rawurlencode}&amp;delwhere=locality">{t}{$locality->name}{/t}</a>: {$locality->data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_localities.php" alt="{t}Localities of DVDs{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Origins of Movies{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$origins item=origin}
						<li><a href="index.php?addwhere=pmp_countries_of_origin[dot]id&amp;whereval=country[dot]{$origin->name|rawurlencode}&amp;delwhere=origin">{t}{$origin->name}{/t}</a>: {$origin->data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_origins.php" alt="{t}Origins of Movies{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Ratings{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$ratings item=rating}
						<li><a href="index.php?addwhere=rating&amp;whereval={$rating.name|rawurlencode}&amp;delwhere=rating&amp;caption=Rating:%20{$rating.name|rawurlencode}">{$rating.name|default:"Ohne Angabe"}:</a> {$rating.data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_ratings.php" alt="{t}Ratings{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>
         
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Year of Purchase{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ul class="noindent">
					<li><a href="index.php?content=statisticsdetail&amp;id=4">{t}Detailed Statistic{/t}</a></li>
					{foreach from=$dates item=purch}
						<li><a href="index.php?addwhere=year([tab]purchdate)&amp;whereval={$purch->name|rawurlencode}&amp;delwhere=year([tab]purchdate)&amp;caption=Year%20of%20Purchase:%20{$purch->name|rawurlencode}">{$purch->name|default:"Ohne Angaben"}:</a> {$purch->data} {t}DVDs{/t}{if $pmp_statistic_showprice == 1}<em> ({$purch->value|number_format:2:$pmp_dec_point:$pmp_thousands_sep} {$pmp_usecurrency})</em>{/if}</li>
					{/foreach}
				</ul>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_yearofpurchase.php" alt="{t}Year of Purchase{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>
            
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Production Decade{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ul class="noindent">
					<li><a href="index.php?content=statisticsdetail&amp;id=3">{t}Detailed Statistic{/t}</a></li>
					{foreach from=$years item=year}
						<li><a href="index.php?addwhere=prodyear&amp;whereval={$year->name|substr:0:3}_&amp;delwhere=prodyear&amp;caption=Production%20Decade:%20{$year->name}">{$year->name}:</a> {$year->data} {t}DVDs{/t}</li>
					{/foreach}
				</ul>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_productiondecade.php" alt="{t}Production Decade{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>

	{if isset($places) && $places > 0}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Place of Purchase (Top 10){/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
					<ol class="noindent">
						{foreach from=$places item=place}
							<li><a href="index.php?addwhere=purchplace&amp;whereval={$place->name|rawurlencode}&amp;caption=Place%20of%20Purchase:%20{$place->name|rawurlencode}">{$place->name}:</a> {$place->data} {t}DVDs{/t}{if $pmp_statistic_showprice == 1}<em> ({$place->value|number_format:2:$pmp_dec_point:$pmp_thousands_sep} {$pmp_usecurrency})</em>{/if}</li>
						{/foreach}
					</ol>
					{if $pmp_gdlib == 1}
						<div style="text-align: center;"><img src="statistic/graph_placeofpurchase.php" alt="{t}Place of Purchase{/t}" /></div>
					{/if}
         		</td>
			</tr>
		</table>
	{/if}
               
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Genre (Top 10){/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$genres item=genre}
						<li><a href="index.php?addwhere=pmp_genres[dot]id&amp;whereval=genre[dot]{$genre->name|rawurlencode}&amp;caption=Genre:%20{$genre->name|rawurlencode}">{t}{$genre->name}{/t}:</a> {$genre->data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_genres.php" alt="{t}Genres{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>
            
	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Studio (Top 10){/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$studios item=studio}
						<li><a href="index.php?addwhere=pmp_studios[dot]id&amp;whereval=studio[dot]{$studio->name|rawurlencode}&amp;caption=Studio:%20{$studio->name|rawurlencode}">{$studio->name}:</a> {$studio->data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_studios.php" alt="{t}Studios{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Media Companies (Top 10){/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ol class="noindent">
					{foreach from=$companies item=company}
						<li><a href="index.php?addwhere=pmp_media_companies[dot]id&amp;whereval=company[dot]{$company->name|rawurlencode}&amp;caption=Media%20Company:%20{$company->name|rawurlencode}">{$company->name}:</a> {$company->data} {t}DVDs{/t}</li>
					{/foreach}
				</ol>
				{if $pmp_gdlib == 1}
					<div style="text-align: center;"><img src="statistic/graph_media_companies.php" alt="{t}Media Companies{/t}" /></div>
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Visitors{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<ul class="noindent">
					<li>{t}Visitors{/t}: {$visitors} -  <a href="index.php?content=statisticsdetail&amp;id=1">{t}Detailed Statistic{/t}</a></li>
					<li>{t}Visited DVDs{/t}: {$profiles} - <a href="index.php?content=statisticsdetail&amp;id=2">{t}Detailed Statistic{/t}</a></li>
				</ul>
			</td>
		</tr>
	</table>
         
	{include file="window-end.inc.tpl"}

</div>

</td>

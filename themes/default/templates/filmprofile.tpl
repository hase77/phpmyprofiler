<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div style="height: 100%; overflow: auto;">

	{if $dvd->OriginalTitle != ''}
		{assign var="Title" value=$dvd->Title}
		{assign var="OriginalTitle" value=$dvd->OriginalTitle}
		{assign var="Year" value=$dvd->Year}
		{assign var="windowtitle" value="$Title <i>$OriginalTitle</i> ($Year)"}
	{else}
		{assign var="Title" value=$dvd->Title}
		{assign var="Year" value=$dvd->Year}
		{assign var="windowtitle" value="$Title ($Year)"}
	{/if}

	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Features{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<table class="feature">
					<tr style="vertical-align: middle;">
						{strip}
						{if $dvd->Loaned == 'true'}
							<td class="feature" style="width: 8%;">
								<img src="themes/{$pmp_theme}/images/additional/loaned.png" alt="{t}This DVD is currently loaned{/t}" title="{t}This DVD is currently loaned{/t}" style="vertical-align: middle;" />
							</td>
						{/if}

						<td class="feature" style="width: 12%;">
							{$dvd->Media|getpic:media}
						</td>

						<td class="feature" style="width: 12%;">
							{foreach from=$dvd->Regions item=RC}
								{$RC|region:$dvd->Media}
							{/foreach}
						</td>

						<td class="feature">
							{if $dvd->Rating != ''}{$dvd->Rating|rating:$dvd->Locality}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/if}

							{if $dvd->Casetype != ''}{$dvd->Casetype|casetype}&nbsp;{/if}

							{if $dvd->Slipcover == '1'}<img src="themes/{$pmp_theme}/images/additional/slipcover.gif" alt="Slipcover" title="Slipcover" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->PanAndScan == '1'}<img src="themes/{$pmp_theme}/images/additional/4by3.gif" alt="Pan&Scan" title="Pan&Scan" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->FullFrame == '1'}<img src="themes/{$pmp_theme}/images/additional/133.gif" alt="Full Frame" title="Full Frame" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '1.66'}<img src="themes/{$pmp_theme}/images/additional/166.gif" alt="1:1.66 Widescreen" title="1:1.66 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '1.78'}<img src="themes/{$pmp_theme}/images/additional/178.gif" alt="1:1.78 Widescreen" title="1:1.78 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '1.85'}<img src="themes/{$pmp_theme}/images/additional/185.gif" alt="1:1.85 Widescreen" title="1:1.85 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '2.20'}<img src="themes/{$pmp_theme}/images/additional/220.gif" alt="1:2.20 Widescreen" title="1:2.20 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '2.35'}<img src="themes/{$pmp_theme}/images/additional/235.gif" alt="1:2.35 Widescreen" title="1:2.35 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '2.40'}<img src="themes/{$pmp_theme}/images/additional/240.gif" alt="1:2.40 Widescreen" title="1:2.40 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Widescreen == '1' && $dvd->Ratio == '2.55'}<img src="themes/{$pmp_theme}/images/additional/255.gif" alt="1:2.55 Widescreen" title="1:2.55 Widescreen" style="vertical-align: middle;" />&nbsp;{/if}
							{if $dvd->Anamorph == '1'}<img src="themes/{$pmp_theme}/images/additional/anamorph.gif" alt="16:9 Anamorph" title="16:9 Anamorph" style="vertical-align: middle;" />&nbsp;{/if}
							{if isset($dvd->dts) && $dvd->dts == '1'}<img src="themes/{$pmp_theme}/images/audio/dts.png" alt="DTS (Digital Theatre System)" title="DTS (Digital Theatre System)" style="height: 20px; vertical-align: middle;" />&nbsp;{/if}
							{if isset($dvd->dd) && $dvd->dd == '1'}<img src="themes/{$pmp_theme}/images/audio/dolbydigital.gif" alt="Dolby Digital" title="Dolby Digital" style="height: 20px; vertical-align: middle;" />&nbsp;{/if}
						</td>
						{/strip}
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Details{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content-center">
				<div style="text-align: center" id="ib{$dvd->id}">
					<input name="opt_view" id="page1" type="radio" value="overview" class="title_page" {if $page == 1}checked="checked"{/if}/>{t}Overview{/t}&nbsp;&nbsp;
					<input name="opt_view" id="page2" type="radio" value="details" class="title_page" {if $page == 2}checked="checked"{/if} />{t}Details{/t}&nbsp;&nbsp;
					<input name="opt_view" id="page3" type="radio" value="cast" class="title_page" {if $page == 3}checked="checked"{/if} />{t}Cast &amp; Crew{/t}&nbsp;&nbsp;
					{if isset($dvd->Events)}
						<input name="opt_view" id="page4" type="radio" value="events" class="title_page" {if $page == 4}checked="checked"{/if} />{t}Events{/t}&nbsp;&nbsp;
					{/if}
					{if $dvd->EPG == '1'}
						<a href="epg/{$dvd->id}.html" onclick="popUpWindow(this.href,'','600','600','yes'); return false" >{t}Episode Guide{/t}</a>
					{/if}

					<!-- Movie Details -->
					<table class="details">
						<tr>
							<td class="details-left">
								{if $page == '1'}{include file='filmprofile_page1.tpl'}{/if}
								{if $page == '2'}{include file='filmprofile_page2.tpl'}{/if}
								{if $page == '3'}{include file='filmprofile_page3.tpl'}{/if}
								{if $page == '4'}{include file='filmprofile_page4.tpl'}{/if}
							</td>

							<td class="details-right">
								{if isset($pmp_show_brief_review) && $pmp_show_brief_review == 1 && isset($dvd->Review)}
									<table class="properties">
										<tr><td class="propheader">{t}Voting{/t}:</td></tr>
										<tr><td class="propvalue">
											<img src="voting.php?rating={$dvd->Review}&amp;size=big" alt="{$dvd->Review}" />
										</td></tr>
									</table>
								{/if}

								<table class="properties">
									<tr><td class="propheader">{t}Cover Images{/t}:</td></tr>
									<tr><td class="propvalue">
										{if $dvd->frontpic}<a rel="gallery_cover" href="thumbnail.php?id={$dvd->id}&amp;type=front&amp;width=noscale" class="fancybox">{/if}
										<img src="thumbnail.php?id={$dvd->id}&amp;type=front&amp;width=200" width="200" alt="Front" />
										{if $dvd->frontpic}</a><br /><br />{/if}
										{if $dvd->backpic}<a rel="gallery_cover" href="thumbnail.php?id={$dvd->id}&amp;type=back&amp;width=noscale" class="fancybox">{/if}
										<img src="thumbnail.php?id={$dvd->id}&amp;type=back&amp;width=200" width="200" alt="Back" />
										{if $dvd->backpic}</a><br /><br />{/if}
									</td></tr>

									{if isset($dvd->isBoxset) && $dvd->isBoxset != false}
										<tr><td class="propheader">{t}Boxset Contents{/t}:</td></tr>
										<tr>
											<td class="propvalue">
												<table class="hidden">
													{foreach from=$dvd->Boxset_childs item=content}
														<tr>
															<td class="title_select_sub" id="ie{$content->id}"><a href="index.php?content=filmprofile&amp;id={$content->id}"><img src="thumbnail.php?id={$content->id}&amp;type=front&amp;width=60" alt="{$content->Title}" width="60" /></a></td>
															<td class="title_select_sub" id="if{$content->id}"><a href="index.php?content=filmprofile&amp;id={$content->id}">{$content->Title}</a></td>
														</tr>
													{/foreach}
												</table>
											</td>
										</tr>
									{/if}

									{if $dvd->partofBoxset != false}
										<tr><td class="propheader">{t}Part of boxset{/t}:</td></tr>
										<tr>
											<td class="propvalue">
												<table class="hidden">
													<tr>
														<td class="title_select_sub" id="ie{$dvd->partofBoxset}" style="width: 50%;" align="left"><a href="index.php?content=filmprofile&amp;id={$dvd->partofBoxset}"><img src="thumbnail.php?id={$dvd->partofBoxset}&amp;type=front&amp;width=90" height="125" alt="Front" /></a></td>
														<td class="title_select_sub" id="if{$dvd->partofBoxset}" style="width: 50%;" align="right"><a href="index.php?content=filmprofile&amp;id={$dvd->partofBoxset}"><img src="thumbnail.php?id={$dvd->partofBoxset}&amp;type=back&amp;width=90" height="125" alt="Back" /></a></td>
													</tr>
												</table>
											</td>
										</tr>
									{/if}

									{if isset($dvd->MyLinks) && ( ( isset($pmp_show_links) && ( $pmp_show_links == 1 || $pmp_show_links == 3 ) ) || ( !isset($pmp_show_links) || $pmp_show_links == 0 ) )}
										<tr><td class="propheader">{t}My Links{/t}:</td></tr>
										{assign var="category" value='0'}
										{foreach from=$dvd->MyLinks item=value}
											{if $value->category != $category}
												{assign var="category" value=$value->category}
												{if $category == '1'}<tr><td class="proptitle">{t}Official Websites{/t}:</td></tr>{/if}
												{if $category == '2'}<tr><td class="proptitle">{t}Fan Sites{/t}:</td></tr>{/if}
												{if $category == '3'}<tr><td class="proptitle">{t}Trailers and Clips{/t}:</td></tr>{/if}
												{if $category == '4'}<tr><td class="proptitle">{t}Reviews{/t}:</td></tr>{/if}
												{if $category == '5'}<tr><td class="proptitle">{t}Ratings{/t}:</td></tr>{/if}
												{if $category == '6'}<tr><td class="proptitle">{t}General Information{/t}:</td></tr>{/if}
												{if $category == '7'}<tr><td class="proptitle">{t}Games{/t}:</td></tr>{/if}
												{if $category == '8'}<tr><td class="proptitle">{t}Other{/t}:</td></tr>{/if}
												{if $category == '9'}<tr><td class="proptitle">{t}Hidden{/t}:</td></tr>{/if}
											{/if}
											<tr><td class="propvalue"><a href="{$value->url}">{$value->description}</a></td></tr>
										{/foreach}
									{/if}

									{if ( isset($pmp_show_links) && ( $pmp_show_links == 2 || $pmp_show_links == 3 ) ) || (( !isset($pmp_show_links) || $pmp_show_links == 0 ) && !isset($dvd->MyLinks) )}
										<tr><td class="propheader">{t}External Links{/t}:</td></tr>
										<tr>
											{if $dvd->OriginalTitle}
												{assign var="imdbTitle" value=$dvd->OriginalTitle}
											{else}
												{assign var="imdbTitle" value=$dvd->Title}
											{/if}
											<td class="propvalue">
												<b>{t}International{/t}:</b><br />
												<a href="http://www.invelos.com/Forums.aspx?task=contributionnotes&amp;ProfileUPC={$dvd->id}">Contribution Notes</a><br />
												<a href="http://www.invelos.com/dvdpro/userinfo/ProfileContributors.aspx?UPC={$dvd->id}" onclick="popUpWindow(this.href,'','700','500','yes'); return false" >Profile Contributors</a><br />
												<a href="http://invelos.com/ProfileLinks.aspx?id={$dvd->id}">Profile Links</a><br />
												{if isset($dvd->imdbID)}
													<a href="http://www.imdb.com/title/tt{$dvd->imdbID}/">IMDB (International)</a><br />
												{else}
													<a href="http://www.imdb.com/find?s=tt&amp;q={$imdbTitle|rawurlencode}">IMDB (International)</a><br />
												{/if}
												<a href="http://www.themoviedb.org/search?query={$imdbTitle|rawurlencode}">themoviedb.org</a><br />
												<a href="http://www.rottentomatoes.com/search/?search={$imdbTitle|rawurlencode}">Rotten Tomatoes</a><br />
												<a href="http://en.wikipedia.org/wiki/{$imdbTitle|rawurlencode}">Wikipedia (International)</a><br />
												<a href="http://www.moviemistakes.com/searchpage.php?type=movies&amp;text={$imdbTitle|rawurlencode}">Movie Mistakes</a><br />
												<a href="http://www.dvdcompare.net/comparisons/search.php?searchtype=text&amp;param={$imdbTitle|rawurlencode}">Rewind (DVD comparisons)</a><br />
												<a href="http://www.dvd-basen.dk/uk/home.php3?search={$imdbTitle|urlencode}&amp;land=z&amp;ok=go&amp;mvis=ok&amp;region=z">DVD-Basen</a><br />
												<a href="http://www.youtube.com/results?search_query={$imdbTitle|rawurlencode}%20trailer&amp;search_type=&amp;aq=f">YouTube Trailer Search (International)</a><br />
												<a href="http://www.amazon.com/s/url=search-alias%3Ddvd&amp;field-keywords={$imdbTitle|rawurlencode}">Amazon.com Search</a><br />
												{if $smarty.session.lang_id == 'de'}
													<b>{t}German{/t}:</b><br />
													<a href="http://de.wikipedia.org/wiki/{$dvd->Title|rawurlencode}">Wikipedia (Deutsch)</a><br />
													{if isset($dvd->ofdbID)}
														<a href="http://www.ofdb.de/film/{$dvd->ofdbID|rawurlencode}">OFDB</a><br />
													{elseif $dvd->OriginalTitle == ''}
														<a href="http://www.ofdb.de/view.php?page=suchergebnis&amp;Kat=DTitel&amp;SText={$dvd->Title|rawurlencode}">OFDB</a><br />
													{else}
														<a href="http://www.ofdb.de/view.php?page=suchergebnis&amp;Kat=OTitel&amp;SText={$dvd->OriginalTitle|rawurlencode}">OFDB</a><br />
													{/if}
													<a href="http://www.schnittberichte.com/svds.php?Page=Liste&amp;Kat=3&amp;SearchKat=Titel&amp;String={$dvd->Title|rawurlencode}">Schnittberichte.com</a><br />
													<a href="http://www.cinefacts.de/suche/suche.php?name={$dvd->Title|rawurlencode}">Cinefacts</a><br />
													<a href="http://www.dvd-palace.de/dvddatabase/dbsearch.php?action=1&amp;suchbegriff={$dvd->Title|rawurlencode}">DVD-Palace</a><br />
													<a href="http://www.moviemaze.de/suche/result.phtml?searchword={$dvd->Title|rawurlencode}">MovieMaze</a><br />
													<a href="http://www.caps-a-holic.com/index.php?search={$dvd->Title|rawurlencode}">caps-a-holic DVD Vergleiche</a><br />
													<a href="http://www.caps-a-holic.com//hd_vergleiche/test.php?search={$dvd->Title|rawurlencode}">caps-a-holic HD/SD Vergleiche</a><br />
													<a href="http://www.filmstarts.de/finde.html?anfrage={$dvd->Title|rawurlencode}">FILMSTARTS.de</a><br />
													<a href="http://www.dvdiggle.de/digglebot.php?dvdtitle={$dvd->Title|rawurlencode}&amp;abroad=1">Preissuche DVDiggle</a><br />
													<a href="http://www.amazon.de/gp/search?ie=UTF8&amp;keywords={$dvd->Title|rawurlencode}&amp;index=dvd">Amazon.de Suche</a><br />
												{elseif $smarty.session.lang_id == 'nl'}
													<b>{t}Dutch{/t}:</b><br />
													<a href="http://www.moviemeter.nl/film/search/{$imdbTitle|rawurlencode}">Moviemeter</a><br />
													<a href="http://www.bol.com/nl/s/dvd/zoekresultaten/Ntt/{$dvd->Title|rawurlencode}/Ntk/dvd_all/Ntx/mode+matchallpartial/Nty/1/N/3133/Ne/3133/search/true/searchType/qck/index.html?">Bol.com</a><br />
												{/if}
											</td>
										</tr>
									{/if}
								</table>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
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
				<strong>{$counter.all}</strong> {t}Visitors{/t} ({$counter.today} {t}today{/t})
			</td>
		</tr>
	</table>

	{include file="window-end.inc.tpl"}

</div>

</td>

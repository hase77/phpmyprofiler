{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

filmprofile.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

            <div class="col-lg-6">

               {if $dvd->OriginalTitle != ''}
                  {assign var="Title" value=$dvd->Title}
                  {assign var="OriginalTitle" value=$dvd->OriginalTitle}
                  {assign var="Year" value=$dvd->Year}
                  {assign var="windowtitle" value="$Title ($Year)<br><i>$OriginalTitle</i>"}
               {else}
                  {assign var="Title" value=$dvd->Title}
                  {assign var="Year" value=$dvd->Year}
                  {assign var="windowtitle" value="$Title ($Year)"}
               {/if}

               <h2>{$windowtitle}</h2>
               
               <!-- Cover Images -->
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Cover Images{/t}</div>
                  <div class="panel-body" style="text-align: center;">
                     {if $dvd->frontpic}
                        <a href="thumbnail.php?id={$dvd->id}&amp;type=front&amp;width=noscale" title="Front Cover">
                           <img src="thumbnail.php?id={$dvd->id}&amp;type=front&amp;width=noscale" style="width: 48%; vertical-align:top;" alt="Front Cover">
                        </a>
                     {/if}
                     {if $dvd->backpic}
                        <a href="thumbnail.php?id={$dvd->id}&amp;type=back&amp;width=noscale" title="Back Cover">
                           <img src="thumbnail.php?id={$dvd->id}&amp;type=back&amp;width=noscale" style="width: 48%; vertical-align:top;" alt="Back Cover">
                        </a>
                     {/if}
                  </div>
               </div>
                  
               <!-- Features -->
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Features{/t}</div>
                  <div class="panel-body">
                     {strip}
                        {if $dvd->Loaned == 'true'}
                           <p>
                              <img src="themes/{$pmp_theme}/images/additional/loaned.png" alt="{t}This DVD is currently loaned{/t}" title="{t}This DVD is currently loaned{/t}" style="vertical-align: middle;">
                           </p>
                        {/if}
      
                        <div class="dual-label dual-label-primary">
                           <div class="dual-label-upper-primary">Media</div>
                           <div class="dual-label-lower-primary">{$dvd->Media}</div>
                        </div>
   
                        {foreach from=$dvd->Regions item=RC}
                           <div class="dual-label dual-label-default">
                              <div class="dual-label-upper-default">Region</div>
                              <div class="dual-label-lower-default">{$RC}</div>
                           </div>
                        {/foreach}
      
                        {if $dvd->Rating != ''}
                           <div class="dual-label dual-label-info">
                              <div class="dual-label-upper-info">Rating</div>
                              <div class="dual-label-lower-info">{$dvd->Rating}</div>
                           </div>
                        {/if}
                        
                        {if $dvd->Casetype != ''}
                           <div class="dual-label dual-label-bw">
                              <div class="dual-label-upper-bw">Case</div>
                              <div class="dual-label-lower-bw">{$dvd->Casetype}</div>
                           </div>
                        {/if}
                        
                        {if $dvd->Slipcover == '1'}
                           <div class="dual-label dual-label-bw">
                              <div class="dual-label-upper-bw">Cover</div>
                              <div class="dual-label-lower-bw">Slipcover</div>
                           </div>
                        {/if}
                        
                        {if $dvd->PanAndScan == '1'}
                           <div class="dual-label dual-label-success">
                              <div class="dual-label-upper-success">Pan & Scan</div>
                              <div class="dual-label-lower-success">4 : 3</div>
                           </div>
                        {/if}
                        
                        {if $dvd->FullFrame == '1'}
                           <div class="dual-label dual-label-success">
                              <div class="dual-label-upper-success">Full Frame</div>
                              <div class="dual-label-lower-success">1.33 : 1</div>
                           </div>
                        {/if}
                        
                        {if $dvd->Widescreen == '1'}
                           <div class="dual-label dual-label-warning">
                              <div class="dual-label-upper-warning">Widescreen</div>
                              <div class="dual-label-lower-warning">{$dvd->Ratio} : 1</div>
                           </div>
                        {/if}
                        
                        {if $dvd->Anamorph == '1'}
                           <div class="dual-label dual-label-warning">
                              <div class="dual-label-upper-warning">Anamorph</div>
                              <div class="dual-label-lower-warning">16 : 1</div>
                           </div>
                        {/if}
                        
                        {if isset($dvd->dts) && $dvd->dts == '1'}
                           <div class="dual-label dual-label-danger">
                              <div class="dual-label-upper-danger">Digital Audio</div>
                              <div class="dual-label-lower-danger">DTS</div>
                           </div>
                        {/if}
                        
                        {if isset($dvd->dd) && $dvd->dd == '1'}
                           <div class="dual-label dual-label-danger">
                              <div class="dual-label-upper-danger">Digital Audio</div>
                              <div class="dual-label-lower-danger">Dolby</div>
                           </div>
                        {/if}
                        
                     {/strip}
                  </div>
               </div>

               <!-- Overview Details -->
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Details{/t}</div>
                  <div class="panel-body">
                     <ul class="nav nav-tabs" style="margin-bottom: 8px;">
                        <li class="active"><a href="#overview" data-toggle="tab">{t}Overview{/t}</a></li>
                        <li><a href="#details" data-toggle="tab">{t}Details{/t}</a></li>
                        <li><a href="#cast" data-toggle="tab">{t}Cast &amp; Crew{/t}</a></li>
                        {if isset($dvd->Events)}
                           <li><a href="#events" data-toggle="tab">{t}Events{/t}</a></li>
                        {/if}
                        {if $dvd->EPG == '1'}
                           <li><a href="epg/{$dvd->id}.html" title="{t}Episode Guide{/t}..." onclick="popUpWindow(this.href,'','600','600','yes'); return false" >{t}Episode Guide{/t}</a></li>
                        {/if}
                     </ul>
                     
                     <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="overview">
                           {include file='filmprofile_page1.tpl'}
                        </div>
                        <div class="tab-pane fade in" id="details">
                           {include file='filmprofile_page2.tpl'}
                        </div>
                        <div class="tab-pane fade in" id="cast">
                           {include file='filmprofile_page3.tpl'}
                        </div>
                        {if isset($dvd->Events)}
                           <div class="tab-pane fade in" id="events">
                              {include file='filmprofile_page4.tpl'}
                           </div>
                        {/if}
                     </div>                              
                  </div>
               </div>

               <!-- Boxset Content -->
               {if isset($dvd->isBoxset) && $dvd->isBoxset != false}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Boxset Contents{/t}</div>
                  <div class="panel-body">
                     {foreach from=$dvd->Boxset_childs item=content}
                     <p>
                        <a href="index.php?content=filmprofile&amp;id={$content->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><img src="thumbnail.php?id={$content->id}&amp;type=front&amp;width=60" alt="{$content->Title}" style="width:60px;"></a><br>
                        <a href="index.php?content=filmprofile&amp;id={$content->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$content->Title}</a>
                     </p>
                     {/foreach}
                  </div>
               </div>
               {/if}

               <!-- Part of Boxset -->
               {if $dvd->partofBoxset != false}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Part of boxset{/t}</div>
                  <div class="panel-body">
                     <a href="index.php?content=filmprofile&amp;id={$dvd->partofBoxset}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><img src="thumbnail.php?id={$dvd->partofBoxset}&amp;type=front&amp;width=90" style="height:125px;" alt="Front"></a>
                     <a href="index.php?content=filmprofile&amp;id={$dvd->partofBoxset}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><img src="thumbnail.php?id={$dvd->partofBoxset}&amp;type=back&amp;width=90" style="height:125px;" alt="Back"></a>
                  </div>
               </div>
               {/if}

               <!-- Voting -->
               {if isset($pmp_show_brief_review) && $pmp_show_brief_review == 1 && isset($dvd->Review)}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Voting{/t}</div>
                  <div class="panel-body">
                     <img src="include/voting.php?rating={$dvd->Review}&amp;size=big" alt="{$dvd->Review}">
                  </div>
               </div>
               {/if}

               <!-- My Links -->
               {if isset($dvd->MyLinks) && ( ( isset($pmp_show_links) && ( $pmp_show_links == 1 || $pmp_show_links == 3 ) ) || ( !isset($pmp_show_links) || $pmp_show_links == 0 ) )}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}My Links{/t}</div>
                  <div class="panel-body">
                     {assign var="category" value='0'}
                     {foreach from=$dvd->MyLinks item=value}
                        {if $value->category != $category}
                           {assign var="category" value=$value->category}
                           {if $category == '1'}{t}Official Websites{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '2'}{t}Fan Sites{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '3'}{t}Trailers and Clips{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '4'}{t}Reviews{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '5'}{t}Ratings{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '6'}{t}General Information{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '7'}{t}Games{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '8'}{t}Other{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                           {if $category == '9'}{t}Hidden{/t}: <a href="{$value->url}">{$value->description}<br>{/if}
                        {/if}
                     {/foreach}
                  </div>
               </div>
               {/if}

               <!-- External Links -->
               {if ( isset($pmp_show_links) && ( $pmp_show_links == 2 || $pmp_show_links == 3 ) ) || (( !isset($pmp_show_links) || $pmp_show_links == 0 ) && !isset($dvd->MyLinks) )}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}External Links{/t}</div>
                  <div class="panel-body">
                     {if $dvd->OriginalTitle}
                        {assign var="imdbTitle" value=$dvd->OriginalTitle}
                     {else}
                        {assign var="imdbTitle" value=$dvd->Title}
                     {/if}
                     <p>
                        <strong>{t}International{/t}:</strong><br>
                        <a href="http://www.invelos.com/Forums.aspx?task=contributionnotes&amp;ProfileUPC={$dvd->id}">Contribution Notes</a><br>
                        <a href="http://www.invelos.com/dvdpro/userinfo/ProfileContributors.aspx?UPC={$dvd->id}" onclick="popUpWindow(this.href,'','700','500','yes'); return false" >Profile Contributors</a><br>
                        <a href="http://invelos.com/ProfileLinks.aspx?id={$dvd->id}">Profile Links</a><br>
                        {if isset($dvd->imdbID)}
                           <a href="http://www.imdb.com/title/tt{$dvd->imdbID}/">IMDB (International)</a><br>
                        {else}
                           <a href="http://www.imdb.com/find?s=tt&amp;q={$imdbTitle|rawurlencode}">IMDB (International)</a><br>
                        {/if}
                        <a href="http://www.themoviedb.org/search?query={$imdbTitle|rawurlencode}">themoviedb.org</a><br>
                        <a href="http://www.rottentomatoes.com/search/?search={$imdbTitle|rawurlencode}">Rotten Tomatoes</a><br>
                        <a href="http://en.wikipedia.org/wiki/{$imdbTitle|rawurlencode}">Wikipedia (International)</a><br>
                        <a href="http://www.moviemistakes.com/searchpage.php?type=movies&amp;title={$imdbTitle|rawurlencode}">Movie Mistakes</a><br>
                        <a href="http://www.dvdcompare.net/comparisons/search.php?searchtype=text&amp;param={$imdbTitle|rawurlencode}">Rewind (DVD comparisons)</a><br>
                        <a href="http://www.dvd-basen.dk/uk/home.php3?search={$imdbTitle|urlencode}&amp;land=z&amp;ok=go&amp;mvis=ok&amp;region=z">DVD-Basen</a><br>
                        <a href="http://www.youtube.com/results?search_query={$imdbTitle|rawurlencode}%20trailer&amp;search_type=&amp;aq=f">YouTube Trailer Search (International)</a><br>
                        <a href="http://www.amazon.com/s/url=search-alias%3Ddvd&amp;field-keywords={$imdbTitle|rawurlencode}">Amazon.com Search</a><br>
                     </p>
                     {if $smarty.session.lang_id == 'de'}
                     <p>
                        <strong>{t}German{/t}:</strong><br>
                        {if isset($dvd->imdbID)}
                           <a href="http://www.imdb.de/title/tt{$dvd->imdbID}/">IMDB (Deutsch)</a><br>
                        {else}
                           <a href="http://www.imdb.de/find?s=tt&amp;q={$imdbTitle|rawurlencode}">IMDB (German)</a><br>
                        {/if}
                        <a href="http://de.wikipedia.org/wiki/{$dvd->title|rawurlencode}">Wikipedia (Deutsch)</a><br>
                        {if isset($dvd->ofdbID)}
                           <a href="http://www.ofdb.de/film/{$dvd->ofdbID|rawurlencode}">OFDB</a><br>
                        {elseif $dvd->OriginalTitle == ''}
                           <a href="http://www.ofdb.de/view.php?page=suchergebnis&amp;Kat=DTitel&amp;SText={$dvd->title|rawurlencode}">OFDB</a><br>
                        {else}
                           <a href="http://www.ofdb.de/view.php?page=suchergebnis&amp;Kat=OTitel&amp;SText={$dvd->OriginalTitle|rawurlencode}">OFDB</a><br>
                        {/if}
                        <a href="http://www.schnittberichte.com/svds.php?Page=Liste&amp;Kat=3&amp;SearchKat=Titel&amp;String={$dvd->title|rawurlencode}">Schnittberichte.com</a><br>
                        <a href="http://www.cinefacts.de/suche/suche.php?name={$dvd->title|rawurlencode}">Cinefacts</a><br>
                        <a href="http://www.digital-movie.de/dvd-reviews/dvdreview.asp?name={$dvd->title|rawurlencode}">Digital Movie</a><br>
                        <a href="http://www.dvd-palace.de/dvddatabase/dbsearch.php?action=1&amp;suchbegriff={$dvd->title|rawurlencode}">DVD-Palace</a><br>
                        <a href="http://www.moviemaze.de/suche/result.phtml?searchword={$dvd->title|rawurlencode}">MovieMaze</a><br>
                        <a href="http://www.caps-a-holic.com/index.php?search={$dvd->title|rawurlencode}">caps-a-holic DVD Vergleiche</a><br>
                        <a href="http://www.caps-a-holic.com//hd_vergleiche/test.php?search={$dvd->title|rawurlencode}">caps-a-holic HD/SD Vergleiche</a><br>
                        <a href="http://www.filmstarts.de/finde.html?anfrage={$dvd->title|rawurlencode}">FILMSTARTS.de</a><br>
                        <a href="http://www.dvdiggle.de/digglebot.php?dvdtitle={$dvd->Title|rawurlencode}&amp;abroad=1">Preissuche DVDiggle</a><br>
                        <a href="http://www.amazon.de/gp/search?ie=UTF8&amp;keywords={$dvd->title|rawurlencode}&amp;tag=phpmyp-21&amp;index=dvd">Amazon.de Suche</a><br>
                     </p>
                     {elseif $smarty.session.lang_id == 'nl'}
                     <p>
                        <strong>{t}Dutch{/t}:</strong><br>
                        {if $dvd->imdbID != ''}
                           <a href="http://www.imdb.com/title/tt{$dvd->imdbID}/">IMDB (Internationaal)</a><br>
                        {else}
                           <a href="http://www.moviemeter.nl/film/search/{$imdbTitle|rawurlencode}">Moviemeter</a><br>
                        {/if}
                        <a href="http://www.bol.com/nl/s/dvd/zoekresultaten/Ntt/{$dvd->title|rawurlencode}/Ntk/dvd_all/Ntx/mode+matchallpartial/Nty/1/N/3133/Ne/3133/search/true/searchType/qck/index.html?">Bol.com</a><br>
                     </p>
                     {/if}
                  </div>
               </div>
               {/if}

               {if $pmp_disable_reviews != 1}
                  <!-- User Reviews -->
                  <div class="panel panel-primary">
                     <div class="panel-heading">{t}User Reviews{/t}</div>
                     <div class="panel-body">
                        {if isset($dvd->Reviews)}
                           {foreach from=$dvd->Reviews item=Review}
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <strong>{$Review.Title}</strong><br>
                                    {$Review.Name} - {$Review.Date}<br>
                                    {$Review.Vote|getpic:Vote}<br>
                                 </div>
                                 <div class="panel-body">
                                    {$Review.Text|nl2br}
                                 </div>
                              </div>
                           {/foreach}
                        {/if}
                        <button type="submit" class="btn btn-primary" onclick="window.location='index.php?content=review&amp;id={$dvd->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}';">{t}Compose a review{/t}</button>
                     </div>
                  </div>
               {/if}

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

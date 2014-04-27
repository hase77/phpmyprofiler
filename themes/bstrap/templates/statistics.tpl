{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

statistics.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
         
            <div class="col-lg-6">

               <h2>{t}Statistics{/t}</h2>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Other Statistics{/t}</div>
                  <div class="panel-body">
                     <a href="index.php?content=statisticsdetail&amp;id=5&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Actor Statistic{/t}</a><br>
                     <a href="index.php?content=statisticsdetail&amp;id=9&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Composer Statistic{/t}</a><br>
                     <a href="index.php?content=statisticsdetail&amp;id=6&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Director Statistic{/t}</a><br>
                     <a href="index.php?content=statisticsdetail&amp;id=7&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Producer Statistic{/t}</a><br>
                     <a href="index.php?content=watched&amp;showlist={$showlist}">{t}What's been watched{/t}</a><br>
                     <a href="index.php?content=statisticsdetail&amp;id=8&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Writer &amp; Screenwriter Statistic{/t}</a>
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Number of DVDs{/t}: <strong>{$count_all|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong></div>
                  <div class="panel-body">
                     {if $pmp_statistic_showprice == 1}{t}With Pricing Information{/t}: <strong>{$count_price|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong><br>{/if}
                     {t}DVDs without a Child Profile{/t}: <strong>{$withoutchilds|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong><br>
                     {t}Boxset Profiles{/t}: <strong>{$boxsets|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong><br>
                     {t}Child Profiles{/t}: <strong>{$childs|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong><br>
                     {t}DVDs with Collection Number{/t}: <strong>{$count_number|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong><br>
                     {t}DVDs with Rating Information{/t}: <strong>{$count_rating|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</strong><br>
                     <br>
                     {if $pmp_gdlib == 1}
                        <img style="max-width: 100%;" src="statistic/graph_lists.php" alt="{t}Number of DVDs{/t}">
                     {/if}
                  </div>
               </div>

               {if $pmp_statistic_showprice == 1}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Price of all DVDs{/t}: <strong>{$price_sum} {$pmp_usecurrency}</strong></div>
                  <div class="panel-body">
                     {if $count_price > 0}
                        <p>{t}Average price{/t}: <strong>{$average} {$pmp_usecurrency}</strong></p>
                        <p>{t}Most expensive DVDs{/t}:</p>
                        <ol>
                           {foreach from=$expensive item=exp}
                              <li><a href="index.php?content=filmprofile&amp;id={$exp->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$exp->Title}</a>: <strong>{$exp->ConvPrice} {$exp->ConvCurrency} {if $exp->PurchCurrencyID != $exp->ConvCurrency}({$exp->PurchPrice} {$exp->PurchCurrencyID}){/if}</strong></li>
                           {/foreach}
                        </ol>
                        <p>{t}Cheapest DVDs{/t}:</p>
                        <ol>
                           {foreach from=$cheapest item=cheap}
                              <li><a href="index.php?content=filmprofile&amp;id={$cheap->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$cheap->Title}</a>: <strong>{$cheap->ConvPrice} {$cheap->ConvCurrency} {if $cheap->PurchCurrencyID != $cheap->ConvCurrency}({$cheap->PurchPrice} {$cheap->PurchCurrencyID}){/if}</strong></li>
                           {/foreach}
                        </ol>
                     {/if}
                  </div>
               </div>
               {/if}

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Length of all DVDs{/t}: <strong>{$length_sum|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}minutes{/t}</strong></div>
                  <div class="panel-body">
                     <p>
                        {if $length_sum}{t}Average Length{/t}: <strong>{$length_avg|round} {t}minutes{/t}</strong>{/if}
                     </p>
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th>{t}Hours{/t}</th>
                                 <th>{t}Days{/t}</th>
                                 <th>{t}Weeks{/t}</th>
                                 <th>{t}Months{/t}</th>
                                 <th>{t}Years{/t}</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>{$length_sum_hours|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</td>
                                 <td>{$length_sum_days|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</td>
                                 <td>{$length_sum_weeks|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</td>
                                 <td>{$length_sum_months|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</td>
                                 <td>{$length_sum_years|number_format:0:$pmp_dec_point:$pmp_thousands_sep}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <p>{t}Longest DVDs{/t}:</p>
                     <ol>
                        {foreach from=$longest item=long}
                           <li><a href="index.php?content=filmprofile&amp;id={$long->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$long->Title}</a>: <strong>{$long->Length|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}minutes{/t}</strong></li>
                        {/foreach}
                     </ol>
                     <p>{t}Shortest DVDs{/t}:</p>
                     <ol>
                        {foreach from=$shortest item=short}
                           <li><a href="index.php?content=filmprofile&amp;id={$short->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$short->Title}</a>: <strong>{$short->Length|number_format:0:$pmp_dec_point:$pmp_thousands_sep} {t}minutes{/t}</strong></li>
                        {/foreach}
                     </ol>
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Regions{/t}</div>
                  <div class="panel-body">
                     <ol>
                     {foreach from=$regions item=region}
                        <li><a href="index.php?addwhere=pmp_regions[dot]id&amp;whereval=region[dot]{$region->name|rawurlencode}&amp;caption=Region:%20{$region->name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Regioncode{/t} {$region->name}</a>: <strong>{$region->data}</strong> {t}DVDs{/t}</li>
                     {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_regions.php" alt="{t}Regions{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Localities of DVDs{/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$localities item=locality}
                           <li><a href="index.php?addwhere=locality&amp;whereval={$locality->name|rawurlencode}&amp;delwhere=locality&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}{$locality->name}{/t}</a>: <strong>{$locality->data}</strong> {t}DVDs{/t}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_localities.php" alt="{t}Localities of DVDs{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Origins of Movies{/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$origins item=origin}
                           <li><a href="index.php?addwhere=pmp_countries_of_origin[dot]id&amp;whereval=country[dot]{$origin->name|rawurlencode}&amp;delwhere=origin&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}{$origin->name}{/t}</a>: <strong>{$origin->data}</strong> {t}DVDs{/t}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_origins.php" alt="{t}Origins of Movies{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Ratings{/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$ratings item=rating}
                           <li><a href="index.php?addwhere=rating&amp;whereval={$rating.name|rawurlencode}&amp;delwhere=rating&amp;caption=Rating:%20{$rating.name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$rating.name|default:"Ohne Angabe"}:</a> <strong>{$rating.data}</strong> {t}DVDs{/t}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_ratings.php" alt="{t}Ratings{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Production Decade{/t}</div>
                  <div class="panel-body">
                     <p>
                        {foreach from=$years item=year}
                           <a href="index.php?addwhere=prodyear&amp;whereval={$year->name|substr:0:3}_&amp;delwhere=prodyear&amp;caption=Production%20Decade:%20{$year->name}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$year->name}:</a> <strong>{$year->data}</strong> {t}DVDs{/t}<br>
                        {/foreach}
                     </p>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_productiondecade.php" alt="{t}Production Decade{/t}"></div>
                     {/if}
                     <p>
                        <br><button type="button" class="btn btn-default" onclick="window.location='index.php?content=statisticsdetail&amp;id=3&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}';">{t}Detailed Statistic{/t}</button>
                     </p>
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Genre (Top 10){/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$genres item=genre}
                           <li><a href="index.php?addwhere=pmp_genres[dot]id&amp;whereval=genre[dot]{$genre->name|rawurlencode}&amp;caption=Genre:%20{$genre->name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}{$genre->name}{/t}:</a> <strong>{$genre->data}</strong> {t}DVDs{/t}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_genres.php" alt="{t}Genres{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Studio (Top 10){/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$studios item=studio}
                           <li><a href="index.php?addwhere=pmp_studios[dot]id&amp;whereval=studio[dot]{$studio->name|rawurlencode}&amp;caption=Studio:%20{$studio->name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$studio->name}:</a> <strong>{$studio->data}</strong> {t}DVDs{/t}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_studios.php" alt="{t}Studios{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Media Companies (Top 10){/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$companies item=company}
                           <li><a href="index.php?addwhere=pmp_media_companies[dot]id&amp;whereval=company[dot]{$company->name|rawurlencode}&amp;caption=Media%20Company:%20{$company->name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$company->name}:</a> <strong>{$company->data}</strong> {t}DVDs{/t}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_media_companies.php" alt="{t}Media Companies{/t}"></div>
                     {/if}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Year of Purchase{/t}</div>
                  <div class="panel-body">
                     <p>
                        {foreach from=$dates item=purch}
                           <a href="index.php?addwhere=year([tab]purchdate)&amp;whereval={$purch->name|rawurlencode}&amp;delwhere=year([tab]purchdate)&amp;caption=Year%20of%20Purchase:%20{$purch->name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$purch->name|default:"Ohne Angaben"}:</a> <strong>{$purch->data}</strong> {t}DVDs{/t}{if $pmp_statistic_showprice == 1}<em> ({$purch->value|number_format:2:$pmp_dec_point:$pmp_thousands_sep} {$pmp_usecurrency})</em>{/if}<br>
                        {/foreach}
                     </p>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_yearofpurchase.php" alt="{t}Year of Purchase{/t}"></div>
                     {/if}
                     <p>
                        <br><button type="button" class="btn btn-default" onclick="window.location='index.php?content=statisticsdetail&amp;id=4&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}';">{t}Detailed Statistic{/t}</button>
                     </p>
                  </div>
               </div>

               {if isset($places) && $places > 0}
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Place of Purchase (Top 10){/t}</div>
                  <div class="panel-body">
                     <ol>
                        {foreach from=$places item=place}
                           <li><a href="index.php?addwhere=purchplace&amp;whereval={$place->name|rawurlencode}&amp;caption=Place%20of%20Purchase:%20{$place->name|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$place->name}:</a> <strong>{$place->data}</strong> {t}DVDs{/t}{if $pmp_statistic_showprice == 1}<em> ({$place->value|number_format:2:$pmp_dec_point:$pmp_thousands_sep} {$pmp_usecurrency})</em>{/if}</li>
                        {/foreach}
                     </ol>
                     {if $pmp_gdlib == 1}
                        <div><img style="max-width: 100%;" src="statistic/graph_placeofpurchase.php" alt="{t}Place of Purchase{/t}"></div>
                     {/if}
                  </div>
               </div>
               {/if}

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Visitors{/t}</div>
                  <div class="panel-body">
                     <p>
                        {t}Visitors{/t}: <strong>{$visitors}</strong> -  <a href="index.php?content=statisticsdetail&amp;id=1&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Detailed Statistic{/t}</a><br>
                        {t}Visited DVDs{/t}: <strong>{$profiles}</strong> - <a href="index.php?content=statisticsdetail&amp;id=2&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}Detailed Statistic{/t}</a>
                     </p>
                  </div>
               </div>

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

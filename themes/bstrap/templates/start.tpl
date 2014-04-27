{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

start.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
         
            <div class="col-lg-6">
            
               {if $news|@count > 0}
               <h2>{t}News{/t}</h2>
               {foreach from=$news item=n}
               <div class="panel panel-primary">
                  <div class="panel-heading">
                     <h3 class="panel-title">{$n->title|stripslashes} ({$n->date|date_format:$pmp_dateformat})</h3>
                  </div>
                  <div class="panel-body">{$n->text|stripslashes|nl2br}</div>
               </div>
               {/foreach}
               {/if}
            
            
               {if $new|@count > 0}
               <h2>{t c=$new|@count}The %c latest DVDs{/t}</h2>
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>{t}Cover{/t}</th>
                           <th>{t}Movie Information{/t}</th>
                           <th>{t}Purchase Information{/t}</th>
                        </tr>
                     </thead>
                     <tbody>
                        {foreach from=$new item=Film key=sch}
                        <tr>
                           <td id="ie{$Film->id}"><a href="index.php?content=filmprofile&amp;id={$Film->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><img alt="" src="thumbnail.php?id={$Film->id}&amp;type=front&amp;width=50" width="50"></a></td>
                           <td id="ia{$Film->id}"><a href="index.php?content=filmprofile&amp;id={$Film->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">
                              <strong>{$Film->Title|trunc}</strong></a><br>
                              {if $Film->Edition}<i>{$Film->Edition}</i>{/if}<br>
                              {t}Year of Production{/t}: {$Film->Year}<br>
                              {t}Running Time{/t}: {$Film->Length} {t}Minutes{/t}
                           </td>
                           <td>
                              {t}Bought{/t} {if $Film->PurchPlace != ''} {t}at{/t}&nbsp;<strong>{$Film->PurchPlace}</strong><br>
                              {/if}{if $pmp_statistic_showprice == 1}{if $Film->ConvPrice != '0.00'}{t}for{/t} {$Film->ConvPrice} {$Film->ConvCurrency} {if $Film->PurchCurrencyID != $Film->ConvCurrency}({$Film->PurchPrice} {$Film->PurchCurrencyID}){/if}{/if} {/if}{t}on{/t} {$Film->PurchDate}<br>
                              ({t}Release Date{/t}: {$Film->Released})
                           </td>
                        </tr>
                        {/foreach}
                     </tbody>
                  </table>
               </div>
               {/if}
               
               {if $ordered|@count > 0}
               <h2>{t c=$ordered|@count}The %c last ordered DVDs{/t}</h2>
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr style="background-color: #dddddd;">
                           <th>{t}Cover{/t}</th>
                           <th>{t}Movie Information{/t}</th>
                           <th>{t}Purchase Information{/t}</th>
                        </tr>
                     </thead>
                     <tbody>
                        {foreach from=$ordered item=Film key=sch}
                           <tr>
                              <td id="ie{$Film->id}" style="text-align:center"><a href="index.php?content=filmprofile&amp;id={$Film->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><img alt="" src="thumbnail.php?id={$Film->id}&amp;type=front&amp;width=50" width="50"></a></td>
                              <td id="ia{$Film->id}">
                                 <a href="index.php?content=filmprofile&amp;id={$Film->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><strong>{$Film->Title|trunc}</strong></a><br>
                                 {if $Film->Edition}<i>{$Film->Edition}</i>{/if}<br>
                                 {t}Year of Production{/t}: {$Film->Year}<br>{t}Running Time{/t}: {$Film->Length} {t}Minutes{/t}
                              </td>
                              <td>
                                 {t}Ordered {/t} {if $Film->PurchPlace != ''}{t}at{/t}&nbsp;<strong>{$Film->PurchPlace}</strong><br>
                                 {/if}{if $pmp_statistic_showprice == 1}{if $Film->ConvPrice != '0.00'}{t}for{/t} {$Film->ConvPrice} {$Film->ConvCurrency} {if $Film->PurchCurrencyID != $Film->ConvCurrency}({$Film->PurchPrice} {$Film->PurchCurrencyID}){/if}{/if} {/if}{t}the{/t} {$Film->PurchDate}<br><br>({t}Release Date{/t}: {$Film->Released})
                              </td>
                           </tr>
                        {/foreach}
                     </tbody>
                  </table>
               </div>
               {/if}
            
               <ul class="list-group">
                  <li class="list-group-item"><span class="badge">{$count}</span>{t}DVDs{/t}</li>
                  <li class="list-group-item"><span class="badge">{$counter.all}</span>{t}Visitors{/t}</li>
                  <li class="list-group-item"><span class="badge">{$counter.today}</span>{t}Visitors{/t} {t}today{/t}</li>
               </ul>
                  
            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

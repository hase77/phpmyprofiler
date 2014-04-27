{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

news.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

            <div class="col-lg-6">

               <h2>{t}News Archive{/t}</h2>

               <ul class="list-group">
                  <li class="list-group-item"><span class="badge">{$count}</span>{t}Number of news{/t}</li>
               </ul>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}News Archive{/t}</div>
                  <div class="panel-body">
                     {foreach from=$news item=n}
                        <div class="panel panel-default">
                           <div class="panel-heading">
                              {$n->date|date_format:$pmp_dateformat}:&nbsp;<strong>{$n->title|stripslashes}</strong>
                           </div>
                           <div class="panel-body">
                              {$n->text|stripslashes|nl2br}
                           </div>
                        </div>
                     {/foreach}
                  </div>
               </div>

               {if $pages > 1}
               <ul class="pagination">
                  {if $page > 1}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page=1&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;&lt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$page-1}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;</a></li>
                  {else}
                     <li><a href="#">&lt;&lt;</a></li>
                     <li><a href="#">&lt;</a></li>
                  {/if}
                  {section name="Pages" start=1 loop=$pages+1}
                     {if ( $smarty.section.Pages.index == 1 ) || ( $page == $smarty.section.Pages.index - 3 ) || ( $page == $smarty.section.Pages.index - 2 ) || ( $page == $smarty.section.Pages.index - 1 ) || ( $page == $smarty.section.Pages.index ) || ( $page == $smarty.section.Pages.index + 1 ) || ( $page == $smarty.section.Pages.index + 2 ) || ( $page == $smarty.section.Pages.index + 3 ) || ( $smarty.section.Pages.index == $pages )}
                        {if ( $smarty.section.Pages.index == $pages ) && ( $page < $smarty.section.Pages.index - 4 )}
                           <li><a href="#">...</a></li>
                        {/if}
                        {if $page == $smarty.section.Pages.index}
                           <li class="active"><a href="#">{$smarty.section.Pages.index}</a></li>
                        {else}
                           <li><a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$smarty.section.Pages.index}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$smarty.section.Pages.index}</a></li>
                        {/if}
                        {if ( $smarty.section.Pages.index == 1 ) && ( $page > 5 )}
                           <li><a href="#">...</a></li>
                        {/if}
                     {/if}
                  {/section}
                  {if $page < $pages}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$page+1}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=news&amp;page={$pages}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;&gt;</a></li>
                  {else}
                     <li><a href="#">&gt;</a></li>
                     <li><a href="#">&gt;&gt;</a></li>
                  {/if}
               </ul>
               {/if}

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

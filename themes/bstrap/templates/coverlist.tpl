{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

coverlist.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

            <div class="col-lg-6">

               <h2>{t}Cover Gallery{/t}</h2>

               <ul class="list-group">
                  <li class="list-group-item"><span class="badge">{$count}</span>{t}Number of covers{/t}</li>
               </ul>
               
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <tbody>
                        <tr>
                           {assign var="counter" value="0"}
                           {foreach from=$cover item=c name=cover}   
                              {assign var="counter" value="$counter+1"}
                              {assign var="hundred" value="100"}
                              <td style="text-align:center; width: {$hundred/$pmp_cover_per_row}%;">
                                 <p><a href="index.php?content=filmprofile&amp;id={$c->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}" title="{$c->Title}"><img src="thumbnail.php?id={$c->id}&amp;type=front&amp;width=120" alt="{$c->Title}" width="120"></a></p>
                                 <p><a href="index.php?content=filmprofile&amp;id={$c->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$c->Title}</a></p>
                              </td>
                              {if $smarty.foreach.cover.iteration%$pmp_cover_per_row == '0'}
                                 </tr>
                                 <tr>
                                 {assign var="counter" value="0"} 
                              {/if}
                           {/foreach}
                           {if $counter != $pmp_cover_per_row}<td colspan="{$pmp_cover_per_row-$counter}">&nbsp;</td>{/if}
                        </tr>
                     </tbody>
                  </table>
               </div>

               {if $pages > 1}
               <ul class="pagination">
                  {if $page > 1}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page=1&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;&lt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$page-1}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;</a></li>
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
                           <li><a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$smarty.section.Pages.index}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$smarty.section.Pages.index}</a></li>
                        {/if}
                        {if ( $smarty.section.Pages.index == 1 ) && ( $page > 5 )}
                           <li><a href="#">...</a></li>
                        {/if}
                     {/if}
                  {/section}
                  {if $page < $pages}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$page+1}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=coverlist&amp;page={$pages}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;&gt;</a></li>
                  {else}
                     <li><a href="#">&gt;</a></li>
                     <li><a href="#">&gt;&gt;</a></li>
                  {/if}
               </ul>
               {/if}

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

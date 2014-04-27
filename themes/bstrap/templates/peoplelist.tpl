{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

peoplelist.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
            
            <div class="col-lg-6">

               <h2>{t}People Gallery{/t}</h2>

               <ul class="list-group">
                  <li class="list-group-item"><span class="badge">{$count}</span>{t}Cast and Crew Images{/t}{if $pletter!=''}&nbsp;{t}starting with{/t}&nbsp;{$pletter}{/if}</li>
               </ul>

               <ul class="pagination pagiantion-sm">
                  {if isset($letter)}
                     <li><a href="index.php?content=peoplelist&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}All{/t}</a></li>
                  {else}
                     <li class="active"><a href="#">{t}All{/t}</a></li>
                  {/if}
                  {foreach from=$alphabet item=letts}
                     {if isset($letter) && $letts == $letter}
                        <li class="active"><a href="#">{$letts}</a></li>
                     {else}
                        <li><a href="index.php?content=peoplelist&amp;pletter={$letts}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$letts}</a></li>
                     {/if}
                  {/foreach}
               </ul>
               
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <tbody>
                        <tr>
                           {assign var="hundred" value=100}
                           {assign var="counter" value=0}   
                           {foreach from=$person item=p name=person}   
                              {assign var="counter" value=$counter+1}   
                              <td style="text-align:center; width: {$hundred/$pmp_cover_per_row}%;">
                                 <p><a href="index.php?content=searchperson&amp;name={$p.Name|rawurlencode}&amp;nowildcards{if isset($p.Birthyear)}&amp;birthyear={$p.Birthyear}{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}"><img src="{$pmp_dir_cast}{$p.File|rawurlencode}" alt="{$p.file}" width="100"></a></p>
                                 <p><a href="index.php?content=searchperson&amp;name={$p.Name|rawurlencode}&amp;nowildcards{if isset($p.Birthyear)}&amp;birthyear={$p.Birthyear}{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$p.Name} {if isset($p.Birthyear)} ({$p.Birthyear}){/if}</a></p>
                              </td>
                              {if $smarty.foreach.person.iteration%$pmp_people_per_row == '0'}
                                 </tr>
                                 <tr>
                                 {assign var="counter" value="0"} 
                              {/if}
                           {/foreach}
                           {if $counter != $pmp_people_per_row}<td colspan="{$pmp_people_per_row-$counter}"></td>{/if}
                        </tr>
                     </tbody>
                  </table>
               </div>

               {if $pages > 1}
               <ul class="pagination">
                  {if $page > 1}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page=1&amp;pletter={$pletter}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;&lt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$page-1}&amp;pletter={$pletter}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;</a></li>
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
                           <li><a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$smarty.section.Pages.index}&amp;pletter={$pletter}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$smarty.section.Pages.index}</a></li>
                        {/if}
                        {if ( $smarty.section.Pages.index == 1 ) && ( $page > 5 )}
                           <li><a href="#">...</a></li>
                        {/if}
                     {/if}
                  {/section}
                  {if $page < $pages}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$page+1}&amp;pletter={$pletter}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=peoplelist&amp;page={$pages}&amp;pletter={$pletter}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;&gt;</a></li>
                  {else}
                     <li><a href="#">&gt;</a></li>
                     <li><a href="#">&gt;&gt;</a></li>
                  {/if}
               </ul>
               {/if}

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

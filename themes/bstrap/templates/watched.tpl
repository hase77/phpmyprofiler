{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

watched.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
         
            <div class="col-lg-6">

               <h2>{t}Watched{/t}</h2>

               <div class="panel panel-primary">
                  <div class="panel-heading">Total</div>
                  <div class="panel-body">
                     {t}Viewer{/t}:&nbsp;&nbsp;<strong>{$persons|@count}</strong><br>
                     {foreach from=$results item=result}
                        {t}Total Running Time{/t} ({t}Days{/t} : {t}Hours{/t} : {t}Minutes{/t}):&nbsp;&nbsp;<strong>{$result->days} : {$result->hours} : {$result->minutes}</strong><br>
                        {t}Titles Watched{/t}:&nbsp;&nbsp;<strong>{$result->cnt}</strong><br>
                        {t}Average Running Time{/t}:&nbsp;&nbsp;<strong>{$result->avg} min</strong>
                     {/foreach} 
                  </div>
               </div>

               {foreach from=$persons item=person key=s1}
               <div class="panel panel-default">
                  <div class="panel-heading"><a href="{if $fn neq $person->firstname or $ln neq $person->lastname}?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}{else}?content=watched{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$person->firstname} {$person->lastname}</a></div>
                  <div class="panel-body">
                     <p>
                        {t}Total Running Time{/t} ({t}Days{/t} : {t}Hours{/t} : {t}Minutes{/t}):&nbsp;&nbsp;<strong>{$person->days} : {$person->hours} : {$person->minutes}</strong><br>
                        {t}Titles Watched{/t}:&nbsp;&nbsp;<strong>{$person->cnt}</strong><br>
                        {t}Average Running Time{/t}:&nbsp;&nbsp;<strong>{$person->avg} min</strong>
                     </p>
                     <ul style="padding-left: 16px;">
                        {foreach from=$years item=year key=s2}
                           {if $person->lastname eq $year->lastname & $person->firstname eq $year->firstname}
                              <li><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={if $yr neq $year->year}{$year->year}{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$year->year}</a></li>
                              <ul style="padding-left: 16px;">
                                 {foreach from=$months item=month key=s3}
                                    {if $year->year eq $month->year}
                                       <li><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={$year->year}&amp;month={if $mo neq $month->month}{$month->month}{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}{$month->monthname}{/t}</a></li>
                                       <ul style="padding-left: 16px;">
                                          {foreach from=$movies item=movie name=movie key=s4}
                                             {if $month->month eq $movie->month}
                                                <li><a href="index.php?content=filmprofile&amp;id={$movie->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$movie->title}</a> | {$movie->runningtime} min | {$movie->date}</li>
                                             {/if}
                                          {/foreach}
                                       </ul>
                                    {/if}
                                 {/foreach}         
                              </ul>
                           {/if}
                        {/foreach}  
                     </ul>
                  </div>
               </div>
               {/foreach}

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->


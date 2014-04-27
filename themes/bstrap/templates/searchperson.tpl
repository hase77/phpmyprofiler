{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

searchperson.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

            <div class="col-lg-6">

               <h2>{t}Search for Person{/t}</h2>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Search{/t} {t}Details{/t}</div>
                  <div class="panel-body">
                     {t}Searched for{/t}:&nbsp;'{$name}'<br>
                     {$cast|@count}&nbsp;(Cast)&nbsp;+&nbsp;{$crew|@count}&nbsp;(Crew)&nbsp;{t}records found in this DVD Collection{/t}<br>
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Cast{/t}</div>
                  <div class="panel-body">
                     {assign var="count" value=1}
                     {foreach from=$cast item=pers}
                        {assign var="this_value" value=$pers}
                        {if !isset($last_value) or (($last_value->fullname != $pers->fullname) or $last_value->birthyear != $pers->birthyear)}
                           <div class="panel panel-default">
                              <div class="panel-heading">{$pers->fullname|colorname:$pers->firstname:$pers->middlename:$pers->lastname} {if $pers->birthyear != ''}({$pers->birthyear}){/if}</div>
                              <div class="panel-body">
                                 <div class="col-lg-12">
                                    <div class="col-lg-3">
                                       <img src="{$pmp_dir_cast}/{$pers->picname}" alt="{$pers->fullname}">
                                    </div>
                                    <div class="col-lg-9">
                                       {assign var="movie_id" value=null}
                                       {foreach from=$cast item=pers1}
                                          {if ($pers1->fullname eq $this_value->fullname) and $pers1->birthyear eq $this_value->birthyear}
                                             <div class="col-lg-12" style="border-bottom: 1px dotted #999999; padding: 4px 0 4px 0;">
                                                {if $movie_id != $pers1->DVD->id}
                                                   <div class="col-lg-6"><a href="index.php?content=filmprofile&amp;id={$pers1->DVD->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$pers1->DVD->Title}</a></div>
                                                {else}
                                                   <div class="col-lg-6"></div>
                                                {/if}
                                                <div class="col-lg-6">{if $pers1->role != ''}{t}as{/t} {$pers1->role}{if $pers1->creditedas}&nbsp;({t}credited as{/t}:&nbsp;{$pers1->creditedas}){/if}{/if}{if $pers1->episodes>1} {t}in{/t} {$pers1->episodes} {t}episodes{/t}{/if}</div>
                                             </div>
                                          {/if}
                                          {assign var="movie_id" value=$pers1->DVD->id}
                                      {/foreach}
                                    </div>
                                 </div>
                              </div>
                           </div>
                           {assign var="count" value=$count+1}
                        {/if}
                        {assign var="last_value" value=$pers}
                     {/foreach}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Crew{/t}</div>
                  <div class="panel-body">
                     {assign var="count" value=1}
                     {foreach from=$crew item=pers}
                        {assign var="this_value" value=$pers}
                        {if !isset($last_value2) or (($last_value2->fullname != $pers->fullname) or $last_value2->birthyear != $pers->birthyear)}
                           <div class="panel panel-default">
                              <div class="panel-heading">{$pers->fullname|colorname:$pers->firstname:$pers->middlename:$pers->lastname} {if $pers->birthyear != ''}({$pers->birthyear}){/if}</div>
                              <div class="panel-body">
                                 <div  class="col-lg-12">
                                    <div class="col-lg-3">
                                       <img src="{$pmp_dir_cast}/{$pers->picname}" alt="{$pers->fullname}"><br>
                                    </div>
                                    <div class="col-lg-9">
                                       {assign var="movie_id" value=null}
                                       {foreach from=$crew item=pers1}
                                          {if ($pers1->fullname eq $this_value->fullname) and $pers1->birthyear eq $this_value->birthyear}
                                             <div class="col-lg-12" style="border-bottom: 1px dotted #999999;">
                                                {if $movie_id != $pers1->DVD->id}
                                                   <div class="col-lg-6"><a href="index.php?content=filmprofile&amp;id={$pers1->DVD->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$pers1->DVD->Title}</a></div>
                                                {else}
                                                   <div class="col-lg-6"></div>
                                                {/if}
                                                <div class="col-lg-6">{t}{$pers1->subtype}{/t}{if $pers1->creditedas}&nbsp;({t}credited as{/t}:&nbsp;{$pers1->creditedas}){/if}</div>
                                             </div>
                                          {/if}
                                          {assign var="movie_id" value=$pers1->DVD->id}
                                      {/foreach}
                                    </div>
                                 </div>
                              </div>
                           </div>
                           {assign var="count" value=$count+1}
                        {/if}
                        {assign var="last_value2" value=$pers}
                     {/foreach}
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}International{/t} {t}Search{/t}</div>
                  <div class="panel-body">
                     <a href="http://www.imdb.com/find?q={$name|rawurlencode}">{t}IMDB Search{/t}</a><br>
                     <a href="http://www.wikipedia.org/wiki/{$name|rawurlencode}">{t}Wikipedia Search{/t}</a><br>
                     {if $smarty.session.lang_id == 'de'}
                        <br><b>{t}German{/t}:</b><br>
                        <a href="http://www.imdb.de/find?q={$name|rawurlencode}">{t}IMDB Search{/t}</a><br>
                        <a href="http://www.ofdb.de/view.php?page=suchergebnis&amp;Kat=Person&amp;SText={$name|rawurlencode}">{t}OFDB Search{/t}</a><br>
                        <a href="http://de.wikipedia.org/wiki/{$name|rawurlencode}">{t}Wikipedia Search{/t}</a><br>
                        <a href="http://www.synchronkartei.de/search.php?cat=1&amp;search={$name|rawurlencode}">{t}Deutsche Synchronkartei{/t}</a><br>
                     {elseif $smarty.session.lang_id == 'nl'}
                        <br><b>{t}Dutch{/t}:</b><br>
                        <a href="http://nl.wikipedia.org/wiki/{$name|rawurlencode}">{t}Wikipedia Search{/t}</a><br>
                     {/if}
                  </div>
               </div>

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

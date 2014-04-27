{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

menue.tpl

===============================================================================
*}
         {assign "pmp_theme_css" "bootstrap.css"}
         {assign "showlist" "Owned"}
         {if isset($smarty.session.skin) && $smarty.get.skin != ""}{$pmp_theme_css = $smarty.get.skin} {/if}
         {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
         {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
         
         {if isset($Error) && $Error != ''}
         <div class="row">
            <div class="col-lg-12">
               <div class="alert alert-dismissable alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>{t}Sorry, an error has occurred{/t}!</strong><br>
                  {$Error}
               </div>
            </div>
         </div>
         {/if}
      
         <div class="row">
            <div class="col-lg-6">

               <h2 id="nav-tabs">Movies</h2>
               <ul class="nav nav-pills">
                  {if $showlist == "Owned"}
                     <li class="active"><a href="#">{t}Owned{/t} ({$count})</a></li>
                  {else}
                     <li><a href="index.php?addwhere=collectiontype&amp;delwhere=collectiontype&amp;whereval=Owned&amp;showlist=Owned&amp;skin={$pmp_theme_css}">{t}Owned{/t}</a></li>
                  {/if}
                  {if $showlist == "Ordered"}
                     <li class="active"><a href="#">{t}Ordered{/t} ({$count})</a></li>
                  {else}
                     <li><a href="index.php?addwhere=collectiontype&amp;delwhere=collectiontype&amp;whereval=Ordered&amp;showlist=Ordered&amp;skin={$pmp_theme_css}">{t}Ordered{/t}</a></li>
                  {/if}
                  {if $showlist == "Wishlist"}
                     <li class="active"><a href="#">{t}WishList{/t} ({$count})</a></li>
                  {else}
                     <li><a href="index.php?addwhere=collectiontype&amp;delwhere=collectiontype&amp;whereval=Wish%20List&amp;showlist=Wishlist&amp;skin={$pmp_theme_css}">{t}WishList{/t}</a></li>
                  {/if}
               </ul><br>
      
               <div>
                  <ul class="nav nav-tabs" style="margin-bottom: 8px;">
                     <li class="active"><a href="#result" data-toggle="tab">Result</a></li>
                     <li><a href="#filter" data-toggle="tab">Filter</a></li>
                  </ul>
                  
                  <div id="myTabContent" class="tab-content">
                     <div class="tab-pane fade active in" id="result">                              
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    {strip}
                                    {if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<th>#</th>{/if}
                                    {if isset($pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<th>{getheader column=$pmp_menue_column_1.Sort caption=$pmp_menue_column_1.Header}</th>{/if}
                                    {if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<th>{getheader column=$pmp_menue_column_2.Sort caption=$pmp_menue_column_2.Header}</th>{/if}
                                    {if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<th>{getheader column=$pmp_menue_column_3.Sort caption=$pmp_menue_column_3.Header}</th>{/if}
                                    {if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<th>{getheader column=$pmp_menue_column_4.Sort caption=$pmp_menue_column_4.Header}</th>{/if}
                                    {if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<th>{getheader column=$pmp_menue_column_5.Sort caption=$pmp_menue_column_5.Header}</th>{/if}
                                    {if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<th>{getheader column=$pmp_menue_column_6.Sort caption=$pmp_menue_column_6.Header}</th>{/if}
                                    {/strip}
                                 </tr>
                              </thead>
                              
                              <tbody>
                              {foreach from=$dvds item=dvd key=sch}
                                 {if isset($dvd->isBoxset) && $dvd->isBoxset == true && $sort == 1}<tr class="warning">{else}<tr>{/if}
                                    {strip}
                                    {if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<td style="text-align:right;">{$page*$pmp_dvd_menue+$sch+1-$pmp_dvd_menue})</td>{/if}
                                    {if isset($pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<td>{if isset($dvd->isBoxset) && $dvd->isBoxset == true && $sort == 1}<img onclick="javascript:expandBoxset('row_{$dvd->id}','img_{$dvd->id}', '{$pmp_theme}');" id="img_{$dvd->id}" style="padding-right:5px; vertical-align: middle" src="themes/{$pmp_theme}/images/plus.gif" alt="">{/if}<a href="index.php?content=filmprofile&amp;id={$dvd->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$dvd->get($pmp_menue_column_1.Output)}</a></td>{/if}
                                    {if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<td>{$dvd->get($pmp_menue_column_2.Output)}</td>{/if}
                                    {if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<td>{$dvd->get($pmp_menue_column_3.Output)}</td>{/if}
                                    {if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<td>{$dvd->get($pmp_menue_column_4.Output)}</td>{/if}
                                    {if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<td>{$dvd->get($pmp_menue_column_5.Output)}</td>{/if}
                                    {if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<td>{$dvd->get($pmp_menue_column_6.Output)}</td>{/if}
                                    {/strip}
                                 </tr>
                              
                                 {if isset($dvd->isBoxset) && $dvd->isBoxset == true && $sort == 1}
                                    <tr id="row_{$dvd->id}" style="display:none;">
                                       <td colspan="{$menue_columns}">
                                          <div class="table-responsive">
                                             <table class="table table-striped table-bordered table-hover">
                                             {foreach from=$dvd->Boxset_childs item=child}
                                                {if isset($child->isBoxset) && $child->isBoxset == true && $sort == 1}<tr class="warning">{else}<tr>{/if}
                                                   {strip}
                                                      {if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<td style="text-align:right;">{$child@iteration}</td>{/if}
                                                      {if isset( $pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<td id="id{$child->id}">{if isset($child->isBoxset) && $child->isBoxset == true && $sort == 1}<img onclick="javascript:expandBoxset('row_{$child->id}','img_{$child->id}', '{$pmp_theme}');" id="img_{$child->id}" style="padding-right:5px; vertical-align: middle" src="themes/{$pmp_theme}/images/plus.gif" alt="">{/if}<a href="index.php?content=filmprofile&amp;id={$child->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$child->get($pmp_menue_column_1.Output)}</a></td>{/if}
                                                      {if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<td>{$child->get($pmp_menue_column_2.Output)}</td>{/if}
                                                      {if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<td>{$child->get($pmp_menue_column_3.Output)}</td>{/if}
                                                      {if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<td>{$child->get($pmp_menue_column_4.Output)}</td>{/if}
                                                      {if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<td>{$child->get($pmp_menue_column_5.Output)}</td>{/if}
                                                      {if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<td>{$child->get($pmp_menue_column_6.Output)}</td>{/if}
                                                   {/strip}
                                                </tr>
                        
                                                {if isset($child->isBoxset) && $child->isBoxset == true}
                                                   <tr id="row_{$child->id}" style="display:none;">
                                                      <td colspan="{$menue_columns}">
                                                         <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover">
                                                            {foreach from=$child->Boxset_childs item=grandchild}
                                                               <tr>
                                                                  {strip}
                                                                     {if isset($pmp_menue_column_0) && $pmp_menue_column_0 == 1}<td style="text-align:right;">{$grandchild@iteration}</td>{/if}
                                                                     {if isset( $pmp_menue_column_1.Output) && $pmp_menue_column_1.Output != ''}<td id="id{$grandchild->id}"><a href="index.php?content=filmprofile&amp;id={$grandchild->id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$grandchild->get($pmp_menue_column_1.Output)}</a></td>{/if}
                                                                     {if isset($pmp_menue_column_2.Output) && $pmp_menue_column_2.Output != ''}<td>{$grandchild->get($pmp_menue_column_2.Output)}</td>{/if}
                                                                     {if isset($pmp_menue_column_3.Output) && $pmp_menue_column_3.Output != ''}<td>{$grandchild->get($pmp_menue_column_3.Output)}</td>{/if}
                                                                     {if isset($pmp_menue_column_4.Output) && $pmp_menue_column_4.Output != ''}<td>{$grandchild->get($pmp_menue_column_4.Output)}</td>{/if}
                                                                     {if isset($pmp_menue_column_5.Output) && $pmp_menue_column_5.Output != ''}<td>{$grandchild->get($pmp_menue_column_5.Output)}</td>{/if}
                                                                     {if isset($pmp_menue_column_6.Output) && $pmp_menue_column_6.Output != ''}<td>{$grandchild->get($pmp_menue_column_6.Output)}</td>{/if}
                                                                  {/strip}
                                                               </tr>
                                                            {/foreach}
                                                            </table>
                                                         </div>
                                                      </td>
                                                   </tr>
                                                {/if}
                                             {/foreach}
                                             </table>
                                          </div>
                                       </td>
                                    </tr>
                                 {/if}
                              {/foreach}
                              </tbody>
                           </table>
                        </div>

                        {if $pages > 1}
                        <ul class="pagination">
                           {if $page > 1}
                              <li><a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page=1&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;&lt;</a></li>
                              <li><a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$page-1}&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&lt;</a></li>
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
                                    <li><a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$smarty.section.Pages.index}&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$smarty.section.Pages.index}</a></li>
                                 {/if}
                                 {if ( $smarty.section.Pages.index == 1 ) && ( $page > 5 )}
                                    <li><a href="#">...</a></li>
                                 {/if}
                              {/if}
                           {/section}
                           {if $page < $pages}
                              <li><a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$page+1}&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;</a></li>
                              <li><a href="{$smarty.server.SCRIPT_NAME}?{if isset($letter)}letter={if ($letter=='#')}0{else}{$letter}{/if}&amp;{/if}list_page={$pages}&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">&gt;&gt;</a></li>
                           {else}
                              <li><a href="#">&gt;</a></li>
                              <li><a href="#">&gt;&gt;</a></li>
                           {/if}
                        </ul>
                        {/if}
                        
                     </div>
                     
                     <div class="tab-pane fade" id="filter">
                        <div class="panel panel-primary">
                           <div class="panel-heading">{t}Alphabetic filter{/t}</div>
                           <div class="panel-body">
                              <ul class="pagination pagiantion-sm">
                                 {if isset($letter)}
                                    <li><a href="{$smarty.server.SCRIPT_NAME}?letter=off&amp;list_page=1&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{t}All{/t}</a></li>
                                 {else}
                                    <li class="active"><a href="#">{t}All{/t}</a></li>
                                 {/if}
                                 {foreach from=$letters item=letts}
                                    {if isset($letter) && $letts == $letter}
                                       <li class="active"><a href="#">{$letts}</a></li>
                                    {else}
                                       {if $letts == '#'}
                                          <li><a href="{$smarty.server.SCRIPT_NAME}?letter=0&amp;list_page=1&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$letts}</a></li>
                                       {else}
                                          <li><a href="{$smarty.server.SCRIPT_NAME}?letter={$letts}&amp;list_page=1&amp;whereval={$smarty.get.whereval}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$letts}</a></li>
                                       {/if}
                                    {/if}
                                 {/foreach}
                              </ul>
                           </div>
                        </div>

                        <div class="panel panel-primary">
                           <div class="panel-heading">{t}Active Filters{/t} {t}(click filter to remove){/t}</div>
                           <div class="panel-body">
                              <div style="padding-bottom: 10px;">
                                 <button type="button" class="btn btn-default" onclick="window.location='index.php?content=search&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}';">{t}Add{/t}</button>&nbsp;
                                 <button type="button" class="btn btn-default" onclick="window.location='index.php?reset=1&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}';">{t}Remove all{/t}</button>
                              </div>
                              <div class="panel panel-default">
                                 <div class="panel-body">
                                    {foreach from=$locations item=loc name=loc}
                                       {getfilter filter="locality" value=$loc caption=$loc|flag show_inactive='False' class='flagfilter'}
                                    {/foreach}
                                    {foreach from=$origins item=origin name=origin}
                                       {assign var="country" value="country[dot]$origin"}
                                       {getfilter filter="pmp_countries_of_origin[dot]id" value=$country caption=$origin|flag show_inactive='False' class='flagfilter'} 
                                    {/foreach}
                                    {if $extFilter|count > 0}
                                       {foreach from=$extFilter item=extFlt name=extFilter}
                                          {getfilter filter=$extFlt.field value=$extFlt.value caption=$extFlt.caption show_inactive='False'}
                                       {/foreach}
                                    {/if}
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                                                   
                  </div> <!-- tab-content -->
                  
               </div>
            </div> <!-- col-lg-6 -->

{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

preferences.tpl

===============================================================================
*}

{include file="admin/header.tpl"}
{include file="admin/mainerror.tpl"}

{assign var="showbanner" value=0}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Preferences{/t}</div>
      <div class="panel-body">
         <ul class="nav nav-tabs" style="margin-bottom: 8px;">
            {foreach item=Option from=$Options}
               {if $Option|@is_string}
                  <li {if $Option eq 'Main settings'}class="active"{/if}><a href="#pref{$Option@iteration}" data-toggle="tab">{t}{$Option}{/t}</a></li>
               {/if}
            {/foreach}
         </ul>
            
         <div id="myTabContent" class="tab-content">
            {foreach item=Option from=$Options}
               {if $Option|@is_string}
                  {if $Option@iteration > 1}
                  
                     {if $Option=="Graphic settings" AND $showbanner}
                           <div class="nav-tabs">
                              <div class="form-group" style="padding-top: 12px;">
                                 <label for="showbanner" class="col-lg-12 control-label" style="text-align: left;">{t}Your current signature banners{/t}<br><span style="font-weight: normal;">{t}Your signature banner images are created automatically when you parse a collection and saved in the 'cache' folder.{/t}</span><br><br></label>
                                 <div class="col-lg-12">
                                    {if $showbanner==1 OR $showbanner==3}
                                       <img src="../cache/added_banner.png" alt="" title="added_banner.png">
                                    {/if}
                                    {if $showbanner==2 OR $showbanner==3}
                                       <br><br><img src="../cache/watched_banner.png" alt="" title="watched_banner.png">
                                    {/if}
                                 </div>
                              </div>
                           </div>
                     {/if}
                     
                           <div class="form-group" style="padding-top: 12px;">
                              <div class="col-lg-12">
                                 <button type="submit" class="btn btn-default{if isset($Error) && $Error != ''} disabled{/if}">{t}Save configuration{/t}</button>
                                 <button type="reset" class="btn btn-default{if isset($Error) && $Error != ''} disabled{/if}">{t}Reset{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                  </div>
                  {/if}
                  <div class="tab-pane fade in{if $Option eq 'Main settings'} active{/if}" id="pref{$Option@iteration}">
                     <form class="bs-example form-horizontal" method="post" action="preferences.php?action=save&amp;{$session}" target="_self" accept-charset="utf-8">
                        <fieldset>
               {else}
                           <div class="nav-tabs" style="padding-top: 8px;">
                              <div class="form-group">
                                 <label for="{$Option->Var}" class="col-lg-8 control-label" style="text-align: left;">{t}{$Option->Name}{/t}<br><span style="font-weight: normal;">{t}{$Option->Description}{/t}</span></label>
                                 <div class="col-lg-4">
                                    {if $Option->Child == 1}
                                       <input class="form-control" type="text" name="{$Option->Var}" id="{$Option->Var}" value="{$Option->Value}">
                                    {else}
                                       {if $Option->Child == 3}
                                          <input class="form-control" type="password" name="{$Option->Var}" id="{$Option->Var}" value="{$Option->Value}">
                                       {else}
                                          <select class="form-control" id="{$Option->Var}" name="{$Option->Var}">
                                             {foreach item=Item from=$Option->Optionlist key=value}
                                                <option value="{$value}" {if $value==$Option->Value}selected="selected"{/if}>{t}{$Item}{/t}</option>
                                             {/foreach}
                                          </select>
                                       {/if}
                                    {/if}
                                 </div>
                              </div>
                           </div>
                           
                  {if $Option->Name=="Build banners for use in a signature" && $Option->Value != "0"}
                     {$showbanner = $Option->Value}
                  {/if}
                  
               {/if}
            {/foreach}
                        
                        <div class="form-group" style="padding-top: 12px;">
                           <div class="col-lg-12">
                              <button type="submit" class="btn btn-default{if isset($Error) && $Error != ''} disabled{/if}">{t}Save configuration{/t}</button>
                              <button type="reset" class="btn btn-default{if isset($Error) && $Error != ''} disabled{/if}">{t}Reset{/t}</button>
                           </div>
                        </div>
                     </fieldset>
                  </form>
               </div>
         </div>
      </div>
   </div>
   
</div>                              

{include file="admin/footer.tpl"}

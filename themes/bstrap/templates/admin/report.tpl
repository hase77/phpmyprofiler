{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

report.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Print listing{/t}</div>
      <div class="panel-body">
         <p>
            {t}Please select the columns that will appear in the report:{/t}
         </p>
         <form class="bs-example form-horizontal" method="post" action="report.php?{$session}" target="_self" accept-charset="utf-8">
            <fieldset>
               {foreach item=Option from=$columns key=sch}
                  <div class="nav-tabs" style="padding-top: 8px;">
                     <div class="form-group">
                        <label for="{$Option->Var}" class="col-lg-6 control-label" style="text-align: left;">{t}{$Option->Name}{/t}</label>
                        <div class="col-lg-6">
                           <select class="form-control" id="{$Option->Var}" name="{$Option->Var}">
                              {foreach item=Value from=$Option->Optionlist key=value}
                                  <option value="{$value}" {if $value==$Option->Value}selected="selected"{/if}>{t}{$Value}{/t}</option>
                              {/foreach}
                           </select>
                        </div>
                     </div>
                  </div>
               {/foreach}
               
               <div class="nav-tabs" style="padding-top: 8px;">
                  <div class="form-group">
                     <label for="sortby" class="col-lg-6 control-label" style="text-align: left;">{t}Sort Order{/t}</label>
                     <div class="col-lg-6">
                        <select class="form-control" id="sortby" name="sortby">
                           {foreach item=Value from=$Option->Optionlist key=value}
                              <option value="{$value}" {if $value==$pmp_menue_sortby}selected="selected"{/if}>{t}{$Value}{/t}</option>
                           {/foreach}
                        </select>
                     </div>
                  </div>
               </div>
               
               <div class="nav-tabs" style="padding-top: 8px;">
                  <div class="form-group">
                     <label for="sortdir" class="col-lg-6 control-label" style="text-align: left;">{t}Sort Order Direction{/t}</label>
                     <div class="col-lg-6">
                        <select class="form-control" id="sortdir" name="sortdir">
                           <option value="asc" {if $pmp_menue_sortdir==asc}selected="selected"{/if}>{t}Ascending{/t}</option>
                           <option value="desc" {if $pmp_menue_sortdir==desc}selected="selected"{/if}>{t}Descending{/t}</option>
                        </select>
                     </div>
                  </div>
               </div>
               
               <div class="nav-tabs" style="padding-top: 8px;">
                  <div class="form-group">
                     <label for="where" class="col-lg-6 control-label" style="text-align: left;">{t}Owned, Ordered, WishList or all DVDs{/t}</label>
                     <div class="col-lg-6">
                        <select class="form-control" id="where" name="where">
                           <option value="Owned" selected="selected">{t}Owned{/t}</option>
                           <option value="Ordered">{t}Ordered{/t}</option>
                           <option value="WishList">{t}WishList{/t}</option>
                           <option value="All">{t}All{/t}</option>
                        </select>
                     </div>
                  </div>
               </div>
               
               <div class="nav-tabs" style="padding-top: 8px;">
                  <div class="form-group">
                     <label class="col-lg-6 control-label" style="text-align: left;">&nbsp;</label>
                     <div class="col-lg-6">
                        <input type="radio" name="report" value="html" checked="checked"> {t}Generate HTML-Report{/t}<br>
                        <input type="radio" name="report" value="pdf"> {t}Generate PDF-Report{/t}<br>
                     </div>
                  </div>
               </div>
               
               <div class="nav-tabs" style="padding-top: 8px;">
                  <div class="form-group">
                     <label for="usequery" class="col-lg-6 control-label" style="text-align: left;">&nbsp;</label>
                     <div class="col-lg-6">
                        <input type="checkbox" id="usequery" name="usequery" value="true" {if isset($smarty.get.usequery) && $smarty.get.usequery == 'true'}checked="checked"{/if}> {t}Use filters from main list{/t}<br>
                     </div>
                  </div>
               </div>
               
               <div style="padding-top: 8px;">
                  <div class="col-lg-6 col-lg-offset-6">
                     <button type="submit" class="btn btn-default">{t}Generate Report{/t}</button>
                  </div>
               </div>
            </fieldset>
         </form>
         
      </div>
   </div>
</div>

{include file="admin/footer.tpl"}


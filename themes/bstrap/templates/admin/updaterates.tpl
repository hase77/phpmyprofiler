{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

updaterates.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Actual Rates (Base: Euro){/t}</div>
      <div class="panel-body">
         {if $rates|@count > 0}
            <div class="table-responsive">
               <table class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th>{t}Currency{/t}</th>
                        <th>{t}Rate{/t}</th>
                     </tr>
                  </thead>
                  <tbody>
                  {foreach from=$rates item=rate key=sch}
                     <tr>
                         <td>{$rate->id}</td>
                         <td>{$rate->rate}</td>
                     </tr>
                  </tbody>
                  {/foreach}
               </table>
            </div>
            <p>{t}Rates last updated:{/t} {$rate->date|date_format:$pmp_dateformat}</p>
            <button type="button" class="btn btn-default" tabindex="1" onclick="window.location='updaterates.php?action=update&amp;{$session}';">{t}Click here to update your rates.{/t}</button><br>
            <div class="pull-right"><a class="button" href="http://www.ecb.int/stats/exchange/eurofxref/html/index.en.html">{t}We're using rates from the European Central Bank (ECB).{/t}</a></div>
         {else}
            <p>{t}Found no rates in database. Please update with the button below.{/t}</p>
         {/if}
      </div>
   </div>
   
</div>

{include file="admin/footer.tpl"}

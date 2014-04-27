{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

filmprofile_page3.tpl

===============================================================================
*}

{assign "pmp_theme_css" "bootstrap.css"}
{assign "showlist" "Owned"}
{if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
{if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
{if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

{assign var="last_value" value=""}
{assign var="last_type" value=""}

{if !empty($dvd->Cast)}
<div class="table-responsive">

   <table class="table table-striped table-bordered">
      <thead>
         <tr class="active">
            <th colspan="3" class="warning">{t}Cast{/t}</th>
         </tr>
         <tr>
            <th colspan="2">{t}Actor{/t}</th>
            <th>{t}Role{/t}</th>
         </tr>
      </thead>
      <tbody>
         {foreach from=$dvd->Cast item=value key=sch}
            {if $value->full != '[DIVIDER]'}
               <tr>
                  {strip}
                  <td style="text-align:center;">
                     {if $value->pic}
                        <a href="javascript:void(0);" onmouseover="return overlib('<img src={$pmp_dir_cast}{$value->picname}>', WIDTH, '100', MOUSEOFF);" onmouseout="return nd();">
                           <span class="glyphicon glyphicon-camera" style="color: #999999; font-size: 14px;"></span>
                        </a>
                     {/if}
                  </td>
                  <td>
                     {if $last_value != $value->full}
                        <a href="index.php?content=searchperson&amp;name={$value->full_encoded}&amp;nowildcards{if $value->birthyear != ''}&amp;birthyear={$value->birthyear}{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{if $value->creditedas != ''}{$value->creditedas}{else}{$value->full|colorname:$value->firstname:$value->middlename:$value->lastname}{/if}</a>
                     {/if}
                  </td>
                  <td>
                     {$value->role}{if $value->uncredited || $value->voice}&nbsp;({if $value->uncredited}{t}uncredited{/t}{if $value->voice},&nbsp;{/if}{/if}{if $value->voice}{t}voice{/t}{/if}){/if}
                  </td>
                  {assign var="last_value" value=$value->full}
                  {/strip}
               </tr>
            {else}
               <tr>
                  {if $value->role == 'Group'}
                     <td style="height:12px;font-size:10px;padding:4px;" colspan="3">
                  {elseif $value->role == 'EndDiv'}
                     <td style="height:6px;font-size:10px;padding:1px;" colspan="3">
                  {else}
                     <td style="height:12px;font-size:10px;padding:4px;" colspan="3">
                  {/if}
                     {$value->creditedas}
                  </td>
               </tr>
            {/if}
         {/foreach}
      </tbody>
   </table>

   {if !empty($dvd->Credits)}
   <table class="table table-striped table-bordered">
      <thead>
         <tr class="active">
            <th colspan="3" class="warning">{t}Cast{/t}</th>
         </tr>
      </thead>
      <tbody>
         {assign var="sch" value="0"}
         {foreach from=$dvd->Credits item=value}
            {if $value->full != '[DIVIDER]'}
               {if $last_type != $value->type}
                  <tr>
                     <td colspan="3">
                        <strong>{t}{$value->type}{/t}</strong>
                     </td>
                     {assign var="sch" value=$sch+1}
                  </tr>
               {/if}
               <tr>
                  <td>
                     {if $value->pic}
                        <a href="javascript:void(0);" onmouseover="return overlib('<img src={$pmp_dir_cast}{$value->picname}>', WIDTH, '100', MOUSEOFF);" onmouseout="return nd();">
                           <span class="glyphicon glyphicon-camera" style="color: #999999; font-size: 14px;"></span>
                        </a>
                     {/if}
                  </td>
                  <td>
                     <a href="index.php?content=searchperson&amp;name={$value->full_encoded}&amp;nowildcards{if $value->birthyear != ''}&amp;birthyear={$value->birthyear}{/if}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{if $value->creditedas != ''}{$value->creditedas}{else}{$value->full|colorname:$value->firstname:$value->middlename:$value->lastname}{/if}</a>
                  </td>
                  <td>
                     {t}{$value->subtype}{/t}
                  </td>
               </tr>
               {assign var="last_type" value=$value->type}
            {else}
               <tr>
                  {if $value->type == 'Group'}
                     <td style="height:12px;font-size:10px;padding:4px;" colspan="3">
                  {elseif $value->type == 'EndDiv'}
                     <td style="height:6px;font-size:10px;padding:1px;" colspan="3">
                  {else}
                     <td style="height:12px;font-size:10px;padding:4px;" colspan="3">
                  {/if}
                     {$value->creditedas}
                  </td>
               </tr>
            {/if}
            {assign var="sch" value=$sch+1}
         {/foreach}
      </tbody>
   </table>
   {/if}

</div>
{/if}

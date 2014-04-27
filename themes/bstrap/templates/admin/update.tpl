{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

update.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Refresh database{/t}</div>
      <div class="panel-body">

         {if $StateDB < $StateUpdate}
            <div class="panel panel-danger">
               <div class="panel-heading">{t}Your database is not up-to-date{/t}</div>
               <div class="panel-body">
         {else}
            <div class="panel panel-success">
               <div class="panel-heading">{t}Your database is up-to-date{/t}</div>
               <div class="panel-body">
         {/if}
         
               <ul class="list-group">
                  <li class="list-group-item"><span class="badge">{if $StateDB == -1}{t}no information available{/t}{else}{$StateDB} ({t}latest changes:{/t} {$StateDBTime}){/if}</span> {t}Version database:{/t}</li>
                  <li class="list-group-item"><span class="badge">{$StateUpdate}</span> {t}Version Update{/t}:</li>
               </ul>
      
               {if $StateDB < $StateUpdate}
                  <p>{t}Please backup your installation before you proceed!{/t}</p>
                  <p>
                     <button type="button" class="btn btn-default" onclick="window.location='update.php?action=doupdate&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Process update{/t}</button>
                  </p>
               {/if}
            </div>
         </div>
      </div>
   </div>
   
</div>

{include file="admin/footer.tpl"}

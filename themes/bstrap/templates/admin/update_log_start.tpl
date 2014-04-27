{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

update_log_start.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Refresh database{/t}</div>
      <div class="panel-body">
         
         <ul class="list-group">
            <li class="list-group-item"><span class="badge">{if $StateDB == -1}{t}no information available{/t}{else}{$StateDB} ({t}latest changes:{/t} {$StateDBTime}){/if}</span> {t}Version database:{/t}</li>
            <li class="list-group-item"><span class="badge">{$StateUpdate}</span> {t}Version Update{/t}:</li>
         </ul>
         
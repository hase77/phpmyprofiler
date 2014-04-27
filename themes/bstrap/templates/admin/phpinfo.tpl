{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

phpinfo.tpl

===============================================================================
*}

{include file="admin/header.tpl"}


<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}PHP Info{/t}</div>
      <div class="panel-body">
         {$phpinfo}
      </div>
   </div>
   
</div>

{include file="admin/footer.tpl"}
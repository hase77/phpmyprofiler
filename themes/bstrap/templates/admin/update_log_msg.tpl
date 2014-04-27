{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

update_log_msg.tpl

===============================================================================
*}

{if $type == 'S'}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Success{/t}:</strong><br>
            {t}{$msg}{/t}
         </div>
      </div>
   </div>
{elseif $type == 'I'}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Information{/t}</strong><br>
            {t}{$msg}{/t}
         </div>
      </div>
   </div>
{elseif $type == 'W'}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Warning{/t}</strong><br>
            {t}{$msg}{/t}
         </div>
      </div>
   </div>
{elseif $type == 'E'}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Sorry, an error has occurred{/t}:</strong><br>
            {t}{$msg}{/t}
         </div>
      </div>
   </div>
{/if}

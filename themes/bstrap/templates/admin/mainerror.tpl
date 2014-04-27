{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

mainerror.tpl

===============================================================================
*}

{if isset($Success)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Success{/t}:</strong><br>
            {$Success}
         </div>
      </div>
   </div>
{/if}

{if isset($Info)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Information{/t}</strong><br>
            {$Info}
         </div>
      </div>
   </div>
{/if}

{if isset($Warning)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Warning{/t}</strong><br>
            {$Info}
         </div>
      </div>
   </div>
{/if}

{if isset($Error)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Sorry, an error has occurred{/t}:</strong><br>
            {$Error}
         </div>
      </div>
   </div>
{/if}

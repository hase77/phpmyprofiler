{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

getcover.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{if isset($Error)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Sorry, an error has occurred{/t}:</strong><br>
            {$Error}
            <p>
               <button type="button" class="btn btn-default" onclick="javascript:window.close();"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Close{/t}</button>
            </p>
         </div>
      </div>
   </div>
{/if}

{if isset($cover)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Cover was updated{/t}</strong>
            <p>
               <img src="../cover/{$cover}.jpg" alt="{$cover}" border="0">
            </p>
            <p>
               <button type="button" class="btn btn-default" onclick="javascript:window.close();"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Close{/t}</button>
            </p>
         </div>
      </div>
   </div>
{/if}

{include file="admin/footer.tpl"}

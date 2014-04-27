{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

login.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-3"></div>
<div class="col-lg-6">
   <div class="panel panel-primary">
      <div class="panel-heading">{t}Logon{/t}</div>
      <div class="panel-body">
         <div class="col-lg-2">
            <img src="../themes/{$pmp_theme}/images/login.png" alt="login">
         </div>
         <div class="col-lg-10">
            <form id="login" action="logincheck.php?{$session}" method="post" target="_self" name="formular" accept-charset="utf-8">
               <fieldset>
                  <div class="form-group" style="padding-bottom: 8px;">
                     <label for="inputUsername" class="col-lg-4 control-label">{t}Username{/t}</label>
                     <div class="col-lg-8">
                        <input class="form-control" tabindex="1" name="user" type="text" value="{if isset($Username)}{$Username}{/if}">
                        <input type="hidden" name="form_key" value="{$formkey}">
                     </div>
                  </div>
                  <div class="form-group" style="padding-bottom: 26px;">
                     <br><label for="inputPassword" class="col-lg-4 control-label">{t}Password{/t}</label>
                     <div class="col-lg-8">
                        <input class="form-control" name="passwd" tabindex="2" type="password">
                     </div>
                  </div>
                  <div class="form-group" style="padding-bottom: 8px;">
                     <label for="inputLoginButton" class="col-lg-4 control-label"></label>
                     <div class="col-lg-8">
                        <input name="login" type="text" value="true" style="visibility:hidden; display: none">
                        <button type="submit" class="btn btn-primary" tabindex="3" name="submit">{t}Login{/t}</button>
                     </div>
                  </div>
               </fieldset>
            </form>
         </div>
         <div class="col-lg-12">
            <p><br>{t}Use a valid username and password to gain access to the administration console.{/t}</p>
         </div>
      </div>
   </div>
</div>
<div class="col-lg-3"></div>

{include file="admin/footer.tpl"}

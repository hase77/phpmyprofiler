{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

passwd.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{if isset($BigError)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Sorry, an error has occurred{/t}:</strong><br>
            {$BigError}
         </div>
      </div>
   </div>
{/if}

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

{if isset($ErrorCur) || isset($ErrorNew)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Sorry, an error has occurred{/t}:</strong><br>
            <ul>
                {if $ErrorCur}<li>{$ErrorCur}</li>{/if}
                {if $ErrorNew}<li>{$ErrorNew}</li>{/if}
            </ul>
         </div>
      </div>
   </div>
{/if}

{if !isset($BigError)}
   <div class="col-lg-3"></div>
   <div class="col-lg-6">
      <div class="panel panel-primary">
         <div class="panel-heading">{t}Change password for admin area{/t}</div>
         <div class="panel-body">
            <div class="col-lg-12">
               <form id="login" action="passwd.php?{$session}" method="post" target="_self" name="formular" accept-charset="utf-8">
                  <fieldset>
                     {if !isset($NoUser)}
                        <div class="form-group" style="padding-bottom: 8px;">
                           <label for="cur_user" class="col-lg-5 control-label">{t}Current Username{/t}</label>
                           <div class="col-lg-7">
                              <input class="form-control" tabindex="1" name="cur_user" id="cur_user" type="text" value="{if $LastCurUser}{$LastCurUser}{/if}">
                           </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 26px;">
                           <br><label for="cur_passwd" class="col-lg-5 control-label">{t}Current Password{/t}</label>
                           <div class="col-lg-7">
                              <input class="form-control" name="cur_passwd" id="cur_passwd" tabindex="2" type="password" value="{if $LastCurPasswd}{$LastCurPasswd}{/if}">
                           </div>
                        </div>
                     {/if}
                     <div class="form-group" style="padding-bottom: 8px;">
                        <label for="new_user" class="col-lg-5 control-label">{t}New Username{/t}</label>
                        <div class="col-lg-7">
                           <input class="form-control" tabindex="3" name="new_user" id="new_user" type="text" value="{if isset($LastNewUser) && $LastNewUser}{$LastNewUser}{/if}">
                        </div>
                     </div>
                     <div class="form-group" style="padding-bottom: 26px;">
                        <br><label for="new_passwd" class="col-lg-5 control-label">{t}New Password{/t}</label>
                        <div class="col-lg-7">
                           <input class="form-control" name="new_passwd" id="new_passwd" tabindex="4" type="password" value="{if isset($LastNewPasswd) && $LastNewPasswd}{$LastNewPasswd}{/if}">
                        </div>
                     </div>
                     <div class="form-group" style="padding-bottom: 26px;">
                        <br><label for="new_passwd2" class="col-lg-5 control-label">{t}Retype new Password{/t}</label>
                        <div class="col-lg-7">
                           <input class="form-control" name="new_passwd2" id="new_passwd2" tabindex="5" type="password" value="{if isset($LastNewPasswd2) && $LastNewPasswd2}{$LastNewPasswd2}{/if}">
                        </div>
                     </div>
                     
                     <div class="form-group" style="padding-bottom: 8px;">
                        <label class="col-lg-5 control-label"></label>
                        <div class="col-lg-7">
                           <input name="setpasswd" type="text" value="true" style="visibility:hidden; display: none"><br>
                           <button type="submit" class="btn btn-default" tabindex="6" name="submit" value="{t}Save changes{/t}">{t}Save changes{/t}</button>
                           <button type="submit" class="btn btn-default" tabindex="7" name="reset" value="{t}Reset{/t}">{t}Reset{/t}</button>
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-3"></div>
{/if}

{include file="admin/footer.tpl"}

{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

contact.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

            <div class="col-lg-6">

               <h2>{t}Contact{/t}</h2>
               
               {if isset($Failed)}
                  <div class="row">
                     <div class="alert alert-dismissable alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{t}Sorry, an error has occurred{/t}!</strong><br>
                        {$Failed}
                     </div>
                  </div>
               {/if}
               {if isset($Success)}
                  <div class="row">
                     <div class="alert alert-dismissable alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {$Success}
                     </div>
                  </div>
               {/if}
               
               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Write your message{/t}</div>
                  <div class="panel-body">
                     {if $pmp_imprint == '1'}
                        <p>
                           <strong>{$pmp_admin_full}</strong> ({$pmp_admin_name})<br>
                           {t}E-mail{/t}: {mailto address=$pmp_admin_mail encode="javascript" text=$pmp_admin_mail_s}<br>
                           {$pmp_admin_adr}<br>
                           {$pmp_admin_zip} - {$pmp_admin_loc}<br>
                           <strong>{$pmp_admin_cnt}</strong>
                        </p>
                     {else}
                        <p>
                           <strong>{t}Administrator{/t}:</strong> {$pmp_admin_name}<br>
                           {t}E-mail{/t}: {if $pmp_admin_mail}{mailto address=$pmp_admin_mail encode="javascript" text=$pmp_admin_mail_s}{/if}<br>
                        <p>
                     {/if}
                     <p>
                        {t}At this point you have the opportunity to contact the administrator of this DVD collection.{/t}<br>
                        {t}Please fill out the form and submit ...{/t}
                     </p>

                     <form class="bs-example form-horizontal" method="post" action="index.php?content=contact&amp;action=send&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}" accept-charset="utf-8">
                        <fieldset>
                           <div class="form-group">
                              <label for="inputName" class="col-lg-2 control-label">{t}Name{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputName" placeholder="Name" name="name" tabindex="1" value="{if isset($smarty.post.name)}{$smarty.post.name}{/if}">
                                 <input type="hidden" name="username">
                                 {* Hidden input for form key *}
                                 <input type="hidden" name="form_key" value="{$formkey}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputEmail" class="col-lg-2 control-label">{t}E-mail{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputEmail" placeholder="Email" name="email" tabindex="2" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputSubject" class="col-lg-2 control-label">{t}Subject{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputSubject" placeholder="Subject" name="subject" tabindex="3" value="{if isset($smarty.post.subject)}{$smarty.post.subject}{/if}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputMessage" class="col-lg-2 control-label">{t}Message{/t}</label>
                              <div class="col-lg-10">
                                 <textarea class="form-control" id="inputMessage" name="message" rows="5" tabindex="4" placeholder="Enter your message here">{if isset($smarty.post.message)}{$smarty.post.message}{/if}</textarea>
                              </div>
                           </div>
                           
                           {if $pmp_guestbook_showcode == '1'}
                           <div class="form-group">
                              <label for="inputCode" class="col-lg-2 control-label">{t}Code{/t}</label>
                              <div class="col-lg-10">
                                 <img src="{$imgLoc}" alt="[{t}Security code{/t}]" style="float:left; margin-right: 5px;"><br>
                                 <input type="hidden" name="image" value="{$imgLoc}">
                                 <input type="text" class="form-control" id="inputCode" placeholder="{t}Enter the above security code here{/t}" name="code" tabindex="5" size="15">
                              </div>
                           </div>
                           {/if}
                           
                           <div class="form-group">
                              <div class="col-lg-10 col-lg-offset-2">
                                 <button type="submit" class="btn btn-primary" tabindex="6" name="send">{t}Send Message{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                     
                  </div>               
               </div>
               
            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->
               
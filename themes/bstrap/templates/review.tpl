{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

review.tpl

===============================================================================
*}

            {assign "pmp_theme_css" "bootstrap.css"}
            {assign "showlist" "Owned"}
            {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
            {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
         
            <div class="col-lg-6">

               <h2>{$title}:<br><i>{$film->Title}</i></h2>

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
                  <div class="panel-heading">{t}Review{/t}</div>
                  <div class="panel-body">

                     <form class="bs-example form-horizontal" method="post" action="index.php?content=review&amp;action=send&amp;id={$id}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}" accept-charset="utf-8">
                        <fieldset>
                           <div class="form-group">
                              <label for="inputName" class="col-lg-2 control-label">{t}Name{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputName" placeholder="{t}Name{/t}" name="name" tabindex="1" value="{if isset($smarty.post.name)}{$smarty.post.name}{/if}">
                                 <input type="hidden" name="username">
                                 {* Hidden input for form key *}
                                 <input type="hidden" name="form_key" value="{$formkey}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputEmail" class="col-lg-2 control-label">{t}E-mail{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputEmail" placeholder="{t}E-mail{/t}" name="email" tabindex="2" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputEmail" class="col-lg-2 control-label">{t}Title of review{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputTitle" placeholder="{t}Title of review{/t}" name="title" tabindex="3" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputEmail" class="col-lg-2 control-label">{t}Review text (without format strings!){/t}</label>
                              <div class="col-lg-10">
                                 <textarea class="form-control" id="inputText" name="text" rows="10" tabindex="4" placeholder="{t}Review text (without format strings!){/t}">{if isset($smarty.post.text)}{$smarty.post.text}{/if}</textarea>
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputEmail" class="col-lg-2 control-label">{t}Review{/t}</label>
                              <div class="col-lg-10">
                                 <select class="form-control" tabindex="5" name="vote">
                                    <option value="9" {if isset($smarty.post.vote) && $smarty.post.vote == '9'}selected="selected"{/if}>9 ({t}excellent{/t})</option>
                                    <option value="8" {if isset($smarty.post.vote) && $smarty.post.vote == '8'}selected="selected"{/if}>8</option>
                                    <option value="7" {if isset($smarty.post.vote) && $smarty.post.vote == '7'}selected="selected"{/if}>7</option>
                                    <option value="6" {if isset($smarty.post.vote) && $smarty.post.vote == '6'}selected="selected"{/if}>6</option>
                                    <option value="5" {if isset($smarty.post.vote) && $smarty.post.vote == '5'}selected="selected"{/if}>5 ({t}fair{/t})</option>
                                    <option value="4" {if isset($smarty.post.vote) && $smarty.post.vote == '4'}selected="selected"{/if}>4</option>
                                    <option value="3" {if isset($smarty.post.vote) && $smarty.post.vote == '3'}selected="selected"{/if}>3</option>
                                    <option value="2" {if isset($smarty.post.vote) && $smarty.post.vote == '2'}selected="selected"{/if}>2</option>
                                    <option value="1" {if isset($smarty.post.vote) && $smarty.post.vote == '1'}selected="selected"{/if}>1 ({t}bad{/t})</option>
                                 </select>
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
                                 <button type="submit" class="btn btn-primary" tabindex="6" name="send">{t}Submit{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                     {if $pmp_review_activatenew == '1'} <strong>{t}Important{/t}:</strong> {t}Your submitted review will show up, as soon as the administrator has activated it. You'll receive an e-mail, when your review is activated{/t}. {/if}
                  </div>
               </div>

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->
               
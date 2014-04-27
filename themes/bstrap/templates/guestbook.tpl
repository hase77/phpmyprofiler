{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

guestbook.tpl

===============================================================================
*}

            {assign "showlist" "Owned"}
            {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}

            <div class="col-lg-6">

               <h2>{t}Guestbook{/t}</h2>

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
               
               <ul class="list-group">
                  <li class="list-group-item"><span class="badge">{$count}</span>{t}Number of comments{/t}</li>
               </ul>

               {if $entries}
                  <div class="panel panel-primary">
                     <div class="panel-heading">{t}Guest Book Entries{/t}</div>
                     <div class="panel-body">
                        {foreach from=$entries item=entry key=sch name=ent}
                           <div class="panel panel-default">
                              <div class="panel-heading">
                                 {if $entry->email != ''}
                                    {$entry->date} - {mailto address=$entry->email encode="javascript" text=$entry->name|stripslashes}
                                 {else}
                                    {$entry->name|stripslashes}
                                 {/if}
                                 {if $entry->url != ''}
                                    (<a href="{$entry->url}" target="_blank">{$entry->url}</a>)
                                 {/if}
                                 {t}wrote{/t}:
                              </div>
                              <div class="panel-body">
                                 {$entry->text|stripslashes|nl2br}
                                 {if $entry->comment != ''}
                                    <div class="panel panel-default" style="margin-top: 8px;">
                                       <div class="panel-body" style="font-style: italic;">
                                          {t}Reply by{/t} {$pmp_admin_name}:<br>
                                          {$entry->comment|stripslashes|nl2br}
                                       </div>
                                    </div>
                                 {/if}
                              </div>
                           </div>
                        {/foreach}
                     </div>
                  </div>
               {/if}               

               {if $pages > 1}
               <ul class="pagination">
                  {if $page > 1}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page=1&amp;showlist={$showlist}">&lt;&lt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$page-1}&amp;showlist={$showlist}">&lt;</a></li>
                  {else}
                     <li><a href="#">&lt;&lt;</a></li>
                     <li><a href="#">&lt;</a></li>
                  {/if}
                  {section name="Pages" start=1 loop=$pages+1}
                     {if ( $smarty.section.Pages.index == 1 ) || ( $page == $smarty.section.Pages.index - 3 ) || ( $page == $smarty.section.Pages.index - 2 ) || ( $page == $smarty.section.Pages.index - 1 ) || ( $page == $smarty.section.Pages.index ) || ( $page == $smarty.section.Pages.index + 1 ) || ( $page == $smarty.section.Pages.index + 2 ) || ( $page == $smarty.section.Pages.index + 3 ) || ( $smarty.section.Pages.index == $pages )}
                        {if ( $smarty.section.Pages.index == $pages ) && ( $page < $smarty.section.Pages.index - 4 )}
                           <li><a href="#">...</a></li>
                        {/if}
                        {if $page == $smarty.section.Pages.index}
                           <li class="active"><a href="#">{$smarty.section.Pages.index}</a></li>
                        {else}
                           <li><a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$smarty.section.Pages.index}&amp;showlist={$showlist}">{$smarty.section.Pages.index}</a></li>
                        {/if}
                        {if ( $smarty.section.Pages.index == 1 ) && ( $page > 5 )}
                           <li><a href="#">...</a></li>
                        {/if}
                     {/if}
                  {/section}
                  {if $page < $pages}
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$page+1}&amp;showlist={$showlist}">&gt;</a></li>
                     <li><a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$pages}&amp;showlist={$showlist}">&gt;&gt;</a></li>
                  {else}
                     <li><a href="#">&gt;</a></li>
                     <li><a href="#">&gt;&gt;</a></li>
                  {/if}
               </ul>
               {/if}

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Add your comment{/t}</div>
                  <div class="panel-body">
                     {if $pmp_guestbook_activatenew == 0}
                        <p>
                        {t}New comments will be invisible until the administrator activates them.{/t}
                        </p>
                     {/if}

                     <form id="guestbook" class="bs-example form-horizontal" method="post" action="index.php?content=guestbook&amp;action=save&amp;showlist={$showlist}" accept-charset="utf-8">
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
                              <label for="inputHomepage" class="col-lg-2 control-label">{t}Homepage{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="inputHomepage" placeholder="Homepage" name="url" tabindex="3" value="{if isset($smarty.post.url)}{$smarty.post.url}{/if}">
                              </div>
                           </div>
                           
                           <div class="form-group">
                              <label for="inputMessage" class="col-lg-2 control-label">{t}Comment{/t}</label>
                              <div class="col-lg-10">
                                 {foreach from=$emoticons item=emoticon key=sch name=emo}
                                    <a href="javascript:insertSmiley('{$sch}');"><img src="themes/{$pmp_theme}/images/emoticons/{$emoticon}" alt="{$sch}"></a>
                                 {/foreach}<br>
                                 <br>
                                 <textarea class="form-control" id="inputMessage" name="message" rows="10" tabindex="4" placeholder="Enter your message here">{if isset($smarty.post.message)}{$smarty.post.message|stripslashes}{/if}</textarea>
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
                                 <button type="submit" class="btn btn-primary" tabindex="6" name="send">{t}Add Comment{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
               
            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

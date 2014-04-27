{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

reviews.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Guestbook{/t}</div>
      <div class="panel-body">

         <div class="panel panel-warning">
            <div class="panel-heading">{t}Pending guestbook entries{/t}</div>
            <div class="panel-body">
               {if $pending|@count > 0}
                  {if $pending|@count > 1}
                     <p>
                        <button type="button" class="btn btn-default" onclick="window.location='guestbook.php?action=allactivate&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Activate all guestbook entries{/t}</button>
                     </p>
                  {/if}
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>{t}From{/t}</th>
                              <th>{t}Text{/t}</th>
                              <th>{t}Comment{/t}</th>
                              <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {foreach from=$pending item=gbentry key=sch}
                              <tr>
                                 <td class="textarea">
                                    <p>
                                       {$gbentry->name|stripslashes}<br>
                                       <img src="../themes/{$pmp_theme}/images/clock.png" border="0" alt="{t}Date{/t}">&nbsp;{$gbentry->date}
                                       {if $gbentry->email}<br><img src="../themes/{$pmp_theme}/images/mail.png" alt="E-Mail">&nbsp;<a href="mailto:{$gbentry->email}">{$gbentry->email}</a>{/if}
                                       {if $gbentry->url}<br><img src="../themes/{$pmp_theme}/images/homepage.png" alt="Homepage">&nbsp;<a href="{$gbentry->url}">{$gbentry->url}</a>{/if}
                                    </p>
                                 </td>
                                 <td class="textarea">{$gbentry->text|stripslashes}</td>
                                 <td class="textarea">
                                    <form action="guestbook.php?action=comment&amp;id={$gbentry->id}&amp;{$session}" method="post" accept-charset="utf-8">
                                       <textarea class="form-control" name="comment" cols="30" rows="2">{$gbentry->comment|stripslashes}</textarea>
                                       <button class="btn btn-default" type="submit" value="{t}OK{/t}" name="send" style="margin-top: 8px;"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}OK{/t}</button>
                                    </form>
                                 </td>
                                 <td class="textarea">
                                    <button type="button" class="btn btn-default" onclick="window.location='guestbook.php?action=activate&amp;id={$gbentry->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Activate{/t}</button>
                                    <button type="button" class="btn btn-default" onclick="window.location='guestbook.php?action=delete&amp;id={$gbentry->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                </td>
                              </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               {else}
                  <p>{t}There are no pending guestbook entries.{/t}</p>
               {/if}
            </div>
         </div>

         <div class="panel panel-success">
            <div class="panel-heading">{t}Active guestbook entries{/t}</div>
            <div class="panel-body">
               {if $active|@count > 0}
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>{t}From{/t}</th>
                              <th>{t}Text{/t}</th>
                              <th>{t}Comment{/t}</th>
                              <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {foreach from=$active item=gbentry key=sch}
                              <tr>
                                 <td class="textarea">
                                    <p>
                                       {$gbentry->name|stripslashes}<br>
                                       <img src="../themes/{$pmp_theme}/images/clock.png" alt="{t}Date{/t}">&nbsp;{$gbentry->date}
                                       {if $gbentry->email}<br><img src="../themes/{$pmp_theme}/images/mail.png" alt="E-Mail">&nbsp;<a href="mailto:{$gbentry->email}">{$gbentry->email}</a>{/if}
                                       {if $gbentry->url}<br><img src="../themes/{$pmp_theme}/images/homepage.png" alt="Homepage">&nbsp;<a href="{$gbentry->url}">{$gbentry->url}</a>{/if}
                                 </td>
                                 <td class="textarea">{$gbentry->text|stripslashes}</td>
                                 <td>
                                    <form action="guestbook.php?action=comment&amp;id={$gbentry->id}&amp;{$session}" method="post" accept-charset="utf-8">
                                       <textarea class="form-control" name="comment" cols="30" rows="2">{$gbentry->comment|stripslashes}</textarea>
                                       <button class="btn btn-default" type="submit" value="{t}OK{/t}" name="send" style="margin-top: 8px;"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}OK{/t}</button>
                                    </form>
                                 </td>
                                 <td class="textarea">
                                    <button type="button" class="btn btn-default" onclick="window.location='guestbook.php?action=delete&amp;id={$gbentry->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                 </td>
                              </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               {else}
                  <p>{t}There are no active guestbook entries.{/t}</p>
               {/if}
            </div>
         </div>
         
      </div>
   </div>

</div>

{include file="admin/footer.tpl"}

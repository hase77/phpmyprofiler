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
      <div class="panel-heading">{t}Reviews{/t}</div>
      <div class="panel-body">

         <div class="panel panel-warning">
            <div class="panel-heading">{t}Pending reviews{/t}</div>
            <div class="panel-body">
               {if $pending|@count > 0}
                  {if $pending|@count > 1}
                     <p>
                        <button type="button" class="btn btn-default" onclick="window.location='reviews.php?action=allactivate&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Activate all review entries{/t}</button>
                     </p>
                  {/if}
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>{t}From{/t}</th>
                              <th>{t}Movie{/t}</th>
                              <th>{t}Title{/t}</th>
                              <th>{t}Text{/t}</th>
                              <th>{t}Review{/t}</th>
                              <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {foreach from=$pending item=review key=sch}
                              <tr>
                                 <td class="textarea">
                                    <p>
                                       {$review->name}<br>
                                       <img src="../themes/{$pmp_theme}/images/clock.png" alt="{t}Date{/t}">&nbsp;{$review->date}
                                       {if $review->email}<br><img src="../themes/{$pmp_theme}/images/mail.png" alt="E-Mail">&nbsp;<a href="mailto:{$review->email}">{$review->email}</a>{/if}
                                    </p>
                                 </td>
                                 <td class="textarea">{$review->dvd->Title}</td>
                                 <td class="textarea">{$review->title}</td>
                                 <td class="textarea">{$review->text}</td>
                                 <td class="text-center">{$review->vote}</td>
                                 <td class="textarea">
                                    <button type="button" class="btn btn-default" onclick="window.location='reviews.php?action=activate&amp;id={$review->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Activate{/t}</button>
                                    <button type="button" class="btn btn-default" onclick="window.location='reviews.php?action=delete&amp;id={$review->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                 </td>
                              </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               {else}
                  <p>{t}There are no pending reviews.{/t}</p>
               {/if}
            </div>
         </div>

         <div class="panel panel-success">
            <div class="panel-heading">{t}Active reviews{/t}</div>
            <div class="panel-body">
               {if $active|@count > 0}
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>{t}From{/t}</th>
                              <th>{t}Movie{/t}</th>
                              <th>{t}Title{/t}</th>
                              <th>{t}Text{/t}</th>
                              <th>{t}Review{/t}</th>
                              <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {foreach from=$active item=review key=sch}
                              <tr>
                                 <td class="textarea">
                                    <p>
                                       {$review->name}<br>
                                       <img src="../themes/{$pmp_theme}/images/clock.png" alt="{t}Date{/t}">&nbsp;{$review->date}
                                       {if $review->email}<br><img src="../themes/{$pmp_theme}/images/mail.png" alt="E-Mail">&nbsp;<a href="mailto:{$review->email}">{$review->email}</a>{/if}
                                    </p>
                                 </td>
                                 <td class="textarea">{$review->dvd->Title}</td>
                                 <td class="textarea">{$review->title}</td>
                                 <td class="textarea">{$review->text}</td>
                                 <td class="text-center">{$review->vote}</td>
                                 <td class="textarea">
                                    <button type="button" class="btn btn-default" onclick="window.location='reviews.php?action=delete&amp;id={$review->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                 </td>
                              </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               {else}
                  <p>{t}There are no active reviews.{/t}</p>
               {/if}
            </div>
         </div>
         
      </div>
   </div>
</div>

{include file="admin/footer.tpl"}

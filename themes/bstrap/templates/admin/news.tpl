{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

updateimdb.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

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

{if !isset($editadd)}
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

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}News{/t}</div>
      <div class="panel-body">

         {if !isset($editadd)}
            <p>
               <button type="button" class="btn btn-default" onclick="window.location='news.php?action=add&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/new_s.png" alt="">&nbsp;&nbsp;{t}Add news{/t}</button>&nbsp;
            </p>
            {if !isset($Info)}
               <div class="panel panel-success">
                  <div class="panel-heading">{t}News{/t}</div>
                  <div class="panel-body">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                  <th>{t}Title{/t}</th>
                                  <th>{t}Date{/t}</th>
                                  <th>{t}Text{/t}</th>
                                  <th>{t}Function{/t}</th>
                              </tr>
                           </thead>
                           <tbody>
                              {foreach from=$news item=new key=sch}
                                 <tr>
                                    <td class="textarea">{$new->title|stripslashes}</td>
                                    <td class="textarea">{$new->date}</td>
                                    <td class="textarea">{$new->text|stripslashes}</td>
                                    <td class="textarea">
                                       <button type="button" class="btn btn-default" onclick="window.location='news.php?action=edit&amp;id={$new->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/edit_s.png" alt="">&nbsp;&nbsp;{t}Edit{/t}</button>&nbsp;
                                       <button type="button" class="btn btn-default" onclick="window.location='news.php?action=delete&amp;id={$new->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>&nbsp;
                                    </td>
                                 </tr>
                              {/foreach}
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            {/if}
         {else}
            {if $editadd == 'add'}
               <div class="panel panel-warning">
                  <div class="panel-heading">{t}Add new news{/t}</div>
                  <div class="panel-body">
                     <form enctype="multipart/form-data" class="bs-example form-horizontal" method="post" action="news.php?action=addsave&amp;{$session}" accept-charset="utf-8">
                        <fieldset>
                           <div class="form-group">
                              <label for="title" class="col-lg-2 control-label">{t}Title{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{if isset($title) && $title}{$title|stripslashes}{/if}">
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="inputText" class="col-lg-2 control-label">{t}Text{/t}</label>
                              <div class="col-lg-10">
                                 <textarea class="form-control" id="inputText" name="text" rows="15" placeholder="Enter your text here">{if isset($text) && $text}{$text|stripslashes}{/if}</textarea>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-lg-10 col-lg-offset-2">
                                 <button type="submit" class="btn btn-default" name="send"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Add news{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            {/if}
            
            {if $editadd == 'edit'}
               <div class="panel panel-warning">
                  <div class="panel-heading">{t}Edit news{/t}</div>
                  <div class="panel-body">
                     {foreach from=$edit item=change}
                     <form enctype="multipart/form-data" class="bs-example form-horizontal" method="post" action="news.php?action=editsave&amp;id={$change->id}&amp;{$session}" accept-charset="utf-8">
                        <fieldset>
                           <div class="form-group">
                              <label for="title" class="col-lg-2 control-label">{t}Title{/t}</label>
                              <div class="col-lg-10">
                                 <input type="text" class="form-control" id="title" name="title" value="{$change->title|stripslashes}">
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="inputText" class="col-lg-2 control-label">{t}Text{/t}</label>
                              <div class="col-lg-10">
                                 <textarea class="form-control" id="inputText" name="text" rows="15">{$change->text|stripslashes}</textarea>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-lg-10 col-lg-offset-2">
                                 <button type="submit" class="btn btn-default" name="send"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Apply changes{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                     {/foreach}
                  </div>
               </div>
            {/if}
         
         {/if}
         
      </div>
   </div>
</div>      

{include file="admin/footer.tpl"}

{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

updateawards.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Update award table{/t}</div>
      <div class="panel-body">
         {if isset($Files)}
            <div class="panel panel-info">
               <div class="panel-heading">{t}Description{/t}</div>
               <div class="panel-body">
                  <p>
                     <strong>{t}Parse{/t}</strong><br>
                     {t}Parse file into awards table.{/t}
                  </p>
                  <p>
                     <strong>{t}Delete{/t}</strong><br>
                     {t}Use this to delete uneeded files.{/t}
                  </p>
               </div>
            </div>

            <div class="panel panel-success">
               <div class="panel-heading">{t}Files{/t}</div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                               <th>{t}File{/t}</th>
                               <th>{t}Size{/t}</th>
                               <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {foreach from=$Files item=file}
                              <tr>
                                 <td>{$file.name}</td>
                                 <td class="text-right">{$file.size}</td>
                                 <td>
                                    <button type="button" class="btn btn-default" onclick="window.location='updateawards.php?action=parse&amp;file={$file.name|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/db_commit_s" alt="">&nbsp;&nbsp;{t}Parse{/t}</button>&nbsp;
                                    <button type="button" class="btn btn-default" onclick="window.location='updateawards.php?action=delete&amp;file={$file.name|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                 </td>
                              </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>            
         {/if}
         
         {if $Types}
            <div class="panel panel-danger">
               <div class="panel-heading">{t}Awards{/t}</div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                               <th>{t}Award{/t}</th>
                               <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {foreach from=$Types item=type}
                              <tr>
                                 <td>{$type}</td>
                                 <td>
                                    <button type="button" class="btn btn-default" onclick="window.location='updateawards.php?action=buildtags&amp;award={$type|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/tag_s.png" alt="">&nbsp;&nbsp;{t}Build tags{/t}</button>&nbsp;
                                    <button type="button" class="btn btn-default" onclick="window.location='updateawards.php?action=deleteaward&amp;award={$type|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                 </td>
                              </tr>
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>            
         {/if}
         
         <div class="panel panel-warning">
            <div class="panel-heading">{t}Upload compressed (zip or bz2) or uncompressed award file{/t}</div>
            <div class="panel-body">
               <form enctype="multipart/form-data" method="post" action="uploadaward.php?{$session}" accept-charset="utf-8">
                  <fieldset>
                     <div class="form-group" style="padding-bottom: 8px;">
                        <div class="col-lg-8">
                           <input class="form-control" name="file" type="file">
                        </div>                        
                        <div class="col-lg-4">
                           <button class="btn btn-default" type="submit" value="{t}Upload file{/t}" name="send">{t}Upload file{/t}</button>
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
         
      </div>
   </div>
</div>

{include file="admin/footer.tpl"}


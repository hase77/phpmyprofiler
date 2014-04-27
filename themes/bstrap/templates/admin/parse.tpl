{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

parse.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

{if isset($count)}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Parsed Finish{/t}:</strong><br>
            {if isset($split)}<p>{t split=$split}The Collection was splitted in %split pieces.{/t}</p>{/if}
            <p>{t dvd=$count sec=$time|string_format:"%04.2f"} Parsed %dvd DVDs in %sec seconds.{/t}</p>
            {if $deleted != '0'}<p>{t del=$deleted}Deleted %del unneeded thumbnails.{/t}</p>{/if}
            {if isset($profiles.new)}<p>{$profiles.new} {t}new Profiles{/t}</p>{/if}
            {if isset($profiles.unaltered)}<p>{$profiles.unaltered} {t}unaltered Profiles{/t}</p>{/if}
            {if isset($profiles.altered)}<p>{$profiles.altered} {t}altered Profiles{/t}</p>{/if}
            {if isset($profiles.deleted) && $profiles.deleted != 0}<p>{$profiles.deleted} {t}deleted Profiles{/t}</p>{/if}
         </div>
      </div>
   </div>
{/if}

<div class="col-lg-12">
   <div class="panel panel-primary">
      <div class="panel-heading">{t}Parse{/t}</div>
      <div class="panel-body">
         {if isset($Files)}
            <div class="panel panel-info">
               <div class="panel-heading">{t}Description{/t}</div>
               <div class="panel-body">
                  <p>
                     <strong>{t}Parse{/t}</strong><br>
                     {t split=$pmp_splitxmlafter}Empty the database and parse the XML-file into the database. For parsing the XML-file will be split in pieces. If you have a large amount of DVDs or your web server is a little bit slow, the parsing may fail (timeout-error or blank page). When the parsing fails you can decrease the number of DVDs for every split file on the preferences page. With the current setting phpMyprofiler will split after every %split DVDs.{/t}
                  </p>
                  <p>
                     <strong>{t}Delete{/t}</strong><br>
                     {t}Use this to delete uneeded files.{/t}
                  </p>
                  <p>
                     <strong>{t}Parser Mode is{/t}:&nbsp; 
                     {if $pmp_parser_mode == 0}
                        <span class="label label-info">{t}Build from scratch{/t}</span>
                     {elseif $pmp_parser_mode == 1}
                        <i>{t}Update with delete{/t}.</i>
                     {else}
                        <i>{t}Update without delete{/t}.</i>
                     {/if}</strong><br>

                     {if $pmp_parser_mode == 0}
                        {t}This mode will delete all profiles before importing all data from xml-file.{/t}<br>
                        {t}You should use this mode if you don't have any data in your database or if your xml-file contains a lot of updated or new profiles.{/t}
                     {elseif $pmp_parser_mode == 1}
                        {t}This mode will import only update and new profiles, while profiles missing in xml-file will be deleted.{/t}<br>
                        {t}You should use this mode if you have data in your database and you want to get rid of some profiles.{/t}
                     {else}
                        {t}This mode will import only update and new profiles, while profiles missing in xml-file will not be deleted.{/t}<br>
                        {t}You should use this mode if you have data in your database and you want to keep all profiles.{/t}
                     {/if}
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
                                    {if $pmp_parser_mode == 0}
                                       <button type="button" class="btn btn-default" onclick="window.location='parse.php?action=split&amp;file={$file.name|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/db_commit_s.png" alt="">&nbsp;&nbsp;{t}Parse{/t}</button>&nbsp;
                                    {else}
                                       <button type="button" class="btn btn-default" onclick="window.location='parse.php?action=parse&amp;file={$file.name|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/db_commit_s.png" alt="">&nbsp;&nbsp;{t}Parse{/t}</button>&nbsp;
                                    {/if}
                                    <button type="button" class="btn btn-default" onclick="window.location='parse.php?action=delete&amp;file={$file.name|rawurlencode}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
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
            <div class="panel-heading">{t}Upload compressed (zip or bz2) or uncompressed Collection XML file{/t}</div>
            <div class="panel-body">
               <form enctype="multipart/form-data" method="post" action="uploadxml.php?{$session}" accept-charset="utf-8">
                  <fieldset>
                     <div class="form-group" style="padding-bottom: 8px;">
                        <div class="col-lg-8">
                           <input class="form-control" name="file" type="file">
                        </div>                        
                        <div class="col-lg-4">
                           <button class="btn btn-default" type="submit" value="{t}Upload file{/t}" name="send"><img src="../themes/{$pmp_theme}/images/menu/upload_s.png" alt="">&nbsp;&nbsp;{t}Upload file{/t}</button>
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

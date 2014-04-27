{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

pictures.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Collection Pictures{/t}</div>
      <div class="panel-body">
      
         <div class="panel panel-warning">
            <div class="panel-heading">{t}Upload pictures{/t}</div>
            <div class="panel-body">
               <form enctype="multipart/form-data" method="post" action="pictures.php?action=add&amp;{$session}" accept-charset="utf-8">
                  <fieldset>
                     <div class="form-group">
                        <label for="inputFilename" class="col-lg-2 control-label">{t}Filename{/t}</label>
                        <div class="col-lg-10">
                           <input type="text" class="form-control" id="inputFilename" placeholder="Filename" name="filename" tabindex="1" value="">
                        </div>
                     </div>
                     <br><br>
                     <div class="form-group">
                        <label for="inputTitle" class="col-lg-2 control-label">{t}Comment{/t}</label>
                        <div class="col-lg-10">
                           <input type="text" class="form-control" id="inputTitle" placeholder="Comment" name="title" tabindex="2" value="">
                        </div>
                     </div>
                     <br><br>
                     <div class="form-group">
                        <label for="inputFile" class="col-lg-2 control-label">{t}File{/t}</label>
                        <div class="col-lg-6">
                           <input class="form-control" id="inputFile" name="file" type="file">
                        </div>                        
                        <div class="col-lg-4">
                           <button class="btn btn-default" type="submit" value="{t}Upload picture{/t}" name="send"><img src="../themes/{$pmp_theme}/images/menu/upload_s.png" alt="">&nbsp;&nbsp;{t}Upload picture{/t}</button>
                        </div>
                     </div>
                     <br><br>
                  </fieldset>
               </form>
            </div>
         </div>

         {if $pics}
         <div class="panel panel-success">
            <div class="panel-heading">{t}Picture Gallery{/t}</div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>{t}Filename{/t}</th>
                           <th>{t}Comment{/t}</th>
                           <th>{t}Size{/t}</th>
                           <th>{t}Dimension{/t}</th>
                           <th>{t}Function{/t}</th>
                        </tr>
                     </thead>
                     <tbody>
                        {foreach from=$pics item=pic key=sch}
                           <tr>
                              <td>
                                 {if $pic->fileexist}
                                    <a href="../pictures/{$pic->image}" class="fancybox"><img src="../pictures/{$pic->image}" style="height: 40px; padding-right: 8px;" alt=""></a>{$pic->filename}
                                 {else}
                                    <span style="text-decoration:line-through;">{$pic->filename}</span>
                                 {/if}
                              </td>
                              <td>{$pic->title}</td>
                              <td class="text-right">{if $pic->fileexist}{$pic->size/1024|round|number_format:0} kB{/if}</td>
                              <td>{if $pic->fileexist}{$pic->x}x{$pic->y}{/if}</td>
                              <td>
                                 <button class="btn btn-default" type="button" onclick="window.location='pictures.php?action=delete&amp;id={$pic->id}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                              </td>
                           </tr>
                      {/foreach}
                     </tbody>
                  </table>
               </div>            
            </div>
         </div>
         {/if}
      
      </div>
   </div>
</div>

{literal}
   <script type="text/javascript">
      //<![CDATA[
      $('.fancybox').fancybox();
      //]]>
   </script>
{/literal}

{include file="admin/footer.tpl"}

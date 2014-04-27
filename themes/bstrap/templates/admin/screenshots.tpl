{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

screenshots.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Screenshots{/t}</div>
      <div class="panel-body">

         {if !isset($show) || $show == 0}
         
            <div class="panel panel-info">
               <div class="panel-heading">{t}Upload{/t}</div>
               <div class="panel-body">
                  <form enctype="multipart/form-data" method="post" action="screenshots.php?action=upload&amp;{$session}" accept-charset="utf-8">
                     <fieldset>
                        <div class="form-group">
                           <label for="inputFile" class="col-lg-2 control-label">{t}File{/t}</label>
                           <div class="col-lg-6">
                              <input class="form-control" id="inputFile" name="file" type="file">
                           </div>                        
                           <div class="col-lg-4">
                              <button class="btn btn-default" type="submit" value="{t}Upload file{/t}" name="send"><img src="../themes/{$pmp_theme}/images/menu/upload_s.png" alt="">&nbsp;&nbsp;{t}Upload file{/t}</button>
                           </div>
                        </div>
                        <br><br>
                     </fieldset>
                  </form>
               </div>
            </div>
            
            {if isset($indb)}
            <div class="panel panel-info">
               <div class="panel-heading">{t}Build tags{/t}</div>
               <div class="panel-body">
                  <button class="btn btn-default" type="button" onclick="window.location='screenshots.php?action=buildtags&amp;{$session}';" value="{t}Build tags{/t}" name="send"><img src="../themes/{$pmp_theme}/images/menu/tag_s.png" alt="{t}Build tags{/t}">&nbsp;&nbsp;{t}Build tags{/t}</button>
               </div>
            </div>         
            {/if}
   
            {if !empty($notindb)}
            <div class="panel panel-warning">
               <div class="panel-heading">{t}Not linked to profiles{/t}</div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>{t}ID{/t}</th>
                              <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {assign var=i value=0}
                           {foreach from=$notindb item=id}
                              <tr>
                                 <td>{if !isset($link.$id)}<img src="../themes/{$pmp_theme}/images/movie.png" alt="{t}SymLink{/t}">&nbsp;{/if}<a href="screenshots.php?action=show&amp;id={$id|escape:"url"}&amp;{$session}">{$id}</a></td>
                                 <td>
                                    <button class="btn btn-default" type="button" onclick="window.location='screenshots.php?action=delete&amp;id={$id|escape:"url"}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                    <button class="btn btn-default" type="button" onclick="window.location='screenshots.php?action=show&amp;id={$id|escape:"url"}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/display_s.png" alt="">&nbsp;&nbsp;{t}Show{/t}</button>
                                 </td>
                              </tr>
                              {assign var=i value=$i+1}
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>         
            {/if}
            
            {if !empty($indb)}
            <div class="panel panel-success">
               <div class="panel-heading">{t}Linked to profiles{/t}</div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>{t}ID{/t}</th>
                              <th>{t}Title{/t}</th>
                              <th>{t}Function{/t}</th>
                           </tr>
                        </thead>
                        <tbody>
                           {assign var=i value=0}
                           {foreach from=$indb item=id}
                              {assign var=tmp value=$id.id}
                              <tr>
                                 <td>{if isset($link.$tmp)}<img src="../themes/{$pmp_theme}/images/movie.png" alt="{t}SymLink{/t}">&nbsp;{/if}<a href="screenshots.php?action=show&amp;id={$id.id|escape:"url"}&amp;{$session}">{$id.id}</a></td>
                                 <td>{$id.title}</td>
                                 <td>
                                    <button class="btn btn-default" type="button" onclick="window.location='screenshots.php?action=delete&amp;id={$id.id|escape:"url"}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt="">&nbsp;&nbsp;{t}Delete{/t}</button>
                                    <button class="btn btn-default" type="button" onclick="window.location='screenshots.php?action=show&amp;id={$id.id|escape:"url"}&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/display_s.png" alt="">&nbsp;&nbsp;{t}Show{/t}</button>
                                 </td>
                              </tr>
                              {assign var=i value=$i+1}
                           {/foreach}
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>         
            {/if}

         {else}
                  
            <div class="panel panel-success">
               <div class="panel-heading">{$id|escape:"url"}</div>
               <div class="panel-body">
                  <form class="bs-example form-horizontal" method="post" action="screenshots.php?action=relink&amp;id={$id|escape:"url"}&amp;{$session}" target="_self" accept-charset="utf-8">
                     <fieldset>
                        <div class="form-group">
                           <label for="inputRelink" class="col-lg-2 control-label" style="text-align: left;">{t}Relink to ID{/t}</label>
                           <div class="col-lg-10">
                              <input class="form-control" type="text" name="relink" id="inputRelink" value="" tabindex="1">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputSymlink" class="col-lg-2 control-label" style="text-align: left;">{t}Symlink to ID{/t}</label>
                           <div class="col-lg-10">
                              <input class="form-control" type="text" name="relink" id="inputSymlink" value="" tabindex="2">
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="col-lg-10 col-lg-offset-2">
                              <button type="submit" class="btn btn-default" tabindex="3"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt="">&nbsp;&nbsp;{t}Apply changes{/t}</button>
                           </div>
                        </div>
                     </fieldset>
                  </form>

                  {if isset( $screenshots )}
                     <div class="panel panel-default">
                        <div class="panel-body">
                           {foreach from=$screenshots item=fname key=sch name=list}
                              <a href="../screenshots/{$id}/{$fname}" class="fancybox"><img src="../screenshots/thumbs/{$id}/{$fname}" alt="{$fname}"></a>&nbsp;
                           {/foreach}
                        </div>
                     </div>
                  {/if}

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

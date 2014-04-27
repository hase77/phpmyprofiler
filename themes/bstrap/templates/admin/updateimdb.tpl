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

{include file="admin/mainerror.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Update external reviews{/t}</div>
      <div class="panel-body">
      
         <div class="panel panel-info">
            <div class="panel-heading">{t}Description{/t}</div>
            <div class="panel-body">
               <p>{t}This feature takes a lot time and need access to remote files. Not every server satisfy this requirements.{/t}</p>
            </div>
         </div>

         <div class="panel panel-success">
            <div class="panel-heading">{t}Reviews{/t}</div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>{t}Source{/t}</th>
                           <th>{t}Total{/t}</th>
                           <th>{t}Outdated{/t}</th>
                           <th>{t}New{/t}</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>IMDB</td>
                           <td>{$imdb_all}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=imdb&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                           <td>{$imdb_old}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=imdb_old&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                           <td>{$imdb_new}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=imdb_new&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                        </tr>
                        <tr>
                           <td>OFDB</td>
                           <td>{$ofdb_all}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=ofdb&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                           <td>{$ofdb_old}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=ofdb_old&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                           <td>{$ofdb_new}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=ofdb_new&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                        </tr>
                        <tr>
                           <td>Rotten Tomatoes</td>
                           <td>{$rotten_all}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=rotten&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                           <td>{$rotten_old}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=rotten_old&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                           <td>{$rotten_new}&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=update&amp;what=rotten_new&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/refresh_s.png" alt="">&nbsp;&nbsp;{t}Update{/t}</button></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>            
         
         <button type="button" class="btn btn-default" onclick="window.location='updateimdb.php?action=imdbtop250&amp;{$session}';"><img src="../themes/{$pmp_theme}/images/menu/tag_s.png" alt="">&nbsp;&nbsp;{t}Click here to create IMDB/OFDB Tags.{/t}</button>&nbsp;
         
      </div>
   </div>
</div>

{include file="admin/footer.tpl"}

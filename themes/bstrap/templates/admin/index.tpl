{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

index.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

{if (($pmp_checkforupdates == '1' && isset($latestrelease)) || (isset($stateDB) && $stateDB < $stateUpdate) || (isset($guestbook) && $guestbook > 0) || (isset($reviews) && $reviews > 0))}
   <div class="col-lg-12">
      <div class="row">
         <div class="alert alert-dismissable alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{t}Information{/t}</strong><br>
            <ul>
               {if ($pmp_checkforupdates == '1' && isset($latestrelease))}
                  <li>{t}You are using phpMyProfiler version{/t} {$pmp_version}<br>
                  {t}Last release version from www.phpmyprofiler.de is{/t} {$latestrelease}</li>
               {/if}
               {if isset($stateDB) && $stateDB < $stateUpdate}<li>{t update=$stateUpdate}New update %update is available. Please refresh your database.{/t}</li>{/if}
               {if isset($guestbook) && $guestbook > 0}<li>{t gb=$guestbook}You have %gb new guestbook entries to activate.{/t}</li>{/if}
               {if isset($reviews) && $reviews > 0}<li>{t review=$reviews}You have %review new review entries to activate.{/t}</li>{/if}
            </ul>
         </div>
      </div>
   </div>
{/if}

<div class="col-lg-12">
   <div class="panel panel-primary">
      <div class="panel-heading">{t}Common preferences:{/t}</div>
      <div class="panel-body">
         <div class="col-lg-4">
            <p><a href="preferences.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/config.png" alt="{t}Change preferences{/t}">&nbsp;{t}Change preferences{/t}</a></p>
         </div>
         <div class="col-lg-4">
            <p><a href="passwd.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/passwd.png" alt="{t}Change password for admin area{/t}">&nbsp;{t}Change password for admin area{/t}</a></p>
         </div>
         <div class="col-lg-4">
            <p><a href="phpinfo.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/phpinfo.png" alt="{t}Call PHP-info{/t}">&nbsp;{t}Call PHP-info{/t}</a></p>
         </div>
      </div>
   </div>
</div>

<div class="col-lg-12">
   <div class="panel panel-primary">
      <div class="panel-heading">{t}Insert/refresh data:{/t}</div>
      <div class="panel-body">
         <div class="col-lg-4">
            <p><a href="parse.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/parse.png" alt="{t}Parse new collection{/t}">&nbsp;{t}Parse new collection{/t}</a></p>
         </div>
         <div class="col-lg-4">
            <p><a href="updateawards.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/updateawards.png" alt="{t}Update award table{/t}">&nbsp;{t}Update award table{/t}</a></p>
         </div>
         <div class="col-lg-4">
            <p><a href="updaterates.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/updaterates.png" alt="{t}Update exchange rates{/t}">&nbsp;{t}Update exchange rates{/t}</a></p>
         </div>
         {if !isset($nomovies)}
            <div class="col-lg-4">
               <p><a href="updateimdb.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/updateimdb.png" alt="{t}Update external reviews{/t}">&nbsp;{t}Update external reviews{/t}</a></p>
            </div>
         {/if}
      </div>
   </div>
</div>

<div class="col-lg-12">
   <div class="panel panel-primary">
      <div class="panel-heading">{t}Additional functions{/t}</div>
      <div class="panel-body">
         <div class="col-lg-4">
            <p><a href="news.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/news.png" alt="{t}News{/t}">&nbsp;{t}News{/t}</a></p>
         </div>
         <div class="col-lg-4">
            <p><a href="pictures.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/photos.png" alt="{t}Collection Pictures{/t}">&nbsp;{t}Collection Pictures{/t}</a></p>
         </div>
         {if isset($gbfound)}
            <div class="col-lg-4">
               <p><a href="guestbook.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/guestbook.png" alt="{t}Guestbook{/t}">&nbsp;{t}Guestbook{/t}</a></p>
            </div>
         {/if}
         {if !isset($nomovies)}
            {if isset($reviewsfound)}
               <div class="col-lg-4">
                  <p><a href="reviews.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/reviews.png" alt="{t}Reviews{/t}">&nbsp;{t}Reviews{/t}</a></p>
               </div>
            {/if}
            <div class="col-lg-4">
               <p><a href="nocover.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/nocover.png" alt="{t}Check pictures of covers{/t}">&nbsp;{t}Check pictures of covers{/t}</a></p>
            </div>
            <div class="col-lg-4">
               <p><a href="screenshots.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/screenshots.png" alt="{t}Screenshots{/t}">&nbsp;{t}Screenshots{/t}</a></p>
            </div>
            <div class="col-lg-4">
               <p><a href="report.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/report.png" alt="{t}Print listing{/t}">&nbsp;{t}Print listing{/t}</a></p>
            </div>
         {/if}
         <div class="col-lg-4">
            <p><a href="update.php?{$session}" {if isset($StandDB) && $StandDB < $StandUpdate}style="border-color:red"{/if}><img src="../themes/{$pmp_theme}/images/menu/update.png" alt="{t}Refresh database{/t}">&nbsp;{t}Refresh database{/t}</a></p>
         </div>
         <div class="col-lg-4">
            <p><a href="checklang.php?{$session}"><img src="../themes/{$pmp_theme}/images/menu/checklang.png" alt="{t}Check translations{/t}">&nbsp;{t}Check translations{/t}</a></p>
         </div>
      </div>
   </div>
</div>

{include file="admin/footer.tpl"}

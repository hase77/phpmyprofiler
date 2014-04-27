{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

header.tpl

===============================================================================
*}

<!DOCTYPE html>
<!--[if true]>
===============================================================================
phpMyProfiler Theme "Bstrap"
_______________________________________________________________________________

Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe
Copyright:  (c) 2014. All rights reserved.
License:    LGPL v3
===============================================================================
<![endif]-->
<html lang="en">
   <head>
      <title>{$pmp_pagetitle}</title>
      
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <link rel="shortcut icon" href="favicon.ico">
      
      <link rel="stylesheet" href="themes/{$pmp_theme}/css/{$pmp_theme}.css.php"  type="text/css" media="screen">

      {assign "pmp_theme_css" "bootstrap.css"}
      {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
      {if $pmp_theme_css == "default.css"} {$pmp_theme_css = "bootstrap.css"} {/if}

      {if $pmp_theme_css == "bootstrap.css"}
         <!-- Standard Bootstrap CSS -->
         <link rel="stylesheet" href="themes/bstrap/css/bootstrap.css/css/bootstrap.min.css"  type="text/css" media="screen">
         <link rel="stylesheet" href="themes/bstrap/css/bootstrap.css/css/bootstrap-theme.min.css"  type="text/css" media="screen">
      {else}
         <!-- Custom Bootstrap CSS -->
         <meta name="skin2" content="{$php_theme_css}">
         <link rel="stylesheet" href="themes/bstrap/css/{$pmp_theme_css}/css/bootstrap.min.css"  type="text/css" media="screen">
      {/if}
      
      <!-- Custom Bstrap styles by George -->
      <link rel="stylesheet" href="themes/bstrap/css/bootstrap.css/css/bootstrap-submenu.min.css"  type="text/css" media="screen">
      <link rel="stylesheet" href="themes/bstrap/css/bstrap/bstrap.css"  type="text/css" media="screen">
      
      <!-- Personal user styles -->
      <link rel="stylesheet" href="themes/bstrap/css/bstrap/custom.css"  type="text/css" media="screen">
      
      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
      <script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js?v=2.0.6"></script>
      <script type="text/javascript" src="js/functions.js"></script>
      <script type="text/javascript" src="js/overlib.js"></script>

      <!-- Fancybox 2 -->
      <!-- Add fancyBox main JS and CSS files -->
      <script type="text/javascript" src="themes/{$pmp_theme}/fancybox2/jquery.fancybox.js?v=2.1.5"></script>
      <link rel="stylesheet" type="text/css" href="themes/{$pmp_theme}/fancybox2/jquery.fancybox.css?v=2.1.5" media="screen">
      <!-- Add Button helper (this is optional) -->
      <link rel="stylesheet" type="text/css" href="themes/{$pmp_theme}/fancybox2/helpers/jquery.fancybox-buttons.css?v=1.0.5">
      <script type="text/javascript" src="themes/{$pmp_theme}/fancybox2/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
      <!-- Add Thumbnail helper (this is optional) -->
      <link rel="stylesheet" type="text/css" href="themes/{$pmp_theme}/fancybox2/helpers/jquery.fancybox-thumbs.css?v=1.0.7">
      <script type="text/javascript" src="themes/{$pmp_theme}/fancybox2/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
      <!-- Add Media helper (this is optional) -->
      <script type="text/javascript" src="themes/{$pmp_theme}/fancybox2/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
      
      <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
         <script src="themes/{$pmp_theme}/bootstrap/js/html5shiv.js"></script>
         <script src="themes/{$pmp_theme}/bootstrap/js/respond.min.js"></script>
      <![endif]-->

      {if $pmp_google == '1' && $pmp_tracking_code != ''}
      {literal}
         <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '{/literal}{$pmp_tracking_code}{literal}']);
            _gaq.push(['_trackPageview']);
            
            (function() {
               var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
               ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
               var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
         </script>
      {/literal}
      {/if}
   </head>

   <body>

      <noscript><div class="noscript">{t}Please activate JavaScript for all functions!{/t}</div></noscript>
   
      <!--[if lt IE 7]>
         <div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>
            <div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='themes/default/images/noie6/ie6nomore-cornerx.jpg' style='border: none;' alt='Close this notice'></a></div>
            <div style='width: 750px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>
               <div style='width: 75px; float: left;'><img src='themes/default/images/noie6/ie6nomore-warning.jpg' alt='Warning!'></div>
               <div style='width: 275px; float: left; font-family: Arial, sans-serif;'>
                  <div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>You are using an outdated browser</div>
                  <div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>For a better experience using this site, please upgrade to a modern web browser.</div>
               </div>
               <div style='width: 75px; float: left;'><a href='http://www.firefox.com'><img src='themes/default/images/noie6/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox 3.5'></a></div>
               <div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html'><img src='themes/default/images/noie6/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer 8'></a></div>
               <div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/'><img src='themes/default/images/noie6/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari 4'></a></div>
               <div style='width: 70px; float: left;'><a href='http://www.google.com/chrome'><img src='themes/default/images/noie6//ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'></a></div>
               <div style='float: left;'><a href='http://www.opera.com/browser/download/'><img src='themes/default/images/noie6/ie6nomore-opera.jpg' style='border: none;' alt='Get Opera'></a></div>
            </div>
         </div>
      <![endif]-->

      <!-- ==================================================================== 
      NAVBAR 
      -->
      <header class="navbar navbar-inverse navbar-fixed-top">
         <div class="container">
            <div class="navbar-header">
               <a href="index.php?content=start&amp;reset=1" class="navbar-brand" style="padding: 6px 0 0 0;"><img src="themes/{$pmp_theme}/images/logo.png" alt="" title="Reset Homepage" style="border: none;"></a>
               <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                  <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
               </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">
               <ul class="nav navbar-nav">
                  <li><a href="index.php?content=start&amp;skin={$pmp_theme_css}">{t}Home{/t}</a></li>
                  <li><a href="index.php?content=statistics&amp;skin={$pmp_theme_css}">{t}Statistics{/t}</a></li>
                  <li><a href="index.php?content=search&amp;skin={$pmp_theme_css}">{t}Search{/t}</a></li>
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" id="galleries">{t}Galleries{/t}<span class="caret"></span></a>
                     <ul class="dropdown-menu" aria-labelledby="galleries">
                        <li><a tabindex="-1" href="index.php?content=coverlist&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/cover_s.png" alt="">&nbsp;&nbsp;{t}Cover Gallery{/t}</a></li>
                        <li><a tabindex="-1" href="index.php?content=peoplelist&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/people_s.png" alt="">&nbsp;&nbsp;{t}People Gallery{/t}</a></li>
                        <li><a tabindex="-1" href="index.php?content=picturelist&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/photos_s.png" alt="">&nbsp;&nbsp;{t}Picture Gallery{/t}</a></li>
                     </ul>
                  </li>
                  {if $pmp_disable_newsarchive != 1 || $pmp_disable_guestbook != 1 || $pmp_disable_contact != 1}
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" id="communication">{t}Communication{/t}<span class="caret"></span></a>
                     <ul class="dropdown-menu" aria-labelledby="communication">
                        {if $pmp_disable_newsarchive != 1}
                        <li><a tabindex="-1" href="index.php?content=news&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/news_s.png" alt="">&nbsp;&nbsp;{t}News Archive{/t}</a></li>
                        {/if}
                        {if $pmp_disable_guestbook != 1}
                        <li><a tabindex="-1" href="index.php?content=guestbook&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/guestbook_s.png" alt="">&nbsp;&nbsp;{t}Guestbook{/t}</a></li>
                        {/if}
                        {if $pmp_disable_contact != 1}
                        <li><a tabindex="-1" href="index.php?content=contact&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/mail_s.png" alt="">&nbsp;&nbsp;{t}Contact{/t}</a></li>
                        {/if}
                     </ul>
                  </li>
                  {/if}
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" id="language">{t}Language{/t}<span class="caret"></span></a>
                     <ul class="dropdown-menu" aria-labelledby="language">
                        {foreach from=$getLangs item=Lang}
                        <li><a tabindex="-1" href="{$smarty.server.SCRIPT_NAME}?lang_id={$Lang}&amp;skin={$pmp_theme_css}">{$Lang|flag}&nbsp;&nbsp;{t}{$Lang}{/t}</a></li>
                        {/foreach}
                     </ul>
                  </li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" id="phpmyprofiler">phpMyProfiler<span class="caret"></span></a>
                     <ul class="dropdown-menu" aria-labelledby="phpmyprofiler">
                        <li><a href="admin"><img src="themes/{$pmp_theme}/images/menu/home_admin_s.png" alt="">&nbsp;&nbsp;{t}Administration{/t}</a></li>
                        <li><a tabindex="-1" href="index.php?content=credits&amp;skin={$pmp_theme_css}"><img src="themes/{$pmp_theme}/images/menu/info_s.png" alt="">&nbsp;&nbsp;{t}Credits{/t}</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                           <a tabindex="-1" href="#"><img src="themes/{$pmp_theme}/images/menu/skin_s.png" alt="">&nbsp;&nbsp;Skin</a>
                           <ul class="dropdown-menu">
                              <li><a tabindex="-1" href="index.php?skin=amelia.css">Amelia</a></li>
                              <li><a tabindex="-1" href="index.php?skin=bootstrap.css">Bootstrap</a></li>
                              <li><a tabindex="-1" href="index.php?skin=cerulean.css">Cerulean</a></li>
                              <li><a tabindex="-1" href="index.php?skin=cosmo.css">Cosmo</a></li>
                              <li><a tabindex="-1" href="index.php?skin=cyborg.css">Cyborg</a></li>
                              <li><a tabindex="-1" href="index.php?skin=flatly.css">Flatly</a></li>
                              <li><a tabindex="-1" href="index.php?skin=journal.css">Journal</a></li>
                              <li><a tabindex="-1" href="index.php?skin=readable.css">Readable</a></li>
                              <li><a tabindex="-1" href="index.php?skin=simplex.css">Simplex</a></li>
                              <li><a tabindex="-1" href="index.php?skin=slate.css">Slate</a></li>
                              <li><a tabindex="-1" href="index.php?skin=spacelab.css">Spacelab</a></li>
                              <li><a tabindex="-1" href="index.php?skin=united.css">United</a></li>
                              <li><a tabindex="-1" href="index.php?skin=yeti.css">Yeti</a></li>
                           </ul>
                        </li>
                        {if $pmp_disable_links != 1}
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="http://www.phpmyprofiler.de"><img src="themes/{$pmp_theme}/images/menu/internet_s.png" alt="">&nbsp;&nbsp;{t}phpMyProfiler Home{/t}</a></li>
                        <li><a tabindex="-1" href="http://forum.phpmyprofiler.de"><img src="themes/{$pmp_theme}/images/menu/internet_s.png" alt="">&nbsp;&nbsp;{t}phpMyProfiler Forum{/t}</a></li>
                        {/if}
                     </ul>
                  </li>
               </ul>
            </div>
         </div>
      </header> <!-- NAVBAR -->

      <!-- ==================================================================== 
      CONTAINER 
      -->
      <div class="container" style="padding-top: 60px;">
        
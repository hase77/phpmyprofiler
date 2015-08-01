<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>phpMyProfiler - Administration</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" media="screen" href="../themes/{$pmp_theme}/css/admin/admin.css"  type="text/css" />
		<link rel="stylesheet" media="print" href="../themes/{$pmp_theme}/css/admin/admin-print.css" type="text/css" />
		<link rel="stylesheet" media="screen" href="../js/fancybox/jquery.fancybox.css?v=v=2.1.5" type="text/css" />
		<link rel="stylesheet" media="screen" href="../themes/{$pmp_theme}/css/admin/jquery-ui.min.css"  type="text/css" />
		<link rel="shortcut icon" href="../favicon.ico" />

		<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
		<script type="text/javascript" src="../js/functions.js"></script>
		<script type="text/javascript" src="../js/overlib.js"></script>

		{if isset($Focus)}
			{literal}
				<script language="javascript" type="text/javascript">
					function FocusField()
					{
						document.formular.{/literal}{$Focus}{literal}.select();
						document.formular.{/literal}{$Focus}{literal}.focus();
					}
				</script>
			{/literal}
		{/if}
	</head>

	<body {if isset($Focus) && $Focus} onload="FocusField();"{/if}>
		{if !isset($nohead)}
			<form action="login.php?{$session}" method="post" target="_self" style="display: inline">
				<div id="menuback">
					<div id="menulogo">
						{if !isset($nologout)}
							<ul id="menu">
								<li>
									<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
									<dl>
										<dt><b class="p1">&nbsp;</b><b class="p2">&nbsp;</b><b class="p3">&nbsp;</b><b class="p4">&nbsp;</b><a href="index.php">{t}Common preferences{/t}</a></dt>
										<dd><a href="preferences.php?{$session}" title="{t}Change preferences{/t}"><img src="../themes/{$pmp_theme}/images/menu/config_s.png" border="0" alt="{t}Change preferences{/t}" style="vertical-align:middle;" /> {t}Preferences{/t}</a></dd>
										<dd><a href="passwd.php?{$session}" title="{t}Change password for admin area{/t}"><img src="../themes/{$pmp_theme}/images/menu/passwd_s.png" border="0" alt="{t}Change password for admin area{/t}" style="vertical-align:middle;" /> {t}Change password{/t}</a></dd>
										<dd><a href="phpinfo.php?{$session}" title="{t}Call PHP-info{/t}"><img src="../themes/{$pmp_theme}/images/menu/phpinfo_s.png" border="0" alt="{t}Call PHP-info{/t}" style="vertical-align:middle;" /> {t}Call PHP-info{/t}</a><b class="p8">&nbsp;</b><b class="p7">&nbsp;</b><b class="p6">&nbsp;</b><b class="p5">&nbsp;</b></dd>                      
									</dl>
									<!--[if lte IE 6]></td></tr></table></a><![endif]-->
								</li>
								<li>
									<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
									<dl>
										<dt><b class="p1">&nbsp;</b><b class="p2">&nbsp;</b><b class="p3">&nbsp;</b><b class="p4">&nbsp;</b><a href="index.php">{t}Refresh data{/t}</a></dt>
										<dd><a href="parse.php?{$session}" title="{t}Parse new collection{/t}"><img src="../themes/{$pmp_theme}/images/menu/parse_s.png" border="0" alt="{t}Parse new collection{/t}" style="vertical-align:middle;" /> {t}New collection{/t}</a></dd>
										<!-- Coverflow for later implementation <dd><a href="coverflow.php?{$session}" title="{t}Coverflow{/t}"><img src="../themes/{$pmp_theme}/images/menu/coverflow_s.png" border="0" alt="{t}Coverflow{/t}" style="vertical-align:middle;" /> {t}Coverflow{/t}</a></dd>-->
										<dd><a href="updateawards.php?{$session}" title="{t}Update award table{/t}"><img src="../themes/{$pmp_theme}/images/menu/updateawards_s.png" border="0" alt="{t}Update award table{/t}" style="vertical-align:middle;" /> {t}Update awards{/t}</a></dd>
										<dd><a href="updaterates.php?{$session}" title="{t}Update exchange rates{/t}"><img src="../themes/{$pmp_theme}/images/menu/updaterates_s.png" border="0" alt="{t}Update exchange rates{/t}" style="vertical-align:middle;" /> {t}Exchange rates{/t}</a></dd>
										{if !isset($nomovies)}<dd><a href="updateimdb.php?{$session}" title="{t}Update external reviews{/t}"><img src="../themes/{$pmp_theme}/images/menu/updateimdb_s.png" border="0" alt="{t}Update external reviews{/t}" style="vertical-align:middle;" /> {t}Update external reviews{/t}</a><b class="p8">&nbsp;</b><b class="p7">&nbsp;</b><b class="p6">&nbsp;</b><b class="p5">&nbsp;</b></dd>{/if}
									</dl>
									<!--[if lte IE 6]></td></tr></table></a><![endif]-->
								</li>
								<li>
									<!--[if lte IE 6]><a href="#nogo"><table><tr><td><![endif]-->
									<dl>
										<dt><b class="p1">&nbsp;</b><b class="p2">&nbsp;</b><b class="p3">&nbsp;</b><b class="p4">&nbsp;</b><a href="index.php">{t}Additional functions{/t}</a></dt>
										<dd><a href="news.php?{$session}" title="{t}News{/t}"><img src="../themes/{$pmp_theme}/images/menu/news_s.png" border="0" alt="{t}News{/t}" style="vertical-align:middle;" /> {t}News{/t}</a></dd>
										<dd><a href="pictures.php?{$session}" title="{t}Collection Pictures{/t}"><img src="../themes/{$pmp_theme}/images/menu/photos_s.png" border="0" alt="{t}Collection Pictures{/t}" style="vertical-align:middle;" /> {t}Collection Pictures{/t}</a></dd>
										{if isset($gbfound)}<dd><a href="guestbook.php?{$session}" title="{t}Guestbook{/t}"><img src="../themes/{$pmp_theme}/images/menu/guestbook_s.png" border="0" alt="{t}Guestbook{/t}" style="vertical-align:middle;" /> {t}Guestbook{/t}</a></dd>{/if}
										{if !isset($nomovies)}
											<dd><a href="reviews.php?{$session}" title="{t}Reviews{/t}"><img src="../themes/{$pmp_theme}/images/menu/reviews_s.png" border="0" alt="{t}Reviews{/t}" style="vertical-align:middle;" /> {t}Reviews{/t}</a></dd>
											<dd><a href="nocover.php?{$session}" title="{t}Check pictures of covers{/t}"><img src="../themes/{$pmp_theme}/images/menu/nocover_s.png" border="0" alt="{t}Check pictures of covers{/t}" style="vertical-align:middle;" /> {t}Check pictures of covers{/t}</a></dd>
											<dd><a href="screenshots.php?{$session}" title="{t}Screenshots{/t}"><img src="../themes/{$pmp_theme}/images/menu/screenshots_s.png" border="0" alt="{t}Screenshots{/t}" style="vertical-align:middle;" /> {t}Screenshots{/t}</a></dd>
											<dd><a href="report.php?{$session}" title="{t}Print listing{/t}"><img src="../themes/{$pmp_theme}/images/menu/report_s.png" border="0" alt="{t}Print listing{/t}" style="vertical-align:middle;" /> {t}Print listing{/t}</a></dd>
										{/if}
										<dd><a href="update.php?{$session}" title="{t}Refresh database{/t}" {if isset($StandDB) && $StandDB < $StandUpdate}style="border-color:red"{/if}><img src="../themes/{$pmp_theme}/images/menu/update_s.png" border="0" alt="{t}Refresh database{/t}" style="vertical-align:middle;" /> {t}Refresh database{/t}</a></dd>
										<dd><a href="checklang.php?{$session}" title="{t}Check translations{/t}"><img src="../themes/{$pmp_theme}/images/menu/checklang_s.png" border="0" alt="{t}Check translations{/t}" style="vertical-align:middle;" /> {t}Check translations{/t}</a><b class="p8">&nbsp;</b><b class="p7">&nbsp;</b><b class="p6">&nbsp;</b><b class="p5">&nbsp;</b></dd>
									</dl>
									<!--[if lte IE 6]></td></tr></table></a><![endif]-->
								</li>
							</ul>
        						<div id="menulogout">
								<input name="logout" type="text" value="true" style="visibility:hidden; width:0px;" />
								<input id="menubutton" type="submit" value="{t}Logout{/t}" />
							</div>
						{/if}
					</div>
				</div>
			</form>
			{if isset($header)}
				<div id="mainheader">
					<div style="float: left">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><img src="../themes/{$pmp_theme}/images/menu/{$header_img}.png" border="0" alt="{$header}" /></td>
								<td style="padding-left: 20px; padding-top: 2px; font-size: 16px"><strong>{$header}</strong></td>
							</tr>
						</table>
					</div>
					<div style="float: right; text-align: right">
						{if $header_img == "upload"}<a href="parse.php?{$session}">{t}Back to parsing menu...{/t}</a><br /><br />{/if}
						{if $header_img == "uploadcsv"}<a href="updateawards.php?{$session}">{t}Back to award menu...{/t}</a><br /><br />{/if}
						{if $header_img == "getcover"}<a href="nocover.php?{$session}">{t}Back to Cover overview{/t}</a><br /><br />{/if}
						{if $header_img == "getheadshot"}<a href="headshot.php?{$session}">{t}Back to headshots{/t}</a><br /><br />{/if}
						{if $header_img == "screenshots" && isset($show) && $show == 1}<a href="screenshots.php?{$session}">{t}Back to screenshots{/t}</a><br /><br />{/if}
						{if isset($editadd)}<a href="news.php?{$session}">{t}Back to the News{/t}</a><br /><br />{/if}
						<a href="index.php?{$session}">{t}Back to admin menu{/t}</a>
					</div>
					<div style="clear: both"></div>
				</div>
			{/if}
		{else}
			<div id="mainheader" style="height: 5px">
				<div style="float:right">
					<a href="javascript:window.close()">{t}Close{/t}</a>
				</div>
				<div style="clear: both"></div>
			</div>
		{/if}

		<div id="main">
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="robots" content="noindex, nofollow" />
		<title>{$pmp_pagetitle}</title>
		<link rel="stylesheet" href="themes/{$pmp_theme}/css/{$pmp_theme}.css.php"  type="text/css" media="screen" />
		<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<link rel="stylesheet" href="js/morris-0.5.1.css" type="text/css" media="screen" />
		
		<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
		<script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="js/overlib.js"></script>
		<script type="text/javascript" src="js/raphael-2.1.2.min.js"></script>
		<script type="text/javascript" src="js/morris-0.5.1.min.js"></script>

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
			<div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='themes/default/images/noie6/ie6nomore-cornerx.jpg' style='border: none;' alt='Close this notice'/></a></div>
			<div style='width: 750px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>
				<div style='width: 75px; float: left;'><img src='themes/default/images/noie6/ie6nomore-warning.jpg' alt='Warning!'/></div>
				<div style='width: 275px; float: left; font-family: Arial, sans-serif;'>
					<div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>You are using an outdated browser</div>
					<div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>For a better experience using this site, please upgrade to a modern web browser.</div>
				</div>
				<div style='width: 75px; float: left;'><a href='http://www.firefox.com'><img src='themes/default/images/noie6/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox 3.5'/></a></div>
				<div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html'><img src='themes/default/images/noie6/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer 8'/></a></div>
				<div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/'><img src='themes/default/images/noie6/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari 4'/></a></div>
				<div style='width: 70px; float: left;'><a href='http://www.google.com/chrome'><img src='themes/default/images/noie6//ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div>
				<div style='float: left;'><a href='http://www.opera.com/browser/download/'><img src='themes/default/images/noie6/ie6nomore-opera.jpg' style='border: none;' alt='Get Opera'/></a></div>
			</div>
		</div>
	<![endif]-->

	<table class="banner">
		<tr>
			<td class="banner"><img src="themes/{$pmp_theme}/images/banner.png" alt="" title="" style="border: none;"/></td>
		</tr>
	</table>

	<table class="shortcut-bar">
		<tr>
			<td class="shortcut-bar">
				<table>
					<tr>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=start"><img src="themes/{$pmp_theme}/images/shortcut-bar/home.png" alt="{t}Home{/t}" title="{t}Home{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=statistics"><img src="themes/{$pmp_theme}/images/shortcut-bar/statistics.png" alt="{t}Statistics{/t}" title="{t}Statistics{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=search"><img src="themes/{$pmp_theme}/images/shortcut-bar/search.png" alt="{t}Search{/t}" title="{t}Search{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-split"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=coverlist"><img src="themes/{$pmp_theme}/images/shortcut-bar/cover-gallery.png" alt="{t}Cover Gallery{/t}" title="{t}Cover Gallery{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=peoplelist"><img src="themes/{$pmp_theme}/images/shortcut-bar/people-gallery.png" alt="{t}People Gallery{/t}" title="{t}People Gallery{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=picturelist"><img src="themes/{$pmp_theme}/images/shortcut-bar/photo-gallery.png" alt="{t}Picture Gallery{/t}" title="{t}Picture Gallery{/t}" style="border: none;"/></a>
						</td>
						{if $pmp_disable_newsarchive != 1 || $pmp_disable_guestbook != 1 || $pmp_disable_contact != 1}
						<td class="shortcut-split"></td>
						{/if}
						{if $pmp_disable_newsarchive != 1}
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=news"><img src="themes/{$pmp_theme}/images/shortcut-bar/news.png" alt="{t}News Archive{/t}" title="{t}News Archive{/t}" style="border: none;"/></a>
						</td>
						{/if}
						{if $pmp_disable_guestbook != 1}
						{if $pmp_disable_newsarchive != 1}
						<td class="shortcut-space"></td>
						{/if}
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=guestbook"><img src="themes/{$pmp_theme}/images/shortcut-bar/guestbook.png" alt="{t}Guestbook{/t}" title="{t}Guestbook{/t}" style="border: none;"/></a>
						</td>
						{/if}
						{if $pmp_disable_contact != 1}
						{if $pmp_disable_newsarchive != 1 || $pmp_disable_guestbook != 1}
						<td class="shortcut-space"></td>
						{/if}
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=contact"><img src="themes/{$pmp_theme}/images/shortcut-bar/contact.png" alt="{t}Contact{/t}" title="{t}Contact{/t}" style="border: none;"/></a>
						</td>
						{/if}
						<td class="shortcut-split"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="admin/index.php"><img src="themes/{$pmp_theme}/images/shortcut-bar/admin.png" alt="{t}Administration{/t}" title="{t}Administration{/t}" style="border: none;"/></a>
						</td>
						{if $pmp_disable_links != 1}
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="http://www.phpmyprofiler.de"><img src="themes/{$pmp_theme}/images/shortcut-bar/homepage.png" alt="{t}phpMyProfiler Home{/t}" title="{t}phpMyProfiler Home{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="https://forum.phpmyprofiler.de"><img src="themes/{$pmp_theme}/images/shortcut-bar/forum.png" alt="{t}phpMyProfiler Forum{/t}" title="{t}phpMyProfiler Forum{/t}" style="border: none;"/></a>
						</td>
						{/if}
						<td class="shortcut-space"></td>
						<td class="shortcut" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
							<a href="index.php?content=credits"><img src="themes/{$pmp_theme}/images/shortcut-bar/about.png" alt="{t}Credits{/t}" title="{t}Credits{/t}" style="border: none;"/></a>
						</td>
						<td class="shortcut-split"></td>
					</tr>
				</table>
			</td>
			<td class="shortcut-bar" style="text-align: right; width: 165px;">
				<table>
					<tr>
						{foreach from=$getLangs item=Lang}
							<td class="shortcut" style="text-align: right;" onmouseover="this.className='shortcut-hover';" onmouseout="this.className='shortcut';">
								<a href="{$smarty.server.SCRIPT_NAME}?lang_id={$Lang}">{$Lang|flag}</a>
							</td>
						{/foreach}
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table width="100%">
		<tr>

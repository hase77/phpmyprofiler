{include file="admin/header.tpl"}

<div id="mainerror">
	{if (($pmp_checkforupdates == '1' && isset($latestrelease)) || (isset($stateDB) && $stateDB < $stateUpdate) || (isset($guestbook) && $guestbook > 0) || (isset($reviews) && $reviews > 0))}
		<div class="info_box">
			<div class="info_headline">{t}Information{/t}:</div>
			<div class="info_msg">
				<ul>
					{if ($pmp_checkforupdates == '1' && isset($latestrelease))}
						<li>{t}You are using phpMyProfiler version{/t} {$pmp_version}<br />
						{t}Last release version from www.phpmyprofiler.de is{/t} {$latestrelease}</li>
					{/if}
					{if isset($stateDB) && $stateDB < $stateUpdate}<li>{t update=$stateUpdate}New update %update is available. Please refresh your database.{/t}</li>{/if}
					{if isset($guestbook) && $guestbook > 0}<li>{t gb=$guestbook}You have %gb new guestbook entries to activate.{/t}</li>{/if}
					{if isset($reviews) && $reviews > 0}<li>{t review=$reviews}You have %review new review entries to activate.{/t}</li>{/if}
				</ul>
			</div>&nbsp;
		</div>
	{/if}
</div>

<div id="menupanel">
	{* Global Configuration *}
	<div class="link"><h2>{t}Common preferences:{/t}</h2></div>
	<div style="clear: left"></div>

	<div class="link"><a href="preferences.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/config.png" align="middle" border="0" alt="{t}Change preferences{/t}" /><br />{t}Change preferences{/t}</a></div>
	<div class="link"><a href="passwd.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/passwd.png" align="middle" border="0" alt="{t}Change password for admin area{/t}" /><br />{t}Change password for admin area{/t}</a></div>
	<div class="link"><a href="phpinfo.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/phpinfo.png" align="middle" border="0" alt="{t}Call PHP-info{/t}" /><br />{t}Call PHP-info{/t}</a></div>
	<div style="clear: left"></div>

	{* Insert New / Delete / Refresh Collection *}
	<div class="link"><h2>{t}Insert/refresh data:{/t}</h2></div>
	<div style="clear: left"></div>

	<div class="link"><a href="parse.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/parse.png" align="middle" border="0" alt="{t}Parse new collection{/t}" /><br />{t}Parse new collection{/t}</a></div>
	<div class="link"><a href="updateawards.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/updateawards.png" align="middle" border="0" alt="{t}Update award table{/t}" /><br />{t}Update award table{/t}</a></div>
	<div class="link"><a href="updaterates.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/updaterates.png" align="middle" border="0" alt="{t}Update exchange rates{/t}" /><br />{t}Update exchange rates{/t}</a></div>
	{if !isset($nomovies)}<div class="link"><a href="updateimdb.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/updateimdb.png" align="middle" border="0" alt="{t}Update external reviews{/t}" /><br />{t}Update external reviews{/t}</a></div>{/if}
	<div style="clear: left"></div>

	{* Other Functions *}
	<div class="link"> <h2>{t}Additional functions{/t}:</h2></div>
	<div style="clear: left"></div>

	<div class="link"><a href="news.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/news.png" align="middle" border="0" alt="{t}News{/t}" /><br />{t}News{/t}</a></div>
	<div class="link"><a href="pictures.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/photos.png" align="middle" border="0" alt="{t}Collection Pictures{/t}" /><br />{t}Collection Pictures{/t}</a></div>
	{if isset($gbfound)}<div class="link"><a href="guestbook.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/guestbook.png" align="middle" border="0" alt="{t}Guestbook{/t}" /><br />{t}Guestbook{/t}</a></div>{/if}
	{if !isset($nomovies)}
		{if isset($reviewsfound)}<div class="link"><a href="reviews.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/reviews.png" align="middle" border="0" alt="{t}Reviews{/t}" /><br />{t}Reviews{/t}</a></div>{/if}
		<div class="link"><a href="nocover.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/nocover.png" align="middle" border="0" alt="{t}Check pictures of covers{/t}" /><br />{t}Check pictures of covers{/t}</a></div>
		<div class="link"><a href="screenshots.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/screenshots.png" align="middle" border="0" alt="{t}Screenshots{/t}" /><br />{t}Screenshots{/t}</a></div>
		<div class="link"><a href="report.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/report.png" align="middle" border="0" alt="{t}Print listing{/t}" /><br />{t}Print listing{/t}</a></div>
	{/if}
	<div class="link"><a href="update.php?{$session}" {if isset($StandDB) && $StandDB < $StandUpdate}style="border-color:red"{/if}><br /><img src="../themes/{$pmp_theme}/images/menu/update.png" align="middle" border="0" alt="{t}Refresh database{/t}" /><br />{t}Refresh database{/t}</a></div>
	<div class="link"><a href="checklang.php?{$session}"><br /><img src="../themes/{$pmp_theme}/images/menu/checklang.png" align="middle" border="0" alt="{t}Check translations{/t}" /><br />{t}Check translations{/t}</a></div>
	<div style="clear: left"></div>
</div>

{include file="admin/footer.tpl"}

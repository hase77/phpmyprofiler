<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Guestbook"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Information{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{t}Number of comments{/t}: {$count}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Add your comment{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{if $pmp_guestbook_activatenew == 0}
					<p>
					{t}New comments will be invisible until the administrator activates them.{/t}
					</p>
				{/if}
				{if isset($Failed)}
					<div class="error_box">
						<div class="error_headline">
							{t}Sorry, an error has occurred{/t}:
						</div>
						<div class="error_msg">
							{$Failed}
						</div>
					</div>
				{/if}
				{if isset($Success)}
					<div class="success">
						{$Success}
					</div>
				{/if}

				<form id="guestbook" method="post" action="index.php?content=guestbook&amp;action=save" accept-charset="utf-8">
					<table class="gb_form">
						<tr>
							<td class="gb_form">{t}Name{/t}:</td>
							<td class="gb_form">
								<input type="text" tabindex="1" name="name" size="32" value="{if !empty($name)}{$name}{/if}" />
								<input type="hidden" name="username" />
								{* Hidden input for form key *}
								<input type="hidden" name="form_key" value="{$formkey}" />
							</td>
						</tr>
						<tr>
							<td class="gb_form">{t}E-mail{/t}:</td>
							<td class="gb_form">
								<input type="text" tabindex="2" name="email" size="32" value="{if !empty($email)}{$email}{/if}" />
							</td>
						</tr>
						<tr>
							<td class="gb_form">{t}Homepage{/t}:</td>
							<td class="gb_form">
								<input type="text" tabindex="3" name="url" size="32" value="{if !empty($url)}{$url}{/if}" />
							</td>
						</tr>
						<tr>
							<td class="gb_form">{t}Comment{/t}:<br />
							<br />
							{foreach from=$emoticons item=emoticon key=sch name=emo}
								<a href="javascript:insertSmiley('{$sch}')"><img src="themes/{$pmp_theme}/images/emoticons/{$emoticon}" alt="{$sch}" /></a>
								{if $smarty.foreach.emo.iteration % 4 == 0} <br />{/if}
							{/foreach}
							</td>
							<td class="gb_form"><textarea tabindex="4" rows="10" name="message" cols="31">{if !empty($message)}{$message}{/if}</textarea></td>
						</tr>
						{if $pmp_guestbook_showcode == 1}
							<tr>
								<td class="gb_form">{t}Enter security code, please{/t}:</td>
								<td class="gb_form">
									<table class="gb_form">
										<tr>
											<td class="gb_form"><img src="{$imgLoc}" alt="[{t}Security code{/t}]" style="float:left; margin-right:5px" /></td>
											<td class="gb_form"><input type="hidden" name="image" value="{$imgLoc}" /></td>
										</tr>
										<tr>
											<td class="gb_form"><input tabindex="5" type="text" name="code" size="15" /></td>
										</tr>
									</table>
								</td>
							</tr>
						{/if}
						<tr>
							<td class="gb_form"></td>
							<td class="gb_form">
								<input tabindex="6" type="submit" value="{t}Add comment{/t}" class="button" onmouseover="this.className='button-over';" onmouseout="this.className='button';" />
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Guest Book Entries{/t}:&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
			    {if $entries}
					<table class="gb_entries">
						{foreach from=$entries item=entry key=sch name=ent}
							<tr>
								<td class="gb_entry_nr">
									{$entry->nr})
								</td>
								<td class="gb_entry_from">
									{if $entry->email != ''}
										{$entry->date} - {mailto address=$entry->email encode="javascript" text=$entry->name|stripslashes}
									{else}
										{$entry->name|stripslashes}
									{/if}
									{if $entry->url != ''}
										(<a href="{$entry->url}" target="_blank">{$entry->url}</a>)
									{/if}
									{t}wrote{/t}:
								</td>
							</tr>
							<tr>
								<td class="gb_entry_text">&nbsp;</td>
								<td class="gb_entry_text">
									{$entry->text|stripslashes|nl2br}<br />
									{if $entry->comment != ''} <br />
										<div class="gb_entry_answer_from">
											{t}Reply by{/t} {$pmp_admin_name}:<br />
										</div>
										<div class="gb_entry_answer_text">
											{$entry->comment|stripslashes|nl2br}
										</div>
									{/if}
								</td>
							</tr>
						{/foreach}
					</table>
				{/if}
			</td>
		</tr>
	</table>

	{if $pages > 1}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Navigation{/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content-center">
					{if $page > 1}<a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$page-1}">&lt;&lt;</a>{/if}
					&nbsp;{t}Page{/t} {$page} {t}of{/t} {$pages}
					{if $page < $pages}<a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$page+1}">&gt;&gt;</a>{/if}<br />
					{section name="Pages" start=1 loop=$pages+1}
						{if $page == $smarty.section.Pages.index}
							<strong>
						{else}
							<a href="{$smarty.server.SCRIPT_NAME}?content=guestbook&amp;page={$smarty.section.Pages.index}">
						{/if}
						{$smarty.section.Pages.index}
						{if $page == $smarty.section.Pages.index}
							</strong>
						{else}
							</a>
						{/if}
					{/section}
				</td>
			</tr>
		</table>
	{/if}

	{include file="window-end.inc.tpl"}

</div>

</td>

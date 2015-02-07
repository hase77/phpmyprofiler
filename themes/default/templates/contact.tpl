<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Contact"}
	{include file="window-start.inc.tpl"}

	{if $pmp_admin_mail != ''}
		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Information{/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
					<div style="text-align: left;">
						{if $pmp_imprint == '1'}
							<b>{$pmp_admin_full}</b> ({$pmp_admin_name})<br />
							{t}E-mail{/t}: {mailto address=$pmp_admin_mail encode="javascript" text=$pmp_admin_mail_s}<br />
							{$pmp_admin_adr}<br />
							{$pmp_admin_zip} - {$pmp_admin_loc}<br />
							<b>{$pmp_admin_cnt}</b>
						{else}
							<b>{t}Administrator{/t}:</b> {$pmp_admin_name}<br />
							{t}E-mail{/t}: {if $pmp_admin_mail}{mailto address=$pmp_admin_mail encode="javascript" text=$pmp_admin_mail_s}{/if}<br />
						{/if}
						<br />
						<br />
						{t}At this point you have the opportunity to contact the administrator of this DVD collection.{/t}<br />
						{t}Please fill out the form and submit ...{/t}<br />&nbsp;
					</div>
				</td>
			</tr>
		</table>

		<table class="frame">
			<tr>
				<td class="frame-title">
					<div class="frame-title">&nbsp;&nbsp;{t}Write your message{/t}&nbsp;&nbsp;</div>
				</td>
				<td class="frame-title-right"></td>
			</tr>
			<tr>
				<td colspan="2" class="frame-content">
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

					<form method="post" action="index.php?content=contact&amp;action=send" accept-charset="utf-8">
						<table class="gb_form">
							<tr>
								<td class="gb_form">{t}Name{/t}</td>
								<td class="gb_form">
									<input type="text" name="name" tabindex="1" size="32" value="{if !empty($name)}{$name}{/if}" />
									<input type="hidden" name="username" />
									{* Hidden input for form key *}
									<input type="hidden" name="form_key" value="{$formkey}" />
								</td>
							</tr>
							<tr>
								<td class="gb_form">{t}E-mail{/t}</td>
								<td class="gb_form">
									<input type="text" name="email" tabindex="2" size="32" value="{if !empty($email)}{$email}{/if}" />
								</td>
							</tr>
							<tr>
								<td class="gb_form">{t}Subject{/t}</td>
								<td class="gb_form">
									<input type="text" name="subject" tabindex="3" size="32" value="{if !empty($subject)}{$subject}{/if}" />
								</td>
							</tr>
							<tr>
								<td class="gb_form">{t}Message{/t}</td>
								<td class="gb_form">
									<textarea rows="5" name="message" tabindex="4" cols="31" >{if !empty($message)}{$message}{/if}</textarea>
								</td>
							</tr>
							{if $pmp_guestbook_showcode == '1'}
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
								<td class="gb_form"><input type="submit" tabindex="6" value="{t}Send Message{/t}" name="send" class="button" onmouseover="this.className='button-over';" onmouseout="this.className='button';" /></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	{/if}

	{include file="window-end.inc.tpl"}

</div>

</td>

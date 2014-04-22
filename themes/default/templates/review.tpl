<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value=$title}
	{assign var="filmtitle" value=$film->Title}
	{assign var="windowtitle" value="$windowtitle '$filmtitle'"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Add your review{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<table class="gb_form">
					<tr>
						<td class="gb_form">
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
							<form method="post" action="index.php?content=review&amp;action=send&amp;id={$id}" accept-charset="utf-8">
								<table class="gb_form">
									<tr>
										<td class="gb_form">{t}Name{/t}</td>
										<td class="gb_form">
											<input type="text" tabindex="1" name="name" size="30" value="{if isset($smarty.post.name)}{$smarty.post.name}{/if}" />
											<input type="hidden" name="username" />
											{* Hidden input for form key *}
											<input type="hidden" name="form_key" value="{$formkey}" />
										</td>
									</tr>
									<tr>
										<td class="gb_form">{t}E-mail{/t}</td>
										<td class="gb_form">
											<input type="text" tabindex="2" name="email" size="30" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
										</td>
									</tr>
									<tr>
										<td class="gb_form">{t}Title of review{/t}</td>
										<td class="gb_form">
											<input type="text" tabindex="3" name="title" size="30" value="{if isset($smarty.post.title)}{$smarty.post.title}{/if}" />
										</td>
									</tr>
									<tr>
										<td class="gb_form">{t}Review text (without format strings!){/t}</td>
										<td class="gb_form"><textarea tabindex="4" rows="5" name="text" cols="30">{if isset($smarty.post.text)}{$smarty.post.text}{/if}</textarea></td>
									</tr>
									<tr>
										<td class="gb_form">{t}Review{/t}</td>
										<td class="gb_form">
											<select tabindex="5" name="vote">
												<option value="9" {if isset($smarty.post.vote) && $smarty.post.vote == '9'}selected="selected"{/if}>9 ({t}excellent{/t})</option>
												<option value="8" {if isset($smarty.post.vote) && $smarty.post.vote == '8'}selected="selected"{/if}>8</option>
												<option value="7" {if isset($smarty.post.vote) && $smarty.post.vote == '7'}selected="selected"{/if}>7</option>
												<option value="6" {if isset($smarty.post.vote) && $smarty.post.vote == '6'}selected="selected"{/if}>6</option>
												<option value="5" {if isset($smarty.post.vote) && $smarty.post.vote == '5'}selected="selected"{/if}>5 ({t}fair{/t})</option>
												<option value="4" {if isset($smarty.post.vote) && $smarty.post.vote == '4'}selected="selected"{/if}>4</option>
												<option value="3" {if isset($smarty.post.vote) && $smarty.post.vote == '3'}selected="selected"{/if}>3</option>
												<option value="2" {if isset($smarty.post.vote) && $smarty.post.vote == '2'}selected="selected"{/if}>2</option>
												<option value="1" {if isset($smarty.post.vote) && $smarty.post.vote == '1'}selected="selected"{/if}>1 ({t}bad{/t})</option>
											</select>
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
													<td class="gb_form"><input tabindex="6" type="text" name="code" size="15" /></td>
												</tr>
												</table>
											</td>
										</tr>
									{/if}
									<tr>
										<td class="gb_form"></td>
										<td class="gb_form">
											<input type="submit" tabindex="7" value="{t}Submit{/t}" name="send" class="button" onmouseover="this.className='button-over';" onmouseout="this.className='button';" />
										</td>
									</tr>
								</table>
							</form>
							{if $pmp_review_activatenew == '0'} <u>{t}Important{/t}: </u> {t}Your submitted review will show up, as soon as the administrator has activated it. You'll receive an e-mail, when your review is activated{/t}. {/if}
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	{include file="window-end.inc.tpl"}

</div>

</td>

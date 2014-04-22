{include file="admin/header.tpl"}

{literal}
<script type="text/javascript">
//<![CDATA[
	$(function() {
		$( "#configmain" ).tabs();
	});
//]]>
</script>
{/literal}
 
<div id="mainerror">
    {include file="admin/mainerror.tpl"}
</div>
<form action="preferences.php?action=save&amp;{$session}" method="post" target="_self" style="display: inline" accept-charset="utf-8">
<div id="configmain">
	 <ul>
		<li style="margin-left:10px;"><a href="#tabs-1">{t}Main settings{/t}</a></li>
		<li><a href="#tabs-2">{t}Parser settings{/t}</a></li>
		<li><a href="#tabs-3">{t}Display settings for profiles{/t}</a></li>
	</ul>
	{foreach item=Option from=$Options}
		{if $Option eq 'Main settings'}
			<div id="tabs-1">
				<table width="100%" style="width: 100%">
					<tr><td colspan="3" class="configlabel">{t}{$Option}{/t}</td></tr>
		{else if $Option eq 'Parser settings'}
				</table>
			</div>
			<div id="tabs-2">
				<table width="100%" style="width: 100%">
					<tr><td colspan="3" class="configlabel">{t}{$Option}{/t}</td></tr>
		{else if $Option eq 'Display settings for profiles'}
				</table>
			</div>
			<div id="tabs-3">
				<table width="100%" style="width: 100%">
					<tr><td colspan="3" class="configlabel">{t}{$Option}{/t}</td></tr>
		{else}
			<tr>
				{if $Option|@is_string}
					<td colspan="3" class="configlabel">{t}{$Option}{/t}</td>
				{else}
					<td width="10" style="width: 10px">&nbsp;</td>
					<td style="padding-top: 10px; border-bottom: 1px dashed #cccccc; text-align: left;">
						<strong>{t}{$Option->Name}{/t}</strong><br />{t}{$Option->Description}{/t}
					</td>
						<td style="border-bottom: 1px dashed #cccccc; vertical-align: bottom; text-align: left; width:252px;">
						{if $Option->Child == 1}
							<input type="text" name="{$Option->Var}" value="{$Option->Value}" style="width:252px;" />
						{else}
							{if $Option->Child == 3}
								<input type="password" name="{$Option->Var}" value="{$Option->Value}" style="width:252px;" />
							{else}
								<select name="{$Option->Var}" style="width:260px;">
									{foreach item=Item from=$Option->Optionlist key=value}
										<option value="{$value}"
											{if $value==$Option->Value}selected="selected"{/if}>
											{t}{$Item}{/t}
										</option>
									{/foreach}
								</select>
							{/if}
						{/if}
					</td>
				{/if}
			</tr>
		{/if}
	{/foreach}
		</table>
	</div>
</div>
	<table width="100%" style="width: 100%">
		<tr><td colspan="3" id="configlabel">&nbsp;</td></tr>
		<tr style="text-align: center; " align="center">
		<td colspan="3" style="padding-top: 20px; padding-bottom: 10px">
		    <input type="reset" value="{t}Reset{/t}" />
		    <input type="submit" value="{t}Save configuration{/t}" {if isset($Error) && $Error != ''}style="color: grey" disabled {/if}/>
		</td>
		</tr>
	</table>
	</form>

{include file="admin/footer.tpl"}
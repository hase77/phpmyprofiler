{include file="admin/header.tpl"}

<div id="mainerror">
    {if isset($BigError)}
	<div class="error_box">
	    <div class="error_headline">{t}Sorry, an error has occurred{/t}:</div>
	    <div class="error_msg">{$BigError}</div>&nbsp;
	</div>
    {/if}

    {if isset($Success)}
	<div class="success_box">
	    <div class="success_headline">{t}Success{/t}</div>
	    <div class="success_msg">{$Success}</div>&nbsp;
	</div>
    {/if}

    {if isset($ErrorCur) || isset($ErrorNew)}
	<div class="error_box">
	    <div class="error_headline">{t}Sorry, an error has occurred{/t}:</div>
	    <div class="error_msg">
		<ul>
		    {if isset($ErrorCur)}<li>{$ErrorCur}</li>{/if}
		    {if isset($ErrorNew)}<li>{$ErrorNew}</li>{/if}
		</ul>
	    </div>&nbsp;
	</div>
    {/if}
</div>

<div id="mainpanel" align="center">
    {if !isset($BigError)}
	<form action="passwd.php?{$session}" method="post" target="_self" style="visibility: inline" name="formular" accept-charset="utf-8">
	    <table class="box" cellspacing="0" cellpadding="0" border="0">
		{if !isset($NoUser)}
		    <tr>
			<td valign="top" align="left" style="padding-top: 10px">{t}Current Username{/t}</td>
			<td><input name="cur_user" type="text" class="loginbox" size="18" {if isset($LastCurUser)}value="{$LastCurUser}"{/if} /></td>
		    </tr>
		    <tr>
			<td valign="top" align="left" style="padding-top: 10px">{t}Current Password{/t}</td>
			<td><input name="cur_passwd" type="password" class="loginbox" size="18" {if isset($LastCurPasswd)}value="{$LastCurPasswd}"{/if} /></td>
		    </tr>
		    <tr><td colspan="2"><hr /></td></tr>
		{/if}
		<tr>
		    <td valign="top" align="left" style="padding-top: 10px">{t}New Username{/t}</td>
		    <td><input name="new_user" type="text" class="loginbox" size="18" {if isset($LastNewUser) && $LastNewUser}value="{$LastNewUser}"{/if} /></td>
		</tr>
		<tr>
		    <td valign="top" align="left" style="padding-top: 10px">{t}New Password{/t}</td>
		    <td><input name="new_passwd" type="password" class="loginbox" size="18" {if isset($LastNewPasswd) && $LastNewPasswd}value="{$LastNewPasswd}"{/if} /></td>
		</tr>
		<tr>
		    <td valign="top" align="left" style="padding-top: 10px">{t}Retype new Password{/t}</td>
		    <td><input name="new_passwd2" type="password" class="loginbox" size="18" {if isset($LastNewPasswd2) && $LastNewPasswd2}value="{$LastNewPasswd2}"{/if} /></td>
		</tr>
		<tr>
		    <td colspan="2" align="center" style="text-align: center">
			<input name="setpasswd" type="text" value="true" style="visibility:hidden; display: none" /><br />
			<input type="submit" value="{t}Save changes{/t}" />
			<input type="reset" value="{t}Clear{/t}" />
		    </td>
		</tr>
	    </table>
	</form>
    {/if}
</div>

{include file="admin/footer.tpl"}

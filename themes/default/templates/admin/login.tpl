{include file="admin/header.tpl"}

<div style="text-align: center;" align="center">

    <div id="mainerror" style="text-align:left; margin-left:auto; margin-right:auto; width: 550px">
	{include file="admin/mainerror.tpl"}
    </div>


    <div id="mainpanel" style="margin-left: auto; margin-right: auto; width: 500px">
	<h1 style="margin-top: 10px; margin-bottom: 10px">{t}Logon{/t}</h1>

	<div style="text-align: left; float: right; width: 60%;">
	    <form action="logincheck.php?{$session}" method="post" target="_self" name="formular" accept-charset="utf-8">
		<div class="box">
		    <table cellpadding="0" cellspacing="3" border="0" width="100%" style="width: 100%">
			<tr>
			    <td>{t}Username{/t}</td>
			    <td>
				<input name="user" type="text" size="18" value="{if isset($Username)}{$Username}{/if}" />
				{* Hidden input for form key *}
				<input type="hidden" name="form_key" value="{$formkey}" />
			    </td>
			</tr>
			<tr>
			    <td>{t}Password{/t}</td>
			    <td><input name="passwd" type="password" size="18" /></td>
			</tr>
			<tr>
			    <td colspan="2" align="center">
				<input name="login" type="text" value="true" style="visibility:hidden; display: none" />
				<input type="submit" name="submit" value="{t}Login{/t}" />
			    </td>
			</tr>
		    </table>
		</div>
	    </form>
	</div>

	<div style="text-align:left; width:40%; float:left;">
	    <div style="text-align:center;"><img src="../themes/{$pmp_theme}/images/login.png" width="128" height="128" alt="login" /></div>
	</div>
	<br />
	<div style="text-align:left; width:100%; float:left;"><p>{t}Use a valid username and password to gain access to the administration console.{/t}</p></div>

	<div style="clear:both;"></div>
    </div>
</div>

{include file="admin/footer.tpl"}

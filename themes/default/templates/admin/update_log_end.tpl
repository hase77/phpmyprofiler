    <br />
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="text-align: center">
	<tr><td>
	    <table cellpadding="0" cellspacing="0" border="0" class="box" style="text-align: left; width: 500px">
		<tr>
		    <td width="36px">
			{if $founderror}
			    <img src="../themes/{$pmp_theme}/images/messagebox_error.jpg" alt="{t}Error{/t}" />
			{else}
			    <img src="../themes/{$pmp_theme}/images/messagebox_success.jpg" alt="{t}Success{/t}" />
			{/if}
		    </td>
		    <td style="vertical-align:middle">
			<strong>
			    {if $founderror}
				{t}Error: The update was not successful!{/t}
			    {else}
				{t}Success. The database is now up-to-date{/t}
			    {/if}
			</strong>
		    </td>
		</tr>
	    </table>
	</td></tr>
    </table>
</div>

{include file="admin/footer.tpl"}

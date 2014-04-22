{* Each message get a new table to put die-on-error-messages at the bottom of the table *}
<table cellpadding="0" cellspacing="0" border="0" align="center" style="text-align: center">
    <tr><td>
	<table cellpadding="0" cellspacing="0" border="0" class="box" style="text-align: left; width: 500px">
	    <tr>
		<td width="36">
		    {if $type == 'S'}
			<img src="../themes/{$pmp_theme}/images/messagebox_success.jpg" alt="{t}Success{/t}" border="0" />
		    {elseif $type == 'I'}
			<img src="../themes/{$pmp_theme}/images/messagebox_info.jpg" alt="{t}Information{/t}" border="0" />
		    {elseif $type == 'W'}
			<img src="../themes/{$pmp_theme}/images/messagebox_warning.jpg" alt="{t}Warning{/t}" border="0" />
		    {elseif $type == 'E'}
			<img src="../themes/{$pmp_theme}/images/messagebox_error.jpg" alt="{t}Error{/t}" border="0" />
		    {/if}
		</td>
		<td style="vertical-align:middle">{t}{$msg}{/t}</td>
	    </tr>
	</table>
    </td></tr>
</table>

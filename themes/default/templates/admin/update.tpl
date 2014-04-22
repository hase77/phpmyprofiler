{include file="admin/header.tpl"}

<div id="mainpanel">
    {t}Version database:{/t} <strong>{if $StateDB == -1}{t}no information available{/t}{else}{$StateDB} ({t}latest changes:{/t} {$StateDBTime}){/if}</strong><br />
    {t}Version Update{/t}: <strong>{$StateUpdate}</strong><br />

    {if $StateDB < $StateUpdate}
	<p>{t}Please backup your installation before you proceed!{/t}</p>
	<form action="update.php?action=doupdate&amp;{$session}" method="post" target="_self" accept-charset="utf-8">
	    <input type="submit" value="{t}Process update{/t}" />
	</form>
    {else}
	<br />
	<br />
	{t}Your database is up-to-date{/t}.
    {/if}
</div>

{include file="admin/footer.tpl"}

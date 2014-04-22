{include file="admin/header.tpl"}

<div id="mainerror">
    {include file="admin/mainerror.tpl"}
</div>

<div id="mainpanel">
    {t}Version database:{/t} <strong>{if $StateDB == -1}{t}no information available{/t}{else}{$StateDB} ({t}latest changes:{/t} {$StateDBTime}){/if}</strong><br />
    {t}Version Update{/t}: <strong>{$StateUpdate}</strong><br />
    <br />
    <br />

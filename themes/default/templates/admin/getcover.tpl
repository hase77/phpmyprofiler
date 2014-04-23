{include file="admin/header.tpl"}

{if $Error}
    <div id="mainerror">
	<div class="error_box">
	    <div class="error_headline">{t}Error{/t}</div>
	    <div class="error_msg">{$Error}</div>&nbsp;
	</div>
    </div>
{/if}

{if isset($cover)}
    <div id="mainpanel" style="text-align: center; vertical-align: middle">
	<a href="javascript:window.close()"><img src="../cover/{$cover}.jpg" alt="{$cover}" border="0" /></a><br />
    </div>
{/if}

{include file="admin/footer.tpl"}

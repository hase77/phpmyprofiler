{if isset($Info)}
    <div class="info_box">
	<div class="info_headline">{t}Information{/t}</div>
	<div class="info_msg">{$Info}</div>&nbsp;
    </div>
{/if}

{if isset($Warning)}
    <div class="warn_box">
	<div class="warn_headline">{t}Warning{/t}</div>
	<div class="warn_msg">{$Info}</div>&nbsp;
    </div>
{/if}

{if isset($Error)}
    <div class="error_box">
	<div class="error_headline">{t}Sorry, an error has occurred{/t}:</div>
	<div class="error_msg">{$Error}</div>&nbsp;
    </div>
{/if}

{if isset($Success)}
    <div class="success_box">
	<div class="success_headline">{t}Success{/t}</div>
	<div class="success_msg">{$Success}</div>&nbsp;
    </div>
{/if}

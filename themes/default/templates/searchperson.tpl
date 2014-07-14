<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Person Details"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Searched for{/t}:&nbsp;'{$name}'&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{$cast|@count}&nbsp;(Cast)&nbsp;+&nbsp;{$crew|@count}&nbsp;(Crew)&nbsp;{t}records found in this DVD Collection{/t}<br />
				<br />
				<b>{t}International{/t}:</b><br />
				<a href="http://www.imdb.com/find?q={$name|rawurlencode}">{t}IMDB Search{/t}</a><br />
				<a href="http://www.wikipedia.org/wiki/{$name|rawurlencode}">{t}Wikipedia Search{/t}</a><br />
				{if $smarty.session.lang_id == 'de'}
					<br /><b>{t}German{/t}:</b><br />
					<a href="http://www.ofdb.de/view.php?page=suchergebnis&amp;Kat=Person&amp;SText={$name|rawurlencode}">{t}OFDB Search{/t}</a><br />
					<a href="http://de.wikipedia.org/wiki/{$name|rawurlencode}">{t}Wikipedia Search{/t}</a><br />
					<a href="http://www.synchronkartei.de/search.php?cat=1&amp;search={$name|rawurlencode}">Deutsche Synchronkartei</a><br />
				{elseif $smarty.session.lang_id == 'nl'}
					<br /><b>{t}Dutch{/t}:</b><br />
					<a href="http://nl.wikipedia.org/wiki/{$name|rawurlencode}">{t}Wikipedia Search{/t}</a><br />
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Cast{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{if $cast}
					<table style="width: 98%; margin: 0px; padding: 0px; border-collapse: collapse;">
						{assign var="count" value=1}
						{foreach from=$cast item=pers}
							{assign var="this_value" value=$pers}
								{if !isset($last_value) or (($last_value->fullname != $pers->fullname) or $last_value->birthyear != $pers->birthyear)}
									<tr>
										<td class="td{$count%2}c" style="vertical-align: top; width: 150px;">
											<b>{$pers->fullname|colorname:$pers->firstname:$pers->middlename:$pers->lastname} {if $pers->birthyear != ''}({$pers->birthyear}){/if}</b><br />
											<br />
											<img src="{$pmp_dir_cast}/{$pers->picname}" alt="{$pers->fullname}" style="width:100px;" />
										</td>
										<td class="td{$count%2}" style="vertical-align: top;">
											<table>
												{assign var="movie_id" value=null}
												{foreach from=$cast item=pers1}
													{if ($pers1->fullname eq $this_value->fullname) and $pers1->birthyear eq $this_value->birthyear}
														<tr>
															{if $movie_id != $pers1->DVD->id}
																<td class="td{$count%2}"><a href="index.php?content=filmprofile&amp;id={$pers1->DVD->id}">{$pers1->DVD->Title}</a></td>
															{else}
																<td class="td{$count%2}"></td>
															{/if}
															<td class="td{$count%2}" style="padding-left: 6px;">{if $pers1->role != ''}{t}as{/t} {$pers1->role}{if $pers1->creditedas}&nbsp;({t}credited as{/t}:&nbsp;{$pers1->creditedas}){/if}{/if}{if $pers1->episodes>1} {t}in{/t} {$pers1->episodes} {t}episodes{/t}{/if}</td>
														</tr>
													{/if}
													{assign var="movie_id" value=$pers1->DVD->id}
												{/foreach}
											</table>
										</td>
									</tr>
									{assign var="count" value=$count+1}
								{/if}
							{assign var="last_value" value=$pers}
						{/foreach}
					</table>
				{/if}
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Crew{/t}&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				{if $crew}
					<table style="width: 100%; margin: 0px; padding: 0px; border-collapse: collapse;">
						{assign var="count" value=1}
						{foreach from=$crew item=pers}
							{assign var="this_value" value=$pers}
							{if !isset($last_value2) or (($last_value2->fullname != $pers->fullname) or $last_value2->birthyear != $pers->birthyear)}
								<tr>
									<td class="td{$count%2}c" style="vertical-align: top; width: 150px;">
									<b>{$pers->fullname|colorname:$pers->firstname:$pers->middlename:$pers->lastname} {if $pers->birthyear != ''}({$pers->birthyear}){/if}</b><br />
									<br />
									<img src="{$pmp_dir_cast}/{$pers->picname}" alt="{$pers->fullname}" style="width:100px;" />
									</td>
									<td class="td{$count%2}" style="vertical-align: top;">
										<table>
											{assign var="movie_id" value=null}
											{foreach from=$crew item=pers1}
												{if ($pers1->fullname eq $this_value->fullname) and $pers1->birthyear eq $this_value->birthyear}
													<tr>
														{if $movie_id != $pers1->DVD->id}
															<td class="td{$count%2}"><a href="index.php?content=filmprofile&amp;id={$pers1->DVD->id}">{$pers1->DVD->Title}</a></td>
														{else}
															<td class="td{$count%2}"></td>
														{/if}
														<td class="td{$count%2}" style="padding-left: 6px;">{t}{$pers1->subtype}{/t}{if $pers1->creditedas}&nbsp;({t}credited as{/t}:&nbsp;{$pers1->creditedas}){/if}</td>
													</tr>
												{/if}
												{assign var="movie_id" value=$pers1->DVD->id}
											{/foreach}
										</table>
									</td>
								</tr>
								{assign var="count" value=$count+1}
							{/if}
							{assign var="last_value2" value=$pers}
						{/foreach}
					</table>
				{/if}
			</td>
		</tr>
	</table>

	{include file="window-end.inc.tpl"}

</div>

</td>

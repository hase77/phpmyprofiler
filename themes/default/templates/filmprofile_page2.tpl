{if isset($dvd->Audio) || isset($dvd->Subtitles)}
<table class="properties">
	<tr><td class="propheader" colspan="3">{t}Audio{/t}:</td></tr>
	<tr><td class="proptitle" colspan="1"><b>{t}Format{/t}:</b></td>
	<td class="proptitle" colspan="1"><b>{t}Channels{/t}:</b></td>
	<td class="proptitle" colspan="1"><b>{t}Content{/t}:</b></td></tr>
	{if isset($dvd->Audio)}
		{foreach from=$dvd->Audio item=audio}
			<tr>
				<td class="propvalue">{$audio.Format|getpic:format}</td>
				<td class="propvalue">{$audio.Channels|getpic:channels}</td>
				<td class="propvalue">{$audio.Content|flag}</td>
			</tr>
		{/foreach}
	{/if}
	<tr><td class="proptitle" colspan="3"><b>{t}Subtitles{/t}:</b></td></tr>
	{if isset($dvd->Subtitles)}
		{foreach from=$dvd->Subtitles item=sub}
			<tr>
				<td class="propvalue">{$sub|flag}</td>
				<td class="propvalue">{t}{$sub}{/t}</td>
				<td class="propvalue"></td>
			</tr>
		{/foreach}
	{/if}
</table>
{/if}

<table class="properties">
	<tr><td class="propheader" style="width:40%">{t}Video Information{/t}:</td><td class="propheader" style="width:60%" colspan="2"/></tr>
	{if $dvd->Media != 'Blu-ray' && $dvd->Media != 'HD DVD'}
		<tr><td class="proptitle">{t}Video Format{/t}:</td><td class="propvalue">{$dvd->Video}</td><td class="propvalue"></td></tr>
	{/if}
	{if $dvd->PanAndScan || $dvd->FullFrame || $dvd->Widescreen || $dvd->Ratio || $dvd->Anamorph}
		<tr>
			<td class="proptitle">{t}Aspect Ratio{/t}:</td>
			<td class="propvalue">
				{strip}
				{if $dvd->PanAndScan}<img src="themes/{$pmp_theme}/images/additional/4by3.gif" alt="Pan&Scan" title="Pan&Scan" style="vertical-align: middle;" />&nbsp;{/if}
				{if $dvd->FullFrame}<img src="themes/{$pmp_theme}/images/additional/4by3.gif" alt="Full Frame" title="Full Frame" style="vertical-align: middle;" />&nbsp;{/if}
				{if $dvd->Widescreen == '1' && $dvd->Ratio != ''}{$dvd->Ratio|getpic:ratio}&nbsp;{/if}
				{if $dvd->Anamorph}<img src="themes/{$pmp_theme}/images/additional/anamorph.gif" alt="16:9 Letterbox" title="16:9 Letterbox" style="vertical-align: middle;" />&nbsp;{/if}
				{/strip}
			</td>
			<td class="propvalue"></td>
		</tr>
	{/if}
	<tr>
		<td class="proptitle">{t}Color{/t}:</td>
		<td class="propvalue">
			{$dvd->Color|getpic:boolean} {t}Color{/t}<br />
			{$dvd->BlackWhite|getpic:boolean} {t}Black & White{/t}<br />
		</td>
		<td class="propvalue">
			{$dvd->Colorized|getpic:boolean} {t}Colorized{/t}<br />
			{$dvd->Mixed|getpic:boolean} {t}Mixed{/t}
		</td>
	</tr>
	<tr>
		<td class="proptitle">{t}Dimensions{/t}:</td>
		<td class="propvalue">
			{$dvd->Dim2D|getpic:boolean} {t}2D{/t}<br />
			{$dvd->Anaglyph|getpic:boolean} {t}3D Anaglyph{/t}<br />
		</td>
		<td class="propvalue">
			{$dvd->Bluray3D|getpic:boolean} {t}Blu-ray 3D{/t}
		</td>
	</tr>
</table>

<table class="properties">
	<tr><td class="propheader" style="width:50%;">{t}Features{/t}:</td>
	<td class="propheader" style="width:50%;" /></tr>
	<tr>
		<td class="propvalue">
			{$dvd->Scenes|getpic:boolean} {t}Scene Access{/t}<br />
			{$dvd->Trailer|getpic:boolean} {t}Feature Trailers{/t}<br />
			{$dvd->BonusTrailer|getpic:boolean} {t}Bonus Trailers{/t}<br />
			{$dvd->Deleted|getpic:boolean} {t}Deleted Scenes{/t}<br />
			{$dvd->Notes|getpic:boolean} {t}Prod. Notes{/t}<br />
			{$dvd->DVDrom|getpic:boolean} {t}DVD-ROM Content{/t}<br />
			{$dvd->Musicvideos|getpic:boolean} {t}Music Videos{/t}<br />
			{$dvd->Storyboard|getpic:boolean} {t}Storyboard Comparisons{/t}<br />
			{$dvd->ClosedCaptioned|getpic:boolean} {t}Closed Captioned{/t}<br />
			{if $dvd->Media == 'Blu-ray' || $dvd->Media == 'HD DVD'}
				{$dvd->PictureInPicture|getpic:boolean} {t}Picture-in-Picture{/t}<br />
			{/if}
		</td>
		<td class="propvalue">
			{$dvd->Comment|getpic:boolean} {t}Commentary{/t}<br />
			{$dvd->PhotoGallery|getpic:boolean} {t}Photo Gallery{/t}<br />
			{$dvd->MakingOf|getpic:boolean} {t}Featurettes{/t}<br />
			{$dvd->Game|getpic:boolean} {t}Interactive Games{/t}<br />
			{$dvd->Multiangle|getpic:boolean} {t}Multi-angle{/t}<br />
			{$dvd->Interviews|getpic:boolean} {t}Interviews{/t}<br />
			{$dvd->Outtakes|getpic:boolean} {t}Outtakes/Bloopers{/t}<br />
			{$dvd->THX|getpic:boolean} {t}THX Certified{/t}<br />
			{if $dvd->Media == 'Blu-ray'}
				{$dvd->BDLive|getpic:boolean} {t}BD-Live{/t}<br />
			{/if}
			{$dvd->DigitalCopy|getpic:boolean} {t}Digital Copy{/t}<br />
		</td>
	</tr>
	<tr><td class="propvalue" colspan="2">{if !empty($dvd->Other)}{t}Other Features{/t}:<br /><b>{$dvd->Other}</b>{/if}</td></tr>

	<tr><td class="propheader" colspan="2">{t}Additional Information{/t}:</td></tr>
	<tr><td class="proptitle" colspan="2"><b>{t}Studios{/t}:</b></td></tr>
	<tr><td class="propvalue" colspan="2">{if isset($dvd->Studios)}{foreach from=$dvd->Studios item=S}<a href="index.php?addwhere=pmp_studios[dot]id&amp;whereval=studio[dot]{$S|rawurlencode}&amp;caption=Studio:%20{$S|rawurlencode}">{$S}</a><br />{/foreach}{/if}</td></tr>
	<tr><td class="proptitle" colspan="2"><b>{t}Genres{/t}:</b></td></tr>
	<tr><td class="propvalue" colspan="2">{foreach from=$dvd->Genres item=G}<a href="index.php?addwhere=pmp_genres[dot]id&amp;whereval=genre[dot]{$G|rawurlencode}&amp;caption=Genre:%20{$G|rawurlencode}">{$G}</a><br />{/foreach}</td></tr>

	{if isset($dvd->Discs)}
		<tr><td class="proptitle" colspan="2"><b>{t}Media Info{/t}:</b></td></tr>
		<tr>
			<td class="propvalue" colspan="2">
				{strip}
				{foreach from=$dvd->Discs item=Disc}
					{if $dvd->Media == 'DVD'}
						{if $Disc->duallayersidea || $Disc->duallayersideb}
							{if $Disc->dualsided}<img src="themes/{$pmp_theme}/images/additional/dvddlds.gif" alt="DVD 18 (Dual Layered, Dual Sided)" title="DVD 18 (Dual Layered, Dual Sided)" /><br />
							{else}<img src="themes/{$pmp_theme}/images/additional/dvddlss.gif" alt="DVD 9 (Dual Layered, Single Sided)" title="DVD 9 (Dual Layered, Single Sided)" /><br />
							{/if}
						{else}
							{if $Disc->dualsided}<img src="themes/{$pmp_theme}/images/additional/dvdslds.gif" alt="DVD 10 (Single Layered, Dual Sided)" title="DVD 10 (Single Layered, Dual Sided)" /><br />
							{else}<img src="themes/{$pmp_theme}/images/additional/dvdslss.gif" alt="DVD 5 (Single Layered, Single Sided)" title="DVD 5 (Single Layered, Single Sided)" /><br />
							{/if}
						{/if}
					{else}
						{if $Disc->duallayersidea || $Disc->duallayersideb}
							{t}Dual Layered{/t}<br />
						{else}
							{t}Single Layered{/t}<br />
						{/if}
					{/if}

					{if $Disc->descsidea != ''}{t}Description Side A{/t}:&nbsp;{$Disc->descsidea}<br />{/if}
					{if $Disc->labelsidea != ''}{t}Label Side A{/t}:&nbsp;{$Disc->labelsidea}<br />{/if}
					{if $Disc->discidsidea != ''}{t}DiscID Side A{/t}:&nbsp;{$Disc->discidsidea}<br />{/if}
					{if $Disc->descsideb != ''}{t}Description Side B{/t}:&nbsp;{$Disc->descsideb}<br />{/if}
					{if $Disc->labelsideb != ''}{t}Label Side B{/t}:&nbsp;{$Disc->labelsideb}<br />{/if}
					{if $Disc->discidsideb != ''}{t}DiscID Side B{/t}:&nbsp;{$Disc->discidsideb}<br />{/if}
					{if $Disc->location != ''}{t}Location{/t}:&nbsp;{$Disc->location}<br />{/if}
					{if $Disc->slot != ''}{t}Slot{/t}:&nbsp;{$Disc->slot}<br />{/if}
					<br />
				{/foreach}
				{/strip}
			</td>
		</tr>
	{/if}

	{if $dvd->Easteregg != '' || isset($dvd->Awards) }
		<tr><td class="propheader" colspan="2">{t}Various Information{/t}:</td></tr>
	{/if}
	{if $dvd->Easteregg != ''}
		<tr><td class="proptitle" colspan="2"><b>{t}Easter Egg{/t}:</b></td></tr>
		<tr><td class="propvalue" colspan="2">{foreach from=$dvd->Easteregg item=E}{$E|nl2br}<br />{/foreach}</td></tr>
	{/if}
	{if isset($dvd->Awards)}
		<tr><td class="proptitle" colspan="2"><b>{t}Awards{/t}:</b></td></tr>
		<tr>
			<td class="propvalue" colspan="2">
				{assign var="last_value" value=""}
				{foreach from=$dvd->Awards item=Award}
					{if $last_value != $Award->award}
						{if $last_value != ''}<br />{/if}
						<b>{$Award->award}</b> ({$Award->awardyear}):<br />
					{/if}
					{if $Award->winner == 1}
						{t}Winner{/t}
					{else}
						{t}Nominee for{/t}
					{/if}
					{$Award->category}&nbsp;{if $Award->nominee}-&nbsp;{$Award->nominee}{/if}<br />
					{assign var="last_value" value=$Award->award}
				{/foreach}
			</td>
		</tr>
	{/if}

</table>

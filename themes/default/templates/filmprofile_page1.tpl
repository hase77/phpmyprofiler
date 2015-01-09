<table class="properties">
	<tr><td class="propheader" style="width:40%">{t}Movie Information{/t}:</td><td class="propheader" style="width:60%" /></tr>
	<tr><td class="proptitle">{t}Year of Production{/t}:</td><td class="propvalue"><a href="index.php?addwhere=prodyear&amp;delwhere=prodyear&amp;whereval={$dvd->Year}&amp;caption=Production%20Year:%20{$dvd->Year}">{$dvd->Year}</a></td></tr>
	{if $dvd->Origins != ''}<tr><td class="proptitle">{t}Country of Origin{/t}:</td><td class="propvalue">{foreach from=$dvd->Origins item=Origin}{$Origin|flag}&nbsp;{/foreach}</td></tr>{/if}
	<tr><td class="proptitle">{t}Running Time{/t}:</td><td class="propvalue">{$dvd->LengthHours}:{$dvd->LengthMins}&nbsp;{t}hrs{/t}&nbsp;({$dvd->Length}&nbsp;{t}minutes{/t})</td></tr>
	<tr><td class="proptitle">{t}Rating{/t}:</td><td class="propvalue"><a href="index.php?addwhere=rating&amp;whereval={$dvd->Rating|rawurlencode}&amp;delwhere=rating&amp;caption=Rating:%20{$dvd->Rating|rawurlencode}">{$dvd->Rating}</a>{if $dvd->RatingSystem != ''}&nbsp;({$dvd->RatingSystem}){/if}</td></tr>
	{if $dvd->RatingDetails != ''}<tr><td class="proptitle">{t}Rating Details{/t}:</td><td class="propvalue">{$dvd->RatingDetails}</td></tr>{/if}

	<tr><td class="propheader" colspan="2">{$dvd->Media} {t}Information{/t}:</td></tr>
	{if $dvd->Edition != ''}<tr><td class="proptitle">{t}Edition{/t}:</td><td class="propvalue">{$dvd->Edition}</td></tr>{/if}
	<tr><td class="proptitle">{t}ID{/t}:</td><td class="propvalue">{$dvd->id}</td></tr>
	<tr><td class="proptitle">{t}UPC{/t}:</td><td class="propvalue">{$dvd->UPC}</td></tr>
	<tr><td class="proptitle">{t}Profile Date{/t}:</td><td class="propvalue">{$dvd->ProfileDate}</td></tr>
	<tr><td class="proptitle">{t}Last Edited{/t}:</td><td class="propvalue">{$dvd->LastEdited}</td></tr>
	<tr><td class="proptitle">{t}Country{/t}:</td><td class="propvalue">{$dvd->Locality|flag}</td></tr>
	<tr><td class="proptitle">{t}Regions{/t}:</td><td class="propvalue">{foreach from=$dvd->Regions item=RC name=region}{if !$smarty.foreach.region.first}, {/if}<a href="index.php?addwhere=pmp_regions[dot]id&amp;whereval=region[dot]{$RC|rawurlencode}&amp;caption=Region:%20{$RC|rawurlencode}">{$RC}</a>{/foreach}</td></tr>
	<tr><td class="proptitle">{t}Release{/t}:</td><td class="propvalue">{$dvd->Released}</td></tr>
	<tr><td class="proptitle">{t}Case Type{/t}:</td><td class="propvalue"><a href="index.php?addwhere=casetype&amp;delwhere=casetype&amp;whereval={$dvd->Casetype|rawurlencode}&amp;caption=Case%20Type:%20{$dvd->Casetype|rawurlencode}">{t}{$dvd->Casetype}{/t}</a>{if $dvd->Slipcover==1},&nbsp;{t}Slipcover{/t}{/if}</td></tr>

	{if isset($dvd->MediaCompanies)}<tr><td class="proptitle">{t}Media Companies{/t}:</td><td class="propvalue">{foreach from=$dvd->MediaCompanies item=Company name=media}{if !$smarty.foreach.media.first}, {/if}<a href="index.php?addwhere=pmp_media_companies[dot]id&amp;whereval=company[dot]{$Company|rawurlencode}&amp;caption=Media%20Company:%20{$Company|rawurlencode}">{$Company}</a>{/foreach}</td></tr>{/if}

	<tr><td class="proptitle">{t}State{/t}:</td><td class="propvalue">{t}{$dvd->Owned}{/t}{if $dvd->WishPriority != '' && $dvd->Owned == "Wish List"}&nbsp;-&nbsp;{t}{$dvd->WishPriority}{/t}{/if}</td></tr>
	{if $dvd->Number != ''}<tr><td class="proptitle">{t}Collection Number{/t}:</td><td class="propvalue">{$dvd->Number}</td></tr>{/if}
	{if $dvd->Notices != ''}<tr><td class="proptitle">{t}Notes{/t}:</td><td class="propvalue">{$dvd->Notices}</td></tr>{/if}
	{if $dvd->Gift == 0}
		<tr><td class="proptitle">{t}Purchased{/t}:</td><td class="propvalue">{if $dvd->Owned != "Wish List"}{if $dvd->PurchDate != ''}{$dvd->PurchDate}&nbsp;{/if}{if $dvd->PurchPlace != ''}{t}at{/t}&nbsp;{if $dvd->PurchPlaceWebsite != ''}<a href="http://{$dvd->PurchPlaceWebsite}" target="_blank">{/if}<b>{$dvd->PurchPlace}</b>{if $dvd->PurchPlaceWebsite != ''}</a>{/if}&nbsp;{/if}{if $pmp_statistic_showprice == 1}{if $dvd->ConvPrice != '0.00'}{t}for{/t}&nbsp;{$dvd->ConvPrice}&nbsp;<b>{$dvd->ConvCurrency}</b>{if $dvd->PurchCurrencyID != $dvd->ConvCurrency}&nbsp;({$dvd->PurchPrice}&nbsp;<b>{$dvd->CurrencyID}</b>){/if}{/if}{/if}<br />{/if}
		{if $dvd->convAvgPrice != '0.00'}{t}SRP{/t}:&nbsp;{t}{$dvd->convAvgPrice}{/t}&nbsp;<b>{$dvd->convAvgCurrency}</b>&nbsp;{if $dvd->CurrencyID != $dvd->convAvgCurrency}({$dvd->Price}&nbsp;<b>{$dvd->CurrencyID}</b>){/if}{/if}</td></tr>
	{else}
		<tr><td class="proptitle">{t}Gift from{/t}:</td><td class="propvalue">{$dvd->GiftFrom->FirstName} {$dvd->GiftFrom->LastName}</td></tr>
	{/if}
	{if $dvd->Loaned == 1}
		<tr><td class="proptitle">{t}Rented by{/t}:</td><td class="propvalue">{$dvd->LoanTo->FirstName} {$dvd->LoanTo->LastName}</td></tr>
		<tr><td class="proptitle">
			{if $dvd->LoanReturn != '0000-00-00'}{t}Return Date{/t}:</td><td class="propvalue"> <b>{$dvd->LoanReturn}</b>{/if}
		</td></tr>
	{/if}
	{if isset($dvd->Tags)}<tr><td class="proptitle">{t}Tags{/t}:</td><td class="propvalue">{foreach from=$dvd->Tags item=T name=tag}{if !$smarty.foreach.tag.first}, {/if}<a href="index.php?addwhere=pmp_tags[dot]id&amp;whereval=name[dot]{$T.name|rawurlencode}&amp;caption=Tag:%20{$T.fullname|rawurlencode}">{$T.fullname}</a>{/foreach}</td></tr>{/if}

	<tr><td class="propheader" colspan="2">{t}Overview{/t}:</td></tr>
	<tr><td class="propvalue" colspan="2">{$dvd->Overview|nl2br}</td></tr>

	{if isset($dvd->Videos)}
		<tr><td class="propheader" colspan="2">{t}Videos{/t}:</td></tr>
		{foreach from=$dvd->Videos item=Video}
			{if isset($Video->title) && $Video->title != ''}<tr><td class="proptitle" colspan="2">{t}{$Video->title}{/t}:</td></tr>{/if}
			{if $Video->type == 'youtube'}
				<tr><td class="propvalue_c" colspan="2"><iframe width="384" height="265" src="http://www.youtube.com/embed/{$Video->ext_id}" frameborder="0" scrolling='no' allowfullscreen></iframe></td></tr>
			{elseif $Video->type == 'vimeo'}
				<tr><td class="propvalue_c" colspan="2"><iframe width="384" height="216" src="http://player.vimeo.com/video/{$Video->ext_id}?title=0&amp;byline=0&amp;portrait=0" frameborder="0" scrolling='no' allowfullscreen></iframe></td></tr>
			{/if}
		{/foreach}
	{/if}

	{if isset( $screenshots )}
		<tr><td class="propheader" colspan="2">{t}Screenshots{/t}:</td></tr>
		<tr><td class="propvalue" colspan="2">
			<table class="screen">
				{foreach from=$screenshots item=fname key=sch name=list}
					{if !($sch%4)}<tr>{/if}
					<td class="screen"><a href="screenshots/{$dvd->id}/{$fname}" rel="gallery_screen" class="fancybox"><img src="screenshots/thumbs/{$dvd->id}/{$fname}" alt="{$fname}" /></a></td>
					{if !(($sch+1)%4)}</tr>{elseif $smarty.foreach.list.last}</tr>{/if}
				{/foreach}
			</table>
		</td></tr>
	{/if}

	{if (isset($dvd->reviewTitleNum) && $dvd->reviewTitleNum != 0) || $pmp_review_type != 3 || $pmp_disable_reviews != 1}
		{if $pmp_review_type != 3}
			<tr><td class="propheader" colspan="2">{t}Review{/t}:</td></tr>
			<tr><td class="proptitle">{t}Movie{/t}:</td><td class="propvalue">{$dvd->ReviewFilm|getpic:Vote}</td></tr>
			{if $pmp_review_type == 0 || empty($pmp_review_type)}
				<tr><td class="proptitle">{t}DVD{/t}:</td><td class="propvalue">{$dvd->ReviewVideo|getpic:Vote}</td></tr>
			{elseif $pmp_review_type == 2}
				<tr><td class="proptitle">{t}Video{/t}:</td><td class="propvalue">{$dvd->ReviewVideo|getpic:Vote}</td></tr>
				<tr><td class="proptitle">{t}Audio{/t}:</td><td class="propvalue">{$dvd->ReviewAudio|getpic:Vote}</td></tr>
				<tr><td class="proptitle">{t}Extras{/t}:</td><td class="propvalue">{$dvd->ReviewExtras|getpic:Vote}</td></tr>
			{/if}
		{/if}

		{if isset($dvd->reviewTitleNum) && $dvd->reviewTitleNum != 0}
			<tr><td class="propheader" colspan="2">{t}External Reviews{/t}:</td></tr>
			{section name=review start=0 loop=( $dvd->reviewTitleNum )}

				{if isset($dvd->extReviews[review]->reviewTitle)}
					<tr><td class="div" colspan="2">{$dvd->extReviews[review]->reviewTitle}:</td></tr>
				{/if}

				{if isset($dvd->extReviews[review]->imdbRating) && $dvd->extReviews[review]->imdbRating > 0}
					<tr><td class="proptitle">{t}IMDB User Rating{/t}:</td><td class="propvalue"><img src="voting.php?rating={$dvd->extReviews[review]->imdbRating}" alt="{$dvd->extReviews[review]->imdbRating}" /> {$dvd->extReviews[review]->imdbRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/10 ({t}votes{/t}: {$dvd->extReviews[review]->imdbVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td></tr>
					{if isset($dvd->extReviews[review]->imdbTop250)}
						<tr><td class="proptitle">{t}IMDB Top 250{/t}:</td><td class="propvalue">{$dvd->extReviews[review]->imdbTop250}</td></tr>
					{/if}
					{if isset($dvd->imdbBottom100[review])}
						<tr><td class="proptitle">{t}IMDB Bottom 100{/t}:</td><td class="propvalue">{$dvd->extReviews[review]->imdbBottom100}</td></tr>
					{/if}
				{/if}

				{if isset($dvd->extReviews[review]->ofdbRating) && $dvd->extReviews[review]->ofdbRating > 0}
					<tr><td class="proptitle">{t}OFDB User Rating{/t}:</td><td class="propvalue"><img src="voting.php?rating={$dvd->extReviews[review]->ofdbRating}" alt="{$dvd->extReviews[review]->ofdbRating}" /> {$dvd->extReviews[review]->ofdbRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/10 ({t}votes{/t}: {$dvd->extReviews[review]->ofdbVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td></tr>
					{if isset($dvd->extReviews[review]->ofdbTop250)}
						<tr><td class="proptitle">{t}OFDB Top 250{/t}:</td><td class="propvalue">{$dvd->extReviews[review]->ofdbTop250}</td></tr>
					{/if}
					{if isset($dvd->extReviews[review]->ofdbBottom100)}
						<tr><td class="proptitle">{t}OFDB Bottom 100{/t}:</td><td class="propvalue">{$dvd->extReviews[review]->ofdbBottom100}</td></tr>
					{/if}
				{/if}

				{if isset($dvd->extReviews[review]->rotcRating) && $dvd->extReviews[review]->rotcRating > 0}
					<tr><td class="proptitle">{t}RottenTomatoes Critics Rating{/t}:</td><td class="propvalue"><img src="voting.php?rating={$dvd->extReviews[review]->rotcRating}" alt="{$dvd->extReviews[review]->rotcRating}" /> {$dvd->extReviews[review]->rotcRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/10 ({t}votes{/t}: {$dvd->extReviews[review]->rotcVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td></tr>
				{/if}

				{if isset($dvd->extReviews[review]->rotuRating) && $dvd->extReviews[review]->rotuRating > 0}
					<tr><td class="proptitle">{t}RottenTomatoes User Rating{/t}:</td><td class="propvalue"><img src="voting.php?rating={$dvd->extReviews[review]->rotuRating}&maxrate=5" alt="{$dvd->extReviews[review]->rotuRating}" /> {$dvd->extReviews[review]->rotuRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/5 ({t}votes{/t}: {$dvd->extReviews[review]->rotuVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td></tr>
				{/if}
			{/section}
		{/if}

		{if $pmp_disable_reviews != 1}
			<tr><td class="propheader" colspan="2">{t}User Reviews{/t}:</td></tr>
			<tr><td class="propvalue" colspan="2"><a href="index.php?content=review&amp;id={$dvd->id}">{t}Compose a review{/t}</a></td></tr>
			{if isset($dvd->Reviews)}
			<tr>
				<td class="propvalue" colspan="2">
					{foreach from=$dvd->Reviews item=Review}
						<b>{$Review.Title}</b><br />
						{$Review.Name} - {$Review.Date}<br />
						{$Review.Vote|getpic:Vote}<br />
						{$Review.Text|nl2br}<br />
						<br />
					{/foreach}
				</td>
			</tr>
			{/if}
		{/if}
	{/if}
</table>

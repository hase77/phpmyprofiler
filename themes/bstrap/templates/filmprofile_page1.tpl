{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

filmprofile_page1.tpl

===============================================================================
*}

   {assign "pmp_theme_css" "bootstrap.css"}
   {assign "showlist" "Owned"}
   {if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
   {if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
   {if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}
            
   <div class="table-responsive">
   
      <table class="table table-striped table-bordered">
         <tbody>
            <tr>
               <td>{t}Overview{/t}:</td>
               <td>{$dvd->Overview|nl2br}</td>
            </tr>
            <tr>
               <td>{t}Year of Production{/t}:</td>
               <td><a href="index.php?addwhere=prodyear&amp;delwhere=prodyear&amp;whereval={$dvd->Year}&amp;caption=Production%20Year:%20{$dvd->Year}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$dvd->Year}</a></td>
            </tr>
            <tr>
               <td>{t}Country{/t}:</td>
               <td>{$dvd->Locality|flag}</td>
            </tr>
            {if $dvd->Origins != ''}
               <tr>
                  <td>{t}Country of Origin{/t}:</td>
                  <td>{foreach from=$dvd->Origins item=Origin}{$Origin|flag}&nbsp;{/foreach}</td>
               </tr>
            {/if}
            <tr>
               <td>{t}Regions{/t}:</td>
               <td>{foreach from=$dvd->Regions item=RC name=region}{if !$smarty.foreach.region.first}, {/if}<a href="index.php?addwhere=pmp_regions[dot]id&amp;whereval=region[dot]{$RC|rawurlencode}&amp;caption=Region:%20{$RC|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$RC}</a>{/foreach}</td>
            </tr>
            <tr>
               <td>{t}Running Time{/t}:</td>
               <td>{$dvd->LengthHours}:{$dvd->LengthMins}&nbsp;{t}hrs{/t}&nbsp;({$dvd->Length}&nbsp;{t}minutes{/t})</td>
            </tr>
            <tr>
               <td>{t}Rating{/t}:</td>
               <td ><a href="index.php?addwhere=rating&amp;whereval={$dvd->Rating|rawurlencode}&amp;delwhere=rating&amp;caption=Rating:%20{$dvd->Rating|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$dvd->Rating}</a>{if $dvd->RatingSystem != ''}&nbsp;({$dvd->RatingSystem}){/if}</td>
            </tr>
            {if $dvd->RatingDetails != ''}
               <tr>
                  <td>{t}Rating Details{/t}:</td>
                  <td>{$dvd->RatingDetails}</td>
               </tr>
            {/if}
            {if $dvd->Edition != ''}
               <tr>
                  <td>{t}Edition{/t}:</td>
                  <td>{$dvd->Edition}</td>
               </tr>
            {/if}
            <tr>
               <td>{t}ID{/t}:</td>
               <td>{$dvd->id}</td>
            </tr>
            <tr>
               <td>{t}UPC{/t}:</td>
               <td>{$dvd->upc}</td>
            </tr>
            <tr>
               <td>{t}Profile Date{/t}:</td>
               <td>{$dvd->ProfileDate}</td>
            </tr>
            <tr>
               <td>{t}Last Edited{/t}:</td>
               <td>{$dvd->LastEdited}</td>
            </tr>
            <tr>
               <td>{t}Release{/t}:</td>
               <td>{$dvd->Released}</td>
            </tr>
            <tr>
               <td>{t}Case Type{/t}:</td>
               <td>{t}{$dvd->Casetype}{/t}{if $dvd->Slipcover==1}&nbsp;({t}Slipcover{/t}){/if}</td>
            </tr>
            {if isset($dvd->MediaCompanies)}
               <tr>
                  <td>{t}Media Companies{/t}:</td>
                  <td>{foreach from=$dvd->MediaCompanies item=Company name=media}{if !$smarty.foreach.media.first}, {/if}<a href="index.php?addwhere=pmp_media_companies[dot]id&amp;whereval=company[dot]{$Company|rawurlencode}&amp;caption=Media%20Company:%20{$Company|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$Company}</a>{/foreach}</td>
               </tr>
            {/if}
            <tr>
               <td>{t}State{/t}:</td>
               <td>{t}{$dvd->Owned}{/t}{if $dvd->WishPriority != '' && $dvd->Owned == "Wish List"}&nbsp;-&nbsp;{t}{$dvd->WishPriority}{/t}{/if}</td>
            </tr>
            {if $dvd->Number != ''}
               <tr>
                  <td>{t}Collection Number{/t}:</td>
                  <td>{$dvd->Number}</td>
               </tr>
            {/if}
            {if $dvd->Notices != ''}
               <tr>
                  <td>{t}Notes{/t}:</td>
                  <td>{$dvd->Notices}</td>
               </tr>
            {/if}
            {if $dvd->Gift == 0}
               <tr>
                  <td>{t}Purchased{/t}:</td>
                  <td>
                  {if $dvd->Owned != "Wish List"}{if $dvd->PurchDate != ''}
                     {$dvd->PurchDate}&nbsp;{/if}{if $dvd->PurchPlace != ''}{t}at{/t}&nbsp;{if $dvd->PurchPlaceWebsite != ''}<a href="http://{$dvd->PurchPlaceWebsite}" target="_blank">{/if}<strong>{$dvd->PurchPlace}</strong>{if $dvd->PurchPlaceWebsite != ''}</a>{/if}&nbsp;{/if}{if $pmp_statistic_showprice == 1}{if $dvd->ConvPrice != '0.00'}{t}for{/t}&nbsp;{$dvd->ConvPrice}&nbsp;<strong>{$dvd->ConvCurrency}</strong>{if $dvd->PurchCurrencyID != $dvd->ConvCurrency}&nbsp;({$dvd->PurchPrice}&nbsp;<strong>{$dvd->CurrencyID}</strong>){/if}{/if}{/if}<br>
                  {/if}
                  {if $dvd->convAvgPrice != '0.00'}
                     {t}SRP{/t}:&nbsp;{t}{$dvd->convAvgPrice}{/t}&nbsp;<strong>{$dvd->convAvgCurrency}</strong>&nbsp;
                     {if $dvd->CurrencyID != $dvd->convAvgCurrency}
                        ({$dvd->Price}&nbsp;<strong>{$dvd->CurrencyID}</strong>)
                     {/if}
                  {/if}
                  </td>
               </tr>
            {else}
               <tr>
                  <td>{t}Gift from{/t}:</td><td class="propvalue">{$dvd->GiftFrom->FirstName} {$dvd->GiftFrom->LastName}</td>
               </tr>
            {/if}
            {if $dvd->Loaned == 1}
               <tr>
                  <td>{t}Rented by{/t}:</td>
                  <td>{$dvd->LoanTo->FirstName} {$dvd->LoanTo->LastName}</td>
               </tr>
               <tr>
                  <td>{if $dvd->LoanReturn != '0000-00-00'}{t}Return Date{/t}:</td>
                  <td><strong>{$dvd->LoanReturn}</strong>{/if}</td>
               </tr>
            {/if}
            {if isset($dvd->Tags)}
               <tr>
                  <td>{t}Tags{/t}:</td>
                  <td>{foreach from=$dvd->Tags item=T name=tag}{if !$smarty.foreach.tag.first}, {/if}<a href="index.php?addwhere=pmp_tags[dot]id&amp;whereval=name[dot]{$T.name|rawurlencode}&amp;caption=Tag:%20{$T.fullname|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$T.fullname}</a>{/foreach}</td>
               </tr>
            {/if}
            {if isset($dvd->Videos)}
               <tr>
                  <td>{t}Videos{/t}:</td>
                     <td>
                     {foreach from=$dvd->Videos item=Video}
                        {if isset($Video->title) && $Video->title != ''}
                           {t}{$Video->title}{/t}:<br>
                        {/if}
                        {if $Video->type == 'youtube'}
                           <iframe width="384" height="265" src="http://www.youtube.com/embed/{$Video->ext_id}" frameborder="0" scrolling='no' allowfullscreen></iframe>
                        {elseif $Video->type == 'vimeo'}
                           <iframe width="384" height="216" src="http://player.vimeo.com/video/{$Video->ext_id}?title=0&amp;byline=0&amp;portrait=0" frameborder="0" scrolling='no' allowfullscreen></iframe>
                        {/if}
                     {/foreach}
                  </td>
               </tr>
            {/if}
            {if isset( $screenshots )}
               <tr>
                  <td>{t}Screenshots{/t}:</td>
                  <td>
                     {foreach from=$screenshots item=fname key=sch name=list}
                        {if !($sch%4)}
                           <a href="screenshots/{$dvd->id}/{$fname}" rel="gallery_screen" class="fancybox"><img src="screenshots/thumbs/{$dvd->id}/{$fname}" alt="{$fname}"></a>
                        {/if}
                        {if !(($sch+1)%4)}
                           &nbsp;
                        {elseif $smarty.foreach.list.last}
                           &nbsp;
                        {/if}
                     {/foreach}
                  </td>
               </tr>
            {/if}
            
            {if (isset($dvd->reviewTitleNum) && $dvd->reviewTitleNum != 0) || $pmp_review_type != 3 || $pmp_disable_reviews != 1}
               {if $pmp_review_type != 3}
                  <tr>
                     <td>
                        {t}Movie{/t}:
                     </td>
                     <td>
                        {$dvd->ReviewFilm|getpic:Vote}
                     </td>
                  </tr>
                  {if $pmp_review_type == 0 || empty($pmp_review_type)}
                     <tr>
                        <td>{t}DVD{/t}:</td>
                        <td>{$dvd->ReviewVideo|getpic:Vote}</td>
                     </tr>
                  {elseif $pmp_review_type == 2}
                     <tr>
                        <td>{t}Video{/t}:</td>
                        <td>{$dvd->ReviewVideo|getpic:Vote}</td>
                     </tr>
                     <tr>
                        <td>{t}Audio{/t}:</td>
                        <td>{$dvd->ReviewAudio|getpic:Vote}</td>
                     </tr>
                     <tr>
                        <td>{t}Extras{/t}:</td>
                        <td>{$dvd->ReviewExtras|getpic:Vote}</td>
                     </tr>
                  {/if}
               {/if}
         
               {if isset($dvd->reviewTitleNum) && $dvd->reviewTitleNum != 0}
                  <tr>
                     <td colspan="2">{t}External Reviews{/t}:</td>
                  </tr>
                  {section name=review start=0 loop=( $dvd->reviewTitleNum )}
         
                     {if isset($dvd->extReviews[review]->reviewTitle)}
                        <tr>
                           <td colspan="2">{$dvd->extReviews[review]->reviewTitle}:</td>
                        </tr>
                     {/if}
         
                     {if isset($dvd->extReviews[review]->imdbRating) && $dvd->extReviews[review]->imdbRating > 0}
                        <tr>
                           <td>{t}IMDB User Rating{/t}:</td>
                           <td><img src="include/voting.php?rating={$dvd->extReviews[review]->imdbRating}" alt="{$dvd->extReviews[review]->imdbRating}"> {$dvd->extReviews[review]->imdbRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/10 ({t}votes{/t}: {$dvd->extReviews[review]->imdbVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td>
                        </tr>
                        {if isset($dvd->extReviews[review]->imdbTop250)}
                           <tr>
                              <td>{t}IMDB Top 250{/t}:</td>
                              <td>{$dvd->extReviews[review]->imdbTop250}</td>
                           </tr>
                        {/if}
                        {if isset($dvd->imdbBottom100[review])}
                           <tr>
                              <td>{t}IMDB Bottom 100{/t}:</td>
                              <td>{$dvd->extReviews[review]->imdbBottom100}</td>
                           </tr>
                        {/if}
                     {/if}
         
                     {if isset($dvd->extReviews[review]->ofdbRating) && $dvd->extReviews[review]->ofdbRating > 0}
                        <tr>
                           <td>{t}OFDB User Rating{/t}:</td>
                           <td><img src="include/voting.php?rating={$dvd->extReviews[review]->ofdbRating}" alt="{$dvd->extReviews[review]->ofdbRating}"> {$dvd->extReviews[review]->ofdbRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/10 ({t}votes{/t}: {$dvd->extReviews[review]->ofdbVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td>
                        </tr>
                        {if isset($dvd->extReviews[review]->ofdbTop250)}
                           <tr>
                              <td>{t}OFDB Top 250{/t}:</td>
                              <td>{$dvd->extReviews[review]->ofdbTop250}</td>
                           </tr>
                        {/if}
                        {if isset($dvd->extReviews[review]->ofdbBottom100)}
                           <tr>
                              <td>{t}OFDB Bottom 100{/t}:</td>
                              <td>{$dvd->extReviews[review]->ofdbBottom100}</td>
                           </tr>
                        {/if}
                     {/if}
         
                     {if isset($dvd->extReviews[review]->rotcRating) && $dvd->extReviews[review]->rotcRating > 0}
                        <tr>
                           <td>{t}RottenTomatoes Critics Rating{/t}:</td>
                           <td><img src="include/voting.php?rating={$dvd->extReviews[review]->rotcRating}" alt="{$dvd->extReviews[review]->rotcRating}"> {$dvd->extReviews[review]->rotcRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/10 ({t}votes{/t}: {$dvd->extReviews[review]->rotcVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td>
                        </tr>
                     {/if}
         
                     {if isset($dvd->extReviews[review]->rotuRating) && $dvd->extReviews[review]->rotuRating > 0}
                        <tr>
                           <td>{t}RottenTomatoes User Rating{/t}:</td>
                           <td><img src="include/voting.php?rating={$dvd->extReviews[review]->rotuRating}&maxrate=5" alt="{$dvd->extReviews[review]->rotuRating}"> {$dvd->extReviews[review]->rotuRating|number_format:2:$pmp_dec_point:$pmp_thousands_sep}/5 ({t}votes{/t}: {$dvd->extReviews[review]->rotuVotes|number_format:0:$pmp_dec_point:$pmp_thousands_sep})</td>
                        </tr>
                     {/if}
                  {/section}
               {/if}
         
            {/if}
            
         </tbody>
      </table>
      
   </div> <!-- table-responsive -->
      
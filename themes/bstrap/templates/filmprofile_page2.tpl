{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

filmprofile_page2.tpl

===============================================================================
*}

{assign "pmp_theme_css" "bootstrap.css"}
{assign "showlist" "Owned"}
{if isset($smarty.session.skin) && $smarty.get.skin != ""} {$pmp_theme_css = $smarty.get.skin} {/if}
{if isset($smarty.session.showlist) && $smarty.get.showlist != ""}{$showlist = $smarty.get.showlist}{/if}
{if $pmp_theme_css == "default.css"}{$pmp_theme_css = "bootstrap.css"}{/if}

<div class="table-responsive">

   {if isset($dvd->Audio) || isset($dvd->Subtitles)}
   <table class="table table-striped table-bordered">
      <thead>
         <tr class="active">
            <th colspan="3" class="warning">{t}Audio{/t}</th>
         </tr>
         <tr>
            <th>{t}Content{/t}</th>
            <th>{t}Channels{/t}</th>
            <th>{t}Format{/t}</th>
         </tr>
      </thead>
      <tbody>
      {if isset($dvd->Audio)}
         {foreach from=$dvd->Audio item=audio}
            <tr>
               <td>{$audio.Content|flag}</td>
               <td>{$audio.Channels|getpic:channels}</td>
               <td>{$audio.Format|getpic:format}</td>
            </tr>
         {/foreach}
      {/if}
      </tbody>
   </table>
   
   <table class="table table-striped table-bordered">
      <thead>
         <tr class="active">
            <th colspan="3" class="warning">{t}Subtitles{/t}</th>
         </tr>
      </thead>
      <tbody>
         {if isset($dvd->Subtitles)}
            {foreach from=$dvd->Subtitles item=sub}
               <tr>
                  <td colspan="3">{$sub|flag}&nbsp;&nbsp;{t}{$sub}{/t}</td>
               </tr>
            {/foreach}
         {/if}
      </tbody>
   </table>
   {/if}

   <table class="table table-striped table-bordered">
      <thead>
         <tr class="warning">
            <th colspan="3">{t}Video Information{/t}</th>
         </tr>
      </thead>
      <tbody>
         {if $dvd->Media != 'Blu-ray' && $dvd->Media != 'HD DVD'}
            <tr>
               <td>{t}Video Format{/t}</td>
               <td colspan="2">{$dvd->Video}</td>
            </tr>
         {/if}
         {if $dvd->PanAndScan || $dvd->FullFrame || $dvd->Widescreen || $dvd->Ratio || $dvd->Anamorph}
            <tr>
               <td>{t}Aspect Ratio{/t}</td>
               <td colspan="2">
                  {strip}
                  {if $dvd->PanAndScan}
                     <div class="dual-label dual-label-success">
                        <div class="dual-label-upper-success">Pan & Scan</div>
                        <div class="dual-label-lower-success">4 : 3</div>
                     </div>
                  {/if}
                  {if $dvd->FullFrame}
                     <div class="dual-label dual-label-success">
                        <div class="dual-label-upper-success">Full Frame</div>
                        <div class="dual-label-lower-success">1.33 : 1</div>
                     </div>
                  {/if}
                  {if $dvd->Widescreen == '1' && $dvd->Ratio != ''}
                     <div class="dual-label dual-label-warning">
                        <div class="dual-label-upper-warning">Widescreen</div>
                        <div class="dual-label-lower-warning">{$dvd->Ratio} : 1</div>
                     </div>
                  {/if}
                  {if $dvd->Anamorph}
                     <div class="dual-label dual-label-warning">
                        <div class="dual-label-upper-warning">Anamorph</div>
                        <div class="dual-label-lower-warning">16 : 1</div>
                     </div>
                  {/if}
                  {/strip}
               </td>
            </tr>
         {/if}
         <tr>
            <td>{t}Color{/t}</td>
            <td>
               {$dvd->Color|getpic:boolean} {t}Color{/t}<br>
               {$dvd->BlackWhite|getpic:boolean} {t}Black & White{/t}<br>
            </td>
            <td>
               {$dvd->Colorized|getpic:boolean} {t}Colorized{/t}<br>
               {$dvd->Mixed|getpic:boolean} {t}Mixed{/t}
            </td>
         </tr>
         <tr>
            <td>{t}Dimensions{/t}</td>
            <td>
               {$dvd->Dim2D|getpic:boolean} {t}2D{/t}<br>
               {$dvd->Anaglyph|getpic:boolean} {t}3D Anaglyph{/t}<br>
            </td>
            <td>
               {$dvd->Bluray3D|getpic:boolean} {t}Blu-ray 3D{/t}
            </td>
         </tr>
      </tbody>
   </table>

   <table class="table table-striped table-bordered">
      <thead>
         <tr class="warning">
            <th colspan="2">{t}Features{/t}</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               {$dvd->Scenes|getpic:boolean} {t}Scene Access{/t}<br>
               {$dvd->Trailer|getpic:boolean} {t}Feature Trailers{/t}<br>
               {$dvd->BonusTrailer|getpic:boolean} {t}Bonus Trailers{/t}<br>
               {$dvd->Deleted|getpic:boolean} {t}Deleted Scenes{/t}<br>
               {$dvd->Notes|getpic:boolean} {t}Prod. Notes{/t}<br>
               {$dvd->DVDrom|getpic:boolean} {t}DVD-ROM Content{/t}<br>
               {$dvd->Musicvideos|getpic:boolean} {t}Music Videos{/t}<br>
               {$dvd->Storyboard|getpic:boolean} {t}Storyboard Comparisons{/t}<br>
               {$dvd->ClosedCaptioned|getpic:boolean} {t}Closed Captioned{/t}<br>
               {if $dvd->Media == 'Blu-ray' || $dvd->Media == 'HD DVD'}
                  {$dvd->PictureInPicture|getpic:boolean} {t}Picture-in-Picture{/t}<br>
               {/if}
            </td>
            <td>
               {$dvd->Comment|getpic:boolean} {t}Commentary{/t}<br>
               {$dvd->PhotoGallery|getpic:boolean} {t}Photo Gallery{/t}<br>
               {$dvd->MakingOf|getpic:boolean} {t}Featurettes{/t}<br>
               {$dvd->Game|getpic:boolean} {t}Interactive Games{/t}<br>
               {$dvd->Multiangle|getpic:boolean} {t}Multi-angle{/t}<br>
               {$dvd->Interviews|getpic:boolean} {t}Interviews{/t}<br>
               {$dvd->Outtakes|getpic:boolean} {t}Outtakes/Bloopers{/t}<br>
               {$dvd->THX|getpic:boolean} {t}THX Certified{/t}<br>
               {if $dvd->Media == 'Blu-ray'}
                  {$dvd->BDLive|getpic:boolean} {t}BD-Live{/t}<br>
               {/if}
               {$dvd->DigitalCopy|getpic:boolean} {t}Digital Copy{/t}<br>
            </td>
         </tr>
         {if !empty($dvd->Other)}
            <tr>
               <td colspan="2">
                  <strong>{t}Other Features{/t}:</strong><br>
                  {$dvd->Other}
               </td>
            </tr>
         {/if}
      </tbody>
   </table>

   <table class="table table-striped table-bordered">
      <thead>
         <tr class="warning">
            <th>{t}Additional Information{/t}</th>
         </tr>
      </thead>
      <tbody>
         {if isset($dvd->Studios)}
            <tr>
               <td>
                  <strong>{t}Studios{/t}:</strong><br>
                  {foreach from=$dvd->Studios item=S}
                     <a href="index.php?addwhere=pmp_studios[dot]id&amp;whereval=studio[dot]{$S|rawurlencode}&amp;caption=Studio:%20{$S|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$S}</a><br>
                  {/foreach}
               </td>
            </tr>
         {/if}
         <tr>
            <td>
               <strong>{t}Genres{/t}:</strong><br>
               {foreach from=$dvd->Genres item=G}
                  <a href="index.php?addwhere=pmp_genres[dot]id&amp;whereval=genre[dot]{$G|rawurlencode}&amp;caption=Genre:%20{$G|rawurlencode}&amp;showlist={$showlist}&amp;skin={$pmp_theme_css}">{$G}</a><br>
               {/foreach}
            </td>
         </tr>
      </tbody>
   </table>
      
   {if isset($dvd->Discs)}
   <table class="table table-striped table-bordered">
      <thead>
         <tr class="warning">
            <th>{t}Media Info{/t}</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>
               {strip}
               {foreach from=$dvd->Discs item=Disc}
                  {if $dvd->Media == 'DVD'}
                     {if $Disc->duallayersidea || $Disc->duallayersideb}
                        {if $Disc->dualsided}<img src="themes/{$pmp_theme}/images/additional/dvddlds.gif" alt="DVD 18 (Dual Layered, Dual Sided)" title="DVD 18 (Dual Layered, Dual Sided)"><br>
                        {else}<img src="themes/{$pmp_theme}/images/additional/dvddlss.gif" alt="DVD 9 (Dual Layered, Single Sided)" title="DVD 9 (Dual Layered, Single Sided)"><br>
                        {/if}
                     {else}
                        {if $Disc->dualsided}<img src="themes/{$pmp_theme}/images/additional/dvdslds.gif" alt="DVD 10 (Single Layered, Dual Sided)" title="DVD 10 (Single Layered, Dual Sided)"><br>
                        {else}<img src="themes/{$pmp_theme}/images/additional/dvdslss.gif" alt="DVD 5 (Single Layered, Single Sided)" title="DVD 5 (Single Layered, Single Sided)"><br>
                        {/if}
                     {/if}
                  {else}
                     {if $Disc->duallayersidea || $Disc->duallayersideb}
                        {t}Dual Layered{/t}<br>
                     {else}
                        {t}Single Layered{/t}<br>
                     {/if}
                  {/if}
   
                  {if $Disc->descsidea != ''}{t}Description Side A{/t}:&nbsp;{$Disc->descsidea}<br>{/if}
                  {if $Disc->labelsidea != ''}{t}Label Side A{/t}:&nbsp;{$Disc->labelsidea}<br>{/if}
                  {if $Disc->discidsidea != ''}{t}DiscID Side A{/t}:&nbsp;{$Disc->discidsidea}<br>{/if}
                  {if $Disc->descsideb != ''}{t}Description Side B{/t}:&nbsp;{$Disc->descsideb}<br>{/if}
                  {if $Disc->labelsideb != ''}{t}Label Side B{/t}:&nbsp;{$Disc->labelsideb}<br>{/if}
                  {if $Disc->discidsideb != ''}{t}DiscID Side B{/t}:&nbsp;{$Disc->discidsideb}<br>{/if}
                  {if $Disc->location != ''}{t}Location{/t}:&nbsp;{$Disc->location}<br>{/if}
                  {if $Disc->slot != ''}{t}Slot{/t}:&nbsp;{$Disc->slot}<br>{/if}
               {/foreach}
               {/strip}
            </td>
         </tr>
      </tbody>
   </table>
   {/if}

   {if $dvd->Easteregg != '' || isset($dvd->Awards) }
   <table class="table table-striped table-bordered">
      <thead>
         <tr class="warning">
            <th>{t}Various Information{/t}</th>
         </tr>
      </thead>
      <tbody>
         {if $dvd->Easteregg != ''}
            <tr>
               <td>
                  <strong>{t}Easter Egg{/t}:</strong><br>
                  {foreach from=$dvd->Easteregg item=E}
                     {$E|nl2br}<br>
                  {/foreach}
               </td>
            </tr>
         {/if}
         {if isset($dvd->Awards)}
            <tr>
               <td>
                  <strong>{t}Awards{/t}:</strong><br>
                  {assign var="last_value" value=""}
                  {foreach from=$dvd->Awards item=Award}
                     {if $last_value != $Award->award}
                        {if $last_value != ''}<br>{/if}
                        <strong>{$Award->award}</strong> ({$Award->awardyear}):<br>
                     {/if}
                     {if $Award->winner == 1}
                        {t}Winner{/t}
                     {else}
                        {t}Nominee for{/t}
                     {/if}
                     {$Award->category}&nbsp;{if $Award->nominee}-&nbsp;{$Award->nominee}{/if}<br>
                     {assign var="last_value" value=$Award->award}
                  {/foreach}
               </td>
            </tr>
         {/if}
      </tbody>
   </table>
   {/if}

</div>

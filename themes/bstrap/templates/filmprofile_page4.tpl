{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

filmprofile_page4.tpl

===============================================================================
*}

<div class="table-responsive">

   <table class="table table-striped table-bordered">
      <thead>
         <tr class="active">
            <th colspan="3" class="warning">{t}Events{/t}</th>
         </tr>
         <tr>
            <th>{t}Date{/t}</th>
            <th>{t}Event{/t}</th>
            <th>{t}Name{/t}</th>
            <th>{t}Note{/t}</th>
         </tr>
      </thead>
      <tbody>
         {foreach from=$dvd->Events item=event key=sch}
            <tr>
               <td>{$event->date|date_format:$pmp_dateformat}{if $pmp_events_showtime == 1 && $event->time != '00:00:00'} - {$event->time}{/if}</td>
               <td>{t}{$event->eventtype}{/t}</td>
               <td>
                  {*if $event->email != ''*}
                     {*assign var="name" value="{$event->firstname} {$event->lastname}"*}
                     {*mailto address=$event->email encode="javascript" text=$name*}
                  {*else*}
                     {$event->firstname}&nbsp;{$event->lastname}
                  {*/if*}
               </td>
               <td>{$event->note}</td>
            </tr>
         {/foreach}
      </tbody>
   </table>
   
</div>

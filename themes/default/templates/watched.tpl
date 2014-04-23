<td valign="top" width="65%">
  <div>

    {assign var="windowtitle" value="Watched"}
    {include file="window-start.inc.tpl"}
    <table width="100%" style="border:1px solid #546359;" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td>
          <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
            <tr>
              <th style="width:200px;">{t}Viewer{/t}</th>                        
              <th style="text-align:right;">{t}Total Running Time{/t}<br />{t}Days{/t} : {t}Hours{/t} : {t}Minutes{/t}</th>
              <th style="text-align:center;">{t}Titles Watched{/t}</th>
              <th style="text-align:center;">{t}Average Running Time{/t}</th>
            </tr>
            {foreach from=$persons item=person key=s1}
              <tr>
                <td class="td{$s1%2}"><a href="{if $fn neq $person->firstname or $ln neq $person->lastname}?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}{else}?content=watched{/if}">{$person->firstname} {$person->lastname}</a></td>
                <td class="td{$s1%2}" style="text-align:right;">{$person->days} : {$person->hours} : {$person->minutes}</td>
                <td class="td{$s1%2}c">{$person->cnt}</td>
                <td class="td{$s1%2}c">{$person->avg} min</td>
              </tr>
              {foreach from=$years item=year key=s2}
                {if $person->lastname eq $year->lastname & $person->firstname eq $year->firstname}
                  <tr>
                    <td class="td{$s2%2}" style="padding-left:50px;"><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={if $yr neq $year->year}{$year->year}{/if}">{$year->year}</a></td>
                    <td class="td{$s2%2}" style="text-align:right;">{$year->days} : {$year->hours} : {$year->minutes}</td>
                    <td class="td{$s2%2}c">{$year->cnt}</td>
                    <td class="td{$s2%2}c">{$year->avg} min</td>
                  </tr>
                  {foreach from=$months item=month key=s3}
                    {if $year->year eq $month->year}
                      <tr>
                        <td class="td{$s3%2}" style="padding-left:100px;"><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={$year->year}&amp;month={if $mo neq $month->month}{$month->month}{/if}">{t}{$month->monthname}{/t}</a></td>
                        <td class="td{$s3%2}" style="text-align:right;">{$month->days} : {$month->hours} : {$month->minutes}</td>
                        <td class="td{$s3%2}c">{$month->cnt}</td>
                        <td class="td{$s3%2}c">{$month->avg} min</td>
                      </tr>
                      {foreach from=$movies item=movie name=movie key=s4}
                        {if $month->month eq $movie->month}
                          {if $smarty.foreach.movie.iteration == 1}
                            <tr>
                              <th></th>
                              <th><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={$year->year}&amp;month={$month->month}&amp;w_orderby=title&amp;w_orderdir={$w_orderdir}">{t}Title{/t}</a></th>
                              <th style="text-align:center;"><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={$year->year}&amp;month={$month->month}&amp;w_orderby=runningtime&amp;w_orderdir={$w_orderdir}">{t}Running Time{/t}</a></th>
                              <th style="text-align:center;"><a href="?content=watched&amp;fn={$person->firstname}&amp;ln={$person->lastname}&amp;year={$year->year}&amp;month={$month->month}&amp;w_orderby=timestamp&amp;w_orderdir={$w_orderdir}">{t}Date{/t}</a></th>
                            </tr>
                          {/if}
                          <tr>
                            <td style="background-color:#c4d4ff;"></td>
                            <td class="td{$s4%2}"><a href="index.php?content=filmprofile&amp;id={$movie->id}">{$movie->title}</a></td>
                            <td class="td{$s4%2}" style="text-align:center;">{$movie->runningtime} min</td>
                            <td class="td{$s4%2}" style="text-align:center;">{$movie->date}</td>
                          </tr>
                        {/if}
                      {/foreach}
                    {/if}
                  {/foreach}
                {/if}
              {/foreach}
            {/foreach}
            <tr>
              {foreach from=$results item=result}
                <th>Total</th>
                <th style="text-align:right;">{$result->days} : {$result->hours} : {$result->minutes}</th>
                <th style="text-align:center;">{$result->cnt}</th>
                <th style="text-align:center;">{$result->avg} min</th>
              {/foreach}
            </tr>
          </table>
        </td>
      </tr>
    </table>
    {include file="window-end.inc.tpl"}
        
  </div>    
</td>
{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

nocover.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Check pictures of covers{/t}</div>
      <div class="panel-body">
         <p>
            {t}Click on{/t} <img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt=""> {t}-symbol to load missing covers from the Invelos server.{/t}
         </p>
         <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                      <th>{t}DVD{/t}</th>
                      <th class="text-center">{t}Front{/t}</th>
                      <th class="text-center">{t}Back{/t}</th>
                  </tr>
               </thead>
               <tbody>
                  {foreach from=$dvds item=dvd key=sch}
                     <tr>
                        <td>{$dvd->Title}</td>
                        <td class="text-center">
                           {if $dvd->frontpic}
                              <a href="javascript:void(0);" onmouseover="return overlib('&lt;div style=&quot;text-align: center&quot;&gt; &lt;img src=../thumbnail.php?id={$dvd->id}&amp;type=front&amp;width=100&amp;local=true /&gt; &lt;div&gt;', CAPTION, '{$dvd->Title}', MOUSEOFF);" onmouseout="return nd();"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt=""></a>
                           {else}
                              <a onclick="javascript:window.open('getcover.php?cover={$dvd->id}f&amp;nohead=true&amp;{$session}', 'getcover','resizable=1,location=0,directories=0,status=0,menubar=0,scrollbars=0,toolbar=0,width=450,height=400');return false;" href="getcover.php?cover={$dvd->id}f&amp;{$session}"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt=""></a>
                           {/if}
                        </td>
                        <td class="text-center">
                           {if $dvd->backpic}
                              <a href="javascript:void(0);" onmouseover="return overlib('&lt;div style=&quot;text-align: center&quot;&gt; &lt;img src=../thumbnail.php?id={$dvd->id}&amp;type=back&amp;width=100&amp;local=true /&gt; &lt;div&gt;', CAPTION, '{$dvd->Title}', MOUSEOFF);" onmouseout="return nd();"><img src="../themes/{$pmp_theme}/images/menu/apply_s.png" alt=""></a>
                           {else}
                              <a onclick="javascript:window.open('getcover.php?cover={$dvd->id}b&amp;nohead=true&amp;{$session}', 'getcover','resizable=1,location=0,directories=0,status=0,menubar=0,scrollbars=0,toolbar=0,width=450,height=400');return false;" href="getcover.php?cover={$dvd->id}b&amp;{$session}"><img src="../themes/{$pmp_theme}/images/menu/cancel_s.png" alt=""></a>
                           {/if}
                        </td>
                     </tr>
                  {/foreach}
               </tbody>
            </table>
         </div>
         
      </div>
   </div>
   
</div>

{literal}
   <script type="text/javascript">
      //<![CDATA[
      $('.fancybox').fancybox();
      //]]>
   </script>
{/literal}

{include file="admin/footer.tpl"}

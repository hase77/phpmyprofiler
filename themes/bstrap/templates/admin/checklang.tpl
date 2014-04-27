{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

checklang.tpl

===============================================================================
*}

{include file="admin/header.tpl"}

<div class="col-lg-12">

   <div class="panel panel-primary">
      <div class="panel-heading">{t}Check translations{/t}</div>
      <div class="panel-body">
      
         <div class="panel panel-default">
            <div class="panel-heading">
               {t}Choose language to check:{/t}
            </div>
            <div class="panel-body">
               {foreach from=$getLangs item=Lang}
                  <button type="button" class="btn btn-default" name="backAdmin" onclick="window.location='checklang.php?LG={$Lang}&amp;{$session}';">{$Lang|flag}&nbsp;&nbsp;{t}{$Lang}{/t}</button>
               {/foreach}
            </div>
         </div>
         
         <div class="panel panel-success">
            <div class="panel-heading">{t}Detailed overview{/t}</div>
            <div class="panel-body">
            
               {foreach from=$templates item=templ key=templname}
                  {if (isset($templ.missing) && $templ.missing|count) || (isset($templ.used) && $templ.used|count)}
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#panel{$templ.module}">{$templ.module}</a>
                        </div>
                        <div id="panel{$templ.module}" class="panel-body panel-collapse collapse">
                           {if isset($templ.files) && $templ.files|count}
                              <ul>
                                 {foreach from=$templ.files item=str key=string}<li>{$str}</li>{/foreach}
                              </ul>
                           {/if}
                           
                           <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover">
                                 <tbody>
                                    {if isset($templ.missing) && $templ.missing|count}
                                       <tr>
                                          <td colspan="2"><strong>{t}Missing Translations{/t}</strong></td>
                                       </tr>
                                       {foreach from=$templ.missing item=str key=string}
                                          {foreach from=$str item=str2 key=str1}
                                             <tr>
                                                <td>{$str1}</td>
                                                <td>&nbsp;</td>
                                             </tr>
                                          {/foreach}
                                       {/foreach}
                                    {/if}
                                    
                                    
                                    {if (isset($templ.missing) && $templ.missing|count) || (isset($templ.used) && $templ.used|count)}
                                       <tr><td colspan="2">&nbsp;</td></tr>
                                    {/if}
                           
                                    {if isset($templ.used) && $templ.used|count}
                                       <tr><td colspan="2" class="strong"><strong>{t}Used Translations{/t}</strong></td></tr>
                                       {foreach from=$templ.used item=str key=string}
                                          {foreach from=$str item=str2 key=str1}
                                             <tr>
                                                <td>{$str1}</td>
                                                <td>{$str2}</td>
                                             </tr>
                                          {/foreach}
                                       {/foreach}
                                    {/if}
                                 </tbody>
                              </table>
                           </div>
                           
                        </div>
                        
                     </div>
                  {/if}
               {/foreach}
               
            </div>
         </div>
         
         <div class="panel panel-warning">
            <div class="panel-heading">{t}Unused Translations{/t}</div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                     <tbody>
                        {foreach from=$unused item=str key=string}
                           {foreach from=$str item=str2 key=str1}
                              <tr>
                                 <td>{$str1}</td>
                                 <td>{$str2}</td>
                              </tr>
                           {/foreach}
                        {/foreach}
                     </tbody>
                  </table>            
               </div>    
            </div>
         </div>
         
      </div>
   </div>
   
</div>

{include file="admin/footer.tpl"}

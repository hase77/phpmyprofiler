{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

statisticsdetail.tpl

===============================================================================
*}

            <div class="col-lg-6">

               <h2>{$report.title}</h2>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Result{/t}</div>
                  <div class="panel-body">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 {foreach from=$report.column item=th name=foo} 
                                    {if $smarty.foreach.foo.index < 3}
                                       <th>{t}{$th}{/t}</th>
                                    {/if}
                                 {/foreach}
                              </tr>
                           </thead>
                           <tbody>
                              {foreach from=$data item=row key=sch}
                                 <tr> 
                                    {foreach from=$row item=col name=cols} 
                                       {if $smarty.foreach.cols.index < 3}
                                          <td>{if in_array($smarty.foreach.cols.iteration, $report.translate)}{t}{$col}{/t}{else}{$col}{/if}</td>
                                          {*<td>{t}{$col}{/t}</td>*}
                                       {/if}
                                    {/foreach}
                                 </tr> 
                              {/foreach}
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

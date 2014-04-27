{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

search.tpl

===============================================================================
*}

            <div class="col-lg-6">

               <h2>{t}Search DVD Collection{/t}</h2>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Find Movie{/t}</div>
                  <div class="panel-body">
                     <form class="bs-example form-horizontal" method="get" accept-charset="utf-8">
                        <input type="hidden" name="addwildcardboth" value="True">
                        <input type="hidden" name="trim" value="True">
                        <input type="hidden" name="delwhere" value="title">
                        <input type="hidden" name="addwhere" value="title">
                        <input type="hidden" name="caption" value="Title: ??">
                        <input class="form-control" type="text" name="whereval" size="40"><br> 
                        <input type="submit" value="{t}Search for Movie{/t}" class="btn btn-default">
                     </form>
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Find Person{/t}</div>
                  <div class="panel-body">
                     <form action="index.php" method="get" accept-charset="utf-8">
                        <input type="hidden" name="content" value="searchperson">
                        <input class="form-control" type="text" name="name" size="40"><br> 
                        <input type="submit" value="{t}Search for Person{/t}" class="btn btn-default">
                     </form>
                  </div>
               </div>

               <div class="panel panel-primary">
                  <div class="panel-heading">{t}Add Filters{/t}</div>
                  <div class="panel-body">
                  
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Media Type{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="media">
                                 <input type="hidden" name="delwhere" value="media">
                                 <input type="hidden" name="caption" value="Media Type: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {if $MediaDVD > 0}<option value="DVD">DVD</option>{/if}
                                    {if $MediaHDDVD > 0}<option value="HD DVD">HD DVD</option>{/if}
                                    {if $MediaBluray > 0}<option value="Blu-ray">Blu-ray</option>{/if}
                                    {foreach from=$Media item=Type}
                                       <option value="{$Type}">{$Type}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Genre{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_genres[dot]id">
                                 <input type="hidden" name="caption" value="Genre: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Genres item=Genre}
                                       <option value="genre[dot]{$Genre}">{$Genre}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Country{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="locality">
                                 <input type="hidden" name="delwhere" value="locality">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Locations item=Location}
                                       <option value="{$Location}">{t}{$Location}{/t}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Country of Origin{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_countries_of_origin[dot]id">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Origins item=Origin}
                                       <option value="country[dot]{$Origin}">{t}{$Origin}{/t}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Year of Production{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="prodyear">
                                 <input type="hidden" name="delwhere" value="prodyear">
                                 <input type="hidden" name="caption" value="Production Year: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Prodyear item=year}
                                       <option value="{$year}">{$year}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Studio{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_studios[dot]id">
                                 <input type="hidden" name="caption" value="Studio: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Studios item=Studio}
                                       <option value="studio[dot]{$Studio}">{$Studio}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Media Company{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_media_companies[dot]id">
                                 <input type="hidden" name="caption" value="Media Company: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$MediaCompanies item=Company}
                                       <option value="company[dot]{$Company}">{$Company}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Tags{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_tags[dot]id">
                                 <input type="hidden" name="caption" value="Tag: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Tags item=Tag}
                                       <option value="name[dot]{$Tag}">{$Tag}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Audio{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_audio[dot]id">
                                 <input type="hidden" name="caption" value="Audio: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Audio item=Format}
                                       <option value="format[dot]{$Format}">{$Format}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Audio Language{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_audio[dot]id">
                                 <input type="hidden" name="caption" value="Audio Language: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Language item=Lang}
                                       <option value="content[dot]{$Lang}">{t}{$Lang}{/t}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Subtitles{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_subtitles[dot]id">
                                 <input type="hidden" name="caption" value="Subtitle: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Subtitle item=UT}
                                       <option value="subtitle[dot]{$UT}">{t}{$UT}{/t}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Region Code{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="pmp_regions[dot]id">
                                 <input type="hidden" name="caption" value="Region: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Regioncode item=LC}
                                       <option value="region[dot]{$LC}">{$LC}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Rating{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="rating">
                                 <input type="hidden" name="delwhere" value="rating">
                                 <input type="hidden" name="caption" value="Rating: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Rating item=RC}
                                       <option value="{$RC}">{$RC}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Case Type{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="casetype">
                                 <input type="hidden" name="delwhere" value="casetype">
                                 <input type="hidden" name="caption" value="Case Type: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Casetype item=CT}
                                       <option value="{$CT}">{$CT}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                     {if $Purchplace}
                     <form action="index.php" method="get">
                        <fieldset>
                           <div class="form-group">
                              <label class="col-lg-3 control-label">{t}Place of Purchase{/t}</label>
                              <div class="col-lg-9">
                                 <input type="hidden" name="addwhere" value="purchplace">
                                 <input type="hidden" name="delwhere" value="purchplace">
                                 <input type="hidden" name="caption" value="Purchplace: ??">
                                 <select class="form-control" onchange="this.form.submit()" name="whereval">
                                    <option value="" selected="selected">{t}please select{/t}</option>
                                    {foreach from=$Purchplace item=PP}
                                       <option value="{$PP}">{$PP}</option>
                                    {/foreach}
                                 </select>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     {/if}
                     
                     <form action="index.php?reset=1" method="post">
                        <fieldset>
                           <div class="form-group">
                              <div class="col-lg-12">
                                 <button type="submit" class="btn btn-primary" tabindex="6" name="send">{t}Remove all filters{/t}</button>
                              </div>
                           </div>
                        </fieldset>
                     </form><br>
                     
                  </div>
               </div>

            </div> <!-- col-lg-6 -->
            
         </div> <!-- row -->

<td valign="top" style="width: 66%; padding-left: 2px; padding-right: 4px;" id="right-frame">

<div>

	{assign var="windowtitle" value="Search DVD Collection"}
	{include file="window-start.inc.tpl"}

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Find Movie{/t}:&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<table class="feature">
					<tr>
						<td class="feature">
							<form action="index.php" method="get" accept-charset="utf-8">
								<div>
								<input type="hidden" name="addwildcardboth" value="True"/>
								<input type="hidden" name="trim" value="True" />
								<input type="hidden" name="delwhere" value="title" />
								<input type="hidden" name="addwhere" value="title" />
								<input type="hidden" name="caption" value="Title: ??" />
								<input type="text" name="whereval" size="40" class="text" /> 
								<input type="submit" value="{t}Search for Movie{/t}" class="button" onmouseover="this.className='button-over';" onmouseout="this.className='button';" />
								</div>
							</form> 
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
                     
	<table class="frame">
		<tr>
			<td class="frame-title">
				 <div class="frame-title">&nbsp;&nbsp;{t}Find Person{/t}:&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<table class="feature">
					<tr>
						<td class="feature">
							<form action="index.php" method="get" accept-charset="utf-8">
								<div>
								<input type="hidden" name="content" value="searchperson" />
								<input type="text" name="pname" size="40" class="text" /> 
								<input type="submit" value="{t}Search for Person{/t}" class="button" onmouseover="this.className='button-over';" onmouseout="this.className='button';" />
								</div>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="frame">
		<tr>
			<td class="frame-title">
				<div class="frame-title">&nbsp;&nbsp;{t}Add Filters{/t}:&nbsp;&nbsp;</div>
			</td>
			<td class="frame-title-right"></td>
		</tr>
		<tr>
			<td colspan="2" class="frame-content">
				<table class="feature">

					<tr>
						<td class="feature"><b>{t}Media Type{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="media" />
								<input type="hidden" name="delwhere" value="media" />
								<input type="hidden" name="caption" value="Media Type: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option value="" class="option" selected="selected">{t}please select{/t}</option>
									{if $MediaDVD > 0}<option value="DVD" class="option">DVD</option>{/if}
									{if $MediaHDDVD > 0}<option value="HD DVD" class="option">HD DVD</option>{/if}
									{if $MediaBluray > 0}<option value="Blu-ray" class="option">Blu-ray</option>{/if}
									{foreach from=$Media item=Type}
										<option class="option" value="{$Type}">{$Type}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Genre{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_genres[dot]id" />
								<input type="hidden" name="caption" value="Genre: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option value="" class="option" selected="selected">{t}please select{/t}</option>
									{foreach from=$Genres item=Genre}
										<option class="option" value="genre[dot]{$Genre}">{$Genre}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
 
					<tr>
						<td class="feature"><b>{t}Country{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="locality" />
								<input type="hidden" name="delwhere" value="locality" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Locations item=Location}
										<option class="option" value="{$Location}">{t}{$Location}{/t}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
                                 
					<tr>
						<td class="feature"><b>{t}Country of Origin{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_countries_of_origin[dot]id" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Origins item=Origin}
										<option class="option" value="country[dot]{$Origin}">{t}{$Origin}{/t}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Year of Production{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="prodyear" />
								<input type="hidden" name="delwhere" value="prodyear" />
								<input type="hidden" name="caption" value="Production Year: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Prodyear item=year}
										<option class="option" value="{$year}">{$year}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Studio{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_studios[dot]id" />
								<input type="hidden" name="caption" value="Studio: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Studios item=Studio}
										<option class="option" value="studio[dot]{$Studio}">{$Studio}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
            
					<tr>
						<td class="feature"><b>{t}Media Company{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_media_companies[dot]id" />
								<input type="hidden" name="caption" value="Media Company: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$MediaCompanies item=Company}
										<option class="option" value="company[dot]{$Company}">{$Company}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Tags{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_tags[dot]id" />
								<input type="hidden" name="caption" value="Tag: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Tags item=Tag}
										<option class="option" value="name[dot]{$Tag}">{$Tag}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
            
					<tr>
						<td class="feature"><b>{t}Audio{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_audio[dot]id" />
								<input type="hidden" name="caption" value="Audio: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Audio item=Format}
										<option class="option" value="format[dot]{$Format}">{$Format}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
            
					<tr>
						<td class="feature"><b>{t}Audio Language{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_audio[dot]id" />
								<input type="hidden" name="caption" value="Audio Language: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Language item=Lang}
										<option class="option" value="content[dot]{$Lang}">{t}{$Lang}{/t}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Subtitles{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_subtitles[dot]id" />
								<input type="hidden" name="caption" value="Subtitle: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Subtitle item=UT}
										<option class="option" value="subtitle[dot]{$UT}">{t}{$UT}{/t}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
            
					<tr>
						<td class="feature"><b>{t}Region Code{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="pmp_regions[dot]id" />
								<input type="hidden" name="caption" value="Region: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Regioncode item=LC}
										<option class="option" value="region[dot]{$LC}">{$LC}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Rating{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="rating" />
								<input type="hidden" name="delwhere" value="rating" />
								<input type="hidden" name="caption" value="Rating: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Rating item=RC}
										<option class="option" value="{$RC}">{$RC}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					<tr>
						<td class="feature"><b>{t}Case Type{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="casetype" />
								<input type="hidden" name="delwhere" value="casetype" />
								<input type="hidden" name="caption" value="Case Type: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Casetype item=CT}
										<option class="option" value="{$CT}">{$CT}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>

					{if $Purchplace}
					<tr>
						<td class="feature"><b>{t}Place of Purchase{/t}:</b></td>
						<td class="feature">
							<form action="index.php" method="get">
								<div>
								<input type="hidden" name="addwhere" value="purchplace" />
								<input type="hidden" name="delwhere" value="purchplace" />
								<input type="hidden" name="caption" value="Purchplace: ??" />
								<select class="select" onchange="this.form.submit()" name="whereval">
									<option class="option" value="" selected="selected">{t}please select{/t}</option>
									{foreach from=$Purchplace item=PP}
										<option class="option" value="{$PP}">{$PP}</option>
									{/foreach}
								</select>
								</div>
							</form>
						</td>
					</tr>
					{/if}

					<tr>
						<td class="feature"><b>{t}Remove all filters{/t}:</b></td>
						<td class="feature">
							<form action="index.php?reset=1" method="get">
								<div>
								<input type="hidden" name="reset" value="1" />
								<input type="submit" value="{t}Remove all filters{/t}" class="button" onmouseover="this.className='button-over';" onmouseout="this.className='button';" />
								</div>
							</form>
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
   
	{include file="window-end.inc.tpl"}
   
</div>

</td>

<HTML>
	<HEAD>
	
		<!-- Load Applicables Scripts -->
		<script type="text/javascript" src="scripts/_iface/wz_jsgraphics.js"></script>
		<script type="text/javascript" src="scripts/_iface/ui_controls_lowerlayer.js"></script>
		<script type="text/javascript" src="scripts/_iface/dhtmlwindow.js"></script>
		
		<link href="stylesheets/perpcarto.css" 								rel="stylesheet" type="text/css" media="screen" />
		<link href="stylesheets/perpcarto_quickaccess.css" 					rel="stylesheet" type="text/css" media="screen" />
		<link href="stylesheets/perpcarto_mainmenu.css" 					rel="stylesheet" type="text/css" media="screen" />
		<link href="stylesheets/perpcarto_mapcontrols.css" 					rel="stylesheet" type="text/css" media="screen" />
		<link href="stylesheets/dhtmlwindow.css" 							rel="stylesheet" type="text/css" media="screen" />
		
		<?php 
		// LOAD INCLUDES
		
		include("includes/gs_config.php");
		include("includes/_dateandtime/dateandtime.list.php");										// List of all Date and Time functions
		include("includes/_systemusers/systemusers.list.php");										// List of all Navigation functions
		include("includes/_userinterface/userinterface.list.php");									// List of all Navigation functions
		include("includes/_generalsettings/generalsettings.list.php");								// List of all Navigation functions
		
		
		if (!isset($_POST["mapscale"])) {
				// No value present, make equal to 1
				$raw_mapscale = 100;
			} else {
				$raw_mapscale = $_POST['mapscale'];
			}

		//echo "Map Scale is :".$raw_mapscale." <br>";
		
		$new_mapscale = ($raw_mapscale / 100);
		// How big is the origional map?
		$raw_map_l = $maparray[0][0];
		$raw_map_x = $maparray[0][1];
		$raw_map_y = $maparray[0][2];
		
		$new_map_l = $raw_map_l;
		$new_map_x = round(( $raw_map_x * $new_mapscale),2);
		$new_map_y = round(( $raw_map_y * $new_mapscale),2);
		
		//echo "Map Scale is :".$new_mapscale." <br>";
		
		?>
		</HEAD>
	<BODY bgcolor="#000000" leftmargin="0px" topmargin="0px" marginwidth="0px" marginheight="0px" style="margin: 0px; margin-bottom:0px; margin-top:0px;"> 
		<div NAME="IslandMap" ID="IslandMap" style="position:absolute; left:0px; top:0px; z-index: 0;">
			<div id="myCanvas_airportmap" name="myCanvas_airportmap" style="position:absolute;z-index:100;"></div>
			<img src="images/Part_139_327/<?php echo $new_map_l;?>" width="<?php echo $new_map_x;?>" height="<?php echo $new_map_y;?>" onclick="alertCoords(event)" style="cursor:crosshair;" />
			
			</div>
	
<div Name="div_mapinfo" id="div_mapinfo" style="position:fixed;top:140px;left:10px;width:155px;height:200px;z-index:100;display:none;">
	<table width="100%" cellpadding="0" cellspacing="0" style="margin:0px;border:2px solid;padding:0px;border-style: solid;border-color: #000000;border-collapse: collapse;" />
		<tr>
			<td name="MapLayers" id="MapLayers" 
				class="maptoolsfields_on" 
				colspan="3" />
				Element Information
				</td>
			</tr>
		<tr>
			<td class="item_name_inactive">ID</td>
			<td name="ElementInfo_Id" id="ElementInfo_Id" 
				class="item_name_inactive" 
				colspan="2" />
				&nbsp;
				</td>
			</tr>			
		<tr>
			<td class="item_name_inactive">Name</td>
			<td name="ElementInfo_Name" id="ElementInfo_Name" 
				class="item_name_inactive" 
				colspan="2" />
				&nbsp;
				</td>
			</tr>
		<tr>
			<td class="item_name_inactive">Location</td>
			<td name="ElementInfo_LocX" id="ElementInfo_LocX" 
				class="item_name_inactive" />
				&nbsp;
				</td>
			<td name="ElementInfo_LocY" id="ElementInfo_LocY" 
				class="item_name_inactive" />
				&nbsp;
				</td>				
			</tr>	
		<tr>
			<td class="item_name_inactive" 
				colspan="3" align="right" />
				<form style="margin: 0px; margin-bottom:0px; margin-top:-1px;" name="getmoreelementinfo" id="getmoreelementinfo" method="POST" action="_iframe_getairportmap_elementinfo.php" target="_iframe-moreelementinfo"/>
				<input type="hidden" name="menuitemid" value="<?php echo $tmpmenuitemidl1;?>">
				<input type="hidden" name="elementrecordsource" id="elementrecordsource" value="???" />
				<input type="hidden" name="elementrecordidfield" id="elementrecordidfield" value="???" />
				<input type="hidden" name="elementrecordid" id="elementrecordid" value="???" />
				<input type="submit" 
						name="MoreInformationaboutelement" 
						value="More Info" 
						onClick="elementinfo_win=dhtmlwindow.open('moreelementinfo', 'iframe', '', 'Element Information', 'top=140px,left=10px,width=300px,height=310px,resize=1,scrolling=1,center=0', 'recal');javascript:document.forms['getmoreelementinfo'].submit();"
						/>
				<input type="button" 
						name="HideMapTools" id="HideMapTools"
						value="Close" 
						onClick="toggle('div_mapinfo');"
						/>						
				</form>
				</td>
			</tr>			
		</table>
	</div>
	
<form NAME="MapControlForm2" ID="MapControlForm2" method="post" action="_iframe_getairportmap.php" />	
<div Name="div_mapscale" id="div_mapscale" style="position:fixed;top:75px;left:1100px;width:150px;height:300px;z-index:101;">
	<table width="100%" cellpadding="0" cellspacing="0" style="margin:0px;border:2px solid;padding:0px;border-style: solid;border-color: #000000;border-collapse: collapse;" />
		<tr>
			<td name="MapLayers" id="MapLayers" 
				class="maptoolsfields_on" 
				colspan="2" />
				Map Controls
				</td>
			</tr>
		<tr>
			<td colspan="2" class="item_name_inactive">Map Cords</td>
			</tr>
		<tr>
			<td name="MouseXRow" id="MouseXRow" 
				class="maptoolsfields_off" 
				onmouseover="MouseXRowField.className='maptoolsfields_on';MouseXRow.className='item_name_active';" 
				onmouseout="MouseXRowField.className='maptoolsfields_off';MouseXRow.className='item_name_inactive';" />
				&nbsp;X&nbsp;
				</td>
			<td name="MouseXRowField" id="MouseXRowField" 
				class="maptoolsfields_off" 
				onmouseover="MouseXRowField.className='maptoolsfields_on';MouseXRow.className='item_name_active';" 
				onmouseout="MouseXRowField.className='maptoolsfields_off';MouseXRow.className='item_name_inactive';" />
				<input type="text" ID="MouseX" NAME="MouseX" size="4">
				<input type="hidden" ID="mappoint_x" NAME="mappoint_x" size="4">
				</td>
			</tr>
		<tr>
			<td name="MouseYRow" id="MouseYRow" 
				class="maptoolsfields_off" 
				onmouseover="MouseYRowField.className='maptoolsfields_on';MouseYRow.className='item_name_active';" 
				onmouseout="MouseYRowField.className='maptoolsfields_off';MouseYRow.className='item_name_inactive';" />
				&nbsp;Y&nbsp;
				</td>
			<td name="MouseYRowField" id="MouseYRowField" 
				class="maptoolsfields_off" 
				onmouseover="MouseYRowField.className='maptoolsfields_on';MouseYRow.className='item_name_active';" 
				onmouseout="MouseYRowField.className='maptoolsfields_off';MouseYRow.className='item_name_inactive';" />
				<input type="text" ID="MouseY" NAME="MouseY" size="4">
				<input type="hidden" ID="mappoint_y" NAME="mappoint_y" size="4">
				</td>
				</form>
			</tr>		
		<tr>
			<td name="BeamtoIntro" id="BeamtoIntro" 
				class="maptoolsfields_off" 
				onmouseover="BeamtoIntro.className='maptoolsfields_on';BeamtoButton.className='maptoolsfields_on'" 
				onmouseout="BeamtoIntro.className='maptoolsfields_off';BeamtoButton.className='maptoolsfields_off'"
				onclick="whereaminow();" />
				&nbsp;
				</td>
			<td name="BeamtoButton" id="BeamtoButton" 
				class="maptoolsfields_off" 
				onmouseover="BeamtoIntro.className='maptoolsfields_on';BeamtoButton.className='maptoolsfields_on'" 
				onmouseout="BeamtoIntro.className='maptoolsfields_off';BeamtoButton.className='maptoolsfields_off'"
				onclick="whereaminow();" />
				Beam to!
				</td>
			</tr>
		<tr>
			<td colspan="2" class="item_name_inactive">Map Scale</td>
			</tr>
		<tr>
			<td name="MapScaleSlider" id="MapScaleSlider" 
				class="maptoolsfields_off" 
				onmouseover="className='maptoolsfields_on';" 
				onmouseout="className='maptoolsfields_off';"
				height="15" colspan="2" />
				&nbsp;<input type="range" value="<?php echo $raw_mapscale;?>" min="40" max="400" step="10" name="mapscale" id="mapscale" onchange="showValue(this.value)" />&nbsp;
				<input type="hidden" value="0" name="map_scale_txt" id="map_scale_txt" />
				</td>				
			</tr>
		<tr>
			<td class="maptoolsfields_off">&nbsp;</td>
			<td class="maptoolsfields_off">
				Scale <span id="mapscale_disp" width="75"><?php echo $raw_mapscale;?></span>
				</td>
			</tr>
		<tr>
			<td name="MapControlTools" id="MapControlTools" 
				class="item_name_inactive" 
				onmouseover="className='maptoolsfields_on';" 
				onmouseout="className='maptoolsfields_off';"
				onclick="toggle('div_mapinfo');"  
				colspan="2" />
				Map Tools
				</td>
			</tr>				
		</table>
	</div>	
	
<div Name="div_maplayer" id="div_maplayer" style="position:fixed;top:275px;left:1100px;width:150px;height:300px;z-index:101;">
	<table width="100%" cellpadding="0" cellspacing="0" style="margin:0px;border:2px solid;padding:0px;border-style: solid;border-color: #000000;border-collapse: collapse;" />
		<tr>
			<td name="MapLayers" id="MapLayers" 
				class="maptoolsfields_on" 
				colspan="2" />
				Map Layers
				</td>
			</tr>
			</table>
		</div>
	
<div Name="div_maplayer2" id="div_maplayer2" style="position:fixed;top:295px;left:1100px;width:150px;height:290px;z-index:101;overflow:auto;">
	<table width="100%" cellpadding="0" cellspacing="0" style="margin:0px;border:2px solid;padding:0px;border-style: solid;border-color: #000000;border-collapse: collapse;" />
			<?php 
			// Open Connection to Databse and Get List of Surfaces
			$layer1menuconn = mysqli_connect($GLOBALS['hostdomain'], $GLOBALS['hostusername'], $GLOBALS['passwordofdatabase'], $GLOBALS['nameofdatabase']);
				
			if (mysqli_connect_errno()) {
					// there was an error trying to connect to the mysql database
					printf("connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				else {
					// load sql syntax with search criteria
					$sql = 	"SELECT * FROM tbl_gis_surfaces WHERE gis_surfaces_hidden = 0 ORDER BY gis_surfaces_name";
					$layer1menures = mysqli_query($layer1menuconn, $sql);
					
					if ($layer1menures) {
							// Connection to the record set exisits, do work
							// put the number of rows found into a new variable
							$number_of_rows = mysqli_num_rows($layer1menures);
							// echo "There are ".$number_of_rows." rows in the first level";
							while ($layer1array = mysqli_fetch_array($layer1menures, MYSQLI_ASSOC)) {
									$tmpid		= $layer1array['gis_surfaces_id'];
									$tmpname	= $layer1array['gis_surfaces_name'];
									$tmplist	= $layer1array['gis_surface_list'];
									$tmpfilter	= $layer1array['gis_surface_filter'];
									
									$inputname	= 'zLayerID_'.$tmpid;
									
									switch($tmpid) {
											case 4:
												$filtername = '139339_f_name';
												$filterid	= '139339_f_id';
												$filter_h	= '139339_f_archived_yn';
												$field_id	= '139339_c_id';
												$field_name	= '139339_c_name';
												$field_fid	= '139339_c_facility_cb_int';
												$field_lat	= '139339_cc_location_x';
												$field_long	= '139339_cc_location_y';

												break;									
											case 5:
												$filtername = 'equipment_sub_type_name';
												$filterid	= 'equipment_sub_type_id';
												$filter_h	= 'equipment_sub_type_archived_yn';
												$field_id	= 'equipment_id';
												$field_name	= 'equipment_name';
												$field_fid	= 'equipment_type_cb_int';
												$field_lat	= 'equipment_lat';
												$field_long	= 'equipment_long';
												
												break;
											
										}
									
									
									// Check to see if this Layer is currently displayed?
									if (!isset($_POST[$inputname])) {
											// No value present, make equal to ''
											$isitchecked = '';
										} else {
											// Item was checked.... PROGRAM DISPLAY ITEM....
											//		PROGRAM IT HERE
											$isitchecked = 'CHECKED';
											
											switch($tmpid) {
													case 4:
														$field_loct = 'polyxy';
														$filter 	= 'all';
														include("_iframe_getairportmap_displayelement.php");	
														
														break;									
													case 5:
														$field_loct = 'pointgps';
														$filter 	= 'all';
														include("_iframe_getairportmap_displayelement.php");							// List of all Navigation functions
														
														break;
												}
										}
									?>
		<tr>
			<td name="Checkbox_<?php echo $tmpid;?>" id="Checkbox_<?php echo $tmpid;?>" 
				onmouseover="Checkbox_<?php echo $tmpid;?>.className='perp_systemactivity_box_active';SurfaceName_<?php echo $tmpid;?>.className='perp_systemactivity_box_active'" 
				onmouseout="Checkbox_<?php echo $tmpid;?>.className='maptoolsfields_on';SurfaceName_<?php echo $tmpid;?>.className='maptoolsfields_on'" 
				class="maptoolsfields_on" />
				<input name="<?php echo $inputname;?>" name="<?php echo $inputname;?>" type="checkbox" value="1" <?php echo $isitchecked;?> />
				</td>
			<td name="SurfaceName_<?php echo $tmpid;?>" id="SurfaceName_<?php echo $tmpid;?>" 
				onmouseover="Checkbox_<?php echo $tmpid;?>.className='perp_systemactivity_box_active';SurfaceName_<?php echo $tmpid;?>.className='perp_systemactivity_box_active'" 
				onmouseout="Checkbox_<?php echo $tmpid;?>.className='maptoolsfields_on';SurfaceName_<?php echo $tmpid;?>.className='maptoolsfields_on'" 
				class="maptoolsfields_on" />
				<?php echo $tmpname;?>
				</td>
			</tr>
									<?php
									// Now we want to display filter information
									//	Hard Code some things for simplicity
									
									$layer2menuconn = mysqli_connect($GLOBALS['hostdomain'], $GLOBALS['hostusername'], $GLOBALS['passwordofdatabase'], $GLOBALS['nameofdatabase']);
				
									if (mysqli_connect_errno()) {
											// there was an error trying to connect to the mysql database
											printf("connect failed: %s\n", mysqli_connect_error());
											exit();
										}
										else {
											// load sql syntax with search criteria
											$sql = 	"SELECT * FROM ".$tmpfilter." WHERE ".$filter_h." = 0 ORDER BY ".$filtername." ";
											//echo "New SQL :".$sql." <br>";
											
											$layer2menures = mysqli_query($layer2menuconn, $sql);
											
											if ($layer2menures) {
													// Connection to the record set exisits, do work
													// put the number of rows found into a new variable
													$number_of_rows = mysqli_num_rows($layer2menures);
													// echo "There are ".$number_of_rows." rows in the first level";
													while ($layer2array = mysqli_fetch_array($layer2menures, MYSQLI_ASSOC)) {
															$tmp_id 	= $layer2array[$filterid];
															$tmp_name 	= $layer2array[$filtername];
															
															$inputname2	= $tmpid.'_zLayerID_'.$tmp_id;
									
															// Check to see if this Layer is currently displayed?
															if (!isset($_POST[$inputname2])) {
																	// No value present, make equal to ''
																	$isitchecked2 = '';
																} else {
																	// Item was checked.... PROGRAM DISPLAY ITEM....
																	//		PROGRAM IT HERE
																	$isitchecked2 = 'CHECKED';
																	
																	switch($tmpid) {
																			case 4:
																				// Current list is for Equipment
																				$field_loct = 'polyxy';
																				$filter 	= $tmp_id; 
																				include("_iframe_getairportmap_displayelement.php");
																				
																				break;									
																			case 5:
																				// Current list is for Equipment
																				$field_loct = 'pointgps';
																				$filter 	= $tmp_id; 
																				include("_iframe_getairportmap_displayelement.php");	
																					
																				break;
																		}
																}
															
															?>
		<tr>
			<td name="ID<?php echo $tmpid;?>_Checkbox_<?php echo $tmp_id;?>" id="ID<?php echo $tmpid;?>_Checkbox_<?php echo $tmp_id;?>" 
				onmouseover="<?php echo $tmpid;?>_Checkbox_<?php echo $tmp_id;?>.className='perp_systemactivity_box_active';ID<?php echo $tmpid;?>_SurfaceName_<?php echo $tmp_id;?>.className='perp_systemactivity_box_active'" 
				onmouseout="<?php echo $tmpid;?>_Checkbox_<?php echo $tmp_id;?>.className='perp_systemactivity_box';ID<?php echo $tmpid;?>_SurfaceName_<?php echo $tmp_id;?>.className='perp_systemactivity_box'" 
				class="perp_systemactivity_box" />
				<input name="<?php echo $inputname2;?>" name="<?php echo $inputname2;?>" type="checkbox" value="1" <?php echo $isitchecked2;?> />
				</td>
			<td name="ID<?php echo $tmpid;?>_SurfaceName_<?php echo $tmp_id;?>" id="ID<?php echo $tmpid;?>_SurfaceName_<?php echo $tmp_id;?>" 
				onmouseover="ID<?php echo $tmpid;?>_Checkbox_<?php echo $tmp_id;?>.className='perp_systemactivity_box_active';ID<?php echo $tmpid;?>_SurfaceName_<?php echo $tmp_id;?>.className='perp_systemactivity_box_active'" 
				onmouseout="ID<?php echo $tmpid;?>_Checkbox_<?php echo $tmp_id;?>.className='perp_systemactivity_box';ID<?php echo $tmpid;?>_SurfaceName_<?php echo $tmp_id;?>.className='perp_systemactivity_box'" 
				class="perp_systemactivity_box" />
				<?php echo $tmp_name;?>
				</td>
			</tr>											<?php
															
														}
												}
										}
								$filtername = '';
								$filterid	= '';
								$filter_h	= '';
								$field_id	= '';
								$field_name	= '';
								$filed_fid	= '';
								$field_lat	= '';
								$field_long	= '';
								$tmpid		= '';
								$tmpname	= '';
								$tmplist	= '';
								$tmpfilter	= '';
								$inputname	= '';
								$inputname2 = '';
								$isitchecked = '';
								$isitchecked2 = '';
								}
						}
				}
				?>
		</table>
	</div>

<div Name="div_mapSubmit" id="div_mapSubmit" style="position:fixed;top:597px;left:1100px;width:150px;height:100px;z-index:101;">
	<table width="100%" cellpadding="0" cellspacing="0" style="margin:0px;border:2px solid;padding:0px;border-style: solid;border-color: #000000;border-collapse: collapse;" />
		<tr>
			<td name="MapLayers" id="MapLayers" 
				class="maptoolsfields_on" 
				colspan="2" />
				Refresh Map
				</td>
			</tr>
		<tr>
			<td colspan="2" class="item_name_inactive">
				<input type="submit" name="submitmaprefresh" id="submitmaprefresh" value="Refresh" /></td>
			</tr>
		</table>
	</div>
	
	</form>
	
		</BODY>
	</HTML>
<?
function inventoryvehiclescombobox($suppliedid, $archived, $nameofinput, $showcombobox, $default) {
	// $suppliedid		, is the number of the group to do the search for ;
	// $archived		, do you want to list all menu items, or just the archived ones;
	// $nameofinout		, what is the name of the select box that 'could' be ceated by this function;
	// $showcombobox	, Do you want to show the combo box select input style or just the text without the input box;
	// $default			, What is the default group to display in the combobox when it is displayed;

	// Examples
	
	//	$adataselect[$i]($objarray[$adatafieldid[$i]], "all", $adatafield[$i], "hide", "");
	// This example will only show one record, and it will not be in a combobox input box, but rather be displayed as text.
	
	
	$sql	= "";																				// Define the sql variable, just in case
	$nsql 	= "";																				// Define the nsql variable, just in case
	
	$sql = "SELECT * FROM tbl_inventory_sub_v INNER JOIN tbl_organization_main ON tbl_inventory_sub_v . vehicles_manufac_cb_int = tbl_organization_main . Organizations_id ";											// start the SQL Statement with the common syntax
	if ($suppliedid=="all") {																		// if supplied 'all' for the menu_id so the following
			// do not add any employee ID information to the SQL String
			$tmp_flagger = 0;																	// important to tell the procedures below this happened
		}
		else {
			$nsql = "WHERE `vehicles_id` = ".$suppliedid." ";										// if supplied a menu_id, then add it to the SQL Statement
			$sql = $sql.$nsql;																	// combine the nsql and sql strings
			$tmp_flagger = 1;																	// important to tell the procedures below this happened
		}

	if ($archived == "all") {																	// if supplied 'all' for the archived variable do the following
																								// Do not add any systemuser archived information to the SQL string
		}
		else {
			if ($archived=="yes") {																// If archived is 'yes' then
					if ($tmp_flagger==0) {
							$nsql = "WHERE vehicles_archived_yn = 1 ";
							$sql = $sql.$nsql;
							$tmp_flagger = 1;
						}
						else {
							$nsql = "AND vehicles_archived_yn = 1 ";
							$sql = $sql.$nsql;
						}
				}
				else {
					if ($tmp_flagger==0) {
							$nsql = "WHERE vehicles_archived_yn = 0 ";
							$sql = $sql.$nsql;
							$tmp_flagger = 1;
						}
						else {
							$nsql = "AND vehicles_archived_yn = 0 ";
							$sql = $sql.$nsql;
						}
				}
		}
	$nsql = "ORDER BY vehicles_modelyear, org_name ";
	$sql = $sql.$nsql;
	//echo $sql;
	
	$objconn_support = mysqli_connect("localhost", "webuser", "limitaces", "openairport");
	
	if (mysqli_connect_errno()) {
			printf("connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		else {
			$objrs_support = mysqli_query($objconn_support, $sql);
			if ($objrs_support) {
					$number_of_rows = mysqli_num_rows($objrs_support);
					//printf("result set has %d rows. \n", $number_of_rows);
					if ($showcombobox=="show") {
							?>
	<SELECT class="Commonfieldbox" name="<?=$nameofinput?>">
					<?
						}
					while ($objfields = mysqli_fetch_array($objrs_support, MYSQLI_ASSOC)) {
							$tmpsuppliedid 		= $objfields['vehicles_id'];
							$tmpsuppliedname 	= $objfields['vehicles_name'];
							$tmpsuppliedorgname = $objfields['org_name'];
							$tmpsuppliedyear 	= $objfields['vehicles_modelyear'];
							$tmpsuppliedarch	= $objfields['vehicles_archived_yn'];
							
						if ($showcombobox=="show") {
								?>
		<option 
								<?
							}
							if ($suppliedid = "all") {
									$intsuppliedid	= (double) $default;
									if ($tmpsuppliedid == $intsuppliedid) {
											if ($showcombobox=="show") {
													?>
				SELECTED
													<?
												}
										}
										else {
											// There is no user specified so we dont need to set a defualt value
										}
								}
								else {
								
								}
								if ($showcombobox=="show") {
										?>
				value="<?=$tmpsuppliedid;?>"><?=$tmpsuppliedyear;?>&nbsp;&nbsp;<?=$tmpsuppliedorgname;?>&nbsp;&nbsp;<?=$tmpsuppliedname;?></option>
										<?
									}
									else {
										?>
				<?=$tmpsuppliedyear;?>&nbsp;&nbsp;<?=$tmpsuppliedorgname;?>&nbsp;&nbsp;<?=$tmpsuppliedname;?>
										<?
									}
								}	// End of while loop
								mysqli_free_result($objrs_support);
								mysqli_close($objconn_support);
								if ($showcombobox=="show") {
										?>
		</SELECT>
										<?
									}
						}	// end of Res Record Object						
				}
	return $tmpsuppliedyear." ".$tmpsuppliedorgname." ".$tmpsuppliedname;
	}
	?>

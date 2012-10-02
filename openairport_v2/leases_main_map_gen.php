<?
//		  1		    2		  3		    4		  5		    6		  7		    7	      8		
//2345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
//==============================================================================================
//	
//	ooooo	oooo	ooooo	o	o		ooooo	ooooo	oooo	oooo	ooooo	oooo	ooooo
//	o   o	o	o	o		o	o		o	o	  o		o	o	o	o	o	o	o	o	  o
//	o	o	o	o	o		oo	o		o	o	  o		o	o	o	o	o	o	o	o	  o
//	o	o	oooo	oooo	o o	o		ooooo	  o		oooo	oooo	o	o	oooo	  o	
//	o	o	o		o		o  oo		o	o	  o		o  o	o		o	o	o  o	  o
//	o	o	o		o		o	o		o	o	  o		o	o	o		o	o	o	o     o
//	00000	0		ooooo	o	o		o	o	ooooo	o	o	o		ooooo	o	o     o
//
//	The premium quality open source software soultion for airport record keeping requirements
//
//	Designed, Coded, and Supported by Erick Dahl
//
//	Copywrite 2002 - Whatever the current year is
//
//	~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~
//	
//	Name of Document	:	Leases Main Map.php
//
//	Purpose of Page		:	This file will map out the selected lease type
//							
//							
//
//	Special Notes		:	Under normal conditions there should be no need to change this page
//							In the event you wish to change this page, everything should be
//							rather stright forward in what it does and how to change it.
//
//==============================================================================================
//2345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
//		  1		    2		  3		    4		  5		    6		  7		    7	      8		


	// Load include files
	
		include("includes/header.php");																// This include 'header.php' is the main include file which has the page layout, css, AND functions all defined.
		include("includes/POSTs.php");																// This include pulls information from the $_POST['']; variable array for use on this page
		//include("includes/NavFunctions.php");														// already included in header.php
		//include("includes/UserFunctions.php");													// already included in header.php
	
	// Load Get Statements
	
		$sub_type	= $_GET['subtype'];
		$objectid	= $_GET['objectid'];
	
		//echo "Selected Sub Type is :".$sub_type."<br>";	
		//echo "Selected Object ID is :".$objectid."<br>";
		
	// Load information about the selected type of lease to map
	
		// GET The subtype of this lease
	
				$sql = "SELECT * FROM tbl_general_tblrlshp WHERE tbl_gtr_t_id = ".$sub_type;
			
				$objconn_support = mysqli_connect("localhost", "webuser", "limitaces", "openairport");
			
				if (mysqli_connect_errno()) {
						printf("connect failed: %s\n", mysqli_connect_error());
						exit();
					}
					else {
						$objrs_support = mysqli_query($objconn_support, $sql);
						if ($objrs_support) {
								$number_of_rows = mysqli_num_rows($objrs_support);
								while ($objfields = mysqli_fetch_array($objrs_support, MYSQLI_ASSOC)) {
										$tmpsuppliedid 				= $objfields['tbl_gtr_t_id'];
										$tmpsuppliedname 			= $objfields['tbl_gtr_t_name'];
										$tmpsuppliedtablename 		= $objfields['tbl_gtr_t_tablename_txt'];
										$tmpsuppliedtablenamemx 	= $objfields['tbl_gtr_t_tablename_mx_txt'];
										$tmpsuppliedarch			= $objfields['tbl_gtr_t_archived_yn'];
									}
							}
					}
		
		//echo "Lease subtype ID :".$tmpsuppliedid."<br>";
		//echo "Lease subtype Name :".$tmpsuppliedname."<br>";
		//echo "Lease subtype Table Name :".$tmpsuppliedtablename."<br>";
		//echo "Lease subtype Archieved ? :".$tmpsuppliedarch."<br>";
		
		// Use the retrieved subtype of lease to get the actual lease information by pulling the objectid information
		
				$sql = "SELECT * FROM ".$tmpsuppliedtablename." WHERE ".$tmpsuppliedname."_id = ".$objectid;
				
				//echo "SQL Statement is :".$sql."<br>";
				
				$objconn_support = mysqli_connect("localhost", "webuser", "limitaces", "openairport");
			
				if (mysqli_connect_errno()) {
						printf("connect failed: %s\n", mysqli_connect_error());
						exit();
					}
					else {
						$objrs_support = mysqli_query($objconn_support, $sql);
						if ($objrs_support) {
								$number_of_rows = mysqli_num_rows($objrs_support);
								while ($objfields = mysqli_fetch_array($objrs_support, MYSQLI_ASSOC)) {
										$tmpobjectid			= $tmpsuppliedname."_id";
										$tmpobjectname			= $tmpsuppliedname."_name";
										$tmpobjectimage			= $tmpsuppliedname."_image_txt";
										
										$tmpobjectid			= strtolower($tmpobjectid);
										$tmpobjectname			= strtolower($tmpobjectname);
										$tmpobjectimage			= strtolower($tmpobjectimage);
										
										
		//echo "Lease Object ID :".$tmpobjectid."<br>";
				$tmp_suppliedid = $tmpobjectid;
		//echo "Lease Object Name :".$tmpobjectname."<br>";
		//echo "Lease Object Image Name :".$tmpobjectimage."<br>";
		
										$tmpobjectid			= $objfields[$tmpobjectid];
										$tmpobjectname 			= $objfields[$tmpobjectname];
										$tmpobjectimage			= $objfields[$tmpobjectimage];
									}
							}
					}
					
		//echo "Lease Object ID :".$tmpobjectid."<br>";
		//echo "Lease Object Name :".$tmpobjectname."<br>";
		//echo "Lease Object Image Name :".$tmpobjectimage."<br>";

		// Display Lease Background Image
		?>
<HTML>
	<TITLE>
		</TITLE>
	<BODY>
		<div style="position:absolute; z-index:0; left:0; top:0;">
			<img src="<?=$tmpobjectimage;?>">
			</div>
		<div style="position:absolute; z-index:1; left:10; top:10; width:40;">
			<input type="Button" name="printit" value="Print This Map" onclick="javascript:window.print();">
			</div>
		<?

		$sql = "SELECT * FROM tbl_leases_main
				INNER JOIN ".$tmpsuppliedtablenamemx." 	ON maintenance_sub_vp_id 	= leases_type_id 
				INNER JOIN ".$tmpsuppliedtablename." 	ON ".$tmp_suppliedid."		= maintenance_sub_vpv_cb_int 
				INNER JOIN tbl_general_tblrlshp 		ON tbl_gtr_t_id 			= leases_lease_type_cb_int 
				INNER JOIN tbl_organization_main 		ON Organizations_id 		= leases_lessee_cb_int 				
				WHERE ".$tmpsuppliedtablename.".".$tmp_suppliedid." = ".$objectid." AND leases_lease_type_cb_int = ".$sub_type." AND lease_archived_yn = 0";

		//echo "Project ID SQL: ".$sql."<br>";		
				
		$objconn_support = mysqli_connect("localhost", "webuser", "limitaces", "openairport");
		$counter = 3;
		
		if (mysqli_connect_errno()) {
				printf("connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			else {
				$objrs_support = mysqli_query($objconn_support, $sql);
				if ($objrs_support) {
						$number_of_rows = mysqli_num_rows($objrs_support);
						while ($objfields = mysqli_fetch_array($objrs_support, MYSQLI_ASSOC)) {		
								$counter = $counter + 1;
								// Load information from the tables
								$part_x			= $objfields['maintenance_sub_vp_image_x'];
								$part_y			= $objfields['maintenance_sub_vp_image_y'];
								$lessee_name	= $objfields['org_name'];
								$lessee_contact	= $objfields['org_phonenumber'];
								
								//echo "Part X: ".$part_x."<br>";
								//echo "Part Y: ".$part_y."<br>";
								//echo "Lessee Name: ".$lessee_name."<br>";
								//echo "Lessee Contact: ".$lessee_contact."<br>";
								?>
								<div style="position:absolute; z-index:2; left: <?=$part_x;?>px; top: <?=$part_y;?>px; width: 717;" align="left"><?=$lessee_name;?><br><?=$lessee_contact;?></div>
								<?
										
							}
					}
			}
			?>
		</BODY>
	</HTML>

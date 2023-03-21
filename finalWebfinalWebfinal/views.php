<?php if (!defined('ColorApp')) exit();

include 'model.php';

/*
********************************************************************************
This one is for the Filtered Page (the table of color results)
********************************************************************************

parameters - $colorSimple, $showColorName, $showColorHex, $showColorRGB, 
			$sortBy, $index, $resultsPerPage, $loginStatus
*/
function constructFilteredPage($colorSimple, $showColorName, $showColorHex, $showColorRGB, $sortBy, $index, $resultsPerPage, $loginStatus){
	
	// if logged in, the user can see all 800 colors
	if($loginStatus == true){
		$colors = get_all_colors_from_table();
	}
	// if not logged in, the user can only see 100 colors
	else{
		$colors = get_free_colors();
	}
	
	// add a title to the table appropriate to what color they want to see
	if ($colorSimple == '0'){
		$title = "All Colors";
	}
	elseif ($colorSimple == '1'){
		$title = "Red";
	}
	elseif ($colorSimple == '2'){
		$title = "Orange";
	}
	elseif ($colorSimple == '3'){
		$title = "Yellow";
	}
	elseif ($colorSimple == '4'){
		$title = "Green";
	}
	elseif ($colorSimple == '5'){
		$title = "Blue";
	}
	elseif ($colorSimple == '6'){
		$title = "Purple";
	}
	elseif ($colorSimple == '7'){
		$title = "Black";
	}
	
	// all colors
	if ($colorSimple == '0'){
		$data = $colors;
	}
	// specific color
	else{
		$data = get_color_using_basic_color($colors, $title);
	}
	
	// sort the color
	if ($sortBy == '1'){
		$result = sort_color_by_hex($data);	
	}
	// no sort
	else{
		$result = $data;
	}

	// begin filter page contruction
	$output = Array();
	$output[] = "<table class = 'tableFormat'>\n";
	
	$output[] = "<thead>\n";
	$output[] = "	<tr>\n";
	$output[] = "		<th class = 'colorscolorscolors' colspan='4'>COLORS COLORS COLORS!<br></th>\n";
	$output[] = "	</tr>\n";
	$output[] = "</thead>\n";
	
	$output[] = "<thead>\n";
	$output[] = "	<tr>\n";
	$output[] = "		<th colspan='4'>$title<br></th>\n";
	$output[] = "	</tr>\n";
	$output[] = "</thead>\n";
	
	$output[] = "<thead>\n";
	$output[] = "	<tr>\n";
	
	// check boxes to decide which columns to show
	if ($showColorName == true){
		$output[] = "		<th class = 'colorNameCol'>Color Name<br></th>\n";
	}
	if ($showColorHex == true){
		$output[] = "		<th class = 'colorHexCol'>HEX</th>\n";
	}
	if ($showColorRGB == true){
		$output[] = "		<th class = 'colorRGBCol'>RGB</th>\n";
	}
	
	// block with that row's color in it
	$output[] = "		<th class = 'colorBlockCol'>Color Block</th>\n";
	$output[] = "	</tr>\n";
	$output[] = "</thead>\n";
	$output[] = "<tbody>\n";
	
	
	
	// paging
	//---------------------------------------------------------------------------------------------
	$c = 0;
	if ($resultsPerPage == "All"){
		$limit = sizeof($result);
		// place holder for nextIndex and prevIndex variables to avoid errors
		$nextIndex = 0;
		$prevIndex = 0;
	}
	else{
		$limit = (int) $index + (int) $resultsPerPage;
		// index: 20    limit: 10		nextIndex = 20 + 10 = 30
		$nextIndex = (int) $index + (int) $resultsPerPage;  	
		// index: 20	limit: 10		prevIndex = 20 - 10 = 10
		$prevIndex = (int) $index - (int) $resultsPerPage;	
	}
	for ($c = 0; $c < sizeof($result); $c++){
		$hex = $result[$c][0];
		$name = $result[$c][1];
		$basic = $result[$c][2];
		$free = $result[$c][3];
		$red = $result[$c][4];
		$green = $result[$c][5];
		$blue = $result[$c][6];
		
		if ($c >= $index and $c < $limit){
			$output[] = "	<tr>\n";
			
			// add color name, hex, and or RGB if the user checked the boxes
			if ($showColorName == true){
				$output[] = "		<td>$name</td>\n";
			}
			if ($showColorHex == true){
				$output[] = "		<td>$hex</td>\n";
			}
			if ($showColorRGB == true){
				$output[] = "		<td>$red, $green, $blue</td>\n";
			}
			// change color of block for row
			$output[] = "		<td class = 'colorBlockBackground' style='--main-color: $hex;'></td>\n";
			
			$output[] = "	</tr>\n";
		}
	}
	//---------------------------------------------------------------------------------------------
	
	
	
	// only when you are paging and you are past the first page, add prev and top button
	if ($prevIndex >= 0 and $resultsPerPage != 'All'){
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'prevButton'>\n";
		$output[] = "			<form method='post' action='index.php'>\n";
		$output[] = "			<input type='hidden' name='colorSimple' value= $colorSimple>";
		$output[] = "			<input type='hidden' name='name' value=$showColorName>";
		$output[] = "			<input type='hidden' name='hex' value=$showColorHex>";
		$output[] = "			<input type='hidden' name='rgb' value=$showColorRGB>";
		$output[] = "			<input type='hidden' name='sortBy' value=$sortBy>";
		$output[] = "			<input type='hidden' name='limit' value=$resultsPerPage>";
		$output[] = "			<input type='hidden' name='index' value=$prevIndex>";
		$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='prev'/>\n";
		$output[] = "			</form>\n";
		$output[] = " 		</td>\n";
		
		$output[] = "		<td class = 'formNavigationButtons' colspan='2'>\n";
		$output[] = "			<form method='post' action='index.php'>\n";
		$output[] = "			<input type='hidden' name='colorSimple' value= $colorSimple>";
		$output[] = "			<input type='hidden' name='name' value=$showColorName>";
		$output[] = "			<input type='hidden' name='hex' value=$showColorHex>";
		$output[] = "			<input type='hidden' name='rgb' value=$showColorRGB>";
		$output[] = "			<input type='hidden' name='sortBy' value=$sortBy>";
		$output[] = "			<input type='hidden' name='limit' value=$resultsPerPage>";
		$output[] = "			<input type='hidden' name='index' value=0>";
		$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='top'/>\n";
		$output[] = "			</form>\n";
		$output[] = " 		</td>\n";
	}
	
	// only when you are paging and not on the last page, add a next button
	if ($nextIndex <= sizeof($result) and $resultsPerPage != 'All'){
		// next button is only button when first page
		if($prevIndex < 0){
			$output[] = "		<td class = 'nextButton' colspan = '4'>\n";
		}
		else{
			$output[] = "		<td class = 'nextButton'>\n";
		}
		$output[] = "			<form method='post' action='index.php'>\n";
		$output[] = "			<input type='hidden' name='colorSimple' value= $colorSimple>";
		$output[] = "			<input type='hidden' name='name' value=$showColorName>";
		$output[] = "			<input type='hidden' name='hex' value=$showColorHex>";
		$output[] = "			<input type='hidden' name='rgb' value=$showColorRGB>";
		$output[] = "			<input type='hidden' name='sortBy' value=$sortBy>";
		$output[] = "			<input type='hidden' name='limit' value=$resultsPerPage>";
		$output[] = "			<input type='hidden' name='index' value=$nextIndex>";
		$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='next'/>\n";
		$output[] = "			</form>\n";
		$output[] = " 		</td>\n";
		$output[] = "	</tr>\n";
	}
	// search again button on every page
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'formNavigationButtons' colspan='4'>\n";
	$output[] = "			<form method='post' action='index.php'>\n";
	$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='Search Again' />\n";
	$output[] = "			</form>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	
	$output[] = "</tbody>\n";
	$output[] = "</table>\n";
	
	// return the html table
	return $output;
}

/*
Build homepage which gives users three option
Option 1: Go to pick color page where they can filter out the color information 
Option 2: Go to color list page where it shows all the color blocks
Option 3: Go to reviews page to see what our happy customers have to say
*/
function buildHomePage(){
	$output = array();
	$output[] = "<table class = 'tableFormat'>\n";
	
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'titleRow' colspan='3'>\n";
	$output[] = "			<h1>Welcome to the home page!</h1>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// welcome page information
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<p>The purpose of our site is to create a system for 
							finding multiple shades of a desired color, with the 
							ability to sort the colors, as well as see their hex 
							code, rgb code, color name, or all three. Select 
							'Color List' to view all of the available colors, 
							sorted by their hex code. Select 'Color Pick' to 
							fill out a color form for specific color selections. 
							Login to your account to view all 800 colors! When 
							you are not logged in, you will only be able to view 
							and work with 100 of our colors. </p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// welcome page reviews info
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<p>Select 'Reviews' to see what our happy customers
								have to say!</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// color list button
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'homeButton'>\n";
	$output[] = "			<form method='post' action='index.php'>\n";
	$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='Color List' />\n";
	$output[] = "			</form>\n";
	$output[] = "		</td>\n";
	
	// color pick form button
	$output[] = "		<td class = 'homeButton'>\n";
	$output[] = "			<form method='post' action='index.php'>\n";
	$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='Color Pick' />\n";
	$output[] = "			</form>\n";
	$output[] = "		</td>\n";
	
	// reviews button
	$output[] = "		<td class = 'homeButton'>\n";
	$output[] = "			<form method='post' action='index.php'>\n";
	$output[] = "			<input class = 'buttonDesign' type='submit' name='submit' value='Reviews' />\n";
	$output[] = "			</form>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// close table and return
	$output[] = "</table>\n";
	return $output;
}

/*
********************************************************************************
This is the Filter Form Page
********************************************************************************

receives the user privilege and builds the color form page to pick colors

*/
function buildFormPage($privilege){
	
	$table = array();
	$table[] = "<table class='tableFormat'>\n";
	$table[] = "<form method='post' action='index.php'>\n";

	/*
	================================================================================
	Additional features for the Admin
	================================================================================
	*/
	if ($privilege == "admin"){
		
		// add, delete, update name, and update availability buttons
		// add color button to add color to database
		$table[] = "<tr>\n";
		$table[] = "	<td colspan='1' class='submit'>
		<input class = 'buttonDesign' type='submit' name='submit' value='Add Color'></td>\n";
		// delete color button to delete color from database
		$table[] = "	<td colspan='2' class='submit'>
		<input class = 'buttonDesign' type='submit' name='submit' value='Delete Color'></td>\n";
		$table[] = "</tr>\n";
		
		// update name to change the name of a color from database
		$table[] = "<tr>\n";
		$table[] = "	<td colspan='1' class='submit'>
		<input class = 'buttonDesign' type='submit' name='submit' value='Update Name'></td>\n";
		// update availability button to change if a color is free or only seen when logged in
		$table[] = "	<td colspan='2' class='submit'>
		<input class = 'buttonDesign' type='submit' name='submit' value='Update Availability'></td>\n";
		$table[] = "</tr>\n";	
		
	}
	
	// color options
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Color:</td>\n";
	$table[] = "	<td class = 'colorSelectData'> <select name='colorSimple'>
						<option value='0'>All</option>
						<option value='1'>Red</option>
						<option value='2'>Orange</option>
						<option value='3'>Yellow</option>
						<option value='4'>Green</option>
						<option value='5'>Blue</option>
						<option value='6'>Purple</option>
						<option value='7'>Black</option>
					</select></td>\n";
	$table[] = "</tr>\n";
	
	// display options 
	// ONLY DISPLAY WHAT IS CHECKED SO IF NOTHING IS CHECKED, DISPLAY NOTHING!
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Display:</td>\n";
	$table[] = "	<td>\n";
	$table[] = "		<label><input type = 'checkbox' name = 'name' value = 'name' checked> Color Name </label> \n";
	$table[] = "		<label><input type = 'checkbox' name = 'hex' value = 'hex'> HEX </label> \n";
	$table[] = "		<label><input type = 'checkbox' name = 'rgb' value = 'rgb'> RGB </label> \n";
	$table[] = " 	</td>\n";
	$table[] = "</tr>\n";

	// sort by options (either sort the colors, or do not sort the colors)
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Sort Colors?</td>\n";
	$table[] = "	<td>\n";
	$table[] = "		<input type='radio' name='sortBy' value='2' checked> No\n";
	$table[] = "		<input type='radio' name='sortBy' value='1'> Yes\n";	
	$table[] = "	</td>\n";
	$table[] = "</tr>\n";
	
	// colors per page option
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Colors per page:</td>\n";
	$table[] = "	<td class = 'colorsPerPageData'>\n";
	$table[] = "		<input type='radio' name='limit' value='All' checked> All\n";
	$table[] = "		<input type='radio' name='limit' value='5'> 5\n";
	$table[] = "		<input type='radio' name='limit' value='10'> 10\n";
	$table[] = "		<input type='radio' name='limit' value='15'> 15\n";
	$table[] = "		<input type='radio' name='limit' value='20'> 20\n";
	$table[] = "	</td>\n";
	$table[] = "</tr>\n";
	
	// index hidden
	$table[] = "<input type='hidden' name='index' value='0'/>\n";
	
	// search button
	$table[] = "<tr>\n";
	$table[] = "<td colspan='3' class='submit'>
	<input class = 'buttonDesign' type='submit' name='submit' value='Search'></td>\n";
	$table[] = "</tr>\n";
	
	// end form and table
	$table[] = "</form>\n";
	$table[] = "</table>\n";
	
	// return table
	$output = $table;
	return $output;
}

// update color name page
function buildUpdateNamePage($status){
	
	$table = array();
	$table[] = "<table class='tableFormat'>\n";
	$table[] = "<form method='post' action='index.php'>\n";
	
	/*
	====================================================================================
	UPDATE COLOR NAME
	====================================================================================
	*/
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Hex:</td>\n";
	$table[] = "	<td class = 'colorSelectData'>
						<input type='text' id='name' name='hex' required minlength='6' maxlength='6' size='10'>
					</td>\n";
	$table[] = "</tr>\n";
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Color Name:</td>\n";
	$table[] = "	<td class = 'colorsPerPageData'>\n";
	$table[] = "		<input type='text' id='name' name='name' required minlength='4' maxlength='20' size='10'>\n";
	$table[] = "	</td>\n";
	$table[] = "</tr>\n";
	
	// submit change button
	$table[] = "<tr>\n";
	$table[] = "<td colspan='3' class='submit'>
	<input class = 'buttonDesign' type='submit' name='submit' value='Update Color Name'></td>\n";
	$table[] = "</tr>\n";
	
	// show status of update
	if ($status == 'Success'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Update successful</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == 'Fail'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Update Failed</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == "Hex Does not Exists"){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Color does not exist</h2></td>\n";
		$table[] = "</tr>\n";
	}
	
	$table[] = "</form>\n";
	$table[] = "</table>\n";
	
	// return table
	$output = $table;
	return $output;
}

// update availability page
function buildUpdateAvailabilityPage($status){
	/*
	====================================================================================
	UPDATE COLOR AVAILABILITY
	====================================================================================
	*/
	$table = array();
	$table[] = "<table class='tableFormat'>\n";
	$table[] = "<form method='post' action='index.php'>\n";
	
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Hex:</td>\n";	
	$table[] = "	<td class = 'colorSelectData'>
						<input type='text' id='name' name='hex' required minlength='6' maxlength='6' size='10'>
					</td>\n";
	$table[] = "</tr>\n";
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Available</td>\n";
	$table[] = "	<td class = 'colorsPerPageData'>\n";
	$table[] = "		<input type='radio' name='free' value='True' checked> Free\n";
	$table[] = "		<input type='radio' name='free' value='False'> Require Login\n";
	$table[] = "	</td>\n";
	$table[] = "</tr>\n";
	
	// submit change button
	$table[] = "<tr>\n";
	$table[] = "<td colspan='3' class='submit'>
	<input class = 'buttonDesign' type='submit' name='submit' value='Update Color Availability'></td>\n";
	$table[] = "</tr>\n";
	
	// show admin status of change
	if ($status == 'Success'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Update successful</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == 'Fail'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Update Failed</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == "Hex Does not Exists"){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Color does not exist</h2></td>\n";
		$table[] = "</tr>\n";
	}
	
	$table[] = "</form>\n";
	$table[] = "</table>\n";
	
	// return table
	$output = $table;
	return $output;
}


/*
====================================================================================
ADD COLOR	
====================================================================================
*/
function buildAddColorPage($status){
	// $hex, $color_name, $basic_color, $free, $red, $green, $blue
	$table = array();
	$table[] = "<table class='tableFormat'>\n";
	$table[] = "<form method='post' action='index.php'>\n";
	
	// color hex
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Hex:</td>\n";	
	$table[] = "	<td class = 'colorSelectData'>
						<input type='text' id='name' name='hex' required minlength='6' maxlength='6' size='10'>
					</td>\n";
	$table[] = "</tr>\n";	
	
	// name of color
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Color Name:</td>\n";
	$table[] = "	<td>\n";
	$table[] = "		<input type='text' id='name' name='name' required minlength='4' maxlength='20' size='10'>\n";
	$table[] = "	</td>\n";
	$table[] = "</tr>\n";
	
	// what color familiy
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Color:</td>\n";	
	$table[] = "	<td> <select name='colorSimple'>
						<option value='Red'>Red</option>
						<option value='Orange'>Orange</option>
						<option value='Yellow'>Yellow</option>
						<option value='Green'>Green</option>
						<option value='Blue'>Blue</option>
						<option value='Purple'>Purple</option>
						<option value='Black'>Black</option>
					</select></td>\n";
	$table[] = "</tr>\n";
	
	// whether or not the user needs to be logged in to see the new color
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Available</td>\n";
	$table[] = "	<td>\n";
	$table[] = "		<input type='radio' name='free' value='True' checked> Free\n";
	$table[] = "		<input type='radio' name='free' value='False'> Require Login\n";
	$table[] = "	</td>\n";
	$table[] = "</tr>\n";
	
	// red num
	$table[] = "<tr>\n";
	$table[] = "<td class = 'leftCol'>Red</td>\n";
	$table[] = "<td> <input type='number' id='quantity' name='red' min='0' max='255' size ='10'></td>\n";
	$table[] = "</tr>\n";
	
	// green num
	$table[] = "<tr>\n";
	$table[] = "<td class = 'leftCol'>Green</td>\n";
	$table[] = "<td> <input type='number' id='quantity' name='green' min='1' max='255' size ='10'></td>\n";
	$table[] = "</tr>\n";
	
	// blue num
	$table[] = "<tr>\n";
	$table[] = "<td class = 'leftCol'>Blue</td>\n";
	$table[] = "<td class= 'colorsPerPageData'> <input type='number' id='quantity' name='blue' min='1' max='255' size ='10'></td>\n";
	$table[] = "</tr>\n";
	
	
	// submit new color button
	$table[] = "<tr>\n";
	$table[] = "<td colspan='3' class='submit'>
	<input class = 'buttonDesign' type='submit' name='submit' value='Add'></td>\n";
	$table[] = "</tr>\n";
	
	// show status of submision
	if ($status == 'Success'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Color Added</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == 'Fail'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Failed</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == "Hex Exists"){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Color is already in database</h2></td>\n";
		$table[] = "</tr>\n";
	}
	
	$table[] = "</form>\n";
	$table[] = "</table>\n";
	
	// return table
	$output = $table;
	return $output;
}

/*
====================================================================================
DELETE COLOR PAGE
====================================================================================
*/
function buildDeleteColorPage($status){
	
	$table = array();
	$table[] = "<table class='tableFormat'>\n";
	$table[] = "<form method='post' action='index.php'>\n";
	
	// hex code here to delete
	$table[] = "<tr>\n";
	$table[] = "	<td class = 'leftCol'>Hex:</td>\n";	
	$table[] = "	<td class = 'colorSelectData'>
						<input type='text' id='name' name='hex' required minlength='6' maxlength='6' size='10'>
					</td>\n";
	$table[] = "</tr>\n";
	
	// submit delete button
	$table[] = "<tr>\n";
	$table[] = "<td colspan='3' class='submit'>
	<input class = 'buttonDesign' type='submit' name='submit' value='Delete'></td>\n";
	$table[] = "</tr>\n";
	
	// show delete status to admin
	if ($status == 'Success'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Delete successful</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == 'Fail'){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Delete Failed</h2></td>\n";
		$table[] = "</tr>\n";
	}
	elseif ($status == "No Color"){
		$table[] = "<tr>\n";
		$table[] = "<td class = 'adminUpdate' colspan='3'> <h2>Color does not exist</h2></td>\n";
		$table[] = "</tr>\n";
	}
	
	$table[] = "</form>\n";
	$table[] = "</table>\n";
	
	// return table
	$output = $table;
	return $output;
}

/*
Build reviews page which shows user reviews
*/
function buildReviewPage(){
	$output = array();
	$output[] = "<table class = 'tableFormat'>\n";
	
	// title
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'titleRow' colspan='3'>\n";
	$output[] = "			<h1>Reviews!</h1>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Dr. Necaise review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'necaise.gif' alt = 'Dr. Necaise'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'This is the best project I have ever seen! These are my favorite students! </br>\n 
							Outstanding demonstration of color theory.' </br> </br>\n
							 - Dr. Necaise</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Stevie Wonder review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'stevieWonder.jpg' alt = 'Stevie Wonder'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'9da$ 0d! sdfkzljhe kzded a8ia f a;lak 4' </br> </br>\n
							 - Stevie Wonder</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Yoda review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'yoda.jpg' alt = 'Yoda'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'All of the shades of green, I love. Yes, hrrmmm.' </br> </br>\n
							 - Yoda</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Bob Lindgren review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'lindgren.jpg' alt = 'Bob Lindgren'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'My wife and I use this site every night. I am proud to be the President </br>\n 
							of the establishment in which these students attend.' </br> </br>\n
							 - Bob Lindgren</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// God review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'god.jpg' alt = 'God'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'My creations have become the creators. Well done, my sons.' </br> </br>\n
							 - God</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Joe Biden review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'biden.jpg' alt = 'Joe Biden'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'Where am I?' </br> </br>\n
							 - Joe Biden</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Aaron Marker review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'aaron.jpg' alt = 'Aaron Marker'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'Me loVe KoLorS! suCh prETtY and gReat comBinasions. AmayZiNg!' </br> </br>\n
							 - Aaron Marker</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Abe Lincoln review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'abe.jpg' alt = 'Abe Lincoln'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'This site is perfect, and we all know I never lie.' </br> </br>\n
							 - Abe Lincoln</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Ronald McDonald review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'mcdonald.jpg' alt = 'Ronald McDonald'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'These are some of the best shades of red and yellow that I have ever seen.' </br> </br>\n
							 - Ronald McDonald</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Minion review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'minion.jpg' alt = 'Minion'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'C’est banana! Hahaha! Miam Miam! Huh?' </br> </br>\n
							 - Minion</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// Groot review
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "		<img class = 'profilePic' src = 'groot.jpg' alt = 'Groot'>\n";	
	$output[] = "		</td>\n";
	$output[] = "		<td class = 'pageInfo'>\n";
	$output[] = "			<p>'I am groot!' </br> </br>\n
							 - Groot</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	$output[] = "</table>\n";
	
	return $output;
}

/*
Build login page
*/
function buildLoginPage(){
	$output = array();
	$output[] = "<table class = 'tableFormat'>\n";
	
	// title
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'titleRow' colspan='3'>\n";
	$output[] = "			<h1>Login</h1>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// email entry
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<form method='post' action='index.php'>\n";
	$output[] = "			<input type='text' name='email' placeholder='Enter email here'>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// password entry
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<input type='password' name='password' placeholder='Password'>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";

	// login button
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<button type='submit' class='buttonDesign' name='submit' value='loginWithAccount'>Login</button>\n";
	$output[] = "			</form>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	$output[] = "</table>\n";
	
	return $output;
}

/*
Build login page with retry email/password
something was wrong about log in, this is the try again page
*/
function buildLoginPageWrong($status){
	$output = array();
	$output[] = "<table class = 'tableFormat'>\n";
	
	// title
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'titleRow' colspan='3'>\n";
	$output[] = "			<h1>Login</h1>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// enter email
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<form method='post' action='index.php'>\n";
	$output[] = "			<input type='text' name='email' placeholder='Enter email here'>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// enter password
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<input type='password' name='password' placeholder='Password'>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";

	// login button
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<button type='submit' class='buttonDesign' name='submit' value='loginWithAccount'>Login</button>\n";
	$output[] = "			</form>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	// show what went wrong last time the user tried to login
	$output[] = "	<tr>\n";
	$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
	$output[] = "			<p>$status</p>\n";
	$output[] = "		</td>\n";
	$output[] = "	</tr>\n";
	
	$output[] = "</table>\n";
	
	return $output;
}

/*
Build confirmation page
confirm the user has logged in, is logged in, has logged out, or not logged in
to even be able to logout
*/
function buildConfirmationPage($confirm){
	$output = array();
	$output[] = "<table class = 'tableFormat'>\n";
	
	// if login, show login confirmation
	// this is after a successful login OR if they try to click log in when 
	// logged in
	if($confirm == "login"){
		// title
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'titleRow' colspan='3'>\n";
		$output[] = "			<h1>Welcome!</h1>\n";
		$output[] = "		</td>\n";
		$output[] = "	</tr>\n";
		
		// info
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
		$output[] = "			<p>You have logged in. Please enjoy.</p>\n";
		$output[] = "		</td>\n";
		$output[] = "	</tr>\n";
	}
	
	// if logging out, show log out confirmation
	// this is after a successful logout
	elseif($confirm == "logout"){
		// title
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'titleRow' colspan='3'>\n";
		$output[] = "			<h1>Goodbye!</h1>\n";
		$output[] = "		</td>\n";
		$output[] = "	</tr>\n";
		
		// info
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
		$output[] = "			<p>You have logged out. Thank you!</p>\n";
		$output[] = "		</td>\n";
		$output[] = "	</tr>\n";	
	}
	
	// this page is when the user tries to log out but is not logged in
	else{
		// title
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'titleRow' colspan='3'>\n";
		$output[] = "			<h1>Silly user.</h1>\n";
		$output[] = "		</td>\n";
		$output[] = "	</tr>\n";
		
		// info
		$output[] = "	<tr>\n";
		$output[] = "		<td class = 'pageInfo' colspan='3'>\n";
		$output[] = "			<p>You are not logged in. You lost one Necaise token.</p>\n";
		$output[] = "		</td>\n";
		$output[] = "	</tr>\n";	
	}
	
	$output[] = "</table>\n";
	
	return $output;
}
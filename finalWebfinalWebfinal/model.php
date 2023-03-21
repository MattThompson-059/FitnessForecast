<?php if (!defined('ColorApp')) exit();

/*
=========================================================================================
GOAL OF THIS PROJECT
TO IMPROVE THE ARTISTIC STYLES OF THE NEXT GENERATION WEB DEVELOPMENT STUDENTS
=========================================================================================
*/

// update the availability of a color as admin
function update_color_availability($hex, $free){
	// confirm valid input
	if ($hex == ""){
		return array("Hex Empty");
	}
	if (strlen($hex) != 7){
		return array("Wrong Hex Length");
	}
	$data = get_all_hex();
	
	// confirm color exists
	if (!in_array($hex, $data)){
		return array("Hex Does not Exists");
	}
	
	$db = new SQLite3('database/database.db');
	$sql = 'UPDATE colors SET free="';
	$sql .= $free;
	$sql .= '" WHERE hex="';
	$sql .= $hex;
	$sql .= '";';
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
}

// admin update a color name
function update_color_name($hex, $name){
	// confirm valid input
	if ($hex == ""){
		return "Hex Empty";
	}
	if (strlen($hex) != 7){
		return "Wrong Hex Length";
	}
	$data = get_all_hex();
	
	// confirm color exists
	if (!in_array($hex, $data)){
		return array("Hex Does not Exists");
	}
	$db = new SQLite3('database/database.db');
	$sql = 'UPDATE colors SET name="';
	$sql .= $name;
	$sql .= '" WHERE hex = "';
	$sql .= $hex;
	$sql .= '";';
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
}

// admin add a color
function add_color($hex, $color_name, $basic_color, $free, $red, $green, $blue){
	// confirm valid input
	if ($hex == ""){
		return array("Hex Empty");
	}
	if (strlen($hex) != 7){
		return array("Wrong Hex Length");
	}
	$data = get_all_hex();
	
	// confirm if color exists
	if (in_array($hex, $data)){
		return array("Hex Exists");
	}
	if ($color_name == ""){
		return array("Name Empty");
	}
	if ($basic_color == ""){
		return array("Basic Color Empty");
	}
	if ($free == ""){
		return array("Free Empty");
	}
	
	$db = new SQLite3('database/database.db');
	$sql = "INSERT INTO colors VALUES (";
	$sql .= "'";
 	$sql .= $hex;
 	$sql .= "', ";
 	
 	$sql .= "'";
 	$sql .= $color_name;
 	$sql .= "', ";
 	
 	$sql .= "'";
 	$sql .= $basic_color;
 	$sql .= "', ";
 	
 	$sql .= "'";
 	$sql .= $free;
 	$sql .= "', ";
 	
 	$sql .= "'";
 	$sql .= $red;
 	$sql .= "', ";
 	
 	$sql .= "'";
 	$sql .= $green;
 	$sql .= "', ";
 	
 	$sql .= "'";
 	$sql .= $blue;
 	$sql .= "'); ";
 	
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
}

// admin deletes a color
function delete_color($hex){
	// confirm valid input
	if ($hex == ""){
		return array("Hex Empty");
	}
	if (strlen($hex) != 7){
		return array("Wrong Hex Length");
	}
	$data = get_all_hex();
	
	$exist = false;
	if (in_array($hex, $data)){
		$exist = true;
	}
	
	if (!$exist){
		return array("No Color");
	}
	$db = new SQLite3('database/database.db');
	$sql = 'DELETE FROM colors where hex = "';
	$sql .= $hex;
	$sql .= '";';
	
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
	
}

// remove a color
function remove_color($hex){
	// validate input
	if ($hex == ""){
		return "Hex Empty";
	}
	if (strlen($hex) != 7){
		return "Wrong Hex Length";
	}
	
	$db = new SQLite3('database/database.db');
	$sql = 'DELETE FROM colors WHERE hex = "';
	$sql .= $hex;
	$sql .= '";';
	
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
}

// change basic color 
function change_basic_color($hex, $basic_color){
	if ($hex == ""){
		return array("Hex Empty");
	}
	if (strlen($hex) != 7){
		return array("Wrong Hex Length");
	}
	$db = new SQLite3('database/database.db');
	$sql = 'UPDATE colors SET basic_color="';
	$sql .= $basic_color;
	$sql .= '" WHERE hex = "';
	$sql .= $hex;
	$sql .= '";';
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
}

/*
=========================================================================================
GET FUNCTIONS FOR COLORS
=========================================================================================
*/

// get every single one of the 800 colors and put the information in an array
function get_all_colors_from_table(){
	$db = new SQLite3('database/database.db');
	$data = array();
	$results = $db->query('SELECT * FROM colors');
	while ($row = $results->fetchArray()) {
		$hex = trim($row[0], '"');
		$name = trim($row[1], '"');
		$basic_color = trim($row[2], '"');
		$free = trim($row[3], '"');
		$red = trim($row[4], '"');
		$green = trim($row[5], '"');
		$blue = trim($row[6], '"');
		$data[] = array($hex, $name, $basic_color, $free, $red, $green, $blue);
	}
	return $data;
}

// get a color using a hex code
function get_color_using_hex($hex){
	if ($hex == ""){
		return array("Hex Empty");
	}
	if (strlen($hex) != 7){
		return array("Wrong Hex Length");
	}
	$db = new SQLite3('database/database.db');
	$sql = 'SELECT * FROM colors WHERE hex = "';
	$sql .= $hex;
	$sql .= '";';
	$results = $db->query($sql);
	$data = array();
	while ($row = $results->fetchArray()) {
		$data[] = $row;
	}
	if (sizeof($data) > 0){
		return $data[0];
	}
	else{
		return array("Empty");
	}
}

// get the colors from the data base when searching for specifics (like only reds, for example)
function get_color_using_basic_color($data, $color){
	$result = array();
	for($c = 0; $c < sizeof($data); $c++){
		$line = $data[$c];
		if($color == $line[2]){
			$result[] = $line;
		}
	}
	
	return $result;
}

// get only the free colors and put the color information in an array
function get_free_colors(){
	$colors = get_all_colors_from_table();
	$result = array();
	for ($c = 0; $c < sizeof($colors); $c++){
		$curr = $colors[$c];
		if ($curr[3] == "True"){
			$result[] = $curr;
		}
	}
	return $result;
}

// get an array of all the hex codes
function get_all_hex(){
	$db = new SQLite3('database/database.db');
	$sql = 'SELECT hex FROM colors;';
	$results = $db->query($sql);
	$data = array();
	while ($row = $results->fetchArray()) {
		$data[] = $row[0];
	}
	return $data;
}

// sort the colors by their hex code
function sort_color_by_hex($data){
	$temp = array();
	foreach ($data as $key => $row){
		$temp[$key] = $row[0];
	}
	
	array_multisort($temp, SORT_ASC, $data);
	
	return $data;
}

/*
=========================================================================================
GET AND UPDATE FUNCTIONS FOR USERS
=========================================================================================
*/

// get information about a user using their email
function get_user_with_email($email){
	if ($email == ""){
		return array("Email Empty");
	}
	
	$users = get_all_users();
	$data = array();
	for ($u = 0; $u < sizeof($users); $u++){
		$curr = $users[$u];
		if ($curr[0] == $email){
			$data[] = $curr;
		}
	}
	if (sizeof($data) == 0){
		$status = array("No account");
		return $status;
	}
	else{
		return $data[0];
	}
}

// change a user's privilege
function update_user_privilege($email, $privilege){
	if ($email == ""){
		return array("Hex Empty");
	}
	
	$db = new SQLite3('database/database.db');
	$sql = 'UPDATE users SET privilege="';
	$sql .= $privilege;
	$sql .= '" WHERE email ="';
	$sql .= $email;
	$sql .= '";';
	$query = $db->exec($sql);
	if ($query) {
		#echo 'Number of rows modified: ', $db->changes();
		$status = array("Success");
	}
	else{
		$status = array("Fail");
	}
	return $status;
}

// This function only returns users' email and their privilege
function get_all_users(){
	$db = new SQLite3('database/database.db');
	$data = array();
	$results = $db->query('SELECT * FROM users');
	while ($row = $results->fetchArray()) {
		$email = trim($row[1], '"');
		$temp = trim($row[2], '"');
		$password = substr($temp, 2, strlen($temp)-1);
		$temp = trim($row[3], '"');
		$privilege = substr($temp, 2, strlen($temp)-1);
		$data[] = array($email, $password, $privilege);
	}
	return $data;
}

/*
=================================================================================================
THIS FUNCTION CHECKS IF THE LOGIN CREDENTIALS IS CORRECT OR NOT AND RETURN THE STATUS

RETURN VALUES (String)
- "Email Empty"		$email is empty
- "Empty Password"	$password is empty
- "No Account"		Account does not exist
- "Wrong password" 	Failed to log in because user name and password does not match
- "User"			Logged in and the account has user privilege
- "Admin"			Logged in and the account has admin privilege
=================================================================================================
*/
function check_if_login_is_correct($email, $password){
	if ($email == ""){
		return array("Email Empty");
	}
	if ($password == ""){
		return array("Empty Password");
	}
	$users = get_all_users();
	$data = array();
	for ($u = 0; $u < sizeof($users); $u++){
		$curr = $users[$u];
		if ($curr[0] == $email){
			$data[] = $curr;
		}
	}
	
	if (sizeof($data) == 0){
		$status = array("No Account");
		return $status;
	}
	else{
		$user = $data[0];
		if ($password == $user[1]){
			$status = array($user[2]);
		}
		else{
			$status = array("Wrong password");
		}
		return $status;
	}
}
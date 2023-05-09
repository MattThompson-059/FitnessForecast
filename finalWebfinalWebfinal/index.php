<?php

define("FitnessForecast", 1); // obsolete
include "views.php"; 
include "format.php";

// start the session and see if the user is logged in
session_start();
if(isset($_SESSION["username"])){ /// no email for login, use username /// NEW
	$loginStatus = true;
}
else{
	$loginStatus = false;
}

// Display errors
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

// Get user selection and put it in an easier to use variable 
// (only if submit button was pressed)
if(isset($_POST['submit'])) {
	$submit = $_POST['submit'];
	
	// Go to filtered list page (from "Filter" button (from home page) 
	// or "Search" button (from form page))
	if($submit == 'Color List') {
		get_data();
	}
	
	// Go to form page (from "Search Again" button or "Color Pick" button)
	elseif($submit == 'Normal form') /// Submission for normal form
	{
		if(isset($_SESSION["privilege"])){
			
			/// There are only users, no admins
			
			$fp = buildFormPage("status for form page: user");
		}
		buildPage($fp);
	}
	
	// Go back to home page
	elseif($submit == 'Cancel' or $submit == 'Home') {
		$hp = buildHomePage();
		buildPage($hp);     
	}
	/*
	// Go to review page (from "Reviews" button)
	elseif($submit == 'Reviews') {
		$rp = buildReviewPage();
		buildPage($rp);
	}
	*/
	// Go to login page (from "Login" button)
	elseif($submit == 'Login') {
		if (isset($_SESSION["username"])){
			$confirm = "login";
			$cp = buildConfirmationPage($confirm);
			buildPage($cp);
		}
		else{
			$loginp = buildLoginPage();
			buildPage($loginp);
		}
	}
	
	// Logout (from "Logout" button)
	elseif($submit == 'Logout') {
		
		// SESSION LOG OUT HERE!
		if (isset($_SESSION["username"])){
			unset($_SESSION["username"]);
			unset($_SESSION["privilege"]);
			session_destroy();
			
			// reset the login status
			$GLOBALS['loginStatus'] = false;
			$confirm = "logout";
			$cp = buildConfirmationPage($confirm);
			buildPage($cp);
		}
		
		// confirm page
		else {
			$confirm = "notLoggedIn";
			$cp = buildConfirmationPage($confirm);
			buildPage($cp);
		}
		
	}
	
	// Login page submit with username and password typed in
	elseif($submit == 'loginWithAccount'){
		
		$username = "";
		$password = "";
		if (isset($_POST['username'])){
			$username = $_POST['username'];
		}
		if (isset($_POST['password'])){
			$password = $_POST['password'];
		}

		// login status
		$status = check_if_login_is_correct($username, $password);	

		// check status and build page
		if ($status[0] == "Username Empty"){
			$loginp = buildLoginPageWrong("Please enter an username");
			buildPage($loginp);
		}
		elseif ($status[0] == "Empty Password"){
			$loginp = buildLoginPageWrong("Please enter a password");
			buildPage($loginp);
		}
		elseif ($status[0] == "No Account"){
			$loginp = buildLoginPageWrong("No account associated, try again");
			buildPage($loginp);
		}
		elseif ($status[0] == "Wrong password"){
			$loginp = buildLoginPageWrong("Incorrect password, try again");
			buildPage($loginp);
		}
		else{
			$_SESSION["username"] = $username;
			$_SESSION["privilege"] = $status[0];
			
			// change login status
			$GLOBALS['loginStatus'] = true;
			$confirm = "login";
			$cp = buildConfirmationPage($confirm);
			buildPage($cp);
			
			die;
		}
	}
	
	
	*/
	// Either next, prev, or top was clicked in filtered page
	else{
		get_data();
	}
}

// Default go to home page (puts you in welcome page)
// no value for submit button because no submit button has been pressed yet
elseif(isset($_POST['privilege']))
{
	$hpR = buildHomePageWithRoutine();
	buildPage($hpR);
}

else{
	$hp = buildHomePage();
	buildPage($hp);
}

// This function collects the data needed to build the filter page
// It then sends it to the view
function get_data(){
	
	
	
	
	
	/// For disabling specific exercises, send to page that generates routine, which will then ask for routine data from model
	if(isset($_POST['chest']))
	{
		$chestExclusion = $_POST['chest'];	
	}
	else
	{
		$chestExclusion = false;	
	}
	if(isset($_POST['back']))
	{
		$backExclusion = $_POST['back'];	
	}
	else
	{
		$backExclusion = false;	
	}
	if(isset($_POST['shoulder']))
	{
		$shoulderExclusion = $_POST['shoulder'];	
	}
	else
	{
		$shoulderExclusion = false;	
	}
	if(isset($_POST['legs']))
	{
		$legsExclusion = $_POST['legs'];	
	}
	else
	{
		$legsExclusion = false;	
	}
	if(isset($_POST['triceps']))
	{
		$tricepsExclusion = $_POST['triceps'];	
	}
	else
	{
		$tricepsExclusion = false;	
	}
	if(isset($_POST['biceps']))
	{
		$bicepsExclusion = $_POST['biceps'];	
	}
	else
	{
		$bicepsExclusion = false;	
	}
	if(isset($_POST['abs']))
	{
		$absExclusion = $_POST['abs'];	
	}
	else
	{
		$absExclusion = false;	
	}
	
	/// Add other form information, height, weight, age, etc...
	
	/*
	// Get simple color value
	// 0 = All
	// 1 = Red
	// 2 = Orange
	// 3 = Yellow
	// 4 = Green
	// 5 = Blue
	// 6 = Purple
	// 7 = Black
	if(isset($_POST['colorSimple'])) {
		$colorSimple = $_POST['colorSimple'];
	}
	// DEFAULT
	else{
		// defaul "All" has value zero
		$colorSimple = '0';
	}
	
	// Get display color name?
	if(isset($_POST['name'])) {
		$showColorName = $_POST['name'];
	}
	// DEFAULT
	else{
		// show nothing
		$showColorName = false;
	}
	
	// Get display color hex?
	if(isset($_POST['hex'])) {
		$showColorHex = $_POST['hex'];
	}
	// DEFAULT
	else{
		// show nothing
		$showColorHex = false;
	}
	
	// Get display color rgb?
	if(isset($_POST['rgb'])) {
		$showColorRGB = $_POST['rgb'];
	}
	// DEFAULT
	else{
		// show nothing
		$showColorRGB = false;
	}
	
	// Get sort by
	// value 1 is sorted
	// value 2 is not sorted
	if(isset($_POST['sortBy'])) {
		$sortBy = $_POST['sortBy'];
	} 
	// DEFAULT
	else{
		// sort no has value 2
		$sortBy = '2';
	}
	
	// Get number of results per page
	if(isset($_POST['limit'])) {
		$resultsPerPage = $_POST['limit'];
	}
	// DEFAULT
	else{
		$resultsPerPage = 'All';
	}
	
	// Get index
	if(isset($_POST['index'])) {
		$index = $_POST['index'];
	}
	// DEFAULT
	else{
		$index = '0';
	}
	*/
	// Send to the view! /// Call whatever the new page is
	$tp = constructFilteredPage($colorSimple, $showColorName, $showColorHex, $showColorRGB, $sortBy, $index, $resultsPerPage, $GLOBALS['loginStatus']);
	buildPage($tp);

}
<?php 

function buildHomePage() {
	$output[] = array();
	$output[] = "<table class = 'TableFormat'>\n";
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Welcome to Fitness Forecast!</h1>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	$output[] = "</table>\n";
	return $output;
}
	
function buildLoginPage() {
	$output[] = array();
	$output[] = "<form method = 'post' action = 'index.php'>\n";
	$output[] = "<table class = 'TableFormat'>\n";
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Enter Your Personal Info</h1>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Weight</h1>\n";
	$output[] = "<input type='text' name='weight'>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Height</h1>\n";
	$output[] = "<input type='text' name='height'>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Age</h1>\n";
	$output[] = "<input type='text' name='age'>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";

	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Experience</h1>\n";
	$output[] = "<select = 'exp'>\n";
	$output[] = "<option>Beginner</option>\n";
	$output[] = "<option>Intermediate</option>\n";
	$output[] = "<option>Expert</option>\n";
	$output[] = "</select>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Sex</h1>\n";
	$output[] = "<select = 'sex'>\n";
	$output[] = "<option>Female</option>\n";
	$output[] = "<option>Male</option>\n";
	$output[] = "</select>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";

	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<h1>Days Per Week</h1>\n";
	$output[] = "<select = 'days'>\n";
	$output[] = "<option>3</option>\n";
	$output[] = "<option>4</option>\n";
	$output[] = "<option>5</option>\n";
	$output[] = "</select>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	
	$output[] = "<tr>\n";
	$output[] = "<td class = 'TableFormat'>\n";
	$output[] = "<input type='submit' name='Sumbit'>\n";
	$output[] = "</td>\n";
	$output[] = "</tr>\n";
	
	$output[] = "</table>";
	$output[] = "</form>";
	return $output;
}
	
	
		

	
	
	
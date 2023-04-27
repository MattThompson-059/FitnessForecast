<?php if (!defined('ColorApp')) exit();

// creates each page 
function buildPage($contents) {
	
  $page = array();
  $page[] = "<html>\n";
  $page[] = "	<head>\n";
  $page[] = implode(docHeader());
  $page[] = "	</head>\n";
  $page[] = "<body>\n";
  
   // build the page header.
  $page[] = "<table class='app'>\n";
  $page[] = "<tr class='appheader'><td>\n";
  $page[] = implode(pageHeader());
  $page[] = "</td></tr>\n";
  
   // add page gap
  $page[] = "<tr class='gap'><td>\n";
  $page[] = implode(pageGap());
  $page[] = "</td></tr>\n";
  
   // build the page body.
  $page[] = "<tr class='appbody'><td>\n";
  $page[] = implode($contents);
  $page[] = "</td></tr>\n";
   
   // build the page footer.  
  $page[] = "<tr class='appfooter'><td>\n";
  $page[] = implode(pageFooter());
  $page[] = "</td></tr>\n";
  
  $page[] = "</body>\n";
  $page[] = "</html>\n";
  
  print(implode($page));
}

 // build the page header
function buildHeader() {
	$header[] = array();
	$header[] = "<div>\n";
	$header[] = "<img class = 'logo' src = 'eagle.png' alt = 'image we stole off the internet'>\n";
	$header[] = "<form method='post' action='filter.php' class='pageheader'>\n";
	$header[] = "<input class = 'home' type = 'submit' name = 'submit' value = 'Home'>\n";
	$header[] = "<input class = 'about' type = 'submit' name = 'submit' value = 'About'>\n";
	$header[] = "<input class = 'exercizes' type = 'submit' name = 'submit' value = 'Exercizes'>\n";
	$header[] = "</form>\n";
	$header[] = "</div>\n";
	return $header;
}

function pageGap()
{
  $gap = array();
  $gap[] = " \n";
  return $gap;
}
	
function pageFooter()
{
  $footer = array();
  $footer[] = "<p>Last edited April 27th, 2023</p>\n";
  return $footer;
}

function docHeader()
{
  $header = array();
  $header[] = "<title>Color App</title>\n";
  $header[] = "<link rel='icon' href='eagle.png'>";
  $header[] = "<link rel='stylesheet' href='styleFinal.css'/>\n";
  
  return $header;
}
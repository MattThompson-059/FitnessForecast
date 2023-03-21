<?php if (!defined('ColorApp')) exit();

// creates each page 
function buildPage($contents) 
{
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

// builds header and returns to buildPage
function pageHeader()
{
  $header = array();
  $header[] = "			<div>\n";
  $header[] = "				<img class = 'logo' src = 'cat.png' alt = 'cat logo image'>\n";
  $header[] = "				<form method='post' action='index.php'>\n";
  $header[] = "					<input class = 'buttonHeaderHome' type='submit' name='submit' value='Home'>\n";
  $header[] = "					<input class = 'buttonHeaderLogin' type='submit' name='submit' value='Login'>\n";
  $header[] = "					<input class = 'buttonHeaderLogout' type='submit' name='submit' value='Logout'>\n";
  $header[] = "				</form>\n";
  $header[] = "			</div>\n";
  $header[] = "			<h1 class = 'header'>Come discover... pick a COLOR!</h1>\n";


  return $header;
}

// builds gap and returns to buildPage
function pageGap()
{
  $gap = array();
  $gap[] = " \n";
  return $gap;
}

// builds footer and returns to buildPage
function pageFooter()
{
  $footer = array();
  $footer[] = "			<p>Last edited December 12th, 2022</p>\n";
  return $footer;
}

// builds docHeader and returns to buildPage (for title and css link)
function docHeader()
{
  $header = array();
  $header[] = "<title>Color App</title>\n";
  $header[] = "<link rel='icon' href='cat.png'>";
  $header[] = "<link rel='stylesheet' href='styleFinal.css'/>\n";
  
  return $header;
}

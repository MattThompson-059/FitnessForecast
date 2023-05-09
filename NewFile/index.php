<?php
$output = array();
$output[] = "<html>\n";
$output[] = "<head><title>Form</title></head>\n";
$output[] = "<body>\n";
$output[] = "<form method='post' action='filter.php' class='info'>\n";
$output[] = "<p>\n";
$output[] = "Weight:\n";
$output[] = "<input type='text' name='weight'><br><br>\n";
$output[] = "Height:\n";
$output[] = "<input type='text' name='height'><br><br>\n";
$output[] = "Age:\n";
$output[] = "<input type='text' name='age'><br><br>\n";
$output[] = "Experience:\n";
$output[] = "<select name='experience'>\n";
$output[] = "<option>Beginner</option>\n"; 
$output[] = "<option>Intermediate</option>\n"; 
$output[] = "<option>Expert</option>\n"; 
$output[] = "</select><br><br>\n";
$output[] = "Sex:\n";
$output[] = "<select name='sex'>\n";
$output[] = "<option>Male</option>\n";
$output[] = "<option>Female</option>\n";
$output[] = "</select><br><br>\n";
$output[] = "Days Per Week:\n";
$output[] = "<select name='days'>\n";
$output[] = "<option>3</option>\n"; 
$output[] = "<option>4</option>\n"; 
$output[] = "<option>5</option>\n"; 
$output[] = "</select><br><br>\n";

$output[] = "</p>\n";
$output[] = "</form>";
$output[] = "</body>\n";
$output[] = "</html>\n";
print(implode($output));
?>
#!/usr/local/bin/php -q
<?php
$fd = fopen("php://stdin", "r");
$email_content = "";
while (!feof($fd)) {
$email_content .= fread($fd, 1024);
}
fclose($fd);


//split the string into array of strings, each of the string represents a single line, received
$lines = explode("\n", $email_content);

// initialize variable which will assigned later on
$from = "";
$subject = "";
$headers = "";
$message = "";
$is_header= true;

//loop through each line
for ($i=0; $i < count($lines); $i++) {
if ($is_header) {
// hear information. instead of main message body, all other information are here.
$headers .= $lines[$i]."\n";

// Split out the subject portion
if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
$subject = $matches[1];
}
//Split out the sender information portion
if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
$from = $matches[1];
}
} else {
// content/main message body information
$message .= $lines[$i]."\n";
}
if (trim($lines[$i])=="") {
// empty line, header section has ended
$is_header = false;
}
}
?>

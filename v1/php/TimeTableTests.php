<?php
/**
 * Created by PhpStorm.
 * User: luckie
 * Date: 12.01.17
 * Time: 18:03
 */

include "HTMLtoJSONparser.php";

//filter the input for authenticating and choosing the timetable
$week = filter_input(INPUT_GET, 'week', FILTER_VALIDATE_INT);
$class = filter_input(INPUT_GET, 'class', FILTER_VALIDATE_INT);
$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);


$fields = array(
    'username' => $username,
    'password' => $password
);

$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, 'http://hbbk-ilias.de/ilias.php?lang=de&cmd=post&cmdClass=ilstartupgui&cmdNode=99&baseClass=ilStartUpGUI&rtoken=');
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'userData/cookies/cookie-'.$username.'.txt');

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

$cr = curl_init('http://hbbk-ilias.de/data/HBSeLearn/lm_data/lm_62636/02/c/c00055.htm');
curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cr, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-'.$username.'.txt');
$timetable = curl_exec($cr);
curl_close($cr);

echo $timetable;

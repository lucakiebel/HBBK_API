<?php
/**
 * Created by PhpStorm.
 * User: luckie
 * Date: 12.01.17
 * Time: 18:03
 */

include "HBBK_API.class.php";

//filter the input for authenticating and choosing the timetable
$week = filter_input(INPUT_GET, 'week', FILTER_VALIDATE_INT);
$class = filter_input(INPUT_GET, 'class', FILTER_VALIDATE_INT);
$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);


$classes = [1 => "ADA", 2 => "AOP1A", 3 => "AOP1B", 4 => "AOP2A", 5 => "AOP2B", 6 => "AOP3A", 7 => "AOP3B", 8 => "AOP3-P", 9 => "BER", 10 => "BFE1A", 11 => "BFM1A", 12 => "BFS1A", 13 => "BFS1B", 14 => "BFS1C", 15 => "BFS2A", 16 => "BFS2B", 17 => "BFS2C", 18 => "CISCO", 19 => "CKB1-3A", 20 => "CKO4A", 21 => "CLB1-3A", 22 => "CLO4A", 23 => "CTA1A", 24 => "CTA2A", 25 => "CTA3A", 26 => "DIFF", 27 => "DIR", 28 => "EAT1A", 29 => "EAT2A", 30 => "EAT3A", 31 => "EAT4A", 32 => "E-FOR", 33 => "EGB1-3A", 34 => "EGB1-3B", 35 => "EGO4A", 36 => "EGO4B", 37 => "EMB1-3A", 38 => "EMO4A", 39 => "FOB1A", 40 => "FOS1A", 41 => "FOS1B", 42 => "FSC1A", 43 => "FSC2A", 44 => "FSC3A", 45 => "FSC4A", 46 => "FSE1A", 47 => "FSE2A", 48 => "FSE3A", 49 => "FSE4A", 50 => "FSM1A", 51 => "FSM2A", 52 => "FSM3A", 53 => "FSM4A", 54 => "GIA1A", 55 => "GIA2A", 56 => "GIA3A", 57 => "GIA4A", 58 => "GYM1A", 59 => "GYM1B", 60 => "GYM1C", 61 => "GYM2A", 62 => "GYM2B", 63 => "GYM2C", 64 => "GYM3A", 65 => "GYM3B", 66 => "GYM3C", 67 => "HKB1-3A", 68 => "HKB1-3B", 69 => "HKO4A", 70 => "HKO4B", 71 => "IDM1A", 72 => "IDM1B", 73 => "IDM2A", 74 => "IDM2B", 75 => "IDM3A", 76 => "IDM3B", 77 => "IDM4A", 78 => "IDM4B", 79 => "IEL1A", 80 => "IEL1B", 81 => "IEL2A", 82 => "IEL2B", 83 => "IEL3A", 84 => "IEL3B", 85 => "IEL4A", 86 => "IEL4B", 87 => "IFK1A", 88 => "IFK1B", 89 => "IFK1C", 90 => "IFK1D", 91 => "IKK", 92 => "ITA1A", 93 => "ITA2A", 94 => "ITA3A", 95 => "ITE1A", 96 => "ITE2A", 97 => "ITE3A", 98 => "ITF1A", 99 => "ITF1B", 100 => "ITF1C", 101 => "ITF2A", 102 => "ITF2B", 103 => "ITF2C", 104 => "ITF3A", 105 => "ITF3B", 106 => "ITF3C", 107 => "LAB1-3A", 108 => "LAO4A", 109 => "LRAT", 110 => "MBB1-3A", 111 => "MBO4A", 112 => "MED", 113 => "NAS", 114 => "NETZ-Team", 115 => "PFB1-2A", 116 => "STG", 117 => "SYS1A", 118 => "SYS2A", 119 => "SYS3A", 120 => "SYS4A", 121 => "THAG", 122 => "TPD1A", 123 => "TPD2A", 124 => "TPD3A", 125 => "TPD4A", 126 => "TSP1A", 127 => "TSP2A", 128 => "TSP3A", 129 => "TSP4A", 130 => "VEW", 131 => "VKK1A", 132 => "VKK1B", 133 => "VKK1C", 134 => "VKK2A", 135 => "VKK2B", 136 => "VKK2C", 137 => "VKK3A", 138 => "VKK3B", 139 => "VKK3C", 140 => "VKK3D"];

$fields = array(
    'username' => $username,
    'password' => $password
);

$fields_string = '';

if (isset($week, $class, $username, $password)){
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

}
else {
    $error_msg = '{
        "API_Version":"2016-01-14/1",
        "Error_Message":"Could not Authenticate with Ilias"
    }';
    echo $error_msg;
}

<?php
/**
 * Created by PhpStorm.
 * User: luckie
 * Date: 12.01.17
 * Time: 18:03
 */

//filter the input for authenticating and choosing the timetable
$week = filter_input(INPUT_GET, 'week', FILTER_SANITIZE_STRING);
$week = (string) $week;
$class = filter_input(INPUT_GET, 'class');
$class = (string) $class;
$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);

$classes = ["001" => "ADA", "002" => "AOP1A", "003" => "AOP1B", "004" => "AOP2A", "005" => "AOP2B", "006" => "AOP3A", "007" => "AOP3B", "008" => "AOP3-P", "009" => "BER", "010" => "BFE1A", "011" => "BFM1A", "012" => "BFS1A", "013" => "BFS1B", "014" => "BFS1C", "015" => "BFS2A", "016" => "BFS2B", "017" => "BFS2C", "018" => "CISCO", "019" => "CKB1-3A", "020" => "CKO4A", "021" => "CLB1-3A", "022" => "CLO4A", "023" => "CTA1A", "024" => "CTA2A", "025" => "CTA3A", "026" => "DIFF", "027" => "DIR", "028" => "EAT1A", "029" => "EAT2A", "030" => "EAT3A", "031" => "EAT4A", "032" => "E-FOR", "033" => "EGB1-3A", "034" => "EGB1-3B", "035" => "EGO4A", "036" => "EGO4B", "037" => "EMB1-3A", "038" => "EMO4A", "039" => "FOB1A", "040" => "FOS1A", "041" => "FOS1B", "042" => "FSC1A", "043" => "FSC2A", "044" => "FSC3A", "045" => "FSC4A", "046" => "FSE1A", "047" => "FSE2A", "048" => "FSE3A", "049" => "FSE4A", "050" => "FSM1A", "051" => "FSM2A", "052" => "FSM3A", "053" => "FSM4A", "054" => "GIA1A", "055" => "GIA2A", "056" => "GIA3A", "057" => "GIA4A", "058" => "GYM1A", "059" => "GYM1B", "060" => "GYM1C", "061" => "GYM2A", "062" => "GYM2B", "063" => "GYM2C", "064" => "GYM3A", "065" => "GYM3B", "066" => "GYM3C", "067" => "HKB1-3A", "068" => "HKB1-3B", "069" => "HKO4A", "070" => "HKO4B", "071" => "IDM1A", "072" => "IDM1B", "073" => "IDM2A", "074" => "IDM2B", "075" => "IDM3A", "076" => "IDM3B", "077" => "IDM4A", "078" => "IDM4B", "079" => "IEL1A", "080" => "IEL1B", "081" => "IEL2A", "082" => "IEL2B", "083" => "IEL3A", "084" => "IEL3B", "085" => "IEL4A", "086" => "IEL4B", "087" => "IFK1A", "088" => "IFK1B", "089" => "IFK1C", "090" => "IFK1D", "091" => "IKK", "092" => "ITA1A", "093" => "ITA2A", "094" => "ITA3A", "095" => "ITE1A", "096" => "ITE2A", "097" => "ITE3A", "098" => "ITF1A", "099" => "ITF1B", "100" => "ITF1C", "101" => "ITF2A", "102" => "ITF2B", "103" => "ITF2C", "104" => "ITF3A", "105" => "ITF3B", "106" => "ITF3C", "107" => "LAB1-3A", "108" => "LAO4A", "109" => "LRAT", "110" => "MBB1-3A", "111" => "MBO4A", "112" => "MED", "113" => "NAS", "114" => "NETZ-Team", "115" => "PFB1-2A", "116" => "STG", "117" => "SYS1A", "118" => "SYS2A", "119" => "SYS3A", "120" => "SYS4A", "121" => "THAG", "122" => "TPD1A", "123" => "TPD2A", "124" => "TPD3A", "125" => "TPD4A", "126" => "TSP1A", "127" => "TSP2A", "128" => "TSP3A", "129" => "TSP4A", "130" => "VEW", "131" => "VKK1A", "132" => "VKK1B", "133" => "VKK1C", "134" => "VKK2A", "135" => "VKK2B", "136" => "VKK2C", "137" => "VKK3A", "138" => "VKK3B", "139" => "VKK3C", "140" => "VKK3D"];

switch ($week){
    case "-1":
        $week = date("W")-1;
        break;
    case "0":
        $week = date("W");
        break;
    case "1":
        $week = date("W")+1;
        break;
    case "prev":
        $week = date("W")-1;
        break;
    case "this":
        $week = date("W");
        break;
    case "next":
        $week = date("W")+1;
        break;
    default:
        $week = date("W");
        break;
}



if (in_array($class, $classes)) {
    test($week, $class, $username, $password);
}
elseif (array_key_exists($class, $classes)){
    test($week, $class, $username, $password);
}
else{
    $error_msg = '{ "API":"2016-01-14/1", "msg":"Could not Authenticate with Ilias" }';
    echo $error_msg;
}

function test($week, $class, $username, $password){
    if (isset($week, $class, $username, $password)) {

        $fields = array(
            'username' => $username,
            'password' => $password
        );

        $fields_string = '';

        //url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'http://hbbk-ilias.de/ilias.php?lang=de&cmd=post&cmdClass=ilstartupgui&cmdNode=99&baseClass=ilStartUpGUI&rtoken=');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'userData/cookies/cookie-' . $username . '.txt');

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        $cr = curl_init('http://hbbk-ilias.de/data/HBSeLearn/lm_data/lm_62636/02/c/c00'.$class.'.htm');
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cr, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-' . $username . '.txt');
        $timetable = curl_exec($cr);
        curl_close($cr);

        echo $timetable;

    } else {
        $error_msg = '{ "API":"2016-01-14/1", "msg":"Could not Authenticate with Ilias" }';
        echo $error_msg;
    }
}



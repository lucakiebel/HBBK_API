<?php
/**
 * Created by PhpStorm.
 * User: luckie
 * Date: 12.01.17
 * Time: 17:13
 */

class HBBK_API
{
    public function __construct(String $user){
        global $username;
        $username = $user;
    }

    public static function authenticate(String $password){
        global $username;
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
        $result = curl_exec($ch);
        curl_close($ch);

        $cr = curl_init('http://hbbk-ilias.de/data/HBSeLearn/lm_data/lm_62636/default.htm');
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cr, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-'.$username.'.txt');
        $timetable = curl_exec($cr);
        curl_close($cr);

        $falseString = 'Authentication failed. Please <a href="login.php?target=&client_id=HBSeLearn&auth_stat=">click here</a> to continue.';

        return $timetable != $falseString;
    }

    public static function getTimetable(String $week, int $class){
        global $username;
        $url = 'http://hbbk-ilias.de/data/HBSeLearn/lm_data/lm_62636/02/c/c00055.htm';

        $cr = curl_init($url);
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cr, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-'.$username.'.txt');
        $timetable = curl_exec($cr);
        curl_close($cr);
    }
}

<?php
/**
 * File HBBK_API.class.php; Wrapper for hbbk-ilias.de as an API.
 *
 * License Note:
 *|-----------------------------------------------------------------------------|
 *| This is free and unencumbered software released into the public domain.     |
 *|                                                                             |
 *| Anyone is free to copy, modify, publish, use, compile, sell, or             |
 *| distribute this software, either in source code form or as a compiled       |
 *| binary, for any purpose, commercial or non-commercial, and by any           |
 *| means.                                                                      |
 *|                                                                             |
 *| In jurisdictions that recognize copyright laws, the author or authors       |
 *| of this software dedicate any and all copyright interest in the             |
 *| software to the public domain. We make this dedication for the benefit      |
 *| of the public at large and to the detriment of our heirs and                |
 *| successors. We intend this dedication to be an overt act of                 |
 *| relinquishment in perpetuity of all present and future rights to this       |
 *| software under copyright law.                                               |
 *|                                                                             |
 *| THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,             |
 *| EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF          |
 *| MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.      |
 *| IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR           |
 *| OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,       |
 *| ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR       |
 *| OTHER DEALINGS IN THE SOFTWARE.                                             |
 *|                                                                             |
 *| Copyright © 2016 Luca Kiebel, mail+gh@luca-kiebel.de                        |
 *| For more information, please contact me at https://luca-kiebel.de/contact/  |
 *|-----------------------------------------------------------------------------|
 *
 *
 * User: luckie
 * Date: 12.01.17
 * Time: 17:13
 */

include "HTML_Parser.class.php";

/**
 * Class HBBK_API; Wrapper for hbbk-ilias.de as an API.
 *
 * This Class Enables the User of this API to do certain things with hbbk-ilias.de in one call, and doesn't need multiple steps to get to the target file (e.g. a timetable).
 *
 * @param String $username The Username of the client which should be gotten through either POST or GET.
 */
class HBBK_API
{
    /**
     * HBBK_API constructor.
     *
     * Constructs the HBBK_API Object and enables the user to interact with the given functions.
     *
     * @param String $username The Username of the client which should be gotten through either POST or GET.
     */
    public function __construct(String $username){
        global $username;
        $this->$username = $username;
    }

    /**
     * HBBK_API authenticator.
     *
     * Makes a call to hbbk-ilias.de POSTing the client's password, which is the parameter, and the username, which was a parameter of the constructor, to authenticate the user in order to use the API.
     * Returns TRUE if the authentication was successful and FALSE if it wasn't, in that case the user should be told that he may have entered wrong initials.
     *
     * @param String $password The Users Password for Authenticating with hbbk-ilias.de.
     * @return bool
     */
    public static function authenticate(String $password){
        global $username;
        $fields = [
            'username' => $username,
            'password' => $password
        ];

        $fields_string = '';

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, 'http://hbbk-ilias.de/ilias.php?lang=de&cmd=post&cmdClass=ilstartupgui&cmdNode=99&baseClass=ilStartUpGUI&rtoken=');
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'userData/cookies/cookie-'.$username.'.txt');
        $result = curl_exec($ch);
        curl_close($ch);

        $ch = curl_init('http://hbbk-ilias.de/data/HBSeLearn/lm_data/lm_62636/default.htm');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-'.$username.'.txt');
        $timetable = curl_exec($ch);
        curl_close($ch);

        $falseString = 'Authentication failed. Please <a href="login.php?target=&client_id=HBSeLearn&auth_stat=">click here</a> to continue.';

        return $timetable != $falseString;
    }

    /**
     * HBBK_API getTimtable.
     *
     * Makes a call to hbbk-ilias.de taking week and class as parameter to get the current timetable of that week for that class.
     * Right now it only returns the HTML it got from the call, in future versions the API will be able to put out HTML/JSON with a parameter for the format of the return.
     *
     * @param String $week The desired week offset the timetable should be of.
     * @param String $class The desired class the timetable should be of.
     * @return mixed|void
     */
    public static function getTimetable(String $week, String $class){
        global $username;
        global $week, $class, $url;
        $week = self::getWeek($week);
        $class = self::getClassNum($class);


        $url = 'http://hbbk-ilias.de/data/HBSeLearn/lm_data/lm_62636/'.$week.'/c/c00'.$class.'.htm';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-'.$username.'.txt');
        $timetable = curl_exec($ch);
        curl_close($ch);

        $timetable = self::parseHTML($timetable);

        return $timetable;
    }

    /**
     * HBBK_API logout.
     *
     * Makes a call to hbbk-ilias.de and logs the user out, so the system can accept him accessing the timetable through the app, or through the traditional way.
     * This function then also deletes the cookie of the user because they are not needed anymore.
     * Return whether the logout was successful or not.
     *
     * @return bool
     */
    public static function logout(){
        global $username;
        $ch = curl_init('http://hbbk-ilias.de/logout.php?lang=de');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'userData/cookies/cookie-'.$username.'.txt');
        $logout = curl_exec($ch);
        curl_close($ch);

        unlink('userData/cookies/cookie-'.$username.'.txt');

        return isset($logout);
    }

    /**
     * HBBK_API getWeek.
     *
     * This function is used to get the current calender week from GET(week).
     * After that it returns the week with an added 0, if it was under 10 before.
     *
     * @param String $week The week to be adjusted to the current time.
     * @return false|string
     */
    private static function getWeek(String $week){
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
        return self::addLeadingZero($week, 2);
    }

    /**
     * HBBK_API getClassNum.
     *
     * This function checks the class given by the user against either one of the arrays and tries to find the matching UUID (001..140)
     * If the class couldn't be found it returns FALSE, otherwise it'll return the classes UUID as a String.
     *
     * @param $class String The class to be checked against both arrays.
     * @return false|string
     */
    private static function getClassNum(String $class){
        $class = strtoupper($class);

        $classes = ["001" => "ADA", "002" => "AOP1A", "003" => "AOP1B", "004" => "AOP2A", "005" => "AOP2B", "006" => "AOP3A", "007" => "AOP3B", "008" => "AOP3-P", "009" => "BER", "010" => "BFE1A", "011" => "BFM1A", "012" => "BFS1A", "013" => "BFS1B", "014" => "BFS1C", "015" => "BFS2A", "016" => "BFS2B", "017" => "BFS2C", "018" => "CISCO", "019" => "CKB1-3A", "020" => "CKO4A", "021" => "CLB1-3A", "022" => "CLO4A", "023" => "CTA1A", "024" => "CTA2A", "025" => "CTA3A", "026" => "DIFF", "027" => "DIR", "028" => "EAT1A", "029" => "EAT2A", "030" => "EAT3A", "031" => "EAT4A", "032" => "E-FOR", "033" => "EGB1-3A", "034" => "EGB1-3B", "035" => "EGO4A", "036" => "EGO4B", "037" => "EMB1-3A", "038" => "EMO4A", "039" => "FOB1A", "040" => "FOS1A", "041" => "FOS1B", "042" => "FSC1A", "043" => "FSC2A", "044" => "FSC3A", "045" => "FSC4A", "046" => "FSE1A", "047" => "FSE2A", "048" => "FSE3A", "049" => "FSE4A", "050" => "FSM1A", "051" => "FSM2A", "052" => "FSM3A", "053" => "FSM4A", "054" => "GIA1A", "055" => "GIA2A", "056" => "GIA3A", "057" => "GIA4A", "058" => "GYM1A", "059" => "GYM1B", "060" => "GYM1C", "061" => "GYM2A", "062" => "GYM2B", "063" => "GYM2C", "064" => "GYM3A", "065" => "GYM3B", "066" => "GYM3C", "067" => "HKB1-3A", "068" => "HKB1-3B", "069" => "HKO4A", "070" => "HKO4B", "071" => "IDM1A", "072" => "IDM1B", "073" => "IDM2A", "074" => "IDM2B", "075" => "IDM3A", "076" => "IDM3B", "077" => "IDM4A", "078" => "IDM4B", "079" => "IEL1A", "080" => "IEL1B", "081" => "IEL2A", "082" => "IEL2B", "083" => "IEL3A", "084" => "IEL3B", "085" => "IEL4A", "086" => "IEL4B", "087" => "IFK1A", "088" => "IFK1B", "089" => "IFK1C", "090" => "IFK1D", "091" => "IKK", "092" => "ITA1A", "093" => "ITA2A", "094" => "ITA3A", "095" => "ITE1A", "096" => "ITE2A", "097" => "ITE3A", "098" => "ITF1A", "099" => "ITF1B", "100" => "ITF1C", "101" => "ITF2A", "102" => "ITF2B", "103" => "ITF2C", "104" => "ITF3A", "105" => "ITF3B", "106" => "ITF3C", "107" => "LAB1-3A", "108" => "LAO4A", "109" => "LRAT", "110" => "MBB1-3A", "111" => "MBO4A", "112" => "MED", "113" => "NAS", "114" => "NETZ-Team", "115" => "PFB1-2A", "116" => "STG", "117" => "SYS1A", "118" => "SYS2A", "119" => "SYS3A", "120" => "SYS4A", "121" => "THAG", "122" => "TPD1A", "123" => "TPD2A", "124" => "TPD3A", "125" => "TPD4A", "126" => "TSP1A", "127" => "TSP2A", "128" => "TSP3A", "129" => "TSP4A", "130" => "VEW", "131" => "VKK1A", "132" => "VKK1B", "133" => "VKK1C", "134" => "VKK2A", "135" => "VKK2B", "136" => "VKK2C", "137" => "VKK3A", "138" => "VKK3B", "139" => "VKK3C", "140" => "VKK3D"];
        $classesTurned = ["ADA" => "001", "AOP1A" => "002", "AOP1B" => "003", "AOP2A" => "004", "AOP2B" => "005", "AOP3A" => "006", "AOP3B" => "007", "AOP3-P" => "008", "BER" => "009", "BFE1A" => "010", "BFM1A" => "011", "BFS1A" => "012", "BFS1B" => "013", "BFS1C" => "014", "BFS2A" => "015", "BFS2B" => "016", "BFS2C" => "017", "CISCO" => "018", "CKB1-3A" => "019", "CKO4A" => "020", "CLB1-3A" => "021", "CLO4A" => "022", "CTA1A" => "023", "CTA2A" => "024", "CTA3A" => "025", "DIFF" => "026", "DIR" => "027", "EAT1A" => "028", "EAT2A" => "029", "EAT3A" => "030", "EAT4A" => "031", "E-FOR" => "032", "EGB1-3A" => "033", "EGB1-3B" => "034", "EGO4A" => "035", "EGO4B" => "036", "EMB1-3A" => "037", "EMO4A" => "038", "FOB1A" => "039", "FOS1A" => "040", "FOS1B" => "041", "FSC1A" => "042", "FSC2A" => "043", "FSC3A" => "044", "FSC4A" => "045", "FSE1A" => "046", "FSE2A" => "047", "FSE3A" => "048", "FSE4A" => "049", "FSM1A" => "050", "FSM2A" => "051", "FSM3A" => "052", "FSM4A" => "053", "GIA1A" => "054", "GIA2A" => "055", "GIA3A" => "056", "GIA4A" => "057", "GYM1A" => "058", "GYM1B" => "059", "GYM1C" => "060", "GYM2A" => "061", "GYM2B" => "062", "GYM2C" => "063", "GYM3A" => "064", "GYM3B" => "065", "GYM3C" => "066", "HKB1-3A" => "067", "HKB1-3B" => "068", "HKO4A" => "069", "HKO4B" => "070", "IDM1A" => "071", "IDM1B" => "072", "IDM2A" => "073", "IDM2B" => "074", "IDM3A" => "075", "IDM3B" => "076", "IDM4A" => "077", "IDM4B" => "078", "IEL1A" => "079", "IEL1B" => "080", "IEL2A" => "081", "IEL2B" => "082", "IEL3A" => "083", "IEL3B" => "084", "IEL4A" => "085", "IEL4B" => "086", "IFK1A" => "087", "IFK1B" => "088", "IFK1C" => "089", "IFK1D" => "090", "IKK" => "091", "ITA1A" => "092", "ITA2A" => "093", "ITA3A" => "094", "ITE1A" => "095", "ITE2A" => "096", "ITE3A" => "097", "ITF1A" => "098", "ITF1B" => "099", "ITF1C" => "100", "ITF2A" => "101", "ITF2B" => "102", "ITF2C" => "103", "ITF3A" => "104", "ITF3B" => "105", "ITF3C" => "106", "LAB1-3A" => "107", "LAO4A" => "108", "LRAT" => "109", "MBB1-3A" => "110", "MBO4A" => "111", "MED" => "112", "NAS" => "113", "NETZ-Team" => "114", "PFB1-2A" => "115", "STG" => "116", "SYS1A" => "117", "SYS2A" => "118", "SYS3A" => "119", "SYS4A" => "120", "THAG" => "121", "TPD1A" => "122", "TPD2A" => "123", "TPD3A" => "124", "TPD4A" => "125", "TSP1A" => "126", "TSP2A" => "127", "TSP3A" => "128", "TSP4A" => "129", "VEW" => "130", "VKK1A" => "131", "VKK1B" => "132", "VKK1C" => "133", "VKK2A" => "134", "VKK2B" => "135", "VKK2C" => "136", "VKK3A" => "137", "VKK3B" => "138", "VKK3C" => "139", "VKK3D" => "140"];

        if (array_key_exists($class, $classesTurned)) {
            $class = $classesTurned[$class];
            return (string) $class;
        } elseif (array_key_exists($class, $classes)){
            return (string) $class;
        }return false;
    }

    /**
     * HBBK_API parseHTML.
     *
     * As of Version 2017-01-14/1 this function doesn't really do anything, though in future Versions it will be used to get the Timetable in a user desired format.
     *
     * @param $html String The HTML content to be parsed, in the future.
     * @return String
     */
    private static function parseHTML(String $html){
        //TODO: Parse $html and return a JSONified String of it
        $t = new HTML_Parser($html, "HTML");
        return (string) $t->parseIntoHTML();
    }

    /**
     * HBBK_API addLeadingZero.
     *
     * This function adds a zero to $int until the string has the length of $len.
     *
     * @param String $int The String that zeros should be added to.
     * @param int $len The length the String should have.
     * @return String
     */
    private static function addLeadingZero(String $int, int $len){
        while (strlen($int) < $len){
            $int = "0".$int;
        }
        return $int;
    }

    /**
     * HBBK_API debug.
     *
     * This function returns a JSON String consisting of all the variables the user should give via the parameters.
     *
     * @return string
     */
    public static function debug(){
        global $username, $week, $class, $url;
        $debug = '{ "API":"2017-01-14/1", "debug":"[{
        "username":"'.$username.'",
        "week":"'.$week.'",
        "class":"'.$class.'",
        "url":"'.$url.'"
        }]" }';
        return $debug;
    }
}

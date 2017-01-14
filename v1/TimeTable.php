<?php
/**
 * Created by PhpStorm.
 * User: luckie
 * Date: 14.01.17
 * Time: 17:21
 */

include "HBBK_API.class.php";

//filter the input for authenticating and choosing the timetable
$week = (string) filter_input(INPUT_GET, 'week');
$class = (string) filter_input(INPUT_GET, 'class');
$username = filter_input(INPUT_GET, 'username');
$password = filter_input(INPUT_GET, 'password');

if (isset($username, $class, $password, $week)){

    //create a new Instance of the API, set the Username
    $ilias = new HBBK_API($username);

    //authenticate the User with Ilias, if password is correct, proceed
    if ($ilias::authenticate($password)){
        $timetable = $ilias::getTimetable($week, $class);
        echo $timetable;
    }
    else echo "{ \"API\":\"2017-01-14/1\", \"msg\":\"Authentication failed.\" }";
}
else {
    echo "{ \"API\":\"2017-01-14/1\", \"msg\":\"All GET Parameters must be set, please review the documentation.\" }";
}
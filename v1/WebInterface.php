<?php
/**
 * File WebInterface.php the Interface implementing the API Wrapper Class for the Webinterface with login
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
 * User: luckie
 * Date: 25.01.17
 * Time: 20:09
 */

include "HBBK_API.class.php";

//filter the input for authenticating and choosing the timetable
$week = (string) filter_input(INPUT_POST, 'week');
$class = (string) filter_input(INPUT_POST, 'class');
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if (isset($username, $class, $password)){

    //create a new Instance of the API, set the Username
    $ilias = new HBBK_API($username);

    //authenticate the User with Ilias, if password is correct, proceed
    if ($ilias::authenticate($password)){
        $timetable = $ilias::getTimetable($week, $class);
        echo $timetable;
    }
    else echo "false";
}
else echo "false?!";
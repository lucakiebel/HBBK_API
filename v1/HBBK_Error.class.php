<?php

/**
 * File HBBK_Error.class.php; Class for echoing out errors
 * Usage:
 *      "echo new HBBK_Error($class, $msg)" or "return new HBBK_Error($class, $msg)"
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
 * Date: 21.01.17
 * Time: 14:01
 */
class HBBK_Error
{
    /**
     * HBBK_Error constructor.
     * @param String $class The Class of the Error for quick fixing
     * @param String $msg The Message that describes the Error
     */
    public function __construct(String $class, String $msg){
        global $array;
        $version = "2017-01-21/1.2";
        $array = ["API" => $version, "error" => ["class" => $class, "message" => $msg]];
    }

    /**
     * HBBK_Error toString Function.
     * @return string
     */
    public function __toString(){
        global $array;
        $array = json_encode($array);
        return $array;
    }
}
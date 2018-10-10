<?php
/**
 * File Autenticate.php
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
 * Date: 05.02.17
 * Time: 15:40
  4YwHJIK2ZlzHSGiZF1q
1YEje9oMhrgvuEemZm8E
8M6tDaYigYk5Cg4ktdPP
89wpkUgaPaXogD9rqB0g
UndVvF42sjjS1Za5YLk5
UXlk873m1D91rgrzlA3g
NDhmAaoVGdHNZ30lhddn
D6T4IxaPIBHErWbv5BQG
4rQd77N8thqGq9guB4XQ
3w5G9MTNmZie14pTru0c
scot1Blilrg9Btm5Qc7I
3gFTDB4F3hVR0JkRA4YD
GLb5vLxiTsWwfrsU0mPa
fiRI3cVgQ4XNS4NAUFTx
JUSqyNpcjkfzB4qmM6OQ
HpapUuoRvHmITTZAOfOZ
 
 */

include "HBBK_API.class.php";

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

$ilias = new HBBK_API($username);

echo $ilias::authenticate($password);

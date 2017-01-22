<?php

/**
 * File HTML_Parser.class.php;
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
 * Created by PhpStorm.
 * User: luckie
 * Date: 14.01.17
 * Time: 23:09
 */


/**
 * Class HTML_Parser
 */
class HTML_Parser
{
    /**
     * HTML_Parser constructor.
     *
     * @param String $HTML_to_be_parsed
     * @param String $Format_it_should_be_parsed_into
     */
    public function __construct(String $HTML_to_be_parsed, String $Format_it_should_be_parsed_into){
        global $html, $format, $xml;
        $html = $HTML_to_be_parsed;
        $format = $Format_it_should_be_parsed_into;
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    }

    /**
     * Parses the given HTML into $format
     * @return string
     */
    public function parse(){
        global $html, $xml;

        //$html = $xml."\n".$html;


        $xml = simplexml_load_string($html);

        $parsed = $html;
        return (string) $parsed;
    }

    /**
     * Takes out the <head> of the input document and puts it back on
     * @param int $Header_Length The length of the header
     * @return String
     * @internal param String $html
     */
    public function parseIntoHTML(int $Header_Length){
        global $html;
        $len = $Header_Length;
        $head = file_get_contents("head.html");
        $html = substr($html, $len);
        $html = $head.$html;
        return $html;
    }

}


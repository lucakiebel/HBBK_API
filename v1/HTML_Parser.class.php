<?php

/**
 * Created by PhpStorm.
 * User: luckie
 * Date: 14.01.17
 * Time: 23:09
 */
class HTML_Parser
{
    /**
     * HTML_Parser constructor.
     * @param String $html
     * @param String $format
     */
    public function __construct(String $html, String $format){
        global $html, $format, $xml;
        $this->$html = $html;
        $this->$format = $format;
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    }

    /**
     * @return string
     */
    public static function parse(){
        global $html, $xml;

        $html = $xml."\n".$html;

        $html = simplexml_load_string($html) or die("Error: Cannot create object");
        print_r($html);

        $parsed = $html;
        return (string) $parsed;
    }
}

$u = new HTML_Parser("<body><p>Hallo!</p></body>");
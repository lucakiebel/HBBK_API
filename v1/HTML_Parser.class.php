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


}


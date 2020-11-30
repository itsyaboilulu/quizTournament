<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class of useful widly used funcions
 *  - mainly stuff i cant remember the exact code for so package them in a memrable function
 */
class useful
{
    /**
     * retruns current timestamp in formate 'Y-m-d H:i:s' if $formate
     * id not set
     *
     * @param string $formate string date formate
     * @return timstamp
     */
    public static function currentTimeStamp($formate = 'Y-m-d H:i:s')
    {
        return date($formate);
    }


    /**
     * turns given array into a json response for ajax and
     * api functionality
     *
     * @param array $arr array of items to make into json
     * @return response->json()
     */
    public static function jsonResponse($arr)
    {
        return response()->json($arr);
    }


    /**
     * returns a randomised alphabetic string of length $lenth
     *
     * @param int $length length of returned string
     * @return string random alphabetic string
     */
    public static function randomAlphabeticString($length)
    {

        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $return = '';

        for ($i = 0; $i < $length; $i++) {
            $rand = $alphabet[mt_rand(0, strlen($alphabet) - 1)];
            $return .= $rand;
        }

        return $return;
    }


    /**
     * old questions use html special chars, so we procces them here
     *
     * @convert all legacy questions and retire proccess
     *
     * @param $str string to be converted
     * @return string converted string
     */
    public static function stringLegacyProccess($str)
    {
        $str = htmlspecialchars($str);
        $str = str_replace('&amp;quot;', '"', $str);
        $str = str_replace('&quot;', '"', $str);
        return $str;
    }
}

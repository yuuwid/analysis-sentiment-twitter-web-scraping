<?php

namespace Lawana\Utils;

class Tools
{

    public static function random_str($length = 10)
    {
        $pattern = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($x = $pattern, ceil($length / strlen($x)))), 1, $length);
    }


    public static function strContain($search, $str)
    {
        if (preg_match("/{$search}/i", $str)) {
            return true;
        }
    }
}

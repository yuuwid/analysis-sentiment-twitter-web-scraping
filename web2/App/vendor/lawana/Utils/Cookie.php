<?php

namespace Lawana\Utils;


class Cookie
{

    public static function all()
    {
        return $_COOKIE;
    }

    public static function get($name)
    {
        if (self::has($name)) {
            return $_COOKIE[$name];
        } else {
            return null;
        }
    }

    public static function has($name)
    {
        return isset($_COOKIE[$name]);
    }

    public static function make($name, $value, $expired = 60 * 60 * 24 * 7)
    {
        setcookie($name, $value, time() + $expired);
    }

    public static function drop($name)
    {
        if (self::has($name)) {
            setcookie($name, false, time() - 3600);
            unset($_COOKIE[$name]);
        }
    }
}

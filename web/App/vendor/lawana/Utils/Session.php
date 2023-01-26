<?php

namespace Lawana\Utils;


class Session
{

    public static function all()
    {
        return $_SESSION;
    }

    public static function get($name)
    {
        if (self::has($name)) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    public static function has($name)
    {
        return isset($_SESSION[$name]);
    }

    public static function make($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public static function renew($name, $newValue)
    {
        if (self::has($name)) {
            self::make($name, $newValue);
        }
    }

    public static function drop($name)
    {
        if (self::has($name)) {
            unset($_SESSION[$name]);
        }
    }
}

<?php

namespace Lawana\Utils;

class Request
{
    private static $request;

    public function __construct()
    {
        self::$request = $_REQUEST;


        foreach($_REQUEST as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function all()
    {
        return self::$request;
    }

    public static function get($name)
    {
        return self::$request[$name];
    }

}

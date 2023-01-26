<?php

namespace Core\Helpers;

use PDODB\PDOConnect;

class DB
{
    private static function connect()
    {
        return new PDOConnect();
    }

    public static function query($query)
    {
        $db = self::connect();
        return $db->query($query);
    }
}

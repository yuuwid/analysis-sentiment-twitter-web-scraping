<?php

namespace Lawana\Utils;


class Redirect
{
    private static function path()
    {
        return str_replace('Utils', '', __DIR__);
    }

    public static function error($code, $msg = '')
    {
        $error = $msg;
        require_once self::path() . 'Resource/redirect/notfound.php';
        die();
    }

    public static function to($location = null)
    {
        if ($location) {
            if (is_numeric($location)) {
                self::error($location);
            } else {
                $location = ltrim($location, '/');
                header('Location: ' . URL . '/' . $location);
                exit();
            }
        }
    }
}

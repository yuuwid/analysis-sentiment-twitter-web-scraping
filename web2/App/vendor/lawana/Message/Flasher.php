<?php

namespace Lawana\Message;

use Lawana\Utils\Session;

class Flasher extends Builder
{


    /**
     * @param string $color b = blue; r = red; y = yellow; g = green
     * @param string $icon i = info-fill; c = check-circle;  e = exclamation-triangle; n = none
     */
    public static function create($name, $msg = '', $color = 'b', $icon = 'i')
    {
        $flash = self::__compile__($msg, $color, $icon);
        Session::make($name, $flash);
    }


    public static function show($name)
    {
        $flash = Session::get($name);
        Session::drop($name);
        return $flash;
    }
}

<?php

namespace Core;

use Lawana\Routing\Web;

class App extends Web
{

    public static function check($url)
    {
        $urls = self::$urls;
        foreach ($urls as $name => $reg) {
            if ($reg['url'] == $url) {
                return false;
            }
        }
        return true;
    }

}

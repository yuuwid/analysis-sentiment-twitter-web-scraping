<?php

namespace Lawana\Message;

use Lawana\Message\Layout\Bootstrap;

class Builder
{

    protected static function __compile__($msg, $color, $icon)
    {
        if (strtolower(env('CSS_FRAMEWORK', 'bootstrap')) == 'bootstrap') {
            return Bootstrap::__compile__($msg, $color, $icon);
        }
    }

    
}

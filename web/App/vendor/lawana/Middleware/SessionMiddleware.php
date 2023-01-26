<?php

namespace Lawana\Middleware;

use Lawana\Message\Flasher;
use Lawana\Utils\Request;
use Lawana\Utils\Redirect;

class SessionMiddleware 
{
    private static $session = [
        'status' => false,
        'redirect' => null,
        'flasher' => null,
    ];

    protected function accept()
    {
        self::$session['status'] = true;

        return $this;
    }

    
    protected function back(string $redirect)
    {
        self::$session['status'] = false;

        return $this;
    }

    /**
     * Nama Flasher yang akan digunakan oleh class ini adalah:
     * midw-{nama_flasher} <br>
     * contoh: 
     * accept()->flasher('isAdmin');
     * maka untuk menampilkan flasher (feedback) middleware dapat
     * memanggil pada class Flasher dengan nama midw-isAdmin
     * Flasher::show('midw-isAdmin');
     * 
     * @param string $color b = blue; r = red; y = yellow; g = green
     * @param string $icon i = info-fill; c = check-circle;  e = exclamation-triangle; n = none
     * 
     */
    public function flasher(string $name, string $msg = '', string $color = 'b', string $icon = 'i')
    {
        $name = 'midw-' . $name;
        self::$session['flasher'] = $name;
        Flasher::create($name, $msg, $color, $icon);
    }

}
<?php

namespace Lawana\Environment\Local;

class TokenEnv
{

    /**
     * Fungsi untuk membuat sebuah Aplikasi Token
     * 
     * APP_TOKEN akan berisi random dari kumpulan karakter berikut:
     * "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
     * 
     * pattern diatas akan diambil sebanyak 50 karakter untuk digunakan.
     */
    protected static function _create_token_()
    {
        $pattern = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return substr(str_shuffle(str_repeat($x = $pattern, ceil(50 / strlen($x)))), 1, 50);
    }


}

<?php

namespace Lawana\Environment\Options;

/**
 * Cek baris pada file env.lawana yang merupakan Komentar
 * 
 * Komentar pada file env.lawana dapat berupa simbol
 * pagar (#) atau garis miring 2x (//)
 * 
 */
class Comment extends Option
{



    
    /**
     * Fungsi yang dipanggil oleh class lain untuk proses awal pengecekan.
     * @param string $input berisi baris variable file env.lawana
     */
    public static function is_comment($input)
    {
        $comment = self::check($input);

        return $comment;
    }





    /**
     * Cek baris input apakah sebuah komentar dengan mengecek 
     * karakter pertama (#)
     * atau mengecek 
     * karakter pertama dan kedua (//)
     * 
     */
    private static function check($comment)
    {
        if ((substr($comment, 0, 1) == '#') or (substr($comment, 0, 2) == "//")) {
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace Lawana\Environment\Options;

use Lawana\Utils\Tools;

/**
 * Class Tools yang digunakan oleh class Comment dan Some untuk mengecek
 * jenis input variable yang masuk.
 * 
 */

class Option
{


    

    /**
     * Mengecek panjang dari input yang masuk
     * jika input <= 2, maka kembalikan nilai true
     * 
     * nilai true menandakan input sebuah komentar atau blank line.
     * nilai false menandakan input sebuah variable Env yang valid.
     */
    protected static function length_input($input)
    {
        if (strlen($input) <= 2) {
            $results = true;
        } else {
            $results = false;
        }
        return $results;
    }





    /**
     * Cek simbol pemisah Sama dengan ( = ) menggunakan fungsi Utilitas strContain()
     * 
     */
    public static function check_separate($input)
    {

        return Tools::strContain("=", $input);
    }




    /**
     * Membersihkan spasi antara tanda pisah sama dengan ( = )
     * 
     */
    public static function clean_separate($input)
    {
        $input = str_replace(" = ", "=", $input);
        $input = str_replace("= ", "=", $input);
        $input = str_replace(" =", "=", $input);

        return self::clean_value($input);
    }





    /**
     * Membersihkan unsur Enter ( \n ) dalam sebuah input string
     * 
     */
    public static function clean_break($input)
    {
        if (Tools::strContain("\n", $input)) {
            $input = substr($input, 0, -1);
        }
        if ($input === false) {
            $input = "";
        }
        return $input;
    }





    /**
     * Membersihkan unsur simbol tanda petik dua ( " ) dalam value variable Env
     * baik didepan maupun dibelakang
     * 
     * APP_NAME="Lawana Framework"
     * 
     *     menjadi
     * 
     * APP_NAME=Lawana Framework
     * 
     * tujuannya adalah supaya tidak ada simbol petik dua lagi didalam value array $env.
     * 
     */
    private static function clean_value($input)
    {
        $explode = explode('=', $input);

        $explode[1] = self::clean_break($explode[1]);

        if (substr($explode[1], 0, 1) == '"') {
            $explode[1] = substr($explode[1], 1, -1);
        }

        if (substr($explode[1], -1) == '"') {
            $explode[1] = substr($explode[1], 0, -1);
        }

        return [$explode[0] => $explode[1]];
    }
}

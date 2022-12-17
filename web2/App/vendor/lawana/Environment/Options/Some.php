<?php

namespace Lawana\Environment\Options;

/**
 * Cek baris pada file env.lawana yang merupakan sebuah variable Valid 
 * bukan komentar maupun blank line.
 * 
 * variable valid berupa:
 *  {NAMA_VARIABLE} = "{VALUE}"
 * 
 */

class Some extends Option
{




    /**
     * fungsi yang dipanggil untuk memulai proses pengecekan variable Valid
     */
    public static function is_some($input)
    {
        /**
         * $result akan berisi nilai true dan false.
         *  fungsi length_input() akan mengecek panjang dari input baris yang masuk
         * 
         * nilai true menandakan panjang input <= 2; yang artinya merupakan sebuah komentar / blank line
         */
        $result = parent::length_input($input);

        return self::check($result);
    }



    
    /**
     * Hasil pada $result akan dibalik.
     * yang awalnya bernilai true menjadi false dan sebaliknya.
     * 
     * karena class ini adalah mengecek bahwa input bukan sebuah komentar dan blank line
     * dan nilai true pada $result menandakan sebuah komentar / blank line
     * maka harus dibalik nilanya supaya lebih masuk akal.
     */
    private static function check($result)
    {
        if ($result == true) {
            return false;
        } else {
            return true;
        }
    }
}

<?php

namespace Lawana\Environment\Local;

use Lawana\Environment\Local\TokenEnv,
    Lawana\Environment\Options\Option,
    Lawana\Environment\Local\TemporaryEnv,
    Lawana\Utils\Redirect;

    
/**
 * Read Env File "env.lawana" 
 * 
 */

class EnvReader extends TokenEnv
{





    /**
     * Store the values of Env without remove the blank line and comment variable
     *  
     */
    protected static function store_env($env)
    {
        TemporaryEnv::$oriEnv[] = $env;
    }





    /**
     * Save the values of Env variable exclude blank line and comment variable 
     *  
     */
    protected static function save_env($env)
    {
        TemporaryEnv::$Env[] = $env;
    }





    /**
     * Mendapatkan index dari variebel Env APP_TOKEN yang ada pada Temporary Variable
     * TemporaryEnv::$oriEnv dan TemporaryEnv::$Env
     * variable $oriEnv memiliki ukuran array yang lebih banyak daripada $Env
     * maka dari itu untuk mendapatkan kedua index dari variable itu maka dapat dilakukan 
     * pengulangan dan pengujian isset terhadap kedua variable.
     * Pengulangan dilakukan mengikuti size array dari $oriEnv
     * 
     * untuk mencegah lanjut looping ketika variable Env APP_TOKEN sudah ditemukan, maka
     * pengujian pertama mengecek pada variable $Env, karena variable ini memiliki size yang lebih sedikit
     * dari pada variable $oriEnv maka proses pencarian akan lebih cepat.
     * Setelah pada $Env sudah ditemukan selanjutnya dilakukan pengulangan dan pengujuan lagi pada  
     * variable $oriEnv, jikalau sudah ketemua maka hentikan looping
     * 
     * 
     * Proses indexing ini pasti akan mendapatkan hasil index dari kedua variable.
     * variable $Env dan $oriEnv memiliki hubungan linear, dan terurut dalam letak variable Env nya.
     */
    private static function indexing_token()
    {
        $index = [];
        for ($i = 0; $i < sizeof(TemporaryEnv::$oriEnv); $i++) {
            if (isset(TemporaryEnv::$Env[$i]['APP_TOKEN'])) {
                $index['Env'] = $i;
            }
            if (isset(TemporaryEnv::$oriEnv[$i]['APP_TOKEN'])) {
                $index['Ori'] = $i;
                break;
            }
        }
        return $index;
    }



    /**
     * fungsi _token_, ditandai dengan simbol "_" merupakan fungsi penting dalam App ini
     * dalam fungsi ini akan dilakukan pencarian indexing variable APP_TOKEN pada var Env.
     * kemudian cek isi dari APP_TOKEN nya, Framework ini yang baru saja didownload dan ingin 
     * dipakai pertama kali, tidak akan memiliki APP_TOKEN, maka dari itu harus dibuat secara 
     * otomatis oleh sistem Framework ini.
     * 
     * APP_TOKEN akan berisi sebuah random string sebanyak 50 karakter.
     * 
     * untuk mengindari invalid Token (Token kurang dari 50) maka harus dilakukan pengujian 
     * terhadap variable Env APP_TOKEN.
     * 
     * token yang di buat akan masuk kedalam variable $Env dan $oriEnv untuk diproses / dicompile 
     * menjadi variable konfigurasi Environment Aplikasi.
     */
    protected static function _token_()
    {
        $index = self::indexing_token();
        $indexOri = $index['Ori'];
        $indexEnv = $index['Env'];

        if (strlen(TemporaryEnv::$Env[$indexEnv]['APP_TOKEN']) < 50) {
            $token = self::_create_token_();
            TemporaryEnv::$Env[$indexEnv]['APP_TOKEN'] = $token;
            TemporaryEnv::$oriEnv[$indexOri]['APP_TOKEN'] = $token;
        }
    }





    /**
     * fungsi untuk menyimpan input variable Env yang bukan Komentar maupun blank line
     * 
     * karena variable Env yang valid harus memiliki tanda sama dengan maka harus dicek 
     * terlebih dahulu tanda pisah nya.
     * 
     * jika tidak ada tanda pisah sama dengan maka jadikan input tersebut menjadi variable Invalid
     * dan lakukan Redirect Error Env Konfigurasi.
     */
    protected static function validEnv($str)
    {
        if (Option::check_separate($str)) {
            $explode = Option::clean_separate($str);
            self::store_env($explode);
            self::save_env($explode);

        } else {
            self::invalidEnv($str);
            Redirect::error("Env Error", "Invalid Variable <b>{$str}</b>");
        }
        
    }





    /**
     * Simpan input variable Env yang invalid dengan indexing Key "Invalid"
     * 
     */
    protected static function invalidEnv($str)
    {
        self::cleanandstore($str, "Invalid");
    }





    /**
     * Simpan input variable Env yang merupakan sebuah komentar
     * dengan indexing Key Comment
     * 
     */
    protected static function commentEnv($str)
    {
        self::cleanandstore($str, "Comment");
    }





    /**
     * Simpan input variable Env yang merupakan sebuah blank line / baris kosong
     * dengan indexing Key None
     * 
     */
    protected static function blankLineEnv($str)
    {
        self::cleanandstore($str, "None");
    }





    /**
     * fungsi polymorfisme dari fungsi invalidEnv(), commentEnv(), blankLineEnv()
     * 
     */
    protected static function cleanandstore($str, $key)
    {
        $str = Option::clean_break($str);
        self::store_env([$key => $str]);
    }
}

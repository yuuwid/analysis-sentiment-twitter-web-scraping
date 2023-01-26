<?php

namespace Lawana\Environment\RFile;

use Lawana\Environment\Local\EnvReader,
    Lawana\Environment\Options\Comment,
    Lawana\Environment\Options\Some,
    Lawana\Environment\Options\Option,
    Lawana\Environment\Local\TemporaryEnv;

class FileReader extends EnvReader
{





    /**
     * Membuka file env.lawana dan lakukan proses Read line by line dari file tersebut
     * 
     */
    public static function read_env()
    {
        $input = fopen(PATH_APP . '/App/env.lawana', 'r');

        while (!feof($input)) {
            self::gets($input);
        }

        parent::_token_();
        self::_migrate_();
    }





    /**
     * Membaca dan mengecek setiap baris yang masuk apakah sebuah
     * Komentar, Blank Line atau sebuah Variable Env
     * dan melanjutkan ke fungsi berikutnya
     */
    private static function gets($input)
    {
        $str = fgets($input);

        if (Some::is_some($str)) {
            if (!Comment::is_comment($str)) {
                parent::validEnv($str);
            } else {
                parent::commentEnv($str);
            }
        } else {
            parent::blankLineEnv($str);
        }
    }





    /**
     * Memindahkan hasil read file env.lawana kedalam variable Aplikasi $env
     * untuk digunakan sebagai variable konfigurasi.
     * 
     */
    private static function _migrate_()
    {
        global $env;

        foreach (TemporaryEnv::$Env as $Env) {
            $keyEnv = array_keys($Env)[0];
            $valEnv = $Env[$keyEnv];
            
            $env[$keyEnv] = $valEnv;
        }
    }
}

<?php

namespace Lawana\Environment\Local;

/**
 * Menulis ulang / mengupdate file env.lawana
 * 
 */

class EnvWriter
{

 


    /**
     * Load semua Env variable yang tersimpan pada $oriEnv untuk menjadi
     * sebuah template file Env yang baru.
     * 
     */
    protected static function load($file)
    {
        $oriEnv = TemporaryEnv::$oriEnv;
        self::build($oriEnv, $file);
    }




    /**
     * Buat rangkaian variable env.lawana
     * 
     * {NAMA_VARIABLE} = "{VALUE}"
     * 
     */
    private static function build($oriEnv, $file)
    {
        $n = sizeof($oriEnv);
        for ($i = 0; $i < $n; $i++) {
            $str = self::check($oriEnv[$i]);
            if ($i+1 != $n) {
                $str .= "\n";
            }
            self::write($file, $str);
        }
    }





    /**
     * Karena didalam variable $oriEnv terdapat indexing key None, Comment, dan 
     * Nama_Variable_Env, maka pengecekan ini bertujuan untuk membangun ulang 
     * file env.lawana tanpa mengubah posisi maupun tampilan variable-variable env.lawana.
     * Seolah-oleh file env.lawana ini tidak di ubah oleh sistem.
     * 
     * --- contoh sederhana ---
     * APP_NAME = "Lawana Framework"
     * APP_URL = ""
     * APP_TOKEN = ""
     * # ini comment
     * APP_DEV = "project"
     * 
     * --- Setelah App berjalan ---
     * APP_NAME = "Lawana Framework"
     * APP_URL = "dlrZzF6Xphj5WfNT9wQIAOJexPbuaSL7CHiUkYDRVq10oK3nMc"
     * APP_TOKEN = ""
     * # ini comment
     * APP_DEV = "project" 
     * 
     */
    private static function check($var)
    {
        $key = array_keys($var)[0];
        if ($key == "None") {
            return "";
        } else if ($key == "Comment") {
            return $var[$key];
        } else if ($key == "Invalid") {
            return $var[$key];
        } else {
            $value = $var[$key];
            return "{$key} = \"{$value}\"";
        }
    }





    
    /**
     * Fungsi untuk menulis ke dalam file env.lawana
     */
    private static function write($file, $str)
    {
        fwrite($file, $str);
    }
}

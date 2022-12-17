<?php

namespace Lawana\Environment\WFile;

use Lawana\Environment\Local\EnvWriter,
    Lawana\Utils\Redirect;

class FileWriter extends EnvWriter
{





    /**
     * Fungsi untuk memulai proses menulis ulang file env.lawana
     * 
     */
    public static function write_env()
    {
        $fileEnv = fopen(PATH_APP . '/App/env.lawana', 'w') or Redirect::error("Missing Env File!");
        
        parent::load($fileEnv);
    }


}

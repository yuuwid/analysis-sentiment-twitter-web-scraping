<?php

namespace Lawana\Kernel;

use Lawana\Routing\Web,
    Lawana\Environment\RFile\FileReader,
    Lawana\Environment\WFile\FileWriter;

/**
 * Kernel Aplikasi yang digunakan untuk menjalankan proses membaca
 * file "env.lawana" serta menjalankan semua fungsi Aplikasi Framework Lawana
 * 
 */

class Kernel extends Web
{




    /**
     * Memulai proses membaca file "env.lawana" dan menulis ulang isi file "env.lawana"
     * 
     */
    public function start()
    {
        FileReader::read_env();
        FileWriter::write_env();

        $this->server();
    }





    /**
     * Memulai menjalankan server aplikasi.
     * 
     */
    private function server()
    {
        self::start_server();

        require_once PATH_APP . "App/web.php";

        self::serve();
    }
}

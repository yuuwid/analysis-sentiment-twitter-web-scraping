<?php

namespace Lawana\Environment\Local;

class TemporaryEnv
{



    /**
     * Tempat untuk menyimpan sementara variabel-variable env.lawana 
     * tanpa mengabaikan blank line dan variabel comment.
     */
    public static $oriEnv = [

    ];






    /**
     * Tempat untuk menyimpan sementara variabel-variable env.lawana yang valid 
     * sesuai dengan aturan NAMA_VAR = "VALUE"
     * 
     * Komentar dan baris kosong akan dihilangkan pada variabel $Env ini.
     * 
     * variable ini nantinya akan digunakan sebagai konfigurasi variabel Env 
     * yang akan dipakai untuk Setup Aplikasi ini.
     */
    public static $Env = [
        
    ];
    
}

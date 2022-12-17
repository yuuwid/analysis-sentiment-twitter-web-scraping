<?php

namespace Mongo;

use Exception;
use Lawana\Utils\Redirect;
use MongoDB;

class MongoConnect
{

    private $_db = null,
        $_host = null,
        $_collection = null,
        $_port = null,
        $_username = null,
        $_password = null,
        $_error = [];


    public function __construct($collection)
    {
        $this->_host = env('DB_HOST', "localhost");
        $this->_port = env('DB_PORT', "27017");
        $this->_username = env('DB_USER', '');
        $this->_password = env('DB_PASS', '');

        $this->connect($collection);
    }

    private function connect($collection)
    {
        $mongoUrl = env('MONGO_URL', null);
        if ($mongoUrl == null) {
            $user = "";
            // mongodb://host:port/
            // mongodb://username:password@host:port/
            if ($this->_username != "") {
                $user = $this->_username . ":" . $this->_password . "@";
            }
            $mongoUrl = "mongodb://" . $user . $this->_host . ":" . $this->_port . "/";
        }

        try {
            $_db = new MongoDB\Client($mongoUrl);
            $database = env("DB_NAME", "test");
            $this->_collection = $_db->$database->$collection;
        } catch (Exception $e) {
            Redirect::error("ERROR", "Mongo Connect: Failed to Connect in 
            <br>Uri : {$mongoUrl}
            <br>User: {$this->_username}
            <br>Host: {$this->_host}
            <br>Port: {$this->_port}
            ");
        }
    }

    public function ready() {
        return $this->_collection;
    }
}

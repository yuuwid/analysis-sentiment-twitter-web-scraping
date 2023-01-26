<?php

namespace Core\Helpers;

use Mongo\MongoConnect;

class MDB {

    public static function connect($collection) {
        $db = new MongoConnect($collection);

        return $db->ready();
    }
    
}
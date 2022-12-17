<?php

namespace Lawana\Model;

use Core\Helpers\Database;

class BaseModel
{
    protected $table = '';


    public function __construct()
    {
        $table = str_replace('Models\\', '', get_class($this));
        $this->table = strtolower($table);
    }
}

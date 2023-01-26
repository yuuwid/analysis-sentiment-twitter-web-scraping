<?php

namespace Middleware;

use Lawana\Middleware\SessionMiddleware;

class Authenticate extends SessionMiddleware
{

    public function handle()
    {
        
        return $this->accept();
    }
}

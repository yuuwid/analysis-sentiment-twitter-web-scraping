<?php

namespace Lawana\Middleware;

use Lawana\Utils\Request;
use Lawana\Utils\Redirect;

class BaseMiddleware
{
    public function __construct($handlers)
    {

        if (is_array($handlers)) {
            foreach ($handlers as $handler) {
                $this->checkMiddleware($handler);
            }
        } else {
            $this->checkMiddleware($handlers);
        }
    }

    private function checkMiddleware($handler)
    {
        global $registerMidlleware;

        if (!isset($registerMidlleware[$handler])) {
            if (env('APP_DEV', 'project') == 'publish') {
                Redirect::error(404, "<b>Not Found</b>");
            } else {
                Redirect::error("ERROR", "Middleware Handler: <b>$handler</b> Not Registered.");
            }
        }
    }
}

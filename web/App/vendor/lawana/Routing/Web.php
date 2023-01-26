<?php

namespace Lawana\Routing;

use Lawana\Middleware\BaseMiddleware;
use Lawana\Utils\Redirect;
use Lawana\Utils\Request;

class Web extends Route
{


    /**
     * $urls = [
     *      "random_name/custom_name" => [
     *          'request_method' => 'GET' / 'POST',
     *          'url' => '',
     *          'option' => ['controller', 'method_controller']
     *          'reference_model' => model
     *       ]
     *  ]
     */
    protected static $urls = [];


    private static $register = null;


    private static $request_url = null;


    private static $request_method = null;



    protected static function start_server()
    {
        $req_url = $_SERVER['REQUEST_URI'];
        $request_method = $_SERVER['REQUEST_METHOD'];

        if (isset($_SERVER['QUERY_STRING'])) {
            $req_url = str_replace('?' . $_SERVER['QUERY_STRING'], '', $req_url);
        }

        $ROOT_URL = ROOT_URL;
        $req_url = str_replace($ROOT_URL, '', $req_url);
        $req_url = filter_var($req_url, FILTER_SANITIZE_URL);

        $request_url = strtolower($req_url);
        if (strlen($request_url) > 1) {
            if (substr($request_url, -1) == '/') {
                $request_url = substr($request_url, 0, -1);
            }
        }

        $URL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ROOT_URL;
        global $env;
        $env['APP_URL'] = $URL;

        define('REQUEST_URL', $request_url);

        self::$request_url = $request_url;
        self::$request_method = $request_method;
    }




    protected static function serve()
    {
        $urls = self::$urls;
        $found = false;

        if ($urls !== null) {
            foreach ($urls as $name => $reg) {
                self::$register = $reg;
                $found = self::next();
                if ($found == true) {
                    break;
                }
            }

            if ($found == false) {
                Redirect::error(404, "<b>Not Found</b>");
            }
        } else {
            Redirect::error(404, "<b>Not Found</b>");
        }
    }

    protected static function next()
    {
        $req_url = self::$request_url;
        $req_method = self::$request_method;
        $reg = self::$register;
        $found = false;

        if (($reg['url'] == $req_url) and ($reg['request_method'] == $req_method)) {
            parent::check($reg);
            $found = true;
        }
        return $found;
    }
}

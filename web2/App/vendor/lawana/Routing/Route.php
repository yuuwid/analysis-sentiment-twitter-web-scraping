<?php

namespace Lawana\Routing;

use Exception;
use Lawana\Middleware\BaseMiddleware;
use Lawana\View\View,
    Lawana\Utils\Redirect,
    Lawana\Utils\Request;


class Route
{


    private static function checkMiddleware($register)
    {
        global $registerMidlleware;
        if ($register['middleware'] != null) {
            $status = self::handleTheMiddleware($registerMidlleware[$register['middleware']]);
            return $status;
        } else {
            return null;
        }
    }

    protected static function check($register)
    {
        $checkMiddleware = self::checkMiddleware($register);

        if (($checkMiddleware == null) or ($checkMiddleware == true)) {
            if ($register['option'] instanceof \Closure) {
                self::to_closure($register);
            } else {
                $route = $register['option'][0];
                $method_route = $register['option'][1];
                $type = $register['type'];

                $r_path = PATH_APP . 'App/';
                $route_require = $r_path . $route . '.php';

                if (!file_exists($route_require)) {
                    if ($type == 'API') {
                        if (env('APP_DEV', 'project') == 'publish') {
                            Redirect::error(404, "<b>Not Found</b>");
                        } else {
                            Redirect::error("BAD REQUEST", "<b>API has been closed.</b>");
                        }
                    } else {
                        if (env('APP_DEV', 'project') == 'publish') {
                            Redirect::error(404, "<b>Not Found</b>");
                        } else {
                            Redirect::error("ERROR", "Controller: <b>$route_require</b> Not Found.");
                        }
                    }
                }

                // App\Controllers\ExampleController.php ==> App\Models\ExampleController.php
                $model = str_replace('Controllers', 'Models', $route);

                // App\Models\ExampleController.php ==> App\Models\Example.php
                $model = str_replace('Controller', '', $model);
                try {
                    new $model();
                } catch (Exception $e) {}

                $route = new $route();

                $params = [new Request];

                if ($type == 'API') {
                    self::request_api($route, $method_route, $params);
                } else {
                    self::to_controller($route, $method_route, $params);
                }
            }
        }
    }


    public static function handleTheMiddleware($middleware)
    {
        $middleware = new $middleware();
        $method = 'handle';
        $params = [new Request()];

        if (method_exists($middleware, $method)) {
            if (($ret = call_user_func_array([$middleware, $method], $params)) !== null) {
                return $ret;
            }
        } else {
            if (env('APP_DEV', 'project') == 'publish') {
                Redirect::error(404, "<b>Not Found</b>");
            } else {
                Redirect::error("ERROR", "Method: <b>$method</b> Not Found.");
            }
        }
    }




    private static function to_controller($controller, $method_controller, $params)
    {
        if (method_exists($controller, $method_controller)) {
            if (($ret = call_user_func_array([$controller, $method_controller], $params)) !== null) {
                self::user_func($ret);
            }
        } else {
            if (env('APP_DEV', 'project') == 'publish') {
                Redirect::error(404, "<b>Not Found</b>");
            } else {
                Redirect::error("ERROR", "Method: <b>$method_controller</b> Not Found.");
            }
        }
    }




    private static function to_closure($register)
    {
        self::user_func($register['option']());
    }




    private static function user_func($result)
    {
        if ($result instanceof View) {
            $view = $result;
            $data = $view->getData();
            require_once $view->getView();
        } else if (!is_array($result)) {
            echo $result;
        } else {
            var_dump($result);
        }
    }




    private static function request_api($api, $method_api, $params)
    {
        if (method_exists($api, $method_api)) {
            if (($ret = call_user_func_array([$api, $method_api], $params)) !== null) {
                $response = [
                    'status' => 1,
                    'msg' => '',
                    'data' => $ret
                ];
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } else {
            if (env('APP_DEV', 'project') == 'publish') {
                Redirect::error(404, "<b>Not Found</b>");
            } else {
                Redirect::error("BAD REQUEST", "<b>API has been closed.</b>");
            }
        }
    }
}

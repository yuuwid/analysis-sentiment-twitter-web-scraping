<?php

namespace Lawana\Routing;

use Core\App,
    Lawana\Routing\BaseUrl,
    Lawana\Routing\BaseApi;

class Register extends App
{


    public static function url(string $url, $option)
    {
        if (self::check($url) == true) {
            $register = new BaseUrl($url, $option);
            return $register;
        }
    }


    public static function api(string $url, $option)
    {
        if (self::check($url) == true) {
            $register = new BaseApi($url, $option);
            return $register;
        }
    }


    public static function group(string $type, array $register = [])
    {
        if ($type == 'url') {
            foreach ($register as $reg) {
                $url = self::url($reg[0], $reg[1]);
                if (isset($reg[2])) {
                    if (strtolower($reg[2]) == 'post') {
                        $url->post();
                    } else {
                        $url->get();
                    }
                }
            }
        } else {
            foreach ($register as $reg) {
                $api = self::api($reg[0], $reg[1]);
                if (isset($reg[2])) {
                    if (strtolower($reg[2]) == 'post') {
                        $api->post();
                    } else {
                        $api->get();
                    }
                }
            }
        }
    }
}

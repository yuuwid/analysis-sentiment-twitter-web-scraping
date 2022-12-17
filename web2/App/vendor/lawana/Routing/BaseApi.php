<?php 

namespace Lawana\Routing;

use Lawana\Utils\Tools;

class BaseApi extends Web
{

    static $name_api = null;

    public function __construct($url, $option)
    {
        BaseApi::$name_api = Tools::random_str(5);
        self::$urls[BaseApi::$name_api] = [
            'type' => 'API',
            'request_method' => 'GET',
            'url' => $url,
            'option' => $option
        ];
    }

    public function post()
    {
        self::$urls[BaseApi::$name_api]['request_method'] = "POST";
        return $this;
    }

    public function get()
    {
        self::$urls[BaseApi::$name_api]['request_method'] = "GET";
        return $this;
    }


    public function name($name)
    {
        if (!array_key_exists($name, self::$urls))
        {
            self::$urls[$name] = self::$urls[BaseApi::$name_api];
    
            unset(self::$urls[BaseApi::$name_api]);
    
            BaseApi::$name_api = $name;
        }
        return $this;
    }
    
}

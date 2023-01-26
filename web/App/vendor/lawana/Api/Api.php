<?php

namespace Lawana\API;

use GuzzleHttp\Client;

class Api
{

    private static function client()
    {
        return new Client();
    }

    public static function get(string $uri, array $body = [])
    {
        $client = self::client();

        return $client->get($uri, ['json' => json_encode($body)]);
    }


    public static function post(string $uri, array $body = [])
    {
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return $client->request("POST", $uri, ['body' => json_encode($body)]);
        // return $client->post($uri, ['body' => json_encode($body)]);
    }
}

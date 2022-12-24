<?php

namespace Models;

use Core\Helpers\MDB;
use Lawana\Model\BaseModel;
use MongoDB\BSON\ObjectID;

class Sentiment extends BaseModel
{

    public static function insertMany($data)
    {
        MDB::connect('histories')->insertMany($data);
    }

    public static function insertSenti($data)
    {
        MDB::connect('sentiments')->insertOne($data);
    }

    public static function filterHistory($val)
    {
        // db.histories.find({
        //     'id_scrap': {
        //         $eq: "9742839"
        //     }
        // })

        $query = [
            'id_scrap' => [
                '$eq' => (string)$val,
            ]
        ];

        $cursor = MDB::connect('histories')->find($query);
        $data = [];
        foreach ($cursor as $c) {
            $data[] = $c;
        }
        return $data;
    }

    public static function getHistory($id_his)
    {
        $query = [
            '_id' => [
                '$eq' => new ObjectID($id_his),
            ]
        ];

        $cursor = MDB::connect('histories')->find($query);

        foreach ($cursor as $his) {
            return $his;
        }
    }
    

    public static function getSenti($val)
    {
        $query = [
            'id_sentiment' => [
                '$eq' => (string)$val,
            ]
        ];

        $senti_temp = MDB::connect('sentiments')->find($query);

        foreach ($senti_temp as $senti) {
            return [
                'id_sentiment' => $senti['id_sentiment'],
                'tweet' => $senti['tweet'],
                'n_tweet' => $senti['n_tweet'],
                'time' => $senti['time'],
            ];
        }
    }
}

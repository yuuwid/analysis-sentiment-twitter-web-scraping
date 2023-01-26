<?php

namespace Controllers;

use Exception;
use Lawana\Controller\BaseController,
    Lawana\Utils\Request,
    Lawana\API\Api;
use Lawana\Message\Flasher;
use Lawana\Utils\Cookie;
use Lawana\Utils\Redirect;
use Models\Sentiment;

class SentimentController extends BaseController
{

    public function index(Request $request)
    {
        $cookieHistory = json_decode(Cookie::get("history-sentiment"));
        $histories = [];

        if ($cookieHistory != null) {
            foreach ($cookieHistory as $his) {
                $histories[] = Sentiment::getSenti($his);
            }
        }

        $rekom_tweet = [
            faker()->city(),
            faker()->jobTitle(),
            // faker()->company(),
        ];

        $data = [
            'rekom' => $rekom_tweet[array_rand($rekom_tweet)],
            'history' => $histories,
        ];

        return view('home.input_tweet', $data);
    }

    public function results(Request $request)
    {
        $req = $request->all();

        if (sizeof($req) == 0) {
            Flasher::create("error", "Invalid Request", 'r', 'e');
            Redirect::to("/");
        }

        $sentiment = Sentiment::getSenti($req['id_sentiment']);
        $histories = Sentiment::filterHistory($req['id_sentiment']);

        if (sizeof($histories) > 1) {
            $n_neg = 0;
            $n_net = 0;
            $n_pos = 0;

            foreach ($histories as $his) {
                if ($his['sentiment'] == 'Positive') {
                    $n_pos += 1;
                } else if ($his['sentiment'] == 'Netral') {
                    $n_net += 1;
                } else if ($his['sentiment'] == 'Negative') {
                    $n_neg += 1;
                }
            }

            $data = [
                'sentiment' => $sentiment,
                'counts' => [$n_neg, $n_net, $n_pos],
                'histories' => $histories,
            ];

            return view('sentiment.results', $data);
        }

        return view('sentiment.notfound', [
            'id_sentiment' => $req['id_sentiment'],
        ]);
    }

    public function detail(Request $request)
    {
        $req = $request->all();

        if (sizeof($req) == 0) {
            Flasher::create("error", "Invalid Request", 'r', 'e');
            Redirect::to("/");
        }

        $data = Sentiment::getHistory($req['id_history']);

        return view('sentiment.detail', $data);
    }

    public function requestScrap(Request $request)
    {
        $req = $request->all();

        // $idRequest = "9742839";
        $idRequest = (string)strtotime("now");

        $this->validate($req);


        $body = [
            "tweet" => $req['tweet'],
            "n_tweet" => (int) $req['n_tweet'],
            "id_request" => $idRequest,
            "filter_sentiment" => [
                "negative" => isset($req['negative-check']),
                "neutral" => isset($req['neutral-check']),
                "positive" => isset($req['positive-check']),
            ],
        ];

        try {
            $response = Api::post("http://127.0.0.1:5000/api/sentiment-scraping", $body);

            $response = json_decode($response->getBody()->getContents(), true);

            if ($response['status'] === "success") {
                $this->requestGetAllData($idRequest);

                $senti = [
                    'id_sentiment' => $body['id_request'],
                    'tweet' => $body['tweet'],
                    'n_tweet' => $body['n_tweet'],
                    'time' => date("Y-m-d H:i:s", strtotime("now")),
                    'filter_sentiment' => [
                        'negative' => $body['filter_sentiment']['negative'],
                        'neutral' => $body['filter_sentiment']['neutral'],
                        'positive' => $body['filter_sentiment']['positive'],
                    ]
                ];

                Sentiment::insertSenti($senti);

                Redirect::to("/results?id_sentiment=" . $idRequest);
            }
        } catch (Exception $e) {
            Flasher::create("error", "Failed to Request API: " . $e->getCode(), 'r', 'e');
            Redirect::to("/");
        }
    }

    private function requestGetAllData($idRequest)
    {
        $body = [
            "id_request" => $idRequest,
        ];

        $response = Api::post("http://127.0.0.1:5000/api/all", $body);

        $jsonResponse = $response->getBody()->getContents();

        // Save Data dari Cassandra ke MongoDB
        Sentiment::insertMany(json_decode($jsonResponse));

        // Save to Cookie
        $cookieHis = json_decode(Cookie::get("history-sentiment"));
        $cookieHis[] = $idRequest;

        Cookie::make("history-sentiment", json_encode($cookieHis), 60 * 10);
    }



    private function validate($req)
    {
        if ($req['tweet'] == '') {
            Flasher::create("error", "Tweet must be fill", 'r', 'e');
            Redirect::to("/");
        } else {
            if ($req['n_tweet'] < 10) {
                Flasher::create("error", "Minimum Tweet is 10", 'r', 'e');
                Redirect::to("/");
            }

            if ((isset($req['negative-check']) == false) && (isset($req['neutral-check']) == false) && (isset($req['positive-check'])) == false) {
                Flasher::create("error", "Choose one of the sentiment results !", 'r', 'e');
                Redirect::to("/");
            }
        }
    }

    public function clearHistory()
    {
        Cookie::drop('history-sentiment');
        Flasher::create("clear-history-status", "History Cleared", 'g');
        Redirect::to("/");
    }
}

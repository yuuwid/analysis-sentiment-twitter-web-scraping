<?php

use Controllers\ExampleController;
use Controllers\SentimentController;
use Lawana\Routing\Register;

setlocale (LC_TIME, 'id_ID');

/**
 * Registrasi Web Url disini
 * web url dapat berupa link url biasa dan link REST API
 * untuk membuat akses ke link yang ingin dibuat dapat menggunakan class Register::url
 * contoh :
 *      Register::url("link_url", ["Controller", "Method"]);
 * untuk REST API sama dengan membuat link url biasa
 * contoh :
 *      Register::api("link_url", ["Controller", "Method"]);
 * Note: 
 * - setiap url yang diregistrasikan tidak boleh sama, baik itu untuk link biasa atau link REST API,
 *   jika mendaftarkan url yang sama, maka url yang didaftarkan pertama kali yang akan dipakai.
 */

Register::url('/', [SentimentController::class, "index"]);

Register::url('/req-api', [SentimentController::class, "requestScrap"])->post();

Register::url('/results', [SentimentController::class, "results"]);

Register::url('/detail', [SentimentController::class, "detail"]);

Register::url('/req-scrap', [SentimentController::class, "requestScrap"]);

Register::url('/search-history', [SentimentController::class, "searchHistory"])->post();

Register::url('/clear-history', [SentimentController::class, "clearHistory"])->post();

Register::api('/test-api', function () {
    return [1, 2, 3, 4, 5, 6];
});

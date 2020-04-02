<?php
require 'vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

function getPost()
{
    if(!empty($_POST))
    {
        // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
        // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
        return $_POST;
    }

    // when using application/json as the HTTP Content-Type in the request
    $post = json_decode(file_get_contents('php://input'), true);
    if(json_last_error() == JSON_ERROR_NONE)
    {
        return $post;
    }

    return [];
}

function getKey($arr, $key) {
    if ( isset($arr[$key]) )
        return $arr[$key];

    foreach($arr as $value) {
        if (is_array($value) && $v = getKey($value, $key))
            return $v;
    }
}


function sendMail($to, $payload) {
    $httpClient = new GuzzleAdapter(new Client());
    $sparky = new SparkPost($httpClient, ['key'=>'9c848fe3e351e58f5febc11863562e6f3f8cca82']);

    $promise = $sparky->transmissions->post([
        'content' => [
            'from' => [
                'name' => 'MSB Webhook Data',
                'email' => 'noreply@notifications.matsugov.us',
            ],
            'subject' => 'Webhook Data',
            'text' => $payload,
        ],
        'recipients' => [
            [
                'address' => [
                    'email' => $to,
                ],
            ],
        ],
    ]);

    return $promise;
}


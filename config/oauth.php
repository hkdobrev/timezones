<?php

$app['oauth'] = array(
    'client_id' => 'timezonesapp',
    'client_secret' => 'mF17G2hy',
    'token_route' => 'grant',
    'timezones_route' => 'timezones',
    'http_options' => array(
        'exceptions' => false,
    ),
    'keys' => [
        'public' => __DIR__.'/../keys/public.pem',
        'private' => __DIR__.'/../keys/private.pem',
    ],
);

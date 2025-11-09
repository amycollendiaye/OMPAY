<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    // configurition de mon cors;

    'paths' => ['api/v1/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['POST',"GET","PUT","DELETE","PATCH","OPTIONS"],

    'allowed_origins' => ['http://localhost:8000', 'http://127.0.0.1:8000', "https://amycolle-ompay.onrender.com"],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];

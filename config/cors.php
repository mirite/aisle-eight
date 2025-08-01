<?php

return array(

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

    'paths' => array( 'api/*', 'sanctum/csrf-cookie' ),

    'allowed_methods' => array( '*' ),

    'allowed_origins' => array( '*' ),

    'allowed_origins_patterns' => array(),

    'allowed_headers' => array( '*' ),

    'exposed_headers' => array(),

    'max_age' => 0,

    'supports_credentials' => false,

);

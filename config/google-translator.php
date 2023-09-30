<?php

/**
 * Laravel Google translator for a model
 */

return [
    // Google translator Api Key.
    // You can get it from https://console.cloud.google.com/
    "api_key" => env('GOOGLE_TRANSLATE_API',null),

    // sometimes you may need to change the translation table, so this is for you
    "table_name" => env('TRANSLATOR_TABLE_NAME','translations')
];

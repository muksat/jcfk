<?php

return [
    'credentials' => [
        'api_key'     => ENV('MONERIS_API_KEY'),
        'store_id'    => ENV('MONERIS_STORE_ID'),
        'environment' => ENV('MONERIS_ENVIROMENT'),
        'require_cvd' => false
    ]
];
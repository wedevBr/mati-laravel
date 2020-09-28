<?php
return [
    // Client ID provided by Mati dashboard
    'client_id' => env('MATI_CLIENT_ID', null),

    // Client Secret provided by Mati dashboard
    'client_secret' => env('MATI_CLIENT_SECRET', null),

    // Mati's OAuth URL
    'api_url' => env('MATI_API_URL', 'https://api.getmati.com/v2'),

    // Mati's API URL
    'auth_url' => env('MATI_AUTH_URL', 'https://api.getmati.com/oauth')
];

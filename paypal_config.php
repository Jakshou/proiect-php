<?php
require __DIR__ . '/vendor/autoload.php';

// Replace with your actual PayPal credentials
$clientId = 'AbZJmW6H1uowWQM8Sm8-Tv_LyvZVoXwPYFBIymQgAWsA5AXF06pWYqCYxzUxEHlOTloU-2sXjxYs-i9W';
$clientSecret = 'AbZJmW6H1uowWQM8Sm8-Tv_LyvZVoXwPYFBIymQgAWsA5AXF06pWYqCYxzUxEHlOTloU-2sXjxYs-i9W';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential($clientId, $clientSecret)
);

$apiContext->setConfig([
    'mode' => 'sandbox', // 'sandbox' for testing or 'live' for production
    'http.ConnectionTimeOut' => 30,
    'log.LogEnabled' => true,
    'log.FileName' => __DIR__ . '/logs/paypal.log',
    'log.LogLevel' => 'FINE'
]);
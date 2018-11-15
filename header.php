<?php
// Load functions and config
require_once('functions.php');
if (is_readable('config.php')) {
    require_once('config.php');
    $noconf = false;

    // Get latest wallet balance
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$config['URL']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"method":"getbalance"}');
    curl_setopt($ch, CURLOPT_USERPWD, "{$config['username']}:{$config['password']}");
    $result=curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    curl_close ($ch);

    // Decode received data
    $parsed_json = json_decode($result, true);
    $parsed_json = $parsed_json['result'];

    // Store and use decoded data
    $usdbtc = '';
    $btcgrc = '';

    BTCGRC();
    USDBTC();

    $first = $config['USDgoal'] / $usdbtc;
    $goal = $first / $btcgrc;
} else {
    $noconf = true;
}
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

    // Calculate USD to GRC
    $usdgrc = $usdbtc * $btcgrc;

    // Calculate percentage full
    $percent_full = ($parsed_json / $goal) * 100;

    // Calculate how many pints
    $pints_total = (((($percent_full / 100) * 124) + 0.00001) * 100) / 100;

    // Create connection
    $conn = new mysqli($config['dbserver'], $config['dbuser'], $config['dbpass'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    if ($cron = getenv('IS_CRON')) {

        $conversion = "insert into conversion_rate (unix_timestamp, bittrex_chat_id, usd_btc, btc_grc, usd_grc) values(unix_timestamp(), 1, $usdbtc, $btcgrc, $usdgrc)";
        $conn->query($conversion);
          if ($conn->query($conversion) === TRUE) {
             $last_id = $conn->insert_id;
         }
        $balance = "insert into fund_balance (unix_timestamp, bittrex_chat_id, conversion_rate_id, current_balance, goal, pints, percent_full) values(unix_timestamp(), 1, $last_id, $parsed_json, $goal, $pints_total, $percent_full)";
        $conn->query($balance);
    }


} else {
    $noconf = true;
    $parsed_json = 0;
    $goal = 0;
}

<!DOCTYPE html>
<?php
$username = 'USERNAME';
$password = 'PASSWORD';
$URL = 'http://IP:PORT';
$USDgoal = '172';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"method":"getbalance"}');
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
$result=curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);

$parsed_json = json_decode($result, true);
$parsed_json = $parsed_json['result'];


$usdbtc = '';
$btcgrc = '';

function BTCGRC(){
    $api_data = file_get_contents('https://bittrex.com/api/v1.1/public/getorderbook?market=BTC-GRC&type=buy');
    if (!empty($api_data) && is_string($api_data)) {
        $api_data_decoded = json_decode($api_data);
        if (json_last_error() === JSON_ERROR_NONE) {
            if ((bool)$api_data_decoded->success === true) {
                $decoded_result = $api_data_decoded->result;
                $i = 0;
                $sum = 0;
                foreach($decoded_result as $result) {
                    $sum+= $result->{"Rate"};
                    if(++$i > 9) break;
                }
                global $btcgrc;
                $btcgrc = $sum / 10;
            }
        }
    }
}

function USDBTC(){
    $api_data = file_get_contents('https://bittrex.com/api/v1.1/public/getorderbook?market=USD-BTC&type=buy');
    if (!empty($api_data) && is_string($api_data)) {
        $api_data_decoded = json_decode($api_data);
        if (json_last_error() === JSON_ERROR_NONE) {
            if ((bool)$api_data_decoded->success === true) {
                $decoded_result = $api_data_decoded->result;
                $i = 0;
                $sum = 0;
                foreach($decoded_result as $result) {
                    $sum+= $result->{"Rate"};
                    if(++$i > 9) break;
                }
                global $usdbtc;
                $usdbtc = $sum / 10;
            }
        }
    }
}

BTCGRC();
USDBTC();

$first = $USDgoal / $usdbtc;
$goal = $first / $btcgrc;
?>
<html>
<head>
<meta http-equiv="refresh" content="600">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<style>
.my-image {
    margin: 0 auto;
}
.loadgo-container {
    display: inline-block;
    margin: 0 auto;
}
#progress {
    font-size:16px;
    font-weight:bold;
}
#pints {
    margin-bottom:10px;
    font-size:16px;
}
#donate {
  margin-top: 4em;
  font-size: 12px;
  color: #777;
}
#donate a {
  color: #7235d3;
}
#grc-address {
  margin-left: .5em;
}
</style>
<body>
<div style="text-align:center;">
<H1>Beer Fund</H1>
Current Balance: <?php echo $parsed_json; ?> GRC<br />
Goal: <?php echo $goal;?> GRC<br />
  <img id="logo" src="keg.jpg" class="my-image" alt="Logo" />
  <div id="progress">0 %</div>
  <div id="pints"></div>
  <div id="donate">Donate <a href="https://gridcoin.us/">GridCoin</a> <span id="grc-address">S6v2YyShTd9J9VwL7Ngsd6Kz1ZMsfbWUsi</span></div>
</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/LoadGo/2.2/loadgo.min.js"></script>
<script type="text/javascript" src="countUp.js"></script>

<script>
var $logo = $('#logo');
var p = (<?php echo "$parsed_json"; ?> / <?php echo "$goal"; ?>) * 100;

$logo.loadgo();
$logo.loadgo({ direction: 'bt', opacity: 0.7 });
$logo.loadgo('setprogress', p);

var percent = {
    useEasing: true,
    useGrouping: true,
    separator: ',',
    decimal: '.',
    suffix: '%'
};
var numAnimPercent = new CountUp("progress", 0, p, 2, 1.0, percent);
if (!numAnimPercent.error) {
    numAnimPercent.start();
} else {
    console.error(numAnimPercent.error);
}

var pints = (p / 100) * 124;
var p2 = Math.round((pints + 0.00001) * 100) / 100;

var pint = {
    useEasing: true,
    useGrouping: true,
    separator: ',',
    decimal: '.',
    suffix: ' Pints'
};
var numAnimPint = new CountUp("pints", 0, p2, 2, 1.3, pint);
if (!numAnimPint.error) {
    numAnimPint.start();
} else {
    console.error(numAnimPint.error);
}
</script>
</html>

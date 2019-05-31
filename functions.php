<?php
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
                    if(++$i > 2) break;
                }
                global $btcgrc;
                $btcgrc = $sum / 3;
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

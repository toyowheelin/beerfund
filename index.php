<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="600">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<body>
<div class="container-fluid">
    <?php
    if (!$noconf) {
	echo	"<div class='row'>";
	echo	"<div id='rates' class='col col-3 text-center'>";
	echo 	"<h4><u>Current Rates</u></h4>";
	echo	"USD-BTC " . number_format($usdbtc, 8, '.', '')."<br />";
	echo	"BTC-GRC " . number_format($btcgrc, 8, '.', '')."<br />";
	echo	"<h6><u>Calculated</u></h6>";
	echo	"USD-GRC " . ($usdbtc * $btcgrc);
	echo	"</div>";
	echo	"<div id='funds' class='col-auto offset-1 text-center'>";
        echo 	"<H1>Beer Fund</H1>";
        echo 	"Current Balance: $parsed_json GRC<br />";
        echo 	"Goal: $goal GRC<br />";
        echo 	"<img id='logo' src='keg.jpg' class='my-image' alt='Logo' />";
        echo 	"<div id='progress'>0 %</div>";
        echo 	"<div id='pints'></div>";
	echo "</div>";
    } else {
        echo "<H1>Please rename the file config-example.php to config.php in the root directory to make the project working.</H1>";
    }
    ?>
</div>
<div class="row">
    <div class="col-auto offset-4" id="donate">Donate <a href="https://gridcoin.us/">GridCoin</a> <span id="grc-address">S6v2YyShTd9J9VwL7Ngsd6Kz1ZMsfbWUsi</span></div>
    <div id="fork"><a class="btn btn-info" href="https://github.com/toyowheelin/beerfund" target="_blank" style="margin-top:-18px;">GitHub</a></div>
</div>
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

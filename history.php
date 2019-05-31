<?php
require_once './header.php';
$sql = "select from_unixtime(conversion_rate.unix_timestamp) as timestamp, usd_btc, btc_grc, usd_grc, current_balance, goal, pints, percent_full from conversion_rate, fund_balance where fund_balance.conversion_rate_id = conversion_rate.conversion_rate_id order by conversion_rate.unix_timestamp desc";
$result = $conn->query($sql);

echo "<br>";
echo "<table border='1'>
<tr>
<th>Timestamp</th>
<th>USD-BTC</th>
<th>BTC-GRC</th>
<th>USD-GRC</th>
<th>Current Balance</th>
<th>Current Goal</th>
<th>Pints</th>
<th>Percent Full</th>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['timestamp'] . "</td>";
    echo "<td>" . $row['usd_btc'] . "</td>";
    echo "<td>" . $row['btc_grc'] . "</td>";
    echo "<td>" . $row['usd_grc'] . "</td>";
    echo "<td>" . $row['current_balance'] . "</td>";
    echo "<td>" . $row['goal'] . "</td>";
    echo "<td>" . $row['pints'] . "</td>";
    echo "<td>" . $row['percent_full'] . "</td>";
    echo "</tr>";
}
echo "</table>";


$conn->close();
?>

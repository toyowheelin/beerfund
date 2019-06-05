<?php
require_once './header.php';


$rowperpage = 100;
$row = 0;

//Previous Button
if(isset($_POST['but_prev'])){
    $row = $_POST['row'];
    $row -= $rowperpage;
    if( $row < 0 ){
        $row = 0;
    }
}

//Next Button
if(isset($_POST['but_next'])){
    $row = $_POST['row'];
    $allcount = $_POST['allcount'];

    $val = $row + $rowperpage;
    if( $val < $allcount ){
        $row = $val;
    }
}

//Count total number of rows
$sqlc = "SELECT COUNT(*) AS cntrows FROM conversion_rate";
$resultc = $conn->query($sqlc);
$fetchresult = mysqli_fetch_array($resultc);
$allcount = $fetchresult['cntrows'];

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

$sql = "select from_unixtime(conversion_rate.unix_timestamp) as timestamp, usd_btc, btc_grc, usd_grc, current_balance, goal, pints, percent_full from conversion_rate, fund_balance where fund_balance.conversion_rate_id = conversion_rate.conversion_rate_id order by conversion_rate.unix_timestamp desc limit $row,".$rowperpage;
$result = $conn->query($sql);

while ($fetch = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $fetch['timestamp'] . "</td>";
    echo "<td>" . $fetch['usd_btc'] . "</td>";
    echo "<td>" . $fetch['btc_grc'] . "</td>";
    echo "<td>" . $fetch['usd_grc'] . "</td>";
    echo "<td>" . $fetch['current_balance'] . "</td>";
    echo "<td>" . $fetch['goal'] . "</td>";
    echo "<td>" . $fetch['pints'] . "</td>";
    echo "<td>" . $fetch['percent_full'] . "</td>";
    echo "</tr>";
}
$conn->close();

?>

	</table>
        <form method="post" action="">
            <div id="div_pagination">
                <input type="hidden" name="row" value="<?php echo $row; ?>">
                <input type="hidden" name="allcount" value="<?php echo $allcount; ?>">
                <?php if( !$row == 0)
		echo '<input type="submit" class="button" name="but_prev" value="Previous">';
		?>

                <input type="submit" class="button" name="but_next" value="Next">
            </div>
        </form>


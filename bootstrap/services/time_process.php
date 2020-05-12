<?php

require  '../db.php';
require '../sql.php';

$d_account = $_SESSION['d_account'] ?? '';
$departtime = findDriverByBUS($conn, $d_account);
$time=updatedepart($conn, $d_account, $data=[]);
$arrive=date("Y-m-d", strtotime($time."+10 minute"));


?>

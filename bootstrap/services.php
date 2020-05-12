<?php

/**
* =============================================================================
* = 驗證乘客登入
* =============================================================================
*
* @param String $account  
* @param String $password  
* @return Boolean
*
**/
function verifyPassengerLogin($account, $password) {

    $user = DB::find('passenger', $account, 'passenger_account');

    if($user && $user['PASSENGER_PASSWORD'] == $password) return true;
    return false;
}

/*
$d_account = $_SESSION['d_account'] ?? '';
$departtime = findDriverByBUS($conn, $d_account);
$time=updatedepart($conn, $d_account, $data=[]);
$arrive=date("Y-m-d", strtotime($time."+10 minute"));
*/

/**
* =============================================================================
* = 預估抵達下站時間
* =============================================================================
*
* @param DateTime $departTime
* @return DateTime
*
**/
function countTimeToArriveNextStop($departTime) {

    return date("Y-m-d H:i:s", strtotime($departTime."+10 minute"));
}
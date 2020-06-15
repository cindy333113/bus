<?php

date_default_timezone_set('Asia/Taipei');

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
function verifyPassengerLogin($account, $password)
{

    $user = DB::find('passenger', $account, 'passenger_account');

    if ($user && $user['PASSENGER_PASSWORD'] == $password) return true;
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
function countTimeToArriveNextStop($departTime)
{

    return date("Y-m-d H:i:s", strtotime($departTime . "+10 minute"));
}


/**
 * =============================================================================
 * = 計算公車經行站牌數
 * =============================================================================
 *
 * @param String $departureTime  
 * @return Int
 *
 **/
function countStopBusPassed($departureTime)
{

    $passTime = strtotime(date('H:i:s')) - strtotime($departureTime);
    return $countOfStop = floor($passTime / 60 / 10);
}

/**
 * =============================================================================
 * = 計算公車站牌總數
 * =============================================================================
 *
 * @param String $departureTime  
 * @return Int
 *
 **/
function countStopOfRoute($routeId)
{
    $routeStopList = DB::fetchAll('route_stop');
    $routeStopListByRoute = array_filter($routeStopList, function ($routeStop) use ($routeId) {
        return $routeId == $routeStop['route_id'];
    });

    return count($routeStopListByRoute);
}

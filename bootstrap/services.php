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
 * = 預估抵達下站時間
 * =============================================================================
 *
 * @param String $busId
 * @return String
 *
 **/
function findStopNameByBus($busId)
{
    $bus = DB::find('bus', $busId);
    $departureTime = $bus['time'];
    $countOfStop = countStopBusPassed($departureTime);

    $routeId = $bus['route_id'];
    $amountStopOfRoute = countStopOfRoute($routeId);

    $isGoing = floor($countOfStop / $amountStopOfRoute) / 2 == 0 ? '1' : '0';

    $StopOfCurrentDrive = $countOfStop % $amountStopOfRoute;
    $currentOrder =  $isGoing ? $StopOfCurrentDrive : $amountStopOfRoute - $StopOfCurrentDrive;

    return findStopNameByRouteOrder($routeId, $currentOrder);
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
 * @param String $routeId  
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

/**
 * =============================================================================
 * = 依路線及順序找到站牌
 * =============================================================================
 *
 * @param String $routeId
 * @param String $stopOrder 
 * @return String
 *
 **/
function findStopNameByRouteOrder($routeId, $stopOrder)
{
    $routeStopList = DB::fetchAll('route_stop');
    $nowStop = array_filter($routeStopList, function ($routeStop) use ($routeId, $stopOrder) {
        return $routeId == $routeStop['route_id'] && $stopOrder == $routeStop['route_order'];
    });

    $stop = DB::find('stop', array_values($nowStop)[0]['stop_id']);

    return $stop['stop_name'];
}

/**
 * =============================================================================
 * = 依站牌找路線
 * =============================================================================
 *
 * @param String $stopId  
 * @return String
 *
 **/
function findRouteByStop($stopId)
{
    $routeStopList = DB::fetchAll('route_stop');
    $routeStopListByStop = array_filter($routeStopList, function ($routeStop) use ($stopId) {
        return $stopId == $routeStop['stop_id'];
    });

    $routeListByStop = array_map(function($routeStop){
        return DB::find('route', $routeStop['route_id']);
    }, $routeStopListByStop);

    return $routeListByStop;
}
/**
 * =============================================================================
 * = 顯示目前站牌
 * =============================================================================
 *
 * @param String $routeId  
 * @return String
 *
 **/
function findStopListByRoute($routeId)
{
    $routeStopList = DB::fetchAll('route_stop');
    $routeStopListByRoute = array_filter($routeStopList, function ($routeStop) use ($routeId) {
        return $routeId == $routeStop['route_id'];
    });
var_dump($routeStopListByRoute);
    $stopNameByRoute = array_map(function($routeStop){
        return DB::find('stop', $routeStop['stop_id']);
    }, $routeStopListByRoute);

    return $stopNameByRoute;
}
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
 * = 現在位置
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

    if ($countOfStop < 0) {
        return '尚未發車';
    }

    $routeId = $bus['route_id'];
    $amountStopOfRoute = countStopOfRoute($routeId);

    $isGoing = findDirectionByBus($busId);

    $stopOfCurrentDrive = $countOfStop % $amountStopOfRoute;
    $currentOrder =  $isGoing ? $stopOfCurrentDrive : $amountStopOfRoute - $stopOfCurrentDrive;

    return findStopNameByRouteOrder($routeId, $currentOrder);
}

/**
 * =============================================================================
 * = 查詢公車現在路線站數
 * =============================================================================
 *
 * @param String $busId
 * @return String
 *
 **/
function findCurrentOrderByBus($busId)
{
    $bus = DB::find('bus', $busId);
    $departureTime = $bus['time'];
    $countOfStop = countStopBusPassed($departureTime);

    if ($countOfStop < 0) {
        return '尚未發車';
    }

    $routeId = $bus['route_id'];
    $amountStopOfRoute = countStopOfRoute($routeId);

    $isGoing = findDirectionByBus($busId);

    $stopOfCurrentDrive = $countOfStop % $amountStopOfRoute;
    $currentOrder =  $isGoing ? $stopOfCurrentDrive : $amountStopOfRoute - $stopOfCurrentDrive;

    $routeStopList = DB::fetchAll('route_stop');
    $nowStop = array_filter($routeStopList, function ($routeStop) use ($routeId, $currentOrder) {
        return $routeId == $routeStop['route_id'] && $currentOrder == $routeStop['route_order'];
    });

    return DB::find('stop', array_values($nowStop)[0]['stop_id']);
}

/**
 * =============================================================================
 * = 查詢公車現在方向
 * =============================================================================
 *
 * @param String $busId
 * @return String
 *
 **/
function findDirectionByBus($busId)
{
    $bus = DB::find('bus', $busId);
    $departureTime = $bus['time'];
    $countOfStop = countStopBusPassed($departureTime);

    if ($countOfStop < 0) {
        return '尚未發車';
    }

    $routeId = $bus['route_id'];
    $amountStopOfRoute = countStopOfRoute($routeId);

    return floor($countOfStop / $amountStopOfRoute) / 2 == 0 ? '1' : '0';
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

    $routeListByStop = array_map(function ($routeStop) {
        return DB::find('route', $routeStop['route_id']);
    }, $routeStopListByStop);

    return $routeListByStop;
}
/**
 * =============================================================================
 * = 搜尋路線顯示站牌
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

    $stopNameByRoute = array_map(function ($routeStop) {
        return DB::find('stop', $routeStop['stop_id']);
    }, $routeStopListByRoute);

    return $stopNameByRoute;
}

/**
 * =============================================================================
 * = 依乘客找出收藏清單
 * =============================================================================
 *
 * @param String $passengerId
 * @return Array
 *
 **/
function getCollectByPassenger($passengerId)
{
    $user = DB::find('passenger', $passengerId);

    $collectList = DB::fetchAll('collect');
    $collectListByPassenger = [];

    foreach ($collectList as $key => $collect) {

        //獲得預約記錄之站牌資訊
        $stop = DB::find('stop', $collect['stop_id']);
        $route = DB::find('route', $collect['route_id']);

        if ($collect['passenger_id'] === $user['passenger_id']) {
            array_push($collectListByPassenger, [
                'collect' => $collect,
                'route' => $route,
                'stop'  => $stop
            ]);
        }
    };

    return $collectListByPassenger;
}

/**
 * =============================================================================
 * = 依乘客找出預約上車記錄
 * =============================================================================
 *
 * @param String $passengerId
 * @return Array
 *
 **/
function getGetOnByPassenger($passengerId)
{
    $user = DB::find('passenger', $passengerId);

    $getOnList = DB::fetchAll('geton');
    $getOnListByPassenger = [];

    foreach ($getOnList as $key => $getOn) {

        //獲得預約記錄之站牌資訊
        $stop = DB::find('stop', $getOn['stop_id']);
        $bus = DB::find('bus', $getOn['bus_id']);
        $route = DB::find('route', $bus['route_id']);

        if ($getOn['passenger_id'] == $user['passenger_id']) {
            array_push($getOnListByPassenger, [
                'geton' => $getOn,
                'bus'   => $bus,
                'route' => $route,
                'stop'  => $stop
            ]);
        }
    };

    return $getOnListByPassenger;
}

/**
 * =============================================================================
 * = 依乘客找出預約上車記錄
 * =============================================================================
 *
 * @param String $passengerId
 * @return Array
 *
 **/
function getGetOffByPassenger($passengerId)
{
    $user = DB::find('passenger', $passengerId);

    $getOffList = DB::fetchAll('getoff');
    $getOffListByPassenger = [];

    foreach ($getOffList as $key => $getOff) {

        //獲得預約記錄之站牌資訊
        $stop = DB::find('stop', $getOff['stop_id']);
        $bus = DB::find('bus', $getOff['bus_id']);
        $route = DB::find('route', $bus['route_id']);

        if ($getOff['passenger_id'] == $user['passenger_id']) {
            array_push($getOffListByPassenger, [
                'getoff' => $getOff,
                'bus'   => $bus,
                'route' => $route,
                'stop'  => $stop
            ]);
        }
    };

    return $getOffListByPassenger;
}


/**
 * =============================================================================
 * = 依乘客找出黑名單紀錄
 * =============================================================================
 *
 * @param String $passengerId
 * @return Array
 *
 **/
function getBlackListByPassenger($passengerId)
{
    $user = DB::find('passenger', $passengerId);

    $blackList = DB::fetchAll('getoff');
    $blackListByPassenger = [];

    foreach ($blackList as $key => $black) {

        if ($black['passenger_id'] == $user['passenger_id']) {
            array_push($blackListByPassenger, [
                'black' => $black,
                'user'   => $user,
            ]);
        }
    };

    return $blackListByPassenger;
}

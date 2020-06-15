<?php
    require  'db.php';
    session_start();
    //找公車
    function findroutebystop($conn, $search)
    {
        $stmt =$conn->prepare("SELECT route_name from `route_stop as rs,route as r,stop as s` WHERE `stop_name` LIKE :search 
        And s.stop_id=rs.stop_id And rs.route_id=r.route_id");
        $stmt->execute();

        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    function findroute($conn, $search)
    {
        $stmt =$conn->prepare("SELECT route_name from `route` Where`route_name` Like :search");
        $stmt->execute();

        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    //註冊
    function addpassenger($conn, $passenger_account,$passenger_password,$passenger_name)
    {
        $stmt =$conn->prepare("INSERT INTO users (passenger_account, passenger_password, passenger_name) VALUES (:passenger_account, :passenger_password, :passenger_name) ");
        $stmt->execute([
            'account' => $passenger_account,
            'password' => $passenger_password,
            'name' => $passenger_name
        ]);

        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    //登入
    function findpassengerid($conn, $passenger_account)
    {
        $stmt =$conn->prepare("SELECT * from `passenger` Where passenger_account =:passenger_account ");
        $stmt->bindParam(':passenger_account', $passenger_account);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    function finddriverid($conn, $driver_account)
    {
        $stmt =$conn->prepare("SELECT * from `driverr` Where driver_account =:driverr_account ");
        $stmt->bindParam(':driver_account', $driver_account);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    //黑名單
    function addblacktime($conn, $data)
    {
        $sql = "INSERT INTO `black_list` (`passenger_id`, `black_time`) VALUES (:passenger_id, :black_time) ";
    $stmt = $conn->prepare($sql);
    $blackData = [
        'passenger_id'       => $data['passenger_id'], /**完成資料綁定 */
        'black_time'    => $data['black_time'], /**完成資料綁定 */
    ];
    return $stmt->execute($blackData);

    }
    function findblacktime($conn, $passenger_id)
    {
        $stmt =$conn->prepare("SELECT * from `black_list` Where `passenger_id`=$passenger_id");
        $stmt->execute();

        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    //上下車
    function findgeton($conn, $passenger_id)
    {
        $stmt =$conn->prepare("SELECT * from `geton` Where `passenger_id`=$passenger_id");
        $stmt->execute();

        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    function findgetoff($conn, $passenger_id)
    {
        $stmt =$conn->prepare("SELECT * from `getoff` Where `passenger_id`=$passenger_id");
        $stmt->execute();

        $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;

    }
    //以下不是
function stoplistname($conn, $d_account)
{
    $stmt = $conn->prepare("SELECT stop_name from `stop` where stop_id in 
                                (select stop_id from `route_stop` where route_id = 
                                    (select route_id from `bus` where d_account = '$d_account'))");
    $stmt->execute();

    $stoplistname = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $stoplistname;
}

function updatedepart($conn, $d_account, $data=[])
{    
    $sql = "UPDATE bus set `depart`=:depart where d_account = '{$d_account}'";
    //var_dump($d_account);
    $stmt = $conn->prepare($sql);
    //完成要修改的使用者資料陣列
    $updatedepartData =[
        'depart' => $data['depart'] ?? date('Y-m-d H:i:s'),
    ];
    $time=$stmt->execute($updatedepartData);
    //var_dump($time);
    return $time;//回傳 新建資料的結果(true or false)
}

function updatenextstop($conn, $d_account, $data=[])
{ 
    $sql = "UPDATE bus set `nextstop`=:nextstop where d_account = '{$d_account}'";
    //var_dump($d_account);
    $stmt = $conn->prepare($sql);
    //完成要修改的使用者資料陣列
    $updatenextstopData =[
        'nextstop' => $data['nextstop'],
    ];
    $nextstop=$stmt->execute($updatenextstopData);
    //var_dump($time);
    return $nextstop;//回傳 新建資料的結果(true or false)
}

?>

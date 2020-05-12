<?php
    require  'db.php';
    session_start();
    
    function fetchAllUser($conn)
{
    $stmt = $conn->prepare('SELECT * FROM bus');
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_CLASS,'BUS');
}
    

    function findDriverByBUS($conn, $d_account)
{
    $stmt = $conn->prepare('SELECT * FROM bus where d_account = :d_account');
    $stmt->bindParam(':d_account', $d_account);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findStopByBUS($conn, $d_account)
{
    $stmt = $conn->prepare("SELECT * from `stop` where stop_id in 
                                (select stop_id from `route_stop` where route_id = 
                                    (select route_id from `bus` where d_account = '$d_account'))");
    $stmt->execute();

    $stoplist = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $stoplist;
}

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

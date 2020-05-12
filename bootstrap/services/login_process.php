<?php
require  '../db.php';
require '../sql.php';


$d_account = $_POST["d_account"] ?? "";
$d_password = $_POST["d_password"] ?? "";
$driver=findDriverByBUS($conn, $d_account);


/*$user = ["d_account"=>$d_account, "d_password"=>$d_password];
var_dump($user);
var_dump($driver["D_PASSWORD"]);
die();
*/

//查詢使用者是否存在
if ($driver && $d_password==$driver["D_PASSWORD"]) {
    $_SESSION["d_account"] = $d_account;
    $_SESSION["d_name"] = $driver["D_NAME"];
    header("Location:../driverpage.php");
} else {
    $msg = "登入失敗!";
    header("Location:../login.php?msg=" . $msg);
    die();
}
?>
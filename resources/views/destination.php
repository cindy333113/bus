<!DOCTYPE html>
<html lang="en">
  <head>
    <title>公車查詢</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
      
  </head>
  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">Hey Bus</a>
	      <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
            
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav nav ml-auto">
	          <li class="nav-item"><a href="index.php" class="nav-link"><span>首頁</span></a></li>
	          <li class="nav-item"><a href="myfavourite.php" class="nav-link"><span>我的最愛</span></a></li>
	          <li class="nav-item"><a href="booking.php" class="nav-link"><span>預約</span></a></li>
	          <li class="nav-item"><a href="route.php" class="nav-link"><span>路線規劃</span></a></li>
	          <li class="nav-item"><a href="login.php" class="nav-link"><span>登入/註冊</span></a></li>
              <li class="nav-item"><a class="nav-link"><span>|</span></a>
	          <li class="nav-item"><a href="english.php" class="nav-link"><span>English</span></a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
<?php

// 定義資料庫資訊
$DB_NAME = "hey bus"; // 資料庫名稱
$DB_USER = "root"; // 資料庫管理帳號
$DB_PASS = "12345678"; // 資料庫管理密碼
$DB_HOST = "localhost"; // 資料庫位址

// 連接 MySQL 資料庫伺服器
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
if (empty($con)) {
    print mysqli_error($con);
    die("資料庫連接失敗！");
    exit;
}

// 選取資料庫
if (!mysqli_select_db($con, $DB_NAME)) {
    die("選取資料庫失敗！");
} else {
    echo "連接 " . $DB_NAME . " 資料庫成功！<br>";
}

// 設定連線編碼
mysqli_query($con, "SET NAMES 'UTF-8'");

// 取得資料
$sql = "SELECT * FROM route,route_stop,stop";
$result = mysqli_query($con, $sql);

$sql2 = "SELECT * FROM `route_stop` WHERE `route_id` = 1";
$result2 = mysqli_query($con, $sql2);
      
$sql3 = "SELECT * FROM `route_stop` WHERE `route_id` = 2";
$result3 = mysqli_query($con, $sql3);

// 獲得資料筆數
if ($result) {
    $num = mysqli_num_rows($result);
    echo $num . " 筆資料<br>";
}

if ($result2) {
    $num2 = mysqli_num_rows($result2);
    echo $num2 . " 筆資料<br>";
}
      
if ($result3) {
    $num3 = mysqli_num_rows($result3);
    echo $num3 . " 筆資料<br>";
}
      
?>
    <section class="ftco-section contact-section ftco-no-pb" id="contact-section">
    <div id="home-section" class="hero"> 
      <div class="container">
      	<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">公車查詢</h2>
          </div>
        </div>

        <button class="tablink" onclick="openCity('235', this, 'grey')" id="defaultOpen">235</button>
        <button class="tablink" onclick="openCity('842', this, 'grey')">842</button>

        <form action="#" class="bg-light p-4 p-md-5 contact-form">
        <div class="form">
            
        <div id="235" class="tabcontent">
        <table class = "table table-hover">
        <tr align=center>
            <td>編號</td>
            <td>站牌編號</td>
            <td>站牌</td>
            <td>站牌</td>
        </tr>

        <tr align=center>
        <td><?php $result = mysqli_query($con, $sql2);
        while ($rowA = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        printf($rowA["route_order"]);
        }?>
        </td>
        <td><?php $result = mysqli_query($con, $sql2);
        while ($rowB = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        printf($rowB["stop_id"]);
        }?>
        </td>
        <td><?php $result2 = mysqli_query($con, $sql2);
        while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        printf($row["stop_name"]);
        }?>
        </td>
        <td><?php $result2 = mysqli_query($con, $sql2);
        while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        printf($row["stop_name"]);
        }?>
        </td>
        </tr>
        <?php
        $conn = null; 
        ?>
        </table>
        </div>
            
        <div id="842" class="tabcontent">
        <table class = "table table-hover">
        <tr align=center>
            <td>編號</td>
            <td>站牌編號</td>
            <td>站牌</td>
        </tr>

        <tr align=center>
        <td><?printf($rowC[2])?></td>
        <td><?=$rowB->stop_id?></td>
        <td><?=$sql->stop_name?></td>
        </tr>
        <?php
        $conn = null; 
        ?>
        </table>
        </div>
            
        </div>
        </form>
      </div>
     </div>
    </section>


    <footer class="ftco-footer ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  
<script>
function openCity(cityName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(cityName).style.display = "block";
  elmnt.style.backgroundColor = color;

}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  
  <script src="js/main.js"></script>
    
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
<?php
if(empty($isdriver)){
	render("/driverlogin");
	die;
}
?>
  <head>
    <title>黑名單</title>
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
    <meta name="description" content="Login Form - Responsive Template">
    <link rel="shortcut icon" href="images/favicon.ico">


<link rel="stylesheet" href="css/style2.css">

    <style>
    input[type="submit"]{padding:5px 15px; background:#ccc; border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; }
    
    input[type="text"]{padding:5px 15px; border:2px black solid;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; }

    </style>
  </head>

  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
         <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target" id="ftco-navbar">
	     <div class="container">
	      <a class="navbar-brand" href="/index">Heybus</a>
	      <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav nav ml-auto">
          <li class="nav-item"><a href="/manage" class="nav-link"><span>司機首頁</span></a></li>
          <li class="nav-item"><a href="/blacklist" class="nav-link"><span>黑名單</span></a></li>
          <li class="nav-item"><a class="nav-link" action="/logout" href="/logout"><span>登出</span></a></li> 
          <li class="nav-item"><a class="nav-link"><span>|</span></a></li>
          <li class="nav-item"><a class="nav-link" href="/english"><span>English</span></a></li>
        </ul>   
       </div>
     </div>
   </nav>
     <table class="table table-striped"  style="text-align:center">

<br>
<br>
<br>
  <thead class="thead-dark">

                          
    <tr>
      <th scope="col">使用者ID</th>
      <th scope="col">使用者姓名</th>
      <th scope="col">違規日期</th>
    </tr>
  </thead>
    <tbody> <?php foreach ($a as $key => $blacklistdata) { ?>
        <tr>
          <td><?= $blacklistdata['passenger_id'] ?></td>
          <td><?= $blacklistdata['passenger_name'] ?></td>
          <td><?= $blacklistdata['black_time'] ?></td>
        </tr>
      <?php } ?></tbody>

  </table>



  <!-- jquery latest version -->
  <script src="js/jquery.min.js"></script>
  <!-- popper.min.js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Jquery Rippler js -->
  <script src="js/jquery.rippler.min.js"></script>
  <!-- script js -->
  <script src="js/script.js"></script>

</body>

</html>
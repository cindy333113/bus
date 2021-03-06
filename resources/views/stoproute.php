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
          <li class="nav-item"><a href="/index" class="nav-link"><span>首頁</span></a></li>
          <li class="nav-item"><a href="/myfavourite" class="nav-link"><span>我的最愛</span></a></li>
          <li class="nav-item"><a href="/geton" class="nav-link"><span>預約上車</span></a></li>
          <li class="nav-item"><a href="/getoff" class="nav-link"><span>預約下車</span></a></li>
          <li class="nav-item"><a href="/planroute" class="nav-link"><span>路線規劃</span></a></li>
          <li class="nav-item"><a href="/destination" class="nav-link"><span>公車查詢</span></a></li>
          <li class="nav-item"><a class="nav-link" href="/logout"><span>登出</span></a></li>
          <li class="nav-item"><a class="nav-link"><span>|</span></a></li>
          <li class="nav-item"><a class="nav-link" href="/english"><span>English</span></a></li>
        </ul>
      </div>
    </div>
  </nav>



  <section class="ftco-section contact-section ftco-no-pb" id="contact-section">
    <div id="home-section" class="hero">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">公車查詢</h2>
          </div>
        </div>

        <div>
          <h2><?= $stop_name ?></h2>
          <?php foreach ($routeListByStop as $key => $route) { ?>
            <h3><?= $route['route_name'] ?></h3>
          <?php } ?>

        </div>



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
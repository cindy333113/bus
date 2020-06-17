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
	          <li class="nav-item"><a href="/login" class="nav-link"><span>登入/註冊</span></a></li>
              <li class="nav-item"><a class="nav-link"><span>|</span></a>
	          <li class="nav-item"><a href="/english" class="nav-link"><span>English</span></a></li>
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

        <button class="tablink" onclick="openCity('235', this, 'grey')" id="defaultOpen">235</button>
        <button class="tablink" onclick="openCity('842', this, 'grey')">842</button>

        <form action="#" class="bg-light p-4 p-md-5 contact-form">
        <div class="form">
            
        <div id="235" class="tabcontent">
        <table class = "table table-hover">
        <tr align=center>
            <td>編號</td>
            <td>站牌</td>
        </tr>

        <tr align=center>
        <td></td>
        <td></td>
        </tr>
          
        </table>
        </div>
            
        <div id="842" class="tabcontent">
        <table class = "table table-hover">
        <tr align=center>
            <td>編號</td>
            <td>站牌</td>
        </tr>

        <tr align=center>
        <td></td>
        <td></td>
        </tr>
            
        </table>
        </div>
            
        </div>
        </form>
      </div>
     </div>
    </section>

    
  
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
<!DOCTYPE html>
<html lang="en">

<head>
  <title>HeyBus</title>
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
      <a class="navbar-brand" href="english.php">Hey Bus</a>
      <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav nav ml-auto">
          <li class="nav-item"><a href="/index" class="nav-link"><span>Home</span></a></li>
          <li class="nav-item"><a href="i/myfavourite" class="nav-link"><span>My Favourite</span></a></li>
          <li class="nav-item"><a href="/geton" class="nav-link"><span>Get On</span></a></li>
          <li class="nav-item"><a href="/getoff" class="nav-link"><span>Get Off</span></a></li>
          <li class="nav-item"><a href="/planroute" class="nav-link"><span>Plan Route</span></a></li>
          <?php if (empty($userdata)) { ?> <li class="nav-item"><a href="/login" class="nav-link"><span>Login/Sign Up/span></a></li><?php } ?>
          <?php if (!empty($userdata)) { ?> <li class="nav-item"><a class="nav-link" href="/logout"><span>Logout</span></a></li> <?php } ?>
          <li class="nav-item"><a class="nav-link"><span>|</span></a></li>
          <li class="nav-item"><a class="nav-link" href="/index"><span>中文</span></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="home-section" class="hero">
    <img src="images/blob-shape-3.svg" class="svg-blob" alt="Colorlib Free Template">
    <div class="home-slider owl-carousel">

      <div class="slider-item">
        <div class="overlay"></div>
        <div class="container-fluid p-0">
          <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
            <div class="one-third order-md-last">
              <div class="img" style="background-image:url(images/1.jpg);">
                <div class="overlay"></div>
              </div>
              <div class="bg-primary">
                <div class="vr"><span class="pl-3 py-4" style="background-image: url(images/1.jpg);">Yangming</span></div>
              </div>
            </div>
            <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <div class="text">

                <section class="ftco-section ftco-services-2" id="services-section">
                  <div class="container">
                    <div class="row justify-content-center pb-5">
                      <div class="col-md-12 heading-section text-center ftco-animate">

                        <h2 class="mb-4">Latest News</h2><br>
                        <table>
                          <tr>
                            <th>2019.3.01</th>
                            <td>New bus is serving now.</td>
                          </tr>
                          <tr>
                            <th>2019.2.10</th>
                            <td>&nbsp;New version of the website is online.</td>
                          </tr>
                          <tr>
                            <th>2019.2.09</th>
                            <td>Must wear mask on a bus.</td>
                          </tr>
                        </table>
                      </div>
                      <div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="slider-item">
        <div class="overlay"></div>
        <div class="container-fluid p-0">
          <div class="row d-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
            <div class="one-third order-md-last">
              <div class="img" style="background-image:url(images/2.jpeg);">
                <div class="overlay"></div>
              </div>
              <div class="vr"><span class="pl-3 py-4" style="background-image: url(images/2.jpeg);">Huashan</span></div>
            </div>
            <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <div class="text">

                <section class="ftco-section ftco-services-2" id="services-section">
                  <div class="container">
                    <div class="row justify-content-center pb-5">
                      <div class="col-md-12 heading-section text-center ftco-animate">
                        <h2 class="mb-4">Our Service</h2>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services text-center d-block">
                          <div class="icon justify-content-center align-items-center d-flex"><span class="flaticon-world"></span></div>
                          <div class="media-body">
                            <h3 class="heading mb-3">Search for Bus</h3>
                            <p class="mb-0"><a href="#" class="btn btn-white px-4 py-3">More...</a></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services text-center d-block">
                          <div class="icon justify-content-center align-items-center d-flex"><span class="flaticon-tour-guide"></span></div>
                          <div class="media-body">
                            <h3 class="heading mb-3">My Favorite</h3><br>
                            <p class="mb-0"><a href="#" class="btn btn-white px-4 py-3">More...</a></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services text-center d-block">
                          <div class="icon justify-content-center align-items-center d-flex"><span class="flaticon-map-of-roads"></span></div>
                          <div class="media-body">
                            <h3 class="heading mb-3">Bus Stops Nearby</h3>
                            <p class="mb-0"><a href="#" class="btn btn-white px-4 py-3">More...</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="ftco-footer ftco-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">

          <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>
              document.write(new Date().getFullYear());
            </script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" /></svg></div>


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
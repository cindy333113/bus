<!DOCTYPE html>
<html lang="en">
<?php
if (empty($userdata)) {
  render("/login");
  die;
}
?>

<head>
  <title>HeyBus 預約上車</title>
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
  <link rel="stylesheet" href="css/customise.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="/index">heyBUS</a>
      <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav nav ml-auto">
          <li class="nav-item"><a href="/index" class="nav-link"><span>首頁</span></a></li>
          <li class="nav-item"><a href="/myfavourite" class="nav-link"><span>我的最愛</span></a></li>
          <li class="nav-item"><a href="/getoff" class="nav-link"><span>預約上車</span></a></li>
          <li class="nav-item"><a href="/getoff" class="nav-link"><span>預約下車</span></a></li>
          <li class="nav-item"><a href="/planroute" class="nav-link"><span>路線規劃</span></a></li>
          <li class="nav-item"><a href="/destination" class="nav-link"><span>公車查詢</span></a></li>
          <?php if (empty($userdata)) { ?> <li class="nav-item"><a href="/login" class="nav-link"><span>登入/註冊</span></a></li><?php } ?>
          <?php if (!empty($userdata)) { ?> <li class="nav-item"><a class="nav-link" action="/logout" href="/logout"><span>登出</span></a></li> <?php } ?>
          <li class="nav-item"><a class="nav-link"><span>|</span></a></li>
          <li class="nav-item"><a class="nav-link" href="/english"><span>English</span></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="ftco-section ftco-no-pb ftco-no-pt" style="position:relative; top: 100px">
    <div class="container">
      <div class="row justify-content-center pb-0 pb-mb-5 pt-5 pt-md-0">
        <div class="col-md-12 heading-section ftco-animate">
          <h2 class="mb-4">預約上車清單</h2>
        </div>
      </div>
      <section class="getoff">
        <div style="width:800px; height:auto;border-style:dotted;border-size:10px">
          <table class="myList" style="position:relative; margin: 35px;width:400px" action="/getoff" method="post">
            <tr>
              <td>公車號</td>
              <td>方向 </td>
              <td>站牌 </td>
              <td>公車現在位置</td>
              <td>需要協助</td>
              <td> 刪除 </td>
            </tr>

            <?php foreach ($List as $key => $getoffdata) { ?>
              <tr>
                <td><?= $getoffdata['route_name'] ?></td>
                <td><?= $getoffdata['direction'] ?></td>
                <td><?= $getoffdata['stop_name'] ?></td>
                <td><?= findStopNameByBus($getoffdata['bus_id']) ?></td>
                <td><?= $getoffdata['unusal'] ?></td>
                <td>
                  <form name="deleteForm" action="/getoff/delete" method="post">
                    <input type="hidden" name="getoff_id" value=<?= $getoffdata['getoff_id'] ?> />
                    <button type="submit" style="background:transparent;border:none;">
                      <span class="material-icons">
                        delete
                      </span>
                    </button>
                  </form>
                </td>

              </tr>
            <?php } ?>

            <!--
      <tr>
       <td>299</td>
       <td>迴龍</td>
       <td>捷運輔大站</td>
       <td>海山里</td>
       <td>否</td>
       <td><span class="material-icons"><a href="/myfavourite/delete">delete</a></span></td>
      </tr>
      <tr>
       <td>235</td>
       <td>土城</td>
       <td>新泰路口</td>
       <td>5 min</td>
       <td>是</td>
       <td><span class="material-icons">delete</span></td>
      </tr>
     -->
          </table>
        </div><br>
      </section>


      <form action="/getoff/add" method="POST">
        <div class="row">
          <h3>預約上車</h3><br>
          <div class="col-md-12">
            <div class="search-wrap-1 ftco-animate p-4">
              <form action="/getoff" method="post" class="search-property-1">
                <div class="row">

                  <div class="col-lg align-items-end">
                    <div class="form-group">

                      <label for="#">公車號</label>
                      <div class="form-field">
                        <input type="text" name="route_name" class="form-control" placeholder="輸入公車號">
                      </div>
                    </div>
                  </div>

                  <div class="col-lg align-items-end">
                    <div class="form-group">
                      <label for="#">方向</label>
                      <div class="form-field">
                        <div class="select-wrap">
                          <select name="direction" class="form-control" placeholder="選擇方向">
                            <option value="0">迴龍</option>
                            <option value="1">土城</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-lg align-items-end">
                  <div class="form-group">
                    <label for="#">是否需要特殊</label>
                    <div class="form-field">
                      <div class="select-wrap">
                        <select name="unusal" id="" class="form-control">
                          <option value="1">是</option>
                          <option value="0">否</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg align-items-end">
                    <div class="form-group">
                      <label for="#">站牌</label>
                      <div class="form-field">
                        <div class="select-wrap">
                        <select name="stop_name" id="" class="form-control">
                        <option value="西盛">西盛</option>
                            <option value="東方之星">東方之星</option>
                            <option value="西盛館">西盛館</option>
                            <option value="家麟新天地">家麟新天地</option>
                            <option value="正豐">正豐</option>
                            <option value="大唐江山">大唐江山</option>
                            <option value="台灣通用">台灣通用</option>
                            <option value="光華街口">光華街口</option>
                            <option value="新寶社區">新寶社區</option>
                            <option value="光華國小">光華國小</option>
                            <option value="福祿新城1">福祿新城1</option>
                            <option value="福祿新城2">福祿新城2</option>
                            <option value="民安路橋">民安路橋</option>
                            <option value="民安路">民安路</option>
                            <option value="後港社區">後港社區</option>

                          </select>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg align-self-end">
                      <div class="form-group">
                        <div class="form-field">
                          <input type="submit" value="新增" class="form-control btn btn-primary" onclick="/getoff/add" method="post">
                        </div>
                      </div>
                    </div>
              </form>
            </div>
      </form>

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
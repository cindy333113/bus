<?php

$reasonList = [
  0 => [
    'title' => '因不可抗力因素無法停車',
    'content' => '可能因塞車、車禍、路況不佳、或有其他因素無法停車'
  ],
  1 => [
    'title' => '因要駛上高速公路無法停車',
    'content' => '因應政府規定，駛上高速公路時車上乘客需要都有位置坐，如果沒有位置，不再讓乘客上車。'
  ],
  2 => [
    'title' => '因車上乘客已滿無法停車',
    'content' => '因車上乘客過多，沒有位置能夠乘載後面上車的乘客，不停車。'
  ],
  3 => [
    'title' => '因其他特殊原因無法停車',
    'content' => '可能因車上有發生突發狀況、其他緊急情況，司機不能夠停車。'
  ],
  4 => [
    'title' => '長得太可愛',
    'content' => '長相太甜美，讓司機分心無法好好開車。'
  ]
]

?>
<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . "/head.php"; ?>

<body>

  <?php include __DIR__ . "/header.php"; ?>

  <!-- main wrapper start -->
  <main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area common-bg">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="breadcrumb-wrap">
              <nav aria-label="breadcrumb">
                <h1>黑名單</h1>
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">黑名單列表</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-space pb-0" style="margin-bottom: 80px;">
      <div class="container">
        <div class="row">
          <!-- Order Summary Details -->
          <div class="col-lg-12">
            <div class="order-summary-details">
              <h2 style="text-align:center;">黑名單</h2>
              <div class="order-summary-content">
                <!-- Order Summary Table -->
                <div class="order-summary-table table-responsive text-center">
                  <?php if (isset($blackList)) { ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th><strong>黑名單姓名</strong></th>
                          <th><strong>標題</strong></th>
                          <th><strong>事由</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($blackList as $key => $black) { ?>
                          <tr>
                            <td>
                              <?= DB::find('passenger',$black['passenger_id'])['passenger_name'] ?>
                            </td>
                            <td>
                              <?= $reasonList[$key]['title'] ?>
                            </td>
                            <td>
                              <?= $reasonList[$key]['content'] ?>
                            </td>
                          </tr>
                        <?php } ?>
                    </table>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- checkout main wrapper end -->
    </div>
  </main>
  <!-- main wrapper end -->

  <?php include __DIR__ . "/footer.php"; ?>

  <!--All Vendor Js -->
  <script src="/assets/js/vendor.js"></script>
  <!-- Active Js -->
  <script src="/assets/js/active.js"></script>
</body>

</html>

<!--
<div class="content">
  <div class="container">
    <div class="col-md-6 content-top1">
      <img src="images/car1.jpg" class="img-responsive" alt="">
      <div class="content-plan">

        <h6>因不可抗力因素無法停車</a></h6>
        <p>可能因塞車、車禍、路況不佳、或有其他因素無法停車，請選擇這個。</p>
      </div>
      <a href="#"><span class="locations">通知乘客</span></a>
    </div>
    <div class="col-md-6 content-top1">
      <img src="images/car2.jpg" class="img-responsive" alt="">
      <div class="content-plan">

        <h6>因要駛上高速公路無法停車</h6>
        <p>因應政府規定，駛上高速公路時車上乘客需要都有位置坐，如果沒有位置，不再讓乘客上車。</p>
      </div>
      <a href="#"><span class="locations">通知乘客</span></a>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="col-md-6 content-top1">
      <img src="images/car3.jpg" class="img-responsive" alt="">
      <div class="content-plan">

        <h6>因車上乘客已滿無法停車</h6>
        <p>因車上乘客過多，沒有位置能夠乘載後面上車的乘客，不停車。</p>
      </div>
      <a href="#"><span class="locations">通知乘客</span></a>
    </div>
    <div class="col-md-6 content-top1">
      <img src="images/car4.jpg" class="img-responsive" alt="">
      <div class="content-plan">

        <h6>因其他特殊原因無法停車</h6>
        <p>可能因車上有發生突發狀況、其他緊急情況，司機不能夠停車</p>
      </div>
      <a href="#"><span class="locations">通知乘客</span></a>
    </div>

                        -->
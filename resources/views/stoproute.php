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
                <h1>路線規劃</h1>
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page">路線規劃</li>
                  <li class="breadcrumb-item active" aria-current="page">站牌資訊</li>
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
          <div class="col-lg-5">
            <div class="order-summary-details">
              <h2 style="text-align:center;">站牌名稱：<strong><?= $stopＮame ?></strong></h2>
            </div>
          </div>

          <!-- Order Summary Details -->
          <div class="col-lg-7">
            <div class="order-summary-details">
              <h2 style="text-align:center;">站牌經過路線</h2>
              <div class="order-summary-content">
                <!-- Order Summary Table -->
                <div class="order-summary-table table-responsive text-center">
                  <?php if (isset($routeList)) { ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th><strong>路線名稱</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($routeList as $key => $route) { ?>
                          <tr>
                            <td>
                              <form name="routeSearch_<?=$route['route_id']?>" action="/destination/routesearch" method="post">
                                <input type="hidden" name="route_id" value=<?= $route['route_id'] ?> />
                                <a style="color: #6b6b6b;" href="javascript:document.routeSearch_<?=$route['route_id']?>.submit();">
                                  <?= $route['route_name'] ?>
                                </a>
                              </form>
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
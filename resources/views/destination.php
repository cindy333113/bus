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
                  <li class="breadcrumb-item active" aria-current="page">路線資訊</li>
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
          <!-- Checkout Billing Details -->
          <div class="col-lg-6">
            <div class="checkout-billing-details-wrap">
              <h2>查找公車路線</h2>
              <div class="billing-form-wrap">
                <form name="routeSearch" action="/destination/routesearch" method="post">
                  <div class="row">
                    <div class="col-md-7">
                      <div class="align-items-start">
                        <label for="route">公車路線 :</label>
                        <div class="form-field">
                          <select id="route" name="route_id" class="nice-select" style="width:100%;">
                            <?php foreach ($routeList as $key => $route) { ?>
                              <option value="<?= $route['route_id'] ?>" <?= $route['route_id'] === ($routeId ?? '') ? 'selected':'' ?>><?= $route['route_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-5">
                      <div class="align-items-end" style="padding-top: 30px;">
                        <div class="form-group">
                          <div class="action_link">
                            <a class="btn btn-cart2" href="javascript:document.routeSearch.submit();">查詢路線</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Order Summary Details -->
          <div class="col-lg-6">
            <div class="order-summary-details">
              <h2>公車路線 站牌資訊</h2>
              <div class="order-summary-content">
                <!-- Order Summary Table -->
                <div class="order-summary-table table-responsive text-center">
                  <?php if (isset($stopNameByRoute)) { ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th><strong>去程</strong></th>
                          <th><strong>回程</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($stopNameByRoute as $key => $stop) { ?>
                          <tr>
                            <td><a href="/destination/stopsearch/<?= $stop['stop_id'] ?>" style="color: #6b6b6b;"><?= $stop['stop_name'] ?></a></td>
                            <td><a href="/destination/stopsearch/<?= $stop['stop_id'] ?>" style="color: #6b6b6b;"><?= array_reverse($stopNameByRoute)[$key]['stop_name'] ?></a></td>
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
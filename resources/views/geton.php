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
                <h1>預約上車</h1>
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page">預約系統</li>
                  <li class="breadcrumb-item active" aria-current="page">預約上車</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- wishlist main wrapper start -->
    <div class="wishlist-main-wrapper section-space pb-0">
      <div class="container">
        <!-- Wishlist Page Content Start -->
        <div class="section-bg-color">
          <div class="row">
            <div class="col-lg-12">
              <!-- Wishlist Table Area -->
              <div class="cart-table table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="pro-thumbnail">公車號</th>
                      <th class="pro-quantity">方向</th>
                      <th class="pro-price">站牌</th>
                      <th class="pro-title">公車現在位置</th>
                      <th class="pro-subtotal">需要協助</th>
                      <th class="pro-remove"> 刪除</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php var_dump($user);foreach ($List as $key => $getondata) { ?>
                      <tr>
                        <td class="pro-thumbnail">
                          <a href="#">
                            <?= $getondata['route_name'] ?>
                          </a>
                        </td>
                        <td class="pro-quantity">
                          <a href="#">
                            <?= $getondata['getonRecord']['direction']??'' ?>
                          </a>
                        </td>
                        <td class="pro-price">
                          <span>
                            <?= $getondata['stop_name'] ?>
                          </span>
                        </td>
                        <td class="pro-title">
                          <span class="text-success">
                            <?= findStopNameByBus($getondata['getonRecord']['bus_id']) ?>
                          </span>
                        </td>
                        <td class="pro-subtotal">
                            <?= $getondata['getonRecord']['unusal'] ? '✔︎':'✗' ?>
                        </td>
                        <td class="pro-remove">
                          <form name="deleteForm" action="/geton/delete" method="post">
                            <input type="hidden" name="id" value=<?= $getondata['getonRecord']['geton_id'] ?> />
                            <span><i class="fa fa-trash-o"></i></span>
                          </form>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Wishlist Page Content End -->
      </div>
    </div>
    <!-- wishlist main wrapper end -->

    <section class="ftco-section ftco-no-pb ftco-no-pt" style="position:relative; top: 100px">
      <div class="container">
        <div class="row justify-content-center pb-0 pb-mb-5 pt-5 pt-md-0">
          <div class="col-md-12 heading-section ftco-animate">
            <h2 class="mb-4">預約上車清單</h2>
          </div>
        </div>
        <section class="geton">
          <div style="width:800px; height:auto;border-style:dotted;border-size:10px">
            <table class="myList" style="position:relative; margin: 35px;width:400px" action="/geton" method="post">
              <tr>
                <td>公車號</td>
                <td>方向 </td>
                <td>站牌 </td>
                <td>公車現在位置</td>
                <td>需要協助</td>
                <td> 刪除 </td>
              </tr>

              <?php foreach ($List as $key => $getondata) { ?>
                <tr>
                  <td><?= $getondata['route_name'] ?></td>
                  <td><?= $getondata['direction'] ?></td>
                  <td><?= $getondata['stop_name'] ?></td>
                  <td><?= findStopNameByBus($getondata['bus_id']) ?></td>
                  <td><?= $getondata['bus_id'] ?></td>
                  <td>
                    <form name="deleteForm" action="/geton/delete" method="post">
                      <input type="hidden" name="id" value=<?= $stop['geton_id'] ?> />
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


        <form action="/geton/add" method="POST">
          <div class="row">
            <h3>預約上車</h3><br>
            <div class="col-md-12">
              <div class="search-wrap-1 ftco-animate p-4">
                <form action="/geton" method="post" class="search-property-1">
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
                              <option value="捷運輔大站">捷運輔大站</option>
                              <option value="盲人重建院">盲人重建院</option>
                              <option value="">海山里</option>
                              <option value="">新泰中正路口</option>
                              <option value="">材試所</option>
                              <option value="">新泰國中南站</option>
                              <option value="">新莊棒球場</option>
                              <option value="">新莊體育場</option>
                              <option value="">新莊田徑場</option>
                              <option value="">財元廣場</option>
                              <option value="">中華路</option>
                              <option value="">正邦社區</option>
                              <option value="">幸福中華路口</option>
                              <option value="">幸福新城</option>

                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg align-self-end">
                        <div class="form-group">
                          <div class="form-field">
                            <input type="submit" value="新增" class="form-control btn btn-primary" onclick="geton/add" method="post">
                          </div>
                        </div>
                      </div>
                </form>
              </div>
        </form>

      </div>
    </section>

  </main>
  <!-- main wrapper end -->

  <?php include __DIR__ . "/footer.php"; ?>

  <!--All Vendor Js -->
  <script src="/assets/js/vendor.js"></script>
  <!-- Active Js -->
  <script src="/assets/js/active.js"></script>
</body>

</html>
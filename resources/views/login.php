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
                <h1>乘客 / 司機登入</h1>
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">使用者登入</li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- login register wrapper start -->
    <div class="login-register-wrapper section-space pb-0">
      <div class="container">
        <div class="member-area-from-wrap">
          <div class="row">
            <!-- Passenger Login Content Start -->
            <div class="col-lg-6">
              <div class="login-reg-form-wrap">
                <h2>乘客登入</h2>
                <form action="/login" method="post">
                  <input type="hidden" name="identity" value="passenger" />
                  <div class="single-input-item">
                    <input type="account" placeholder="請輸入使用者帳號" required />
                  </div>
                  <div class="single-input-item">
                    <input type="password" placeholder="請輸入密碼" required />
                  </div>
                  <div class="single-input-item">
                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                      <!--
                      <div class="remember-meta">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="rememberMe">
                          <label class="custom-control-label" for="rememberMe">Remember Me</label>
                        </div>
                      </div>
                    -->
                      <a href="/register" class="forget-pwd">還沒有帳號？</a>
                    </div>
                  </div>
                  <div class="single-input-item">
                    <button class="btn btn__bg">確認登入</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Passenger Login Content End -->

            <!-- Driver Login Content Start -->
            <div class="col-lg-6">
              <div class="login-reg-form-wrap">
                <h2>司機登入</h2>
                <form action="/login" method="post">
                  <input type="hidden" name="identity" value="driver" />
                  <div class="single-input-item">
                    <input type="account" placeholder="請輸入使用者帳號" required />
                  </div>
                  <div class="single-input-item">
                    <input type="password" placeholder="請輸入密碼" required />
                  </div>
                  <!-- 登入選項
                  <div class="single-input-item">
                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                      <div class="remember-meta">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="rememberMe">
                          <label class="custom-control-label" for="rememberMe">Remember Me</label>
                        </div>
                      </div>
                      <a href="#" class="forget-pwd">Forget Password?</a>
                    </div>
                  </div>
                  -->
                  <div class="single-input-item">
                    <button class="btn btn__bg">確認登入</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- Driver Login Content End -->
          </div>
        </div>
      </div>
    </div>
    <!-- login register wrapper end -->
  </main>
  <!-- main wrapper end -->

  <!-- Scroll to top start -->
  <div class="scroll-top not-visible">
    <i class="fa fa-angle-up"></i>
  </div>
  <!-- Scroll to Top End -->

  <!-- All vendor & plugins & active js include here -->
  <!--All Vendor Js -->
  <script src="assets/js/vendor.js"></script>
  <!-- Active Js -->
  <script src="assets/js/active.js"></script>
</body>

</html>
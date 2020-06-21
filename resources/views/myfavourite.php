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
								<h1>我的最愛</h1>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">收藏站牌</li>
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
											<th class="pro-price">站牌</th>
											<th class="pro-remove"> 刪除</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($collectList as $key => $collect) { ?>
											<tr>
												<td class="pro-thumbnail">
													<?= $collect['route']['route_name'] ?>
												</td>
												<td class="pro-price">
													<span>
														<?= $collect['stop']['stop_name'] ?>
													</span>
												</td>
												<td class="pro-remove">
													<form name="deleteForm" action="/passenger/geton/delete" method="post">
														<input type="hidden" name="id" value=<?= $collect['collect']['collect_id'] ?> />
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

		<!-- page main wrapper start -->
		<div class="shop-main-wrapper section-space">
			<div class="container">
				<div class="row">
					<!-- product details wrapper start -->
					<div class="col-lg-12 order-1 order-lg-2">
						<!-- product details inner end -->
						<div class="product-details-inner">
							<div class="row">
								<div class="col-lg-12">
									<h2 class="mb-4">新增收藏</h2>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="align-items-end" style="padding-top: 5px;">
										<div class="form-group">
											<label for="#">公車路線 :</label>
											<div class="form-field">
												<select name="route_id" class="nice-select">
													<?php foreach ($routeList as $key => $route) { ?>
														<option value="<?= $route['route_id'] ?>"><?= $route['route_name'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>

									<div class="align-items-end" style="padding-top: 30px;">
										<div class="form-group">
											<label for="#">站牌名稱</label>
											<div class="form-field">
												<select name="direction" class="nice-select">
													<?php foreach ($stopList as $key => $stop) { ?>
														<option value="<?= $stop['stop_id'] ?>"><?= $stop['stop_name'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="align-items-end" style="padding-top: 30px;">
										<div class="form-group">
											<div class="action_link">
												<a class="btn btn-cart2" href="#">新增收藏</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- product details inner end -->
				</div>
				<!-- product details wrapper end -->
			</div>
		</div>
		<!-- page main wrapper End -->

	</main>
	<!-- main wrapper end -->

	<?php include __DIR__ . "/footer.php"; ?>

	<!--All Vendor Js -->
	<script src="/assets/js/vendor.js"></script>
	<!-- Active Js -->
	<script src="/assets/js/active.js"></script>
</body>

</html>
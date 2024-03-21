<!DOCTYPE html>
<html lang="es">


<head>
	<title>Detalles del Producto</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
</head>

<body class="animsition">

	<!-- Header -->
	<?php require_once "../html/MainHeader.php"; ?>

	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">
				Men
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Lightweight Jacket
			</span>
		</div>
	</div>


	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">

						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div id="img-slide" class="slick3 gallery-lb">
								<div class="item-slick3" data-thumb="../../public/images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="../../public/images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../public/images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								<div class="item-slick3" data-thumb="../../public/images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="../../public/images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../public/images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								<div class="item-slick3" data-thumb="../../public/images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="../../public/images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../public/images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								<div class="item-slick3" data-thumb="../../public/images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="../../public/images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../public/images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
								<div class="item-slick3" data-thumb="../../public/images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="../../public/images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../public/images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 id="tv-nombre" class="mtext-105 cl2 js-name-detail p-b-14">
							Espere....
						</h4>

						<span id="tv-precio" class="mtext-106 cl2">
							$00.00
						</span>

						<p id="tv-descripcion" class="stext-102 cl3 p-t-23">
							Espere...
						</p>

						<!--  -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Talla
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="select_talla" class="js-select2" name="time">
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Color
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="select-color" class="js-select2" name="time">
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>
							<div class="flex-c-m respon6">
								<p id="stock">0 Unidades Disponibles</p>
							</div>
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div id="disminuir" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input id="input_stock" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

										<div id="sumar" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

									<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
										Agregar al carrito
									</button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
	</section>
	<?php require_once "../html/footer.php"; ?>
	<?php require_once "../html/MainJS.php"; ?>
	<script src="content.js"></script>

</body>

</html>
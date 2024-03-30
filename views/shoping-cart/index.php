<!DOCTYPE html>
<html lang="es">

<head>
	<title>Shoping Cart</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
</head>

<body class="">


	<!-- Header -->
	<?php require_once "../html/MainHeader.php"; ?>


	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Carrito de compras
			</span>
		</div>
	</div>


	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table id="contenttable" class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Producto</th>
									<th class="column-2"></th>
									<th class="column-3">Precio</th>
									<th class="column-4">Talla</th>
									<th class="column-5">Color</th>
									<th class="column-6">Cantidad</th>
									<th class="column-7">Total</th>
								</tr>

							</table>
						</div>

						<!-- <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
							<div class="flex-w flex-m m-r-20 m-tb-5">
								<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">

								<div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
									Apply coupon
								</div>
							</div>

							<div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
								Update Cart
							</div>
						</div> -->
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Total del Carrito
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									SubTotal:
								</span>
							</div>

							<div class="size-209">
								<span id="subtotal" class="mtext-110 cl2">
								</span>
							</div>
						</div>

						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Envió a:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<p class="stext-111 cl6 p-t-2">
									Seleccione un método de envió para su compra
								</p>

								<div class="p-t-15">
									<span class="stext-112 cl8">
										Métodos de retiro
									</span>

									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select class="js-select2" name="time" id="selectRetiro">
											<option>Seleccione una opción de retiro</option>
											<option value="1">Retiro en domicilio</option>
											<option value="2">Retiro en oficina</option>
											<option value="3">Enviar regalo</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>

									<div class="bor8 bg0 m-b-12">
										<input name="provincia" id="provincia" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="Provincia">
									</div>

									<div class="bor8 bg0 m-b-22">
										<input name="canton" id="canton" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Canton">
									</div>
									<div class="bor8 bg0 m-b-22">
										<input name="direccion" id="direccion" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Dirección">
									</div>
									<div class="bor8 bg0 m-b-22">
										<input name="nombre" id="nombre" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Nombres y Apellidos">
									</div>
									<div class="bor8 bg0 m-b-22">
										<input name="email" id="email" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="email">
									</div>
									<div class="bor8 bg0 m-b-22">
										<input name="telefono" id="telefono" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Teléfono / Celular">
									</div>
								</div>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total a pagar:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span id="totalspan" class="mtext-110 cl2">
								</span>
							</div>
						</div>

						<button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceder al pago
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>


	<?php require_once "../html/footer.php"; ?>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>


	<?php require_once "../html/MainJS.php"; ?>
	<script src="content.js"></script>

</body>

</html>
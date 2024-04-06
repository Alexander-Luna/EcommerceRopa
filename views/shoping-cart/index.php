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
							<table id="miTabla" class="table-shopping-cart">

							</table>
						</div>


					</div>
				</div>

				<form action="">
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
							<div class="flex-w flex-t bor12 p-b-13">
								<div class="size-208">
									<span class="stext-110 cl2">
										Costo de envio:
									</span>
								</div>

								<div class="size-209">
									<span id="cenvio" class="mtext-110 cl2">$0.00
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
									<div id="accordionEnvio">
										<div class="card">
											<div class="card-header" id="headingEnvio">
												<h5 class="mb-0">
													<button class="btn btn-link" data-toggle="collapse" data-target="#collapseEnvio" aria-expanded="true" aria-controls="collapseEnvio">
														Información de Envío
													</button>
												</h5>
											</div>

											<div id="collapseEnvio" class="collapse" aria-labelledby="headingEnvio" data-parent="#accordionEnvio">
												<div class="card-body">

												</div>
											</div>
										</div>
									</div>

									<p class="stext-111 cl6 p-t-2">
										Seleccione un método de envió para su compra
									</p>
									<div class="form-group">
										<label class="col-form-label">Opciones de retiro:</label>
										<select class="form-control" id="id_envio" name="id_envio" required>
											<option value="">Seleccione...</option>
											<option value="1">Retiro en domicilio</option>
											<option value="2">Retiro en oficina</option>
											<option value="3">Enviar regalo</option>
										</select>
										<label class="col-form-label">Información de envio</label>
										<div class="bor8 bg0 m-b-22">
											<input name="nombre" id="nombre" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Nombres y Apellidos">
										</div>
										<div class="form-group">
											<select class="form-control" id="provincias" name="provincias" required>
												<option value="">Seleccione una provincia...</option>
												<option value="Azuay">Azuay</option>
												<option value="Bolívar">Bolívar</option>
												<option value="Cañar">Cañar</option>
												<option value="Carchi">Carchi</option>
												<option value="Chimborazo">Chimborazo</option>
												<option value="Cotopaxi">Cotopaxi</option>
												<option value="El Oro">El Oro</option>
												<option value="Esmeraldas">Esmeraldas</option>
												<option value="Galápagos">Galápagos</option>
												<option value="Guayas">Guayas</option>
												<option value="Imbabura">Imbabura</option>
												<option value="Loja">Loja</option>
												<option value="Los Ríos">Los Ríos</option>
												<option value="Manabí">Manabí</option>
												<option value="Morona Santiago">Morona Santiago</option>
												<option value="Napo">Napo</option>
												<option value="Orellana">Orellana</option>
												<option value="Pastaza">Pastaza</option>
												<option value="Pichincha">Pichincha</option>
												<option value="Santa Elena">Santa Elena</option>
												<option value="Santo Domingo de los Tsáchilas">Santo Domingo de los Tsáchilas</option>
												<option value="Sucumbíos">Sucumbíos</option>
												<option value="Tungurahua">Tungurahua</option>
												<option value="Zamora Chinchipe">Zamora Chinchipe</option>
											</select>
											<br>
										</div>

										<div class="bor8 bg0 m-b-22">
											<input name="canton" id="canton" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Canton">
										</div>
										<div class="bor8 bg0 m-b-22">
											<input name="direccion" id="direccion" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Dirección">
										</div>

										<div class="bor8 bg0 m-b-22">
											<input name="email" id="email" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="email">
										</div>
										<div class="bor8 bg0 m-b-22">
											<input name="telefono" id="telefono" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Teléfono / Celular">
										</div>
									</div>
									<div>

										<div class="bor8 bg0 m-b-22">
											<label for="comprobantef" class="col-form-label">Comprobante de pago:</label>
											<input type="file" class="form-control-file" id="comprobantef" name="comprobantef" accept=".jpg, .jpeg, .png,.pdf" multiple>
										</div>
										<label for="comprobante" class="col-form-label">Número de comprobante:</label>
										<div class="bor8 bg0 m-b-22">
											<input name="comprobante" id="comprobante" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Número de comprobante">
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

							<button id="btnpagar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
								Proceder al pago
							</button>
						</div>
					</div>
				</form>
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
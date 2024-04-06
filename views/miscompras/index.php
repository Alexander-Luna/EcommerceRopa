<!DOCTYPE html>
<html lang="es">

<head>
	<title>Productos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
	<link rel="stylesheet" href="../miscompras/styles.css">
</head>

<body>

	<!-- Header -->
	<?php require_once "../html/MainHeader.php" ?>


	<section>
		<ul class="nav justify-content-center">
			<li class="nav-item">
				<button type="button" id="btncompras" class="nav-link active">Mi Compras</button>
			</li>
			<li class="nav-item">
				<button type="button" id="btnpendiente" class="nav-link">Pendientes</button>
			</li>
			<li class="nav-item">
				<button type="button" id="btnentregado" class="nav-link">Entregadas</button>
			</li>
		</ul>

	</section>


	<section>
		<div class="container py-5">

			<!-- For demo purpose -->
			<div class="row text-center text-white mb-5">

			</div>
			<ul id="container" class="list-group shadow">
			</ul>
			<div class="flex-c-m flex-w w-full p-t-45 m-4">
				<button id="bmas" href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Mostrar más
				</button>
			</div>
		</div>

	</section>


	<?php require_once "../html/footer.php"; ?>


	<?php require_once "../html/MainJS.php"; ?>
	<script type="text/javascript" src="../miscompras/content.js"></script>

</body>

</html>
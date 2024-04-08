<?php
session_start();
if (empty($_SESSION['user_session'])) {
	header("Location: ../main");
	exit();
}
?>

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
	<script src="../favoritos/content.js"></script>

</body>

</html>
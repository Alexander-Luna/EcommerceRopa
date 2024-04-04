<header class="header-v4">

    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Obtén grandes descuentos en todos nuestros productos
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="../direccion/direccion.php" class="flex-c-m trans-04 p-lr-25">
                        Dirección
                    </a>

                    <a href="../infoempresa/informacion.php" class="flex-c-m trans-04 p-lr-25">
                        Informacion
                    </a>
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <li>
                    <h4 class="navbar-brand">Asotaeco</h4>
                </li>
                <!-- Logo desktop -->
                <a href="" class="logo">

                    <img src="../../public/images/icons/logo.png" alt="IMG-LOGO">
                </a>


                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li>
                            <a href="../" class="menu-link">Inicio</a>
                        </li>
                        <li class="menu-item-with-submenu">
                            <a href="../shop" class="menu-link">Comprar</a>
                            <ul class="sub-menu">
                                <li><a href="../shop">Comprar Ahora</a></li>
                                <li><a href="home-02.html">Homepage 2</a></li>
                                <li><a href="home-03.html">Homepage 3</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-with-submenu">
                            <a href="" class="menu-link">Categorias</a>
                            <ul class="sub-menu">
                                <li><a href="">Hombre</a></li>
                                <li><a href="">Mujer</a></li>
                                <li><a href="">Niños</a></li>
                                <li><a href="">Estudiantes</a></li>
                                <li><a href="">Deportivo</a></li>

                            </ul>
                        </li>

                        <li class="menu-item-with-submenu">
                            <a href="" class="menu-link">Tallas</a>
                            <ul class="sub-menu">
                                <li><a href="../tallasg/hombres.php">Hombre</a></li>
                                <li><a href="../tallasg/mujer.php">Mujer</a></li>
                                <li><a href="../tallasg/niños.php">Niños</a></li>


                            </ul>
                        </li>
                        <li>
                            <a href="../infoempresa/informacion.php" class="menu-link">Quienes somos</a>
                        </li>

                    </ul>
                </div>


                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    <div id="notify_cart" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="0">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a id="notify_wish" href="../shoping-wish" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-wish" data-notify="0">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>
                    <?php
                    session_start();
                    if (!isset($_SESSION["user_session"]) || !isset($_SESSION['user_session']['user_id'])) {
                    ?>
                        <a href="../login" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <i class="zmdi zmdi-account-circle"></i>
                        </a>
                    <?php } else { ?>
                        <style>
                            /* Estilos adicionales */
                            .menu-item {
                                cursor: pointer;
                            }

                            .menu-container {
                                display: none;
                            }

                            .show-menu {
                                display: block;
                            }
                        </style>



                        <a href="#" id="menu-toggle" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <i class="zmdi zmdi-account-circle"></i>
                            <?php echo $_SESSION['user_session']['nombre']; ?>
                        </a>

                        <div class="container mt-5 menu-container" id="menu-container" style="display: none;">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6">
                                    <div class="list-group">
                                        <a href="../miscompras/" class="list-group-item list-group-item-action menu-item">
                                            <i class="fa fa-shopping-basket mr-2"></i> Mis Compras
                                        </a>
                                        <a href="../favoritos" class="list-group-item list-group-item-action menu-item">
                                            <i class="fa fa-heart-o mr-2"></i> Favoritos
                                        </a>
                                        <a href="../miperfil" class="list-group-item list-group-item-action menu-item">
                                            <i class="fa fa-user mr-2"></i> Mi Perfil
                                        </a>
                                        <a href="../../config/Logout.php" class="list-group-item list-group-item-action menu-item">
                                            <i class="fa fa-sign-out mr-2"></i> Cerrar Sesión
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </nav>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script>
           $(document).ready(function(){
        $("#menu-toggle").click(function(e){
            e.preventDefault();
            $("#menu-container").slideToggle();
        });
    });
    </script>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="../"><img src="../../public/images/icons/logo.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div id="notify_cart" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="0">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a id="notify_wish" href="../shoping-wish" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-wish" data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
            <a href="../login" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                <i class="zmdi zmdi-account-circle"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Descuentos por temporada y promociones exclusivas para nuestros clientes.
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="../direccion/direccion.php" class="flex-c-m p-lr-10 trans-04">
                        Dirección
                    </a>

                    <a href="../infoempresa/informacion.php" class="flex-c-m p-lr-10 trans-04">
                        Informacion
                    </a>
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">


            <li>
                <a href="../">Inicio</a>
            </li>
            <li data-label1="hot">
                <a href="../shop">Comprar</a>
                <ul class="sub-menu-m">
                    <li><a href="../">Comprar Ahora</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>
            <li data-label1="hot">
                <a href="../shop">Categria</a>
                <ul class="sub-menu-m">
                    <li><a href="">Hombre</a></li>
                    <li><a href="">Mujer</a></li>
                    <li><a href="">Niños</a></li>
                    <li><a href="">Estudiantes</a></li>
                    <li><a href="">Deportivo</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>
            <li data-label1="hot">
                <a href="../shop">Tallas</a>
                <ul class="sub-menu-m">
                    <li><a href="../tallasg/hombres.php">Hombre</a></li>
                    <li><a href="../tallasg/Mujer.php">Mujer</a></li>
                    <li><a href="../tallasg/Niños.php">Niños</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>


            <li>
                <a href="../infoempresa/informacion.php">Quienes somos</a>
            </li>

            <li>
                <a href="../contact">Contáctenos</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="../../public/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                var url = this.getAttribute('data-url');
                fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('main-container').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
        id_user = 2;
        obtenerUsuario();

        function obtenerUsuario() {
            const userData = localStorage.getItem('user_data');

            if (userData) {
                let user = JSON.parse(localStorage.getItem('user_data')) || [];
                id_user = user.user_id;
                listadedeseos();
            } else {
                //id_user = 0;
            }
        }
        carritodecompras();



        function carritodecompras() {
            const cartData = localStorage.getItem('cart');

            if (cartData) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                let numberOfProducts = cart.length;
                document.querySelector('.js-show-cart').setAttribute('data-notify', numberOfProducts);
            } else {
                document.querySelector('.js-show-cart').setAttribute('data-notify', '0');
            }
        }



        async function listadedeseos() {
            try {
                const response = await fetch(
                    "../../controllers/router.php?op=getWishList&id_user=" + id_user
                );
                const wishData = await response.json();

                if (wishData) {
                    let numberOfProducts = wishData.length;
                    document.querySelector('.js-show-wish').setAttribute('data-notify', numberOfProducts);
                } else {
                    document.querySelector('.js-show-wish').setAttribute('data-notify', '0');
                }
            } catch (error) {
                console.error("Error al obtener la lista de deseos:", error);
                document.querySelector('.js-show-wish').setAttribute('data-notify', '0');
            }
        }
    });
</script>

<div id="cart_contain">
    <?php require_once "cart.php"; ?>
</div>
<?php require_once "../components/modal1.php"; ?>
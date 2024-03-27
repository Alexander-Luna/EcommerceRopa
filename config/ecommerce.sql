DROP DATABASE IF EXISTS ecommerce1;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";

--
CREATE DATABASE IF NOT EXISTS `ecommerce1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ecommerce1`;

CREATE TABLE `categorias_productos` (
  `id` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `categorias_productos` (`id`, `nombre`) VALUES
(1, 'Hombre'),
(2, 'Mujer'),
(3, 'Niño'),
(4, 'Niña');



CREATE TABLE `colores` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `colores` (`id`, `nombre`, `est`) VALUES
(1, 'Rojo', 1),
(2, 'Verde', 1),
(3, 'Azul', 1),
(4, 'Amarillo', 1),
(5, 'Negro', 1),
(6, 'Blanco', 1),
(7, 'Gris', 1),
(8, 'Morado', 1),
(9, 'Naranja', 1),
(10, 'Turquesa', 1);


CREATE TABLE `detalleventas` (
  `id` int(10) NOT NULL,
  `idprod` int(10) NOT NULL,
  `idventa` int(10) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `detalleventas` (`id`, `idprod`, `idventa`, `cantidad`, `precio`, `subtotal`) VALUES
(1, 32, 17, 2, 23.00, 46.00),
(2, 32, 18, 3, 23.00, 69.00),
(3, 32, 19, 3, 23.00, 69.00),
(4, 32, 20, 6, 23.00, 138.00),
(5, 32, 21, 4, 23.00, 92.00),
(6, 32, 22, 5, 23.00, 115.00),
(7, 32, 23, 2, 23.00, 46.00),
(8, 35, 24, 2, 12.00, 24.00),
(9, 32, 25, 13, 12.00, 156.00),
(10, 35, 27, 1, 12.00, 12.00),
(11, 35, 28, 1, 12.00, 12.00),
(12, 35, 29, 2, 12.00, 24.00),
(13, 35, 30, 1, 12.00, 12.00),
(14, 33, 31, 3, 20.00, 60.00),
(15, 32, 32, 4, 12.00, 48.00),
(16, 35, 32, 1, 12.00, 12.00),
(17, 34, 36, 0, 12.00, 0.00),
(18, 33, 36, 1, 12.00, 12.00),
(19, 33, 37, 2, 20.00, 40.00),
(20, 33, 38, 1, 20.00, 20.00);


CREATE TABLE `imagenes_productos` (
  `id` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `img` varchar(250) NOT NULL,
  `est` int(1) NOT NULL DEFAULT 1,
  `principal` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `imagenes_productos` (`id`, `id_producto`, `img`, `est`, `principal`) VALUES
(1, 32, '../../public/images/products/product-01.jpg', 1, 1),
(2, 33, '../../public/images/products/product-02.jpg', 1, 0),
(3, 34, '../../public/images/products/product-03.jpg', 1, 1),
(4, 35, '../../public/images/products/product-04.jpg', 1, 0),
(5, 32, '../../public/images/products/product-03.jpg\r\n', 1, 0),
(6, 32, '../../public/images/products/product-04.jpg\r\n', 1, 0),
(7, 32, '../../public/images/products/product-05.jpg\r\n', 1, 0);


CREATE TABLE `inventario` (
  `id_producto` int(10) NOT NULL,
  `id_talla` int(10) NOT NULL,
  `id_color` int(10) NOT NULL,
  `id_proveedor` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `stock_alert` int(10) DEFAULT (5),
  `cant_pred` int(10) DEFAULT (0),
  `costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `inventario` (`id_producto`,`id_proveedor`, `id_talla`, `id_color`, `stock`, `costo`, `precio_venta`) VALUES
(32, 1,1, 1, 50, 50.50, 80.50),
(32, 1,1, 2, 50, 50.50, 80.50),
(32, 1,1, 3, 50, 50.50, 80.50),
(32, 1,2, 1, 50, 50.50, 80.50),
(32, 1,2, 2, 50, 50.50, 80.50),
(32, 1,2, 3, 50, 50.50, 80.50),
(32, 1,3, 1, 50, 50.50, 80.50),
(32, 1,3, 2, 50, 50.50, 80.50),
(32, 1,3, 3, 50, 50.50, 80.50),
(33, 1,1, 1, 50, 50.50, 80.50),
(33, 1,1, 2, 50, 50.50, 80.50),
(33, 1,1, 3, 50, 50.50, 80.50),
(33, 1,2, 1, 50, 50.50, 80.50),
(33, 1,2, 2, 50, 50.50, 80.50),
(33, 1,2, 3, 50, 50.50, 80.50),
(33, 1,3, 1, 50, 50.50, 80.50),
(33, 1,3, 2, 50, 50.50, 80.50),
(33, 1,3, 3, 50, 50.50, 80.50),
(34, 1,1, 1, 50, 50.50, 80.50),
(34, 1,1, 2, 50, 50.50, 80.50),
(34, 1,1, 3, 50, 50.50, 80.50),
(34, 1,2, 1, 50, 50.50, 80.50),
(34, 1,2, 2, 50, 50.50, 80.50),
(34, 1,2, 3, 50, 50.50, 80.50),
(34, 1,3, 1, 50, 50.50, 80.50),
(34, 1,3, 2, 50, 50.50, 80.50),
(34, 1,3, 3, 50, 50.50, 80.50);

CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `existencia` int(10) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `id_categoria` int(10) NOT NULL,
  `id_proveedor` int(10) NOT NULL,
  `tipo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `productos` (`id`, `nombre`, `precio`, `existencia`, `descripcion`, `activo`, `id_categoria`, `id_proveedor`, `tipo`) VALUES
(32, 'Camisa', 10.00, 23, 'Esta camisa es de color rosa claro con lunares blancos. El cuello es en V y tiene mangas largas. El borde del cuello y las mangas son de un color rosa más oscuro. La camisa está hecha de un material ligero y transpirable.', 1, 1, 1, 'Camisa'),
(33, 'Chaleco deportivo', 11.00, 13, 'Chaleco amarillo con ribete negro. El chaleco es de manga corta y tiene un cuello redondo. El ribete negro se encuentra en el cuello, los puños y el borde inferior del chaleco. El chaleco está hecho de un material ligero y transpirable, como algodón o poliéster. Es una prenda cómoda y fresca que se puede usar en climas cálidos.', 1, 2, 1, 'Chaleco deportivo'),
(34, 'Camisa con rayas', 11.00, 21, 'La camisa está hecha de un material ligero y transpirable, como algodón o poliéster. Es una prenda cómoda y fresca que se puede usar en climas cálidos o fríos.', 1, 3, 1, 'Camisa con rayas'),
(35, 'Falda corta', 11.00, 31, 'Tiene pliegues de caja, que son pliegues anchos y uniformemente espaciados que se pliegan planos contra la tela cuando se plancha. La falda tiene una cintura alta, que se coloca a la altura o por encima de la cintura natural.', 1, 4, 1, 'Falda corta');


CREATE TABLE `proveedores` (
  `id` int(10) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `categoria_producto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `proveedores` (`id`, `nombre_proveedor`, `telefono`, `categoria_producto`) VALUES
(1, 'Alexander Alegria', '+593963616505', 'pantalon');


CREATE TABLE `recibe` (
  `id` int(10) NOT NULL,
  `id_venta` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `est` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `roles` (
  `id` int(1) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `roles` (`id`, `nombre`, `est`) VALUES
(1, 'administrador', 1),
(2, 'cliente', 1);

CREATE TABLE `sliders` (
  `id` int(10) NOT NULL,
  `titulo` varchar(250) NOT NULL DEFAULT '',
  `descripcion` varchar(250) NOT NULL DEFAULT '',
  `img` varchar(250) NOT NULL DEFAULT '',
  `url_web` varchar(250) NOT NULL DEFAULT '',
  `est` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `sliders` (`id`, `titulo`, `descripcion`, `img`, `url_web`, `est`) VALUES
(1, 'Chaquetas & Chompas', 'coleccion de chaquetas 2024', '../../public/images/sliders/slide-01.jpg', '', 1),
(2, 'Camisas & Blusas', 'Camisas para hombre y mujer 2024', '../../public/images/sliders/slide-02.jpg', '', 1),
(3, 'Uniformes de niño & niña', 'se diseña los uniformes para colegios 2024', '../../public/images/sliders/slide-03.jpg', '', 1),
(4, 'Pantaloes & Faldas', 'Ropa formal para este 2024', '../../public/images/sliders/slide-04.jpg', '', 1),
(5, 'Pijamas de Adultos & Niños', 'La mejor calidad y diseños para todas las edades', '../../public/images/sliders/slide-05.jpg', '', 1);


CREATE TABLE `sub_categorias_productos` (
  `id` int(10) NOT NULL,
  `id_categoria` int(10) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `sub_categorias_productos` (`id`, `id_categoria`, `descripcion`, `est`) VALUES
(1, 1, 'Camisa', 1),
(2, 1, 'Pantalón', 1),
(3, 1, 'Chaqueta', 1),
(4, 2, 'Blusa', 1),
(5, 2, 'Pantalón', 1),
(6, 2, 'Vestido', 1),
(7, 3, 'Camiseta', 1),
(8, 3, 'Pantalón', 1),
(9, 3, 'Chaqueta', 1),
(10, 4, 'Vestido', 1),
(11, 4, 'Falda', 1),
(12, 4, 'Blusa', 1);


CREATE TABLE `tallas` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tallas` (`id`, `nombre`, `descripcion`, `est`) VALUES
(1, '2T', 'Niños (2 años)', 1),
(2, '3T', 'Niños (3 años)', 1),
(3, '4T', 'Niños (4 años)', 1),
(4, '5T', 'Niños (5 años)', 1),
(5, '6', 'Niños (6 años)', 1),
(6, '7', 'Niños (7 años)', 1),
(7, '8', 'Niños (8 años)', 1),
(8, '10', 'Niños (9-10 años)', 1),
(9, '12', 'Niños (11-12 años)', 1),
(10, '14', 'Niños (13-14 años)', 1),
(11, '16', 'Niños (15-16 años)', 1),
(12, 'S (Hombre)', 'Pecho 97-102 cm, Cintura 81-86 cm', 1),
(13, 'M (Hombre)', 'Pecho 102-107 cm, Cintura 86-91 cm', 1),
(14, 'L (Hombre)', 'Pecho 107-112 cm, Cintura 91-97 cm', 1),
(15, 'XL (Hombre)', 'Pecho 112-117 cm, Cintura 97-102 cm', 1),
(16, 'XXL (Hombre)', 'Pecho 117-122 cm, Cintura 102-107 cm', 1),
(17, '30 (Hombre)', 'Cintura 76 cm, Largo 102 cm', 1),
(18, '32 (Hombre)', 'Cintura 81 cm, Largo 104 cm', 1),
(19, '34 (Hombre)', 'Cintura 86 cm, Largo 107 cm', 1),
(20, '36 (Hombre)', 'Cintura 91 cm, Largo 109 cm', 1),
(21, '38 (Hombre)', 'Cintura 97 cm, Largo 112 cm', 1),
(22, 'S (Mujer)', 'Pecho 86-91 cm, Cintura 66-71 cm', 1),
(23, 'M (Mujer)', 'Pecho 91-97 cm, Cintura 71-76 cm', 1),
(24, 'L (Mujer)', 'Pecho 97-102 cm, Cintura 76-81 cm', 1),
(25, 'XL (Mujer)', 'Pecho 102-107 cm, Cintura 81-86 cm', 1),
(26, 'XXL (Mujer)', 'Pecho 107-112 cm, Cintura 86-91 cm', 1),
(27, '2 (Mujer)', 'Cintura 66 cm, Cadera 91 cm', 1),
(28, '4 (Mujer)', 'Cintura 69 cm, Cadera 94 cm', 1),
(29, '6 (Mujer)', 'Cintura 71 cm, Cadera 97 cm', 1),
(30, '8 (Mujer)', 'Cintura 74 cm, Cadera 100 cm', 1),
(31, '10 (Mujer)', 'Cintura 76 cm, Cadera 103 cm', 1);



CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `rol_id` int(1) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text DEFAULT NULL,
  `cedula` varchar(20) NOT NULL,
  `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `rol_id`, `email`, `pass`, `nombre`, `direccion`, `cedula`, `est`) VALUES
(2, 1, 'paulluna99@gmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Alexannder Luna', 'San Miguel de Bolivar', '0202433919', 1),
(3, 2, 'bryan@nose.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Bryan Shiguango', 'Tena', '0202433123', 1),
(6, 2, 'nicole@hotmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Nicole Anahi', 'Guaranda', '0202433321', 1),
(7, 2, 'xd@hotmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'xd', 'user1direcion', '0202433231', 1),
(8, 1, 'admin@admin.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Admin', 'admin direccion', '0202433312', 1);


CREATE TABLE `ventas` (
  `id` int(10) NOT NULL,
  `idcli` int(10) NOT NULL,
  `idPago` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `ventas` (`id`, `idcli`, `idPago`, `fecha`) VALUES
(1, 3, 'ch_3ORmlKK3mpQlvJke00WeM6HW', '2023-12-26 21:22:28'),
(2, 3, 'ch_3ORmuXK3mpQlvJke1FxNPuUk', '2023-12-26 21:31:58'),
(3, 6, 'ch_3ORmxYK3mpQlvJke11MBSURv', '2023-12-26 21:35:05'),
(4, 6, 'ch_3ORn04K3mpQlvJke0qhf1jzx', '2023-12-26 21:37:41'),
(5, 6, 'ch_3ORn0oK3mpQlvJke0gWDp4nu', '2023-12-26 21:38:27'),
(6, 7, 'ch_3ORn7vK3mpQlvJke16xbJ6m1', '2023-12-26 21:45:48'),
(7, 7, 'ch_3ORnCJK3mpQlvJke1XJrJFkM', '2023-12-26 21:50:21'),
(8, 3, 'ch_3ORnElK3mpQlvJke0OWbKqNa', '2023-12-26 21:52:52'),
(9, 3, 'ch_3ORnkwK3mpQlvJke17lvCo8n', '2023-12-26 22:26:07'),
(10, 6, 'ch_3ORnseK3mpQlvJke03AmUoV3', '2023-12-26 22:34:05'),
(11, 6, 'ch_3ORntJK3mpQlvJke02rgRzTa', '2023-12-26 22:34:47'),
(12, 7, 'ch_3ORnv2K3mpQlvJke0SHuPwjE', '2023-12-26 22:36:33'),
(13, 7, 'ch_3ORnwHK3mpQlvJke05juQ3Gh', '2023-12-26 22:37:50'),
(14, 3, 'ch_3ORnxuK3mpQlvJke1igfXVpJ', '2023-12-26 22:39:31'),
(15, 3, 'ch_3ORoAFK3mpQlvJke0o1GEOAO', '2023-12-26 22:52:16'),
(16, 3, 'ch_3OS4AUK3mpQlvJke1hkWXLCC', '2023-12-27 15:57:34'),
(17, 6, 'ch_3OSU85K3mpQlvJke0TUyWD77', '2023-12-28 19:40:48'),
(18, 6, 'ch_3OSUdcK3mpQlvJke10mq2uZ8', '2023-12-28 20:13:23'),
(19, 6, 'ch_3OSUeDK3mpQlvJke0k52cL6y', '2023-12-28 20:14:00'),
(20, 6, 'ch_3OSUnTK3mpQlvJke0of70fMe', '2023-12-28 20:23:34'),
(21, 7, 'ch_3OUd5UK3mpQlvJke0noJrekj', '2024-01-03 17:39:02'),
(22, 7, 'ch_3OUu89K3mpQlvJke1PO1898O', '2024-01-04 11:50:54'),
(23, 7, 'ch_3OVhohK3mpQlvJke0emkqtTj', '2024-01-06 16:54:07'),
(24, 7, 'ch_3OYNzdK3mpQlvJke03rw173E', '2024-01-14 02:20:29'),
(25, 7, 'ch_3OYO3oK3mpQlvJke1IfRSMcX', '2024-01-14 02:24:47'),
(26, 3, 'ch_3OYO4RK3mpQlvJke0lQiIt1J', '2024-01-14 02:25:26'),
(27, 3, 'ch_3OYO8GK3mpQlvJke1kZSWf5o', '2024-01-14 02:29:23'),
(28, 3, 'ch_3ObQJJK3mpQlvJke0gkkQgAI', '2024-01-22 11:25:19'),
(29, 6, 'ch_3ObmyjK3mpQlvJke1cWJD03t', '2024-01-23 11:37:35'),
(30, 7, 'ch_3Od3wyK3mpQlvJke01gOMp01', '2024-01-26 23:57:02'),
(31, 7, 'ch_3OdgjuK3mpQlvJke1Ul5PUQF', '2024-01-28 17:22:08'),
(32, 6, 'ch_3OdxrWK3mpQlvJke0DAxKClc', '2024-01-29 11:39:10'),
(33, 6, 'ch_3OeJx5K3mpQlvJke0aZbc8Av', '2024-01-30 11:14:21'),
(34, 3, 'ch_3OeJy4K3mpQlvJke1pUV61kz', '2024-01-30 11:15:22'),
(35, 3, 'ch_3OeK85K3mpQlvJke0M5Dd6AS', '2024-01-30 11:25:43'),
(36, 3, 'ch_3OeKNhK3mpQlvJke1MSVjnOv', '2024-01-30 11:41:51'),
(37, 6, 'ch_3OeKOcK3mpQlvJke1NAVzgD3', '2024-01-30 11:42:47'),
(38, 6, 'ch_3OeKYFK3mpQlvJke1ShbW12o', '2024-01-30 11:52:44');

ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `detalleventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkidprod` (`idprod`) USING BTREE,
  ADD KEY `fkidventa` (`idventa`) USING BTREE;

ALTER TABLE `imagenes_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_producto`,`id_talla`,`id_color`) USING BTREE,
  ADD KEY `id_talla` (`id_talla`),
  ADD KEY `id_color` (`id_color`);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_proveedor` (`id_proveedor`);

ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `recibe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`);


ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `sub_categorias_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `kEmail` (`email`),
  ADD KEY `rol_id` (`rol_id`);


ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcli` (`idcli`);

ALTER TABLE `categorias_productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `colores`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `detalleventas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `imagenes_productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

ALTER TABLE `proveedores`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `recibe`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `roles`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `sliders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `sub_categorias_productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `tallas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `ventas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

ALTER TABLE `detalleventas`
  ADD CONSTRAINT `fk_idprod` FOREIGN KEY (`idprod`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_idventa` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`id`);


ALTER TABLE `imagenes_productos`
  ADD CONSTRAINT `imagenes_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);


ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`);


ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_productos` (`id`);


ALTER TABLE `recibe`
  ADD CONSTRAINT `recibe_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);


ALTER TABLE `sub_categorias_productos`
  ADD CONSTRAINT `sub_categorias_productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_productos` (`id`);


ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

ALTER TABLE `ventas`
  ADD CONSTRAINT `idcli` FOREIGN KEY (`idcli`) REFERENCES `usuarios` (`id`);


CREATE TABLE `wish_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
   `est` int(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
   
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `wish_list`( `id_usuario`, `id_producto`) VALUES (2,32),(2,33),(2,34),(2,35);
COMMIT;

-- CREATE TABLE `sub_categorias_productos` (
--   `id` int(10) NOT NULL AUTO_INCREMENT,
--   `id_categoria` int(10) NOT NULL,
--   `descripcion` varchar(100) NOT NULL,
--    `est` int(1) DEFAULT 1,
--   PRIMARY KEY (`id`),
--   FOREIGN KEY (`id_categoria`) REFERENCES `categorias_productos` (`id`)
   
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
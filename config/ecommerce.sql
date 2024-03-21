DROP DATABASE IF EXISTS ecommerce1;
CREATE DATABASE IF NOT EXISTS ecommerce1;
USE ecommerce1;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";

CREATE TABLE `proveedores` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre_proveedor` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `categoria_producto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `clientes` (
  `id` int(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `cedula` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `clientes` (`id`, `email`, `pass`, `nombre`, `direccion`, `cedula`) VALUES
(1, 'nose@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Rodolfo', 'Los trigales', '0201062616'),
(2, 'nico@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'nicole', '', ''),
(3, 'alex@nose.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Alexander Alegria', '1 de Mayo', ''),
(4, 'vinicio@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Vinicio ', '1 de mayo', '0201062619');


CREATE TABLE `sliders` (
  `id` int(10) NOT NULL,
  `titulo` varchar(250) NOT NULL DEFAULT '',
  `descripcion` VARCHAR(250) NOT NULL DEFAULT '',
  `img` VARCHAR(250) NOT NULL DEFAULT '',
  `url_web` varchar(250) NOT NULL DEFAULT '',
  `est` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `sliders` (`id`, `titulo`, `descripcion`,`img`, `est`) VALUES
(1, 'Chaquetas & Chompas','coleccion de chaquetas 2024','../../public/images/sliders/slide-01.jpg', 1),
(2,'Camisas & Blusas','Camisas para hombre y mujer 2024','../../public/images/sliders/slide-02.jpg', 1),
(3, 'Uniformes de niño & niña','se diseña los uniformes para colegios 2024','../../public/images/sliders/slide-03.jpg', 1),
(4, 'Pantaloes & Faldas','Ropa formal para este 2024','../../public/images/sliders/slide-04.jpg', 1),
(5, 'Pijamas de Adultos & Niños','La mejor calidad y diseños para todas las edades','../../public/images/sliders/slide-05.jpg', 1);


CREATE TABLE `categorias_productos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
   
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `categorias_productos` (`nombre`) VALUES
('Hombre'),
('Mujer'),
('Niño'),
('Niña');

CREATE TABLE `sub_categorias_productos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(10) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
   `est` int(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_categoria`) REFERENCES `categorias_productos` (`id`)
   
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `sub_categorias_productos` (`id_categoria`,`descripcion`) VALUES
(1,'Camisa'),
(1,'Pantalón'),
(1,'Chaqueta'),
(2,'Blusa'),
(2,'Pantalón'),
(2,'Vestido'),
(3,'Camiseta'),
(3,'Pantalón'),
(3,'Chaqueta'),
(4,'Vestido'),
(4,'Falda'),
(4,'Blusa');


CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` numeric(10,2) NOT NULL,
  `existencia` int(10) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `id_categoria` int(10) NOT NULL,
  `id_proveedor` int(10) NOT NULL,
  `tipo` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`id`) USING BTREE,
   FOREIGN KEY (`id_categoria`) REFERENCES `categorias_productos` (`id`),
   FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tallas` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(50) NOT NULL,
    `descripcion` varchar(250) NOT NULL,
     `est` int(1) DEFAULT 1

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO tallas (nombre, descripcion) VALUES

  -- Tallas para niños por edad
  ('2T', 'Niños (2 años)'),
  ('3T', 'Niños (3 años)'),
  ('4T', 'Niños (4 años)'),
  ('5T', 'Niños (5 años)'),
  ('6', 'Niños (6 años)'),
  ('7', 'Niños (7 años)'),
  ('8', 'Niños (8 años)'),
  ('10', 'Niños (9-10 años)'),
  ('12', 'Niños (11-12 años)'),
  ('14', 'Niños (13-14 años)'),
  ('16', 'Niños (15-16 años)'),

  -- Tallas para Hombres (Camisetas y camisas)
  ('S (Hombre)', 'Pecho 97-102 cm, Cintura 81-86 cm'),
  ('M (Hombre)', 'Pecho 102-107 cm, Cintura 86-91 cm'),
  ('L (Hombre)', 'Pecho 107-112 cm, Cintura 91-97 cm'),
  ('XL (Hombre)', 'Pecho 112-117 cm, Cintura 97-102 cm'),
  ('XXL (Hombre)', 'Pecho 117-122 cm, Cintura 102-107 cm'),

  -- Tallas para Hombres (Pantalones)
  ('30 (Hombre)', 'Cintura 76 cm, Largo 102 cm'),
  ('32 (Hombre)', 'Cintura 81 cm, Largo 104 cm'),
  ('34 (Hombre)', 'Cintura 86 cm, Largo 107 cm'),
  ('36 (Hombre)', 'Cintura 91 cm, Largo 109 cm'),
  ('38 (Hombre)', 'Cintura 97 cm, Largo 112 cm'),

  -- Tallas para Mujeres (Camisetas y blusas)
  ('S (Mujer)', 'Pecho 86-91 cm, Cintura 66-71 cm'),
  ('M (Mujer)', 'Pecho 91-97 cm, Cintura 71-76 cm'),
  ('L (Mujer)', 'Pecho 97-102 cm, Cintura 76-81 cm'),
  ('XL (Mujer)', 'Pecho 102-107 cm, Cintura 81-86 cm'),
  ('XXL (Mujer)', 'Pecho 107-112 cm, Cintura 86-91 cm'),

  -- Tallas para Mujeres (Pantalones)
  ('2 (Mujer)', 'Cintura 66 cm, Cadera 91 cm'),
  ('4 (Mujer)', 'Cintura 69 cm, Cadera 94 cm'),
  ('6 (Mujer)', 'Cintura 71 cm, Cadera 97 cm'),
  ('8 (Mujer)', 'Cintura 74 cm, Cadera 100 cm'),
  ('10 (Mujer)', 'Cintura 76 cm, Cadera 103 cm')
;

CREATE TABLE `colores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
   `est` int(1) DEFAULT 1,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO colores (nombre) VALUES
  ('Rojo'),
  ('Verde'),
  ('Azul'),
  ('Amarillo'),
  ('Negro'),
  ('Blanco'),
  ('Gris'),
  ('Morado'),
  ('Naranja'),
  ('Turquesa');
CREATE TABLE `inventario` (
  `id_producto` int(10) NOT NULL,
  `id_talla` int(10) NOT NULL,
  `id_color` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_producto`, `id_talla`, `id_color`) USING BTREE,
  FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id`),
  FOREIGN KEY (`id_color`) REFERENCES `colores` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `proveedores` (`id`, `nombre_proveedor`, `telefono`, `categoria_producto`) VALUES
(1, 'Alexander Alegria', '+593963616505', 'pantalon');


INSERT INTO `productos` (`id`,`id_proveedor`, `nombre`, `precio`, `existencia`, `descripcion`, `activo`, `id_categoria`, `tipo`) VALUES
(32,1, 'Camisa', 10, 23, 'Esta camisa es de color rosa claro con lunares blancos. El cuello es en V y tiene mangas largas. El borde del cuello y las mangas son de un color rosa más oscuro. La camisa está hecha de un material ligero y transpirable.', 1, 1, 'Camisa'),
(33, 1,'Chaleco deportivo', 11, 13, 'Chaleco amarillo con ribete negro. El chaleco es de manga corta y tiene un cuello redondo. El ribete negro se encuentra en el cuello, los puños y el borde inferior del chaleco. El chaleco está hecho de un material ligero y transpirable, como algodón o poliéster. Es una prenda cómoda y fresca que se puede usar en climas cálidos.', 1, 2, 'Chaleco deportivo'),
(34, 1,'Camisa con rayas', 11, 21, 'La camisa está hecha de un material ligero y transpirable, como algodón o poliéster. Es una prenda cómoda y fresca que se puede usar en climas cálidos o fríos.', 1, 3, 'Camisa con rayas'),
(35, 1,'Falda corta', 11, 31, 'Tiene pliegues de caja, que son pliegues anchos y uniformemente espaciados que se pliegan planos contra la tela cuando se plancha. La falda tiene una cintura alta, que se coloca a la altura o por encima de la cintura natural.', 1, 4, 'Falda corta');

 

CREATE TABLE `imagenes_productos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_producto` int(10) NOT NULL,
  `img` varchar(250) NOT NULL,
  `est` int(1) NOT NULL DEFAULT 1,
  `principal` int(1) NOT NULL DEFAULT 0,
  FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO imagenes_productos (id_producto, img, est, principal) 
VALUES
    (32, '../../public/images/products/product-01.jpg', 1, 1),
    (33, '../../public/images/products/product-02.jpg', 1, 0),
    (34, '../../public/images/products/product-03.jpg', 1, 1),
    (35, '../../public/images/products/product-04.jpg', 1, 0);






CREATE TABLE `roles` (
  `id` int(1) AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(200) NOT NULL,
   `est` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `roles` (`nombre`) VALUES ('administrador'), ('cliente');


CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `rol_id` int(1) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `cedula` varchar(20) NOT NULL UNIQUE,
  `est` int(1) DEFAULT 1,
    FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`,`rol_id`, `email`, `pass`, `nombre`, `direccion`, `cedula`) VALUES
(2,1, 'paulluna99@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Alexannder Luna','San Miguel de Bolivar','0202433919'),
(3,2, 'bryan@nose.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Bryan Shiguango','Tena','0202433123'),
(6,2, 'nicole@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Nicole Anahi','Guaranda','0202433321'),
(7,2, 'xd@hotmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'xd','user1direcion','0202433231'),
(8,1, 'admin@admin.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin','admin direccion','0202433312');

CREATE TABLE `ventas` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `idcli` int(10) NOT NULL,
  `idPago` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `recibe` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_venta` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `est` int(1) DEFAULT 0,
   FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`)
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






ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kEmail` (`email`);


ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kEmail` (`email`);

ALTER TABLE `clientes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `sliders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ventas`
  ADD CONSTRAINT `idcli` FOREIGN KEY (`idcli`) REFERENCES `usuarios` (`id`);

INSERT INTO `inventario`(`id_producto`, `id_talla`, `id_color`, `stock`, `costo`, `precio_venta`) 
VALUES 
  (32,1,1,50,50.5,80.5),
    (32,1,2,50,50.5,80.5),
    (32,1,3,50,50.5,80.5),
    (32,2,1,50,50.5,80.5),
    (32,2,2,50,50.5,80.5),
    (32,2,3,50,50.5,80.5),
    (32,3,1,50,50.5,80.5),
    (32,3,2,50,50.5,80.5),
    (32,3,3,50,50.5,80.5),
    
    (33,1,1,50,50.5,80.5),
    (33,1,2,50,50.5,80.5),
    (33,1,3,50,50.5,80.5),
    (33,2,1,50,50.5,80.5),
    (33,2,2,50,50.5,80.5),
    (33,2,3,50,50.5,80.5),
    (33,3,1,50,50.5,80.5),
    (33,3,2,50,50.5,80.5),
    (33,3,3,50,50.5,80.5),
   
    (34,1,1,50,50.5,80.5),
    (34,1,2,50,50.5,80.5),
    (34,1,3,50,50.5,80.5),
    (34,2,1,50,50.5,80.5),
    (34,2,2,50,50.5,80.5),
    (34,2,3,50,50.5,80.5),
    (34,3,1,50,50.5,80.5),
    (34,3,2,50,50.5,80.5),
    (34,3,3,50,50.5,80.5);
CREATE TABLE `detalleventas` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `idprod` int(10) NOT NULL,
  `idventa` int(10) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` numeric(10,2) NOT NULL,
  `subtotal` numeric(10,2) NOT NULL,
  CONSTRAINT `fk_idprod` FOREIGN KEY (`idprod`) REFERENCES `productos` (`id`) ,
  CONSTRAINT `fk_idventa` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`id`) ,
  KEY `fkidprod` (`idprod`) USING BTREE,
  KEY `fkidventa` (`idventa`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `detalleventas` (`id`, `idprod`, `idventa`, `cantidad`, `precio`, `subtotal`) VALUES
(1, 32, 17, 2, 23, 46),
(2, 32, 18, 3, 23, 69),
(3, 32, 19, 3, 23, 69),
(4, 32, 20, 6, 23, 138),
(5, 32, 21, 4, 23, 92),
(6, 32, 22, 5, 23, 115),
(7, 32, 23, 2, 23, 46),
(8, 35, 24, 2, 12, 24),
(9, 32, 25, 13, 12, 156),
(10, 35, 27, 1, 12, 12),
(11, 35, 28, 1, 12, 12),
(12, 35, 29, 2, 12, 24),
(13, 35, 30, 1, 12, 12),
(14, 33, 31, 3, 20, 60),
(15, 32, 32, 4, 12, 48),
(16, 35, 32, 1, 12, 12),
(17, 34, 36, 0, 12, 0),
(18, 33, 36, 1, 12, 12),
(19, 33, 37, 2, 20, 40),
(20, 33, 38, 1, 20, 20);

COMMIT;

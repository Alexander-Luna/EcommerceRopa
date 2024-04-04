INSERT INTO `roles` (`id`, `nombre`, `est`) VALUES
(1, 'administrador', 1),
(2, 'cliente', 1);

INSERT INTO `sliders` (`id`, `titulo`, `descripcion`, `img`, `url_web`, `est`) VALUES
(1, 'Chaquetas & Chompas', 'coleccion de chaquetas 2024', '../../public/images/sliders/slide-01.jpg', '', 1),
(2, 'Camisas & Blusas', 'Camisas para hombre y mujer 2024', '../../public/images/sliders/slide-02.jpg', '', 1),
(3, 'Uniformes de niño & niña', 'se diseña los uniformes para colegios 2024', '../../public/images/sliders/slide-03.jpg', '', 1);


INSERT INTO `usuarios` (`rol_id`, `email`, `pass`, `nombre`, `direccion`, `cedula`, `est`) VALUES
( 1, 'paulluna99@gmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Alexannder Luna', 'San Miguel de Bolivar', '0202433919', 1),
( 2, 'bryan@nose.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Bryan Shiguango', 'Tena', '0202433123', 1),
( 2, 'nicole@hotmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Nicole Anahi', 'Guaranda', '0202433321', 1),
( 2, 'xd@hotmail.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'xd', 'user1direcion', '0202433231', 1),
( 1, 'admin@admin.com', '$2y$12$yQsWj3E.s5L/R6AUPy.t4eGRtkfGoKKRLpBJA8tGItB3/sGDStCTi', 'Admin', 'admin direccion', '0202433312', 1);


-- Insertar datos de ejemplo en la tabla recive
INSERT INTO recibe ( nombre, telefono, email, direccion, est)
VALUES 
( 'Juan Perez', '123456789', 'juan@example.com', 'Calle Principal 123', 1),
( 'María López', '987654321', 'maria@example.com', 'Avenida Central 456', 1),
( 'Pedro Martinez', '555444333', 'pedro@example.com', 'Plaza Mayor 789', 1);



INSERT INTO proveedores (ruc, nombre, email, telefono, direccion, est) VALUES ('1234567890', 'Proveedor Uno', 'proveedoruno@example.com', '1234567890', 'Calle Uno #123', 1),
 ('2345678901', 'Proveedor Dos', 'proveedordos@example.com', '593985726434', 'Avenida Dos #456', 1),
('3456789012', 'Proveedor Tres', 'proveedortres@example.com', '593985726434', 'Calle Tres #789', 1),
('4567890123', 'Proveedor Cuatro', 'proveedorcuatro@example.com', '593985726434', 'Avenida Cuatro #012', 1),
 ('5678901234', 'Proveedor Cinco', 'proveedorcinco@example.com', '593985726434', 'Calle Cinco #345', 1);

-- Insertar datos en la tabla de ocasión
INSERT INTO ocasion (nombre) VALUES 
('Formal'), 
('Uniforme Escolar'), 
('Deportivo');

-- Insertar datos en la tabla de género
INSERT INTO genero (nombre) VALUES ('Niño'), ('Niña'), ('Hombre'), ('Mujer');

-- Insertar datos en la tabla de tipo de prenda
INSERT INTO tipo_prenda (nombre) VALUES 
('Camisa'), 
('Pantalón'), 
('Falda'), 
('Camiseta'), 
('Chompa'), 
('Abrigo');
INSERT INTO tallas (id, talla, desc_talla, est) VALUES
(1, 'S', 'Pequeña', 1),
(2, 'M', 'Mediana', 1),
(3, 'L', 'Grande', 1);
INSERT INTO colores (id, color, color_hexa, est) VALUES
(1, 'Negro', '#000000', 1),
(2, 'Blanco', '#FFFFFF', 1),
(3, 'Azul', '#0000FF', 1),
(4, 'Rojo', '#FF0000', 1),
(5, 'Verde', '#00FF00', 1),
(6, 'Gris', '#808080', 1),
(7, 'Amarillo', '#FFFF00', 1),
(8, 'Naranja', '#FFA500', 1),
(9, 'Rosado', '#FFC0CB', 1),
(10, 'Morado', '#800080', 1);


INSERT INTO productos (id, nombre, descripcion, id_genero, id_tipo_prenda, id_ocasion) VALUES
(1, 'Camisa blanca', 'Camisa blanca de manga larga', 1, 1, 1),
(2, 'Pantalones vaqueros', 'Pantalones vaqueros azules', 1, 2, 2),
(3, 'Vestido floral', 'Vestido floral de verano', 2, 3, 3),
(4, 'Chaqueta de cuero', 'Chaqueta de cuero negro', 1, 4, 1),
(5, 'Sudadera con capucha', 'Sudadera con capucha gris', 1, 5, 3),
(6, 'Falda plisada', 'Falda plisada de color rosa', 2, 6, 3),
(7, 'Zapatos de tacón', 'Zapatos de tacón negros', 2, 1, 2),
(8, 'Bufanda de lana', 'Bufanda de lana suave', 1, 2, 1),
(9, 'Gorra de béisbol', 'Gorra de béisbol roja', 1, 3, 1),
(10, 'Abrigo de invierno', 'Abrigo de invierno acolchado', 1, 4, 1),
(11, 'Blusa estampada', 'Blusa estampada de manga corta', 2, 5, 3),
(12, 'Pantalones cortos', 'Pantalones cortos de algodón', 1, 6, 2),
(13, 'Vestido de noche', 'Vestido de noche elegante', 2, 1, 2),
(14, 'Chaleco acolchado', 'Chaleco acolchado de plumas', 1, 2, 1),
(15, 'Zapatos deportivos', 'Zapatos deportivos blancos', 1, 3, 2),
(16, 'Jersey de lana', 'Jersey de lana verde', 2, 4, 1),
(17, 'Gafas de sol', 'Gafas de sol de estilo retro', 1, 5, 2),
(18, 'Pantalones cargo', 'Pantalones cargo de color caqui', 1, 6, 3),
(19, 'Vestido de fiesta', 'Vestido de fiesta rojo', 2, 1, 1),
(20, 'Camiseta sin mangas', 'Camiseta sin mangas de color negro', 1, 2, 2),
(21, 'Sombrero de paja', 'Sombrero de paja de ala ancha', 2, 3, 1),
(22, 'Chaqueta vaquera', 'Chaqueta vaquera desgastada', 1, 4, 2),
(23, 'Calcetines de algodón', 'Calcetines de algodón cómodos', 1, 5, 3),
(24, 'Vestido de cóctel', 'Vestido de cóctel elegante', 2, 6, 3),
(25, 'Chaleco de punto', 'Chaleco de punto gris', 1, 1, 1),
(26, 'Zapatillas de estar por casa', 'Zapatillas de estar por casa cómodas', 2, 2, 1),
(27, 'Camiseta polo', 'Camiseta polo de manga corta', 4, 3, 1),
(28, 'Bufanda de seda', 'Bufanda de seda suave', 3, 4, 1),
(29, 'Gabardina', 'Gabardina beige clásica', 2, 5, 2),
(30, 'Pantalones de vestir', 'Pantalones de vestir de color gris', 1, 6, 3);
INSERT INTO inventario (id_producto, id_color, id_talla, stock, precio) VALUES
(1, 1, 1, 50, 29.99),
(1, 2, 2, 30, 39.99),
(2, 1, 1, 20, 49.99),
(2, 3, 2, 10, 59.99),
(3, 1, 1, 15, 34.99),
(3, 2, 2, 25, 44.99),
(4, 1, 1, 10, 69.99),
(4, 2, 2, 5, 79.99),
(5, 1, 1, 40, 49.99),
(5, 2, 2, 20, 59.99),
(6, 1, 1, 25, 39.99),
(6, 2, 2, 15, 49.99),
(7, 1, 1, 30, 59.99),
(7, 2, 2, 10, 69.99),
(8, 1, 1, 20, 19.99),
(8, 2, 2, 15, 24.99),
(9, 1, 1, 0, 14.99),
(9, 2, 2, 0, 19.99),
(10, 1, 1, 5, 79.99),
(10, 2, 2, 0, 89.99),
(11, 1, 1, 30, 29.99),
(11, 2, 2, 20, 34.99),
(12, 1, 1, 15, 19.99),
(12, 2, 2, 10, 24.99),
(13, 1, 1, 25, 69.99),
(13, 2, 2, 15, 79.99),
(14, 1, 1, 10, 54.99),
(14, 2, 2, 5, 64.99),
(15, 1, 1, 35, 44.99),
(15, 2, 2, 25, 54.99),
(16, 1, 1, 20, 39.99),
(16, 2, 2, 10, 49.99),
(17, 1, 1, 25, 24.99),
(17, 2, 2, 15, 29.99),
(18, 1, 1, 15, 59.99),
(18, 2, 2, 10, 69.99),
(19, 1, 1, 10, 89.99),
(19, 2, 2, 5, 99.99),
(20, 1, 1, 20, 14.99),
(20, 2, 2, 15, 19.99),
(21, 1, 1, 30, 29.99),
(21, 2, 2, 20, 34.99),
(22, 1, 1, 15, 39.99),
(22, 2, 2, 10, 49.99),
(23, 1, 1, 25, 19.99),
(23, 2, 2, 15, 24.99),
(24, 1, 1, 10, 69.99),
(24, 2, 2, 5, 79.99),
(25, 1, 1, 35, 44.99),
(25, 2, 2, 25, 54.99),
(26, 1, 1, 20, 29.99),
(26, 2, 2, 10, 34.99),
(27, 1, 1, 25, 19.99),
(27, 2, 2, 15, 24.99),
(28, 1, 1, 15, 39.99),
(28, 2, 2, 10, 49.99),
(29, 1, 1, 10, 69.99),
(29, 2, 2, 5, 79.99),
(30, 1, 1, 35, 44.99),
(30, 2, 2, 25, 54.99);


INSERT INTO productos_proveedores (id_producto, id_proveedor) VALUES (1, 1), (2, 2), (3, 3), (4, 4);

INSERT INTO imagenes_producto (id_producto, url_imagen, orden, est) VALUES
(1, '../../public/images/products/product-01.jpg', 1, 1),
(1, '../../public/images/products/product-02.jpg', 2, 1),
(2, '../../public/images/products/product-03.jpg', 1, 1),
(2, '../../public/images/products/product-04.jpg', 2, 1);


-- Insertar datos de ejemplo en la tabla ventas
INSERT INTO ventas (id_client,fecha, total, id_recibe)
VALUES 
(1,'2024-04-03 10:00:00', 150.50, 1),
(2,'2024-04-03 11:30:00', 200.75, 2),
(3,'2024-04-03 13:45:00', 100.00, 3);
-- Insertar datos de ejemplo en la tabla detalles_venta
INSERT INTO detalles_venta (id_venta, id_variante_producto, cantidad, precio_unitario, total_producto)
VALUES 
(1, 1, 2, 25.50, 51.00),
(1, 2, 1, 35.75, 35.75),
(2, 3, 3, 20.00, 60.00);

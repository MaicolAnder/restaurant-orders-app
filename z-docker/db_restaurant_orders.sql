CREATE TABLE `estados`  (
  `id_estado` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `estado` varchar(100) NOT NULL COMMENT 'Nombre de estado',
  `descripcion` varchar(500) NULL DEFAULT NULL COMMENT 'Descripcion',
  PRIMARY KEY (`id_estado`)
);

CREATE TABLE `ingredientes`  (
  `id_ingrediente` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `nombre_ingrediente` varchar(100) NOT NULL COMMENT 'Nombre del ingrediente',
  `id_estado` bigint NULL DEFAULT NULL COMMENT 'FK Tabla Estados',
  PRIMARY KEY (`id_ingrediente`)
);

CREATE TABLE `ingredientes_receta`  (
  `id_ingre_receta` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `cantidad_requerida` int NOT NULL DEFAULT 0 COMMENT 'Cantidad para preparació  de la receta',
  `id_ingrediente` bigint NOT NULL COMMENT 'FK tabla Ingredientes',
  `id_receta` bigint NOT NULL COMMENT 'FK tabla recetas',
  PRIMARY KEY (`id_ingre_receta`)
);

CREATE TABLE `ordenes`  (
  `id_orden` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `fecha_orden` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de la orden',
  `fecha_entrega` timestamp NULL COMMENT 'fecha de la entrega',
  `id_estado` bigint NOT NULL COMMENT 'FK Tabla Estados',
  `id_receta` bigint NOT NULL COMMENT 'FK Tabla Recetas',
  PRIMARY KEY (`id_orden`)
);

CREATE TABLE `recetas`  (
  `id_receta` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `nombre_receta` varchar(100) NOT NULL COMMENT 'Nombre de la receta',
  `id_estado` bigint NULL DEFAULT NULL COMMENT 'FK Tabla Estados',
  PRIMARY KEY (`id_receta`)
);

CREATE TABLE `solicitudes`  (
  `id_solicitud` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `cantidad` int NOT NULL COMMENT 'Cantidad solicitada',
  `costo` float(20) NULL COMMENT 'Costo por cantidad',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha donde se realiza el movimiento',
  `tipo_movimiento` enum('Compra','Entrega') NOT NULL DEFAULT 'Compra' COMMENT 'Tipo de movimiento realizado',
  `id_ingrediente` bigint NOT NULL COMMENT 'Ingrediente relacionado',
  PRIMARY KEY (`id_solicitud`)
);

ALTER TABLE `ingredientes` ADD CONSTRAINT `fk_ingredientes_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `ingredientes_receta` ADD CONSTRAINT `fk_ingredientes_receta_ingredientes_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`);
ALTER TABLE `ingredientes_receta` ADD CONSTRAINT `fk_ingredientes_receta_recetas_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`);
ALTER TABLE `ordenes` ADD CONSTRAINT `fk_ordenes_recetas_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`);
ALTER TABLE `ordenes` ADD CONSTRAINT `fk_ordenes_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `recetas` ADD CONSTRAINT `fk_recetas_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `solicitudes` ADD CONSTRAINT `fk_ingresos_ingredientes_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`);

INSERT INTO `estados` (`id_estado`, `estado`, `descripcion`) VALUES (1, 'Nueva orden', 'Orden nueva solicitada por el boton ');
INSERT INTO `estados` (`id_estado`, `estado`, `descripcion`) VALUES (2, 'En Preparación', 'Orden que está siendo preparada en cocina');
INSERT INTO `estados` (`id_estado`, `estado`, `descripcion`) VALUES (3, 'Entrgado', 'Orden preparada y entregada desde la cocina');
INSERT INTO `estados` (`id_estado`, `estado`, `descripcion`) VALUES (4, 'En bodega', 'Ingrediente activo en bodega');
INSERT INTO `estados` (`id_estado`, `estado`, `descripcion`) VALUES (5, 'Inactivo', 'Estado inactivo');
INSERT INTO `estados` (`id_estado`, `estado`, `descripcion`) VALUES (6, 'Activo', 'Estado activo');

INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (1, 'Tomato', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (2, 'Lemon', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (3, 'Potato', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (4, 'Rice', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (5, 'Ketchup', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (6, 'Lettuce', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (7, 'Onion', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (8, 'Cheese', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (9, 'Meat', 4);
INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `id_estado`) VALUES (10, 'Chicken', 4);

INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `id_estado`) VALUES (1, 'Receta 1', 6);
INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `id_estado`) VALUES (2, 'Receta 2', 6);
INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `id_estado`) VALUES (3, 'Receta 3', 6);
INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `id_estado`) VALUES (4, 'Receta 4', 6);
INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `id_estado`) VALUES (5, 'Receta 5', 6);
INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `id_estado`) VALUES (6, 'Receta 6', 6);

INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (1, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 1);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (2, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 2);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (3, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 3);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (4, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 4);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (5, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 5);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (6, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 6);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (7, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 7);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (8, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 8);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (9, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 9);
INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `costo`, `fecha_registro`, `tipo_movimiento`, `id_ingrediente`) VALUES (10, 5, NULL, CURRENT_TIMESTAMP, 'Compra', 10);

INSERT INTO ingredientes_receta (cantidad_requerida, id_ingrediente, id_receta)
( SELECT ROUND((RAND() * (4 - 1)) + 1) AS cantidad_requerida, i.id_ingrediente, r.id_receta 
FROM ingredientes i, recetas r );
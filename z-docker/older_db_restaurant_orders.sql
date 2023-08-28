use db_restaurant_orders;

CREATE TABLE `compras`  (
  `id_compra` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `cantidad_ingreso` int NOT NULL COMMENT 'Cantidad de producto comprado',
  `costo_ingreso` float NULL DEFAULT NULL COMMENT 'Costo de producto comprado',
  `fecha_compra` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha ingreso producto',
  `id_ingrediente` bigint NOT NULL COMMENT 'Ingrediente con movimiento',
  `id_estado` bigint NULL DEFAULT NULL COMMENT 'Estado de transaccion',
  PRIMARY KEY (`id_compra`)
);

CREATE TABLE `estados`  (
  `id_estado` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `estado` varchar(100) NOT NULL DEFAULT '' COMMENT 'Descripcion de estado',
  PRIMARY KEY (`id_estado`)
);

CREATE TABLE `ingredientes`  (
  `id_ingrediente` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK tabla',
  `nombre_ingrediente` varchar(20) NOT NULL COMMENT 'Nombre del ingrediente',
  `cantidad_disponible` int NULL DEFAULT NULL COMMENT 'Cantidad disponible del ingrediente',
  `id_estado` bigint NULL DEFAULT NULL COMMENT 'Estado del ingrediente',
  PRIMARY KEY (`id_ingrediente`)
);

CREATE TABLE `ordenes`  (
  `id_orden` bigint NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria',
  `id_plato` bigint NOT NULL COMMENT 'Plato ordenado',
  `id_estado` bigint NOT NULL COMMENT 'Estado de la orden',
  `fecha_orden` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de solicitud de orden',
  `fecha_entrega` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de entrega de orden',
  PRIMARY KEY (`id_orden`)
);

CREATE TABLE `platos`  (
  `id_plato` bigint NOT NULL AUTO_INCREMENT,
  `nombre_plato` varchar(200) NOT NULL,
  `id_estado` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`id_plato`)
);

CREATE TABLE `recetas`  (
  `id_receta` bigint NOT NULL AUTO_INCREMENT COMMENT 'PK Tabla',
  `cantidad_requerida` int NOT NULL DEFAULT 0 COMMENT 'Cantidad requerida para receta',
  `id_plato` bigint NOT NULL COMMENT 'Plato seleccionado',
  `id_ingrediente` bigint NOT NULL COMMENT 'Ingrediente requerido',
  `id_estado` bigint NULL DEFAULT NULL COMMENT 'Estado de la receta',
  PRIMARY KEY (`id_receta`)
);

ALTER TABLE `compras` ADD CONSTRAINT `fk_compras_ingredientes_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`);
ALTER TABLE `compras` ADD CONSTRAINT `fk_compras_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `ingredientes` ADD CONSTRAINT `fk_ingredientes_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `ordenes` ADD CONSTRAINT `fk_ordenes_platos_1` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`);
ALTER TABLE `ordenes` ADD CONSTRAINT `fk_ordenes_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `platos` ADD CONSTRAINT `fk_platos_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);
ALTER TABLE `recetas` ADD CONSTRAINT `fk_recetas_ingredientes_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`);
ALTER TABLE `recetas` ADD CONSTRAINT `fk_recetas_platos_1` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`);
ALTER TABLE `recetas` ADD CONSTRAINT `fk_recetas_estados_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);


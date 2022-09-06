/*
 Navicat Premium Data Transfer

 Source Server         : localhost_docker_recetas
 Source Server Type    : MySQL
 Source Server Version : 50737
 Source Host           : localhost:3037
 Source Schema         : db_empresa1_1

 Target Server Type    : MySQL
 Target Server Version : 50737
 File Encoding         : 65001

 Date: 24/03/2022 19:17:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ingredientes
-- ----------------------------
DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE `ingredientes`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `precio_base` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00,
  `registro_sanitario` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `elaborado_por` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `fecha_ultima_revision` date NULL DEFAULT NULL,
  `imagen` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ingredientes
-- ----------------------------
INSERT INTO `ingredientes` VALUES (1, 'yogurt entero danone', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 20:47:04', '2022-03-18 21:01:59', NULL);
INSERT INTO `ingredientes` VALUES (2, 'agua', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 20:53:54', '2022-03-18 21:02:12', NULL);
INSERT INTO `ingredientes` VALUES (3, 'nata 35 mg', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 20:55:38', '2022-03-18 20:55:38', NULL);
INSERT INTO `ingredientes` VALUES (4, 'leche en polvo 1% mg', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 20:57:12', '2022-03-18 20:57:12', NULL);
INSERT INTO `ingredientes` VALUES (5, 'proteína lactea', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:01:05', '2022-03-18 21:01:27', NULL);
INSERT INTO `ingredientes` VALUES (6, 'sacarosa', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:04:31', '2022-03-18 21:04:31', NULL);
INSERT INTO `ingredientes` VALUES (7, 'dextrosa', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:06:43', '2022-03-18 21:06:43', NULL);
INSERT INTO `ingredientes` VALUES (8, 'leche condensada azucarada', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:11:12', '2022-03-18 21:11:12', NULL);
INSERT INTO `ingredientes` VALUES (9, 'cremodan se 30', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:13:26', '2022-03-18 21:13:26', NULL);
INSERT INTO `ingredientes` VALUES (10, 'mantequilla', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:14:53', '2022-03-18 21:14:53', NULL);
INSERT INTO `ingredientes` VALUES (11, 'aceite de oliva', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:18:00', '2022-03-18 21:42:19', NULL);
INSERT INTO `ingredientes` VALUES (12, 'cerveza', 0.00, '', '', '2018-05-09', NULL, '2022-03-18 21:19:12', '2022-03-18 21:19:12', NULL);

-- ----------------------------
-- Table structure for ingredientes_atributos
-- ----------------------------
DROP TABLE IF EXISTS `ingredientes_atributos`;
CREATE TABLE `ingredientes_atributos`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `azucares` double NULL DEFAULT 0,
  `materia_grasa_lactea` double NULL DEFAULT 0,
  `materia_grasa_no_lactea` double NULL DEFAULT 0,
  `solidos_no_grasos_de_la_leche` double NULL DEFAULT 0,
  `otros_solidos` double NULL DEFAULT 0,
  `proteinas_lacteas` double NULL DEFAULT 0,
  `lactosa` double NULL DEFAULT 0,
  `poder_anticongelante` double NULL DEFAULT 0,
  `dulzor_relativo` double NULL DEFAULT 0,
  `peso_molecular_azucares` double NULL DEFAULT 0,
  `altramuces` bit(1) NULL DEFAULT NULL,
  `apio` bit(1) NULL DEFAULT NULL,
  `cacahuetes` bit(1) NULL DEFAULT NULL,
  `crustaceos` bit(1) NULL DEFAULT NULL,
  `frutos_secos` bit(1) NULL DEFAULT NULL,
  `gluten` bit(1) NULL DEFAULT NULL,
  `huevos` bit(1) NULL DEFAULT NULL,
  `leche` bit(1) NULL DEFAULT NULL,
  `moluscos` bit(1) NULL DEFAULT NULL,
  `mostaza` bit(1) NULL DEFAULT NULL,
  `pescado` bit(1) NULL DEFAULT NULL,
  `sesamo` bit(1) NULL DEFAULT NULL,
  `soya` bit(1) NULL DEFAULT NULL,
  `sulfitos` bit(1) NULL DEFAULT NULL,
  `humedad` double NULL DEFAULT 0,
  `parte_seca` double NULL DEFAULT 0,
  `volumen_especifico` double NULL DEFAULT 0,
  `orden_pasteurizacion` double NULL DEFAULT 0,
  `alcohol` double NULL DEFAULT 0,
  `energia_kcal` double NULL DEFAULT 0,
  `energia_kj` double NULL DEFAULT 0,
  `grasas` double NULL DEFAULT 0,
  `grasa_saturadas` double NULL DEFAULT 0,
  `hidratos_de_carbono` double NULL DEFAULT 0,
  `hidratos_de_carbono_azucares` double NULL DEFAULT 0,
  `fibras` double NULL DEFAULT 0,
  `proteinas` double NULL DEFAULT 0,
  `sales` double NULL DEFAULT 0,
  `ingrediente_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ingredientes_atributos
-- ----------------------------
INSERT INTO `ingredientes_atributos` VALUES (1, 7.04, 2.9, 0, 5.25, 0, 0, 0, -0.64, 15, 342, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', 0, 15.19, 0, 4, 0, 63, 263.77, 1.55, 1, 7.04, 7.04, 0, 5.25, 0.07, 1);
INSERT INTO `ingredientes_atributos` VALUES (2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.001, 2);
INSERT INTO `ingredientes_atributos` VALUES (3, 3.1, 35, 0, 2, 0, 0, 0, -0.64, 15, 342, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', 0, 40.1, 0, 1, 0, 335, 1402.5, 35, 24, 3.1, 3.1, 0, 2, 0.001, 3);
INSERT INTO `ingredientes_atributos` VALUES (4, 53, 0, 0, 33, 0, 0, 0, -0.64, 15, 342, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', 0, 86, 0, 2, 0, 353, 1477.9, 1, 0.67, 53, 53, 0, 33, 1.4, 4);
INSERT INTO `ingredientes_atributos` VALUES (5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', 0, 0, 0, 1, 0, 274.67, 1150, 0, 0, 0, 0, 0, 0, 1.5, 5);
INSERT INTO `ingredientes_atributos` VALUES (6, 100, 0, 0, 0, 0, 0, 0, -0.64, 100, 342, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 0, 100, 0, 2, 0, 331, 1385, 0, 0, 100, 100, 0, 0, 0, 6);
INSERT INTO `ingredientes_atributos` VALUES (7, 91, 0, 0, 0, 0, 0, 0, -1.22, 70, 180, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 0, 91, 0, 2, 0, 355, 1528.1, 0, 0, 91, 91, 0, 0, 0.01, 7);
INSERT INTO `ingredientes_atributos` VALUES (8, 52.84, 9, 0, 20.21, 0, 0, 11.7, -0.64, 100, 342, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', 0, 93.75, 0, 2, 0, 336, 1406.7, 10.1, 6.3, 52.64, 52.64, 0, 8.51, 0, 8);
INSERT INTO `ingredientes_atributos` VALUES (9, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 0, 1, 0, 2, 0, 660, 2763.2, 68, 67, 0, 0, 24, 1, 0, 9);
INSERT INTO `ingredientes_atributos` VALUES (10, 0, 82, 0, 0.25, 0, 0, 0, -0.64, 15, 1, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', 0, 82.25, 0, 3, 0, 897, 3755.5, 99.5, 62.66, 1, 0, 0, 0.25, 0, 10);
INSERT INTO `ingredientes_atributos` VALUES (11, 0, 0, 100, 1, 0, 0, 0, 0, 0, 1, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 0, 100, 0, 3, 0, 899, 3763.9, 99.9, 14.3, 0, 0, 0, 1, 0, 11);
INSERT INTO `ingredientes_atributos` VALUES (12, 0.16, 0, 0, 0.5, 0, 0, 0, -0.64, 100, 342, b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 0, 0.66, 0, 4, 4.5, 42.4, 177.52, 0, 0, 3.12, 0.16, 0, 0.5, 0, 12);

-- ----------------------------
-- Table structure for ingredientes_datos_generales
-- ----------------------------
DROP TABLE IF EXISTS `ingredientes_datos_generales`;
CREATE TABLE `ingredientes_datos_generales`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `observacion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `descripcion_resumida` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `descripcion_adicional` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `anotaciones` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `proceso_de_elaboracion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `envasado` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `etiquetado` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `almacenamiento_ubicacion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `forma_uso` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `vida_util` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `poblacion_destino` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `ingrediente_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ingredientes_datos_generales
-- ----------------------------
INSERT INTO `ingredientes_datos_generales` VALUES (1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `ingredientes_datos_generales` VALUES (2, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2);
INSERT INTO `ingredientes_datos_generales` VALUES (3, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3);
INSERT INTO `ingredientes_datos_generales` VALUES (4, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4);
INSERT INTO `ingredientes_datos_generales` VALUES (5, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5);
INSERT INTO `ingredientes_datos_generales` VALUES (6, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6);
INSERT INTO `ingredientes_datos_generales` VALUES (7, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7);
INSERT INTO `ingredientes_datos_generales` VALUES (8, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8);
INSERT INTO `ingredientes_datos_generales` VALUES (9, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9);
INSERT INTO `ingredientes_datos_generales` VALUES (10, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10);
INSERT INTO `ingredientes_datos_generales` VALUES (11, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11);
INSERT INTO `ingredientes_datos_generales` VALUES (12, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12);

-- ----------------------------
-- Table structure for recetas
-- ----------------------------
DROP TABLE IF EXISTS `recetas`;
CREATE TABLE `recetas`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `visualizar` tinyint(1) UNSIGNED NULL DEFAULT 0,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of recetas
-- ----------------------------
INSERT INTO `recetas` VALUES (1, 'nueva receta', 0, '2022-03-18 21:19:55', '2022-03-18 21:19:55', NULL);

-- ----------------------------
-- Table structure for recetas_versiones
-- ----------------------------
DROP TABLE IF EXISTS `recetas_versiones`;
CREATE TABLE `recetas_versiones`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `peso_deseado` decimal(10, 2) NULL DEFAULT 0.00,
  `receta_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of recetas_versiones
-- ----------------------------
INSERT INTO `recetas_versiones` VALUES (1, 'versión 1', 0.00, 1, '2022-03-18 21:20:21', '2022-03-18 21:20:21', NULL);
INSERT INTO `recetas_versiones` VALUES (2, 'versión 2', 0.00, 1, '2022-03-19 11:29:41', '2022-03-19 11:29:41', NULL);

-- ----------------------------
-- Table structure for recetas_versiones_ingredientes
-- ----------------------------
DROP TABLE IF EXISTS `recetas_versiones_ingredientes`;
CREATE TABLE `recetas_versiones_ingredientes`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ingrediente_id` smallint(5) UNSIGNED NOT NULL,
  `peso` double NULL DEFAULT NULL,
  `topping` bit(1) NULL DEFAULT NULL,
  `receta_version_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of recetas_versiones_ingredientes
-- ----------------------------
INSERT INTO `recetas_versiones_ingredientes` VALUES (1, 11, 1, b'0', 1);
INSERT INTO `recetas_versiones_ingredientes` VALUES (2, 12, 1, b'0', 1);

SET FOREIGN_KEY_CHECKS = 1;

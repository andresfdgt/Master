/*
 Navicat Premium Data Transfer

 Source Server         : localhost_docker_recetas
 Source Server Type    : MySQL
 Source Server Version : 50737
 Source Host           : localhost:3037
 Source Schema         : recetas_universal

 Target Server Type    : MySQL
 Target Server Version : 50737
 File Encoding         : 65001

 Date: 19/04/2022 22:03:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cif_dni` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL DEFAULT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `razon_social` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `telefono` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `telefono_2` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `longitud` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `latitud` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `pais` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `estado` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '0=inactivo,1=activo,2=mora,3=vencido',
  `observacion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `codigo_postal` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `localidad` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `provincia` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `usuario_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES (1, '1234567890', 'cliente1', 'razon cliente 1', '0987654321', '0987654321', 'calla falsa 123', 'cliente1@demo.com', NULL, NULL, 'colombia', 1, 'nuevo cliente 1', '205010', 'aguachica', 'cesar', 1, '2022-03-18 20:00:53', '2022-03-18 20:00:53', NULL);
INSERT INTO `clientes` VALUES (2, '9087654321', 'cliente2', 'razon cliente2', '896745231', '896745231', 'calle 123', 'cliente2@demo.com', NULL, NULL, 'colombia', 1, 'observacion 2', '205010', 'aguachica', 'cesar', 2, '2022-03-19 10:24:34', '2022-03-19 10:24:34', NULL);

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `formato_fecha` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `logo` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `pais_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `decimales` tinyint(3) UNSIGNED NULL DEFAULT 2,
  `empresa_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES (1, 'd-m-Y', '', 1, 1, '2022-04-08 01:43:14');

-- ----------------------------
-- Table structure for empresas
-- ----------------------------
DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `razon_social` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `telefono` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `longitud` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `latitud` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `imagen` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `estado` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '0=inactivo,1=activo',
  `cif` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL DEFAULT NULL,
  `pais` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `codigo_postal` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `localidad` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `cliente_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `contacto` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `host` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `base_datos` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `user_db` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `password_db` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  `puerto` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of empresas
-- ----------------------------
INSERT INTO `empresas` VALUES (1, 'empresa 1', 'razon empresa 1', '1234567890', 'calla falsa 123', 'empresa1@damo.com', NULL, NULL, NULL, 1, '12121212', 'colombia', '205010', 'aguachica', 1, 'cliente 1', NULL, 'empresa1_1', NULL, NULL, NULL, '2022-03-18 20:03:17', '2022-03-18 20:03:17', NULL);
INSERT INTO `empresas` VALUES (2, 'empres 2', 'razon empresa 2', '1234567890', 'calla falsa 123', 'empresa2@damo.com', NULL, NULL, NULL, 1, '901287343487847', 'colombia', '205010', 'aguachica', 2, 'contacto dos', NULL, 'empresa2_2', 'demo@demo.com', '12345678', NULL, '2022-03-19 10:42:37', '2022-03-19 10:42:37', NULL);

-- ----------------------------
-- Table structure for localidades
-- ----------------------------
DROP TABLE IF EXISTS `localidades`;
CREATE TABLE `localidades` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `provincia_id` smallint(5) unsigned DEFAULT NULL,
  `codigo_postal` varchar(50) DEFAULT NULL NULL,
  `latitud` varchar(255) NULL DEFAULT NULL,
  `longitud` varchar(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
  INDEX localidades_codigo_postal_IDX ON localidades (codigo_postal);
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2021_09_14_154405_create_permission_tables', 2);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `empresa_id` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`, `empresa_id`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for modulos
-- ----------------------------
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `estado` bit(1) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `update_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of modulos
-- ----------------------------
INSERT INTO `modulos` VALUES (1, 'equilibrados', b'1', '2022-03-09 18:40:44', '2022-03-09 18:40:47');
INSERT INTO `modulos` VALUES (2, 'formularios', b'1', '2022-03-28 13:14:59', '2022-03-28 13:15:02');
INSERT INTO `modulos` VALUES (10000, 'System', b'1', '2022-03-14 21:38:42', '2022-03-14 21:38:46');

-- ----------------------------
-- Table structure for modulos_empresas
-- ----------------------------
DROP TABLE IF EXISTS `modulos_empresas`;
CREATE TABLE `modulos_empresas`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `modulo_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of modulos_empresas
-- ----------------------------
INSERT INTO `modulos_empresas` VALUES (1, 1, 1);
INSERT INTO `modulos_empresas` VALUES (2, 2, 1);

-- ----------------------------
-- Table structure for paises
-- ----------------------------
DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `utc` tinyint(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of paises
-- ----------------------------
INSERT INTO `paises` VALUES (1, 'colombia', -5);
INSERT INTO `paises` VALUES (2, 'españa', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modulo_id` smallint(5) UNSIGNED NOT NULL,
  `grupo` smallint(255) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'ingredientes', 1, 1, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (2, 'crear_ingrediente', 1, 1, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (3, 'editar_ingrediente', 1, 1, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (4, 'eliminar_ingrediente', 1, 1, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (50, 'recetas', 1, 2, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (51, 'crear_receta', 1, 2, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (52, 'editar_receta', 1, 2, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (53, 'eliminar_receta', 1, 2, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (54, 'visualizar receta', 1, 2, '2022-03-09 19:11:27', '2022-03-09 19:11:27');
INSERT INTO `permissions` VALUES (55, 'imprimir', 1, 2, '2022-03-19 09:37:25', '2022-03-19 09:37:28');
INSERT INTO `permissions` VALUES (56, 'ficha tecnica', 1, 2, '2022-03-19 09:37:43', '2022-03-19 09:37:47');
INSERT INTO `permissions` VALUES (10000, 'usuarios', 10000, 1, '2022-03-14 21:38:42', '2022-03-14 21:38:46');
INSERT INTO `permissions` VALUES (10001, 'crear_usuarios', 10000, 1, '2022-03-14 21:38:42', '2022-03-14 21:38:46');
INSERT INTO `permissions` VALUES (10002, 'editar_usuarios', 10000, 1, '2022-03-14 21:59:49', '2022-03-14 21:59:49');
INSERT INTO `permissions` VALUES (10003, 'eliminar_usuarios', 10000, 1, '2022-03-14 21:59:49', '2022-03-14 21:59:49');
INSERT INTO `permissions` VALUES (10004, 'estado_usuarios', 10000, 1, '2022-03-14 21:59:49', '2022-03-14 21:59:49');
INSERT INTO `permissions` VALUES (10051, 'empresas', 10000, 2, '2022-03-14 22:00:44', '2022-03-14 22:00:44');
INSERT INTO `permissions` VALUES (10052, 'crear_empresas', 10000, 2, '2022-03-14 22:03:31', '2022-03-14 22:03:31');
INSERT INTO `permissions` VALUES (10053, 'editar_empresas', 10000, 2, '2022-03-14 22:03:31', '2022-03-14 22:03:31');
INSERT INTO `permissions` VALUES (10054, 'eliminar_empresas', 10000, 2, '2022-03-14 22:03:31', '2022-03-14 22:03:31');
INSERT INTO `permissions` VALUES (10055, 'estado_empresa', 10000, 2, '2022-03-15 19:59:58', '2022-03-15 20:00:00');
INSERT INTO `permissions` VALUES (10101, 'roles', 10000, 3, '2022-03-14 22:00:44', '2022-03-14 22:00:44');
INSERT INTO `permissions` VALUES (10102, 'crear_roles', 10000, 3, '2022-03-14 22:03:31', '2022-03-14 22:03:31');
INSERT INTO `permissions` VALUES (10103, 'editar_roles', 10000, 3, '2022-03-14 22:03:31', '2022-03-14 22:03:31');
INSERT INTO `permissions` VALUES (10104, 'eliminar_roles', 10000, 3, '2022-03-14 22:03:31', '2022-03-14 22:03:31');
INSERT INTO `permissions` VALUES (10151, 'perfil', 10000, 4, '2022-03-14 22:09:27', '2022-03-14 22:09:30');
INSERT INTO `permissions` VALUES (10152, 'editar_perfil', 10000, 4, '2022-03-14 22:09:46', '2022-03-14 22:09:49');
INSERT INTO `permissions` VALUES (10201, 'configuracion', 10000, 4, '2022-03-16 12:30:07', '2022-03-16 12:30:09');
INSERT INTO `permissions` VALUES (10202, 'estado_configuracion', 10000, 4, '2022-03-16 12:30:07', '2022-03-16 12:30:09');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for roles_app
-- ----------------------------
DROP TABLE IF EXISTS `roles_app`;
CREATE TABLE `roles_app`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles_app
-- ----------------------------
INSERT INTO `roles_app` VALUES (1, 'nuevo rol', 1, '2022-03-19 12:10:55', '2022-03-19 12:10:55');

-- ----------------------------
-- Table structure for roles_permisos
-- ----------------------------
DROP TABLE IF EXISTS `roles_permisos`;
CREATE TABLE `roles_permisos`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles_permisos
-- ----------------------------
INSERT INTO `roles_permisos` VALUES (1, 1);
INSERT INTO `roles_permisos` VALUES (2, 1);
INSERT INTO `roles_permisos` VALUES (3, 1);
INSERT INTO `roles_permisos` VALUES (4, 1);
INSERT INTO `roles_permisos` VALUES (50, 1);
INSERT INTO `roles_permisos` VALUES (51, 1);
INSERT INTO `roles_permisos` VALUES (52, 1);
INSERT INTO `roles_permisos` VALUES (53, 1);
INSERT INTO `roles_permisos` VALUES (54, 1);
INSERT INTO `roles_permisos` VALUES (55, 1);
INSERT INTO `roles_permisos` VALUES (56, 1);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `payload` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `last_activity` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `last_activity`(`last_activity`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('xwosjiIRBg5DoUzHCk0FXPNbIVM6Id59JPTaHFgt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoidG5iR1BjMUw5anVYMVVJR21lYVZ0ZFlIZVBiOFZqYmVudFl4MzVLRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9pbmdyZWRpZW50ZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTM6ImZvcm1hdG9fZmVjaGEiO3M6NToiZC1tLVkiO3M6MzoidXRjIjtpOi01O3M6ODoiZW1wcmVzYXMiO2k6MTt9', 1649384751);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `rol` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(3) UNSIGNED NOT NULL,
  `base_datos` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `last_empresa_id` smallint(5) UNSIGNED NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email_verified_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `last_login_at` datetime(0) NULL DEFAULT NULL,
  `last_login_ip` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `unique_id`(`unique_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, '4595d249-62d0-4680-a272-ef7a19f7ffae', 'cliente1', 'cliente1@demo.com', '$2y$10$r1fnmfqcRLslbKrYOw9dk..L9sfoZNCLha3ngzR9ozup0WHBsZ6x6', 'master', 1, 'empresa1_1', 1, 'ZvRf0wi5fImNey3FmPMP0uIIeRpfUKGxaaF04sdqXdo4kPxoKpR33L83DehH', NULL, '2022-03-18 20:00:53', '2022-03-18 20:00:53', NULL, '2022-04-08 02:07:33', '127.0.0.1');
INSERT INTO `usuarios` VALUES (2, '03136263-b58a-49ff-b1dd-c65b4553ae2d', 'cliente2', 'cliente2@demo.com', '$2y$10$r1fnmfqcRLslbKrYOw9dk..L9sfoZNCLha3ngzR9ozup0WHBsZ6x6', 'master', 1, 'empresa2_2', 2, NULL, NULL, '2022-03-19 10:24:34', '2022-03-19 10:24:34', NULL, '2022-03-19 10:43:43', '192.168.137.252');

-- ----------------------------
-- Table structure for usuarios_admin
-- ----------------------------
DROP TABLE IF EXISTS `usuarios_admin`;
CREATE TABLE `usuarios_admin`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `rol` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(3) UNSIGNED NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `email_verified_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `last_login_at` datetime(0) NULL DEFAULT NULL,
  `last_login_ip` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuarios_admin
-- ----------------------------
INSERT INTO `usuarios_admin` VALUES (1, 'demo', 'demo@demo.com', '$2y$10$iKTS4ytGlido/LhMJFAfOOBrMXu5C.vjnGaVVqpcvS8cL1StotkJq', 'master', 1, NULL, '2022-03-18 19:58:32', '2022-03-18 19:58:34', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for usuarios_empresas
-- ----------------------------
DROP TABLE IF EXISTS `usuarios_empresas`;
CREATE TABLE `usuarios_empresas`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` smallint(5) UNSIGNED NOT NULL,
  `empresa_id` smallint(5) UNSIGNED NOT NULL,
  `rol_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuarios_empresas
-- ----------------------------
INSERT INTO `usuarios_empresas` VALUES (1, 1, 1, 0);
INSERT INTO `usuarios_empresas` VALUES (2, 2, 2, 0);

-- ----------------------------
-- Procedure structure for modulo_calendarios
-- ----------------------------
DROP PROCEDURE IF EXISTS `modulo_calendarios`;
delimiter ;;
CREATE PROCEDURE `modulo_calendarios`(IN `db_name` CHAR(45))
BEGIN

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'cal_calendarios  (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  descripcion text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  fecha_inicio datetime(0) NULL DEFAULT NULL,
  fecha_fin datetime(0) NULL DEFAULT NULL,
  coloboradores json NULL,
  archivos json NULL,
  color text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  tipo_id tinyint(3) UNSIGNED NULL DEFAULT NULL,
  calendario_id int(10) UNSIGNED NULL DEFAULT NULL,
  created_at datetime(0) NULL DEFAULT NULL,
  updated_at datetime(0) NULL DEFAULT NULL,
  deleted_at datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'cal_colores  (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  hexadecimal text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (1, "Azul claro", "#0488bf")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (2, "Coral", "#d86b67")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (3, "Azul arándano", "#232a44")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (4, "Azul lavanda", "#87ccdb")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (5, "Verde claro", "#23933e")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (6, "Naranja", "#db9d25")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (7, "Gris", "#dbdcde")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (8, "Amarillo", "#f2f4b1")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (9, "Tomate", "#d50001")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (10, "Flamenco", "#e77c75")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (11, "Mandarina", "#f5511e")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (12, "Banana", "#f7bf26")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (13, "Salvia", "#32b679")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (14, "Albahaca", "#0a8142")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (15, "Pavo real", "#039be6")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (16, "Arándano", "#3f51b5")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (17, "Lavanda", "#7a85cc")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (18, "Uva", "#8e24aa")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_colores VALUES (19, "Grafito", "#606060")');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'cal_cuentas  (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  email text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  id_account bigint(20) UNSIGNED NULL DEFAULT NULL,
  picture text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  verified_email bit(1) NULL DEFAULT NULL,
  access_token text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  expires_in int(10) UNSIGNED NULL DEFAULT NULL,
  refresh_token text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  id_token text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  created_at datetime(0) NULL DEFAULT NULL,
  updated_at datetime(0) NULL DEFAULT NULL,
  deleted_at datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'cal_eventos  (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  descripcion text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  estado bit(1) NULL DEFAULT NULL,
  color text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  created_at datetime(0) NULL DEFAULT NULL,
  updated_at datetime(0) NULL DEFAULT NULL,
  deleted_at datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'cal_tipos  (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  color text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  hexadecimal text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (1, "Entradas", "Azul claro", "#0488bf")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (2, "Salidas", "Coral", "#d86b67")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (3, "Salidas Fase V", "Azul arándano", "#232a44")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (4, "Salidas ICFC", "Azul lavanda", "#87ccdb")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (5, "Salidas MCD", "Verde claro", "#23933e")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (6, "Contenedores E/S", "Naranja", "#db9d25")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (7, "Camiones cargados/descargados", "Gris", "#dbdcde")');
PREPARE f FROM @sql1;
EXECUTE f;
SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'cal_tipos VALUES (8, "Camión a la espera o en muelle", "Amarillo", "#f2f4b1")');
PREPARE f FROM @sql1;
EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for modulo_equilibrados
-- ----------------------------
DROP PROCEDURE IF EXISTS `modulo_equilibrados`;
delimiter ;;
CREATE PROCEDURE `modulo_equilibrados`(IN `db_name` CHAR(45))
BEGIN

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'equ_ingredientes  (
 id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 nombre text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 precio_base decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0,
 registro_sanitario text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 elaborado_por text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 fecha_ultima_revision date NULL DEFAULT NULL,
 imagen text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 created_at datetime(0) NULL DEFAULT NULL,
 updated_at datetime(0) NULL DEFAULT NULL,
 deleted_at datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

	SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'equ_ingredientes_atributos  (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  azucares double NULL DEFAULT 0,
  materia_grasa_lactea double NULL DEFAULT 0,
  materia_grasa_no_lactea double NULL DEFAULT 0,
  solidos_no_grasos_de_la_leche double NULL DEFAULT 0,
  otros_solidos double NULL DEFAULT 0,
  proteinas_lacteas double NULL DEFAULT 0,
  lactosa double NULL DEFAULT 0,
  poder_anticongelante double NULL DEFAULT 0,
  dulzor_relativo double NULL DEFAULT 0,
  peso_molecular_azucares double NULL DEFAULT 0,
  altramuces bit(1) NULL DEFAULT NULL,
  apio bit(1) NULL DEFAULT NULL,
  cacahuetes bit(1) NULL DEFAULT NULL,
  crustaceos bit(1) NULL DEFAULT NULL,
  frutos_secos bit(1) NULL DEFAULT NULL,
  gluten bit(1) NULL DEFAULT NULL,
  huevos bit(1) NULL DEFAULT NULL,
  leche bit(1) NULL DEFAULT NULL,
  moluscos bit(1) NULL DEFAULT NULL,
  mostaza bit(1) NULL DEFAULT NULL,
  pescado bit(1) NULL DEFAULT NULL,
  sesamo bit(1) NULL DEFAULT NULL,
  soya bit(1) NULL DEFAULT NULL,
  sulfitos bit(1) NULL DEFAULT NULL,
  humedad double NULL DEFAULT 0,
  parte_seca double NULL DEFAULT 0,
  volumen_especifico double NULL DEFAULT 0,
  orden_pasteurizacion double NULL DEFAULT 0,
  alcohol double NULL DEFAULT 0,
  energia_kcal double NULL DEFAULT 0,
  energia_kj double NULL DEFAULT 0,
  grasas double NULL DEFAULT 0,
  grasa_saturadas double NULL DEFAULT 0,
  hidratos_de_carbono double NULL DEFAULT 0,
  hidratos_de_carbono_azucares double NULL DEFAULT 0,
  fibras double NULL DEFAULT 0,
  proteinas double NULL DEFAULT 0,
  sales double NULL DEFAULT 0,
  ingrediente_id smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = DYNAMIC;');
PREPARE f FROM @sql1;
EXECUTE f;

	SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'equ_ingredientes_datos_generales  (
 id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 observacion text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 descripcion_resumida text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 descripcion_adicional text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 anotaciones text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 proceso_de_elaboracion text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 envasado text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 etiquetado text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 almacenamiento_ubicacion text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 forma_uso text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 vida_util text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 poblacion_destino text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
 ingrediente_id smallint(5) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'equ_recetas  (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
	visualizar tinyint(1) UNSIGNED NULL DEFAULT 0,
  created_at datetime(0) NULL DEFAULT NULL,
  updated_at datetime(0) NULL DEFAULT NULL,
  deleted_at datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'equ_recetas_versiones  (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NULL,
  peso_deseado decimal(10, 2) NULL DEFAULT 0,
  receta_id smallint(5) UNSIGNED NOT NULL,
  created_at datetime(0) NULL DEFAULT NULL,
  updated_at datetime(0) NULL DEFAULT NULL,
  deleted_at datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'equ_recetas_versiones_ingredientes  (
  id mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  ingrediente_id smallint(5) UNSIGNED NOT NULL,
	topping bit(1) NULL DEFAULT NULL,
	peso double NULL DEFAULT 0,
  receta_version_id smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (id) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci ROW_FORMAT = Dynamic;');
PREPARE f FROM @sql1;
EXECUTE f;

END
;;
delimiter ;


-- ----------------------------
-- Procedure structure for general_agencias_transporte
-- ----------------------------
DROP PROCEDURE IF EXISTS `general_agencias_transporte`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_agencias_transporte`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_agencias_transporte (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    favorito bit(1) NOT NULL DEFAULT 0,
    observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for general_iva_articulos
-- ----------------------------
DROP PROCEDURE IF EXISTS `general_iva_articulos`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_iva_articulos`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_iva_articulos (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    favorito bit(1) NOT NULL DEFAULT 0,
    iva double NOT NULL DEFAULT 0,
    recargo double NOT NULL DEFAULT 0,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for general_iva_clientes
-- ----------------------------
DROP PROCEDURE IF EXISTS `general_iva_clientes`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_iva_clientes`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_iva_clientes (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    favorito bit(1) NOT NULL DEFAULT 0,
    iva double NOT NULL DEFAULT 0,
    recargo double NOT NULL DEFAULT 0,
    observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for general_numeraciones
-- ----------------------------
DROP PROCEDURE IF EXISTS `general_numeraciones`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_numeraciones`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_numeraciones (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    favorito bit(1) NOT NULL DEFAULT 0,
    tipo_serie varchar(50) NOT NULL,
    identificador varchar(15) NOT NULL,
    siguiente_numero integer NOT NULL DEFAULT 1,
    rellenar_con_ceros bit(1) NOT NULL DEFAULT 0,
    numero_digitos integer NOT NULL DEFAULT 0,
    observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END
;;
delimiter ;



-- ----------------------------
-- Procedure structure for general_categorias
-- ----------------------------
DROP PROCEDURE IF EXISTS `general_categorias`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_categorias`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_categorias (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    aparece_en_web bit(1) NOT NULL DEFAULT 0,
    orden integer NOT NULL DEFAULT 1,
    slug varchar(15) NOT NULL,
    padre integer NULL DEFAULT NULL,
    imagen varchar(255) NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for general_tipo_portes
-- ----------------------------
DROP PROCEDURE IF EXISTS `general_tipo_portes`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_tipo_portes`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_tipo_portes (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    favorito bit(1) NOT NULL DEFAULT 0,
    observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for general_marcas
-- ----------------------------
CREATE DEFINER=`root`@`%` PROCEDURE `general_marcas`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_marcas (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    imagen varchar(255) NULL DEFAULT NULL,
		favorito bit(1) NOT NULL DEFAULT 0,
		observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END

-- ----------------------------
-- Procedure structure for general_tarifas
-- ----------------------------
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general_tarifas`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_tarifas (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    tipo enum("%dcto","importe","%incr") CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "%dcto",
    valor double NOT NULL DEFAULT 0,
    ivaincluido enum("no","si") CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "no",
    observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END

-- ----------------------------
-- Procedure structure for general_formas_pago
-- ----------------------------
CREATE DEFINER=`root`@`%` PROCEDURE `general_formas_pago`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_formas_pago (
        id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        descripcion varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
        favorito bit(1) NOT NULL DEFAULT 0,
        a_cartera bit(1) NOT NULL DEFAULT 0,
        remesable bit(1) NOT NULL DEFAULT 0,
        observaciones blob NULL DEFAULT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END

-- ----------------------------
-- Procedure structure for general_vencimientos
-- ----------------------------
CREATE DEFINER=`root`@`%` PROCEDURE `general_vencimientos`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('CREATE TABLE IF NOT EXISTS db_', db_name,'.' ,'gen_vencimientos (
        id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        porcentaje double NOT NULL DEFAULT 0,
        dias int UNSIGNED NOT NULL DEFAULT 0,
        forma_pago_id int(10) UNSIGNED NOT NULL,
    created_at datetime(0) NULL DEFAULT NULL,
    updated_at datetime(0) NULL DEFAULT NULL,
    deleted_at datetime(0) NULL DEFAULT NULL,
    PRIMARY KEY (id) USING BTREE,
    CONSTRAINT `gen_vencimientos_forma_pago_id_foreign` FOREIGN KEY(forma_pago_id) REFERENCES gen_formas_pago(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;');
    PREPARE f FROM @sql1;
    EXECUTE f;

END

-- ----------------------------
-- Procedure structure for inicio_esp
-- ----------------------------
DROP PROCEDURE IF EXISTS `inicio_esp`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `master`.`inicio_esp`(IN `db_name` CHAR(45))
BEGIN

    SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'gen_agencias_transporte VALUES (1, "Sin agencia de transporte", 1, NOW(), NOW(), NULL)');
		PREPARE f FROM @sql1;
		EXECUTE f;

    SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'gen_iva_articulos VALUES
		(1, "IVA general", 1, 21, 5.2, NOW(), NOW(), NULL),
		(2, "IVA reducido", 0, 10, 1.4, NOW(), NOW(), NULL),
		(3, "IVA superreducido", 0, 4, 0.5, NOW(), NOW(), NULL)');
		PREPARE f FROM @sql1;
		EXECUTE f;

     SET @sql1 = CONCAT('INSERT INTO db_', db_name,'.' ,'gen_iva_clientes VALUES
		(1, "Exento", 1, 0, 0, NULL, NOW(), NOW(), NULL),
		(2, "Sin recargo", 0, 0, 0, NULL, NOW(), NOW(), NULL),
		(3, "Con recargo", 0, 0, 0, NULL, NOW(), NOW(), NULL),
		(4, "Bienes de inversión", 0, 0, 0, NULL, NOW(), NOW(), NULL),
		(5, "Sujeto pasivo", 0, 0, 0, NULL, NOW(), NOW(), NULL)');
		PREPARE f FROM @sql1;
		EXECUTE f;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for nueva_base_datos
-- ----------------------------
DROP PROCEDURE IF EXISTS `nueva_base_datos`;
delimiter ;;
CREATE PROCEDURE `nueva_base_datos`(IN `nombre_db` CHAR(45))
BEGIN
	declare db_name CHAR(45);
	SET db_name = nombre_db;

	SET @s = CONCAT('CREATE DATABASE IF NOT EXISTS db_', db_name);
	PREPARE stmt_create FROM @s;
	EXECUTE stmt_create;

	CALL modulo_equilibrados(db_name);
	CALL modulo_calendarios(db_name);
    CALL modulo_formularios(db_name);
    CALL modulo_erp(db_name);
    CALL general(db_name);
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------
-- Procedure structure for general
-- ----------------------------
DROP PROCEDURE IF EXISTS `general`;
delimiter ;;

    CREATE DEFINER=`root`@`%` PROCEDURE `master`.`general`(IN `nombre_db` CHAR(45))
    BEGIN
        declare db_name CHAR(45);
        SET db_name = nombre_db;

        CALL general_agencias_transporte(db_name);
        CALL general_iva_articulos(db_name);
        CALL general_numeraciones(db_name);
        CALL general_categorias(db_name);
        CALL general_tipo_portes(db_name);
        CALL general_iva_clientes(db_name);
        CALL general_marcas(db_name);
        CALL general_tarifas(db_name);
        CALL general_formas_pago(db_name);
        CALL general_vencimientos(db_name);
        CALL inicio_esp(db_name);

END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;

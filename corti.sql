/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : corti

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-07-01 19:04:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for appointments
-- ----------------------------
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) unsigned NOT NULL,
  `patient_id` int(10) unsigned DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room` int(11) DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `backgroundColor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foregroundColor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_slot` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_time` time NOT NULL,
  `appointment_durations` int(11) NOT NULL,
  `ending_time` time NOT NULL,
  `appointment_added_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_doctor_id_foreign` (`doctor_id`),
  KEY `appointment_patient_id_foreign` (`patient_id`),
  CONSTRAINT `appointment_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  CONSTRAINT `appointment_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of appointments
-- ----------------------------
INSERT INTO `appointments` VALUES ('43', '2', '6', null, null, '2018-06-13 00:55:13', null, null, null, null, 'Surgery', '2018-06-13', null, '09:00:00', '60', '10:00:00', '5');
INSERT INTO `appointments` VALUES ('45', '2', '6', 'Halif Hour', null, '2018-06-13 01:05:54', null, null, null, null, 'Normal', '2018-06-13', null, '10:00:00', '30', '10:30:00', '5');
INSERT INTO `appointments` VALUES ('46', '2', '6', null, null, '2018-06-13 01:09:03', null, null, null, null, 'Normal', '2018-06-13', null, '10:30:00', '30', '11:00:00', '5');

-- ----------------------------
-- Table structure for appointment_durations
-- ----------------------------
DROP TABLE IF EXISTS `appointment_durations`;
CREATE TABLE `appointment_durations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) unsigned NOT NULL,
  `minutes` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of appointment_durations
-- ----------------------------
INSERT INTO `appointment_durations` VALUES ('5', '2', '40', '2018-06-07 20:37:34', '2018-06-07 20:37:34');
INSERT INTO `appointment_durations` VALUES ('4', '2', '60', '2018-06-07 20:29:52', '2018-06-07 20:29:52');
INSERT INTO `appointment_durations` VALUES ('6', '2', '30', '2018-06-12 18:28:27', '2018-06-12 18:28:27');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for doctor_leaves
-- ----------------------------
DROP TABLE IF EXISTS `doctor_leaves`;
CREATE TABLE `doctor_leaves` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) unsigned NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of doctor_leaves
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_09_03_144628_create_permission_tables', '1');
INSERT INTO `migrations` VALUES ('4', '2017_09_11_174816_create_social_accounts_table', '1');
INSERT INTO `migrations` VALUES ('5', '2017_09_26_140332_create_cache_table', '1');
INSERT INTO `migrations` VALUES ('6', '2017_09_26_140528_create_sessions_table', '1');
INSERT INTO `migrations` VALUES ('7', '2017_09_26_140609_create_jobs_table', '1');
INSERT INTO `migrations` VALUES ('8', '2018_02_17_125521_create_appointment_table', '1');
INSERT INTO `migrations` VALUES ('9', '2018_03_31_212833_add_user_type', '2');
INSERT INTO `migrations` VALUES ('10', '2018_04_01_102409_add_columns_to_appointments', '2');
INSERT INTO `migrations` VALUES ('11', '2018_04_01_104545_alter_table_appointment', '2');
INSERT INTO `migrations` VALUES ('12', '2018_04_02_094644_add_doctor_leave_table', '3');
INSERT INTO `migrations` VALUES ('15', '2018_04_10_085429__add_schedules_table', '4');
INSERT INTO `migrations` VALUES ('16', '2018_04_10_085620__add_appointment_types_table', '4');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('1', '1', 'App\\Models\\Auth\\User');
INSERT INTO `model_has_roles` VALUES ('2', '2', 'App\\Models\\Auth\\User');
INSERT INTO `model_has_roles` VALUES ('3', '3', 'App\\Models\\Auth\\User');
INSERT INTO `model_has_roles` VALUES ('1', '4', 'App\\Models\\Auth\\User');
INSERT INTO `model_has_roles` VALUES ('4', '5', 'App\\Models\\Auth\\User');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'view backend', 'web', '2018-02-18 01:06:51', '2018-02-18 01:06:51');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'administrator', 'web', '2018-02-18 01:06:51', '2018-02-18 01:06:51');
INSERT INTO `roles` VALUES ('2', 'doctor', 'web', '2018-02-18 01:06:51', '2018-02-18 01:06:51');
INSERT INTO `roles` VALUES ('3', 'user', 'web', '2018-02-18 01:06:51', '2018-02-18 01:06:51');
INSERT INTO `roles` VALUES ('4', 'staff', 'web', '2018-06-06 23:19:21', '2018-06-06 23:19:27');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('1', '1');
INSERT INTO `role_has_permissions` VALUES ('1', '2');
INSERT INTO `role_has_permissions` VALUES ('1', '4');

-- ----------------------------
-- Table structure for schedules
-- ----------------------------
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) unsigned NOT NULL,
  `monday_start` time DEFAULT NULL,
  `monday_end` time DEFAULT NULL,
  `tuesday_start` time DEFAULT NULL,
  `tuesday_end` time DEFAULT NULL,
  `wednesday_start` time DEFAULT NULL,
  `wednesday_end` time DEFAULT NULL,
  `thursday_start` time DEFAULT NULL,
  `thursday_end` time DEFAULT NULL,
  `friday_start` time DEFAULT NULL,
  `friday_end` time DEFAULT NULL,
  `saturday_start` time DEFAULT NULL,
  `saturday_end` time DEFAULT NULL,
  `sunday_start` time DEFAULT NULL,
  `sunday_end` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of schedules
-- ----------------------------
INSERT INTO `schedules` VALUES ('1', '2', '08:00:00', '16:00:00', '08:00:00', '16:00:00', '09:00:00', '17:00:00', '09:00:00', '12:00:00', '10:00:00', '16:00:00', '12:00:00', '12:00:00', '12:00:00', '12:00:00', null, '2018-06-12 18:28:08');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for social_accounts
-- ----------------------------
DROP TABLE IF EXISTS `social_accounts`;
CREATE TABLE `social_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `provider` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_accounts_user_id_foreign` (`user_id`),
  CONSTRAINT `social_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of social_accounts
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'gravatar',
  `avatar_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `confirmation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'ea816f45-4f00-40de-9641-b852102dfa32', 'Admin', 'Istrator', 'admin@admin.com', 'gravatar', null, '$2y$10$P8GMcEwvuXgaDgCjz5.sYeYc4eMTXCx8lYGRlA3E1YUTbW.d1.92C', '2018-06-06 18:10:16', '1', '4626a1b174a8e4d2c9531c87b29c381a', '1', 'UTC', 'UXZvkfyMaC8Gxsd9qhvBfhPZOIuhUAezDHvca2PjMkN5GWUp2RKFmSW1GjQm', '2018-02-18 01:06:50', '2018-06-06 18:10:16', null, null);
INSERT INTO `users` VALUES ('2', '48c00c93-6c32-4259-81cd-b45eafa4b059', 'Backend', 'User', 'doctor@doctor.com', 'gravatar', null, '$2y$10$XyGkv/FbBXRiA544lxP75.s4ZumWiEB21yMo2zJzY8bm69Kr4KHsK', '2018-06-06 18:09:01', '1', '9edac98868b585af1bf75c478d357f47', '1', 'UTC', 'BE8PHyC2qpeMwvkatVVJxYLvFItW1Jwlsz7lOHWbhVPARWjBmLYFyQ02eI7o', '2018-02-18 01:06:50', '2018-06-06 18:09:01', null, 'doctor');
INSERT INTO `users` VALUES ('3', '59eddc14-cf59-4171-80b0-8e48eade02dc', 'Test', 'Eintrag', 'user@user.com', 'gravatar', null, '$2y$10$p/DDPCrOTIwY6oZjbob4SOSEQxbQiAOJDJyo902nHIUd/B3RuOg7S', '2018-03-27 05:35:49', '1', '69675ea34ba3f95c37f940e42a8970d0', '1', 'UTC', 'wtR8Q8OJhR0DksML4xE2rNbRTa8sXgG7SvFtquKnEgxIJXbW7V43yU3kaY8C', '2018-02-18 01:06:51', '2018-03-27 05:38:14', null, null);
INSERT INTO `users` VALUES ('4', 'e3a9ae30-c9b4-4644-b213-4614f5cc692d', 'C', 'Corti', 'cc@pkf.at', 'gravatar', null, '$2y$10$8pZPU/XJFZxw0LJnWBqjz.7tptvBN8C6RvOej6indTWd9hJcKgYyC', null, '1', '0e980b347576561e1bd827580398dbc2', '1', 'UTC', null, '2018-03-27 05:34:08', '2018-03-27 05:34:08', null, null);
INSERT INTO `users` VALUES ('5', 'bfcbfc49-512e-486e-97a0-d99da0fafd42', 'Usama', 'Khalid', 'usama@softpyramid.com', 'gravatar', null, '$2y$10$a0sCHtJCsUM6rIoXjFXQIe.XBkN6lSqhmiPCLSqwEQe3VgDmRrRmi', '2018-06-06 18:14:41', '1', null, '1', 'UTC', 'meKjPRYGgWiQoZL0cKt7iaM3Zb6pESwucuLI44fgZW4r4bcFsl6JFDTnT51J', '2018-04-01 17:43:22', '2018-06-06 18:14:41', null, 'staff');
INSERT INTO `users` VALUES ('6', '8c885b0e-0a3f-40bb-87e0-807c8f110148', 'Usama', 'Khalid', 'osama_khalid121@hotmail.com', 'gravatar', null, null, null, '1', null, '1', 'UTC', null, '2018-04-01 17:46:22', '2018-04-01 17:46:22', null, 'patient');

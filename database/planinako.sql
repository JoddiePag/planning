-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 06 juin 2025 à 07:37
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `planinako`
--

-- --------------------------------------------------------

--
-- Structure de la table `dentistes`
--

DROP TABLE IF EXISTS `dentistes`;
CREATE TABLE IF NOT EXISTS `dentistes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualifications` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motdepasse` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motdepasse_confirmation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dentistes`
--

INSERT INTO `dentistes` (`id`, `nom`, `prenom`, `email`, `numero`, `qualifications`, `adresse`, `avatar`, `motdepasse`, `motdepasse_confirmation`, `created_at`, `updated_at`) VALUES
(1, 'ZAFIMANDIMBY TSILAVO', 'Tantely NY Aina', 'Joddie.pag@gmail.com', '0000000000', 'CES en parodontologie\r\nCES en odontologie chirurgicale\r\nCES en Prothèse Fixée\r\nCES en Biologie de la bouche\r\nPARIS DIDEROT\r\nDU en implantologie', 'tsimbazaza', 'images/profiles/default-avatar.jpg', '$2y$12$OKxEqQ8IX70mOrg9WSPIoeg3NCk5N7sW7CDawhQGbrXIQHD9LKSQ.', '$2y$12$o6OBrvKDtY08uSeiM8xLGu0xUVflY5mizSGo0eGPuj2ieD0pknbFq', '2025-06-01 11:00:33', '2025-06-01 14:08:34');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_05_071758_create_dentistes_table', 1),
(6, '2025_05_06_101152_add_avatar_to_dentistes_table', 2),
(7, '2025_05_06_122130_create_patients_table', 2),
(8, '2025_05_07_041342_create_soins_table', 3),
(9, '2025_05_08_110606_create_rendez_vouses_table', 4),
(10, '2025_05_06_131843_add_ordonnance_to_patients_table', 5),
(11, '2025_05_06_132251_add_ordonnance_to_patients_table', 5),
(12, '2025_05_06_134539_add_avatar_to_dentistes_table', 5),
(13, '2025_05_07_100615_add_total_prix_to_patients_table', 5),
(14, '2025_05_07_162023_add_statut_to_soins_table', 5),
(15, '2025_05_15_135907_add_type_dent_to_patients_table', 5),
(16, '2025_05_28_060452_create_ordonnances_table', 5);

-- --------------------------------------------------------

--
-- Structure de la table `ordonnances`
--

DROP TABLE IF EXISTS `ordonnances`;
CREATE TABLE IF NOT EXISTS `ordonnances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` bigint UNSIGNED NOT NULL,
  `dentiste_id` bigint UNSIGNED NOT NULL,
  `type_ordonnance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordonnances_patient_id_foreign` (`patient_id`),
  KEY `ordonnances_dentiste_id_foreign` (`dentiste_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ordonnances`
--

INSERT INTO `ordonnances` (`id`, `patient_id`, `dentiste_id`, `type_ordonnance`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Cas simple', '2025-06-01 11:12:30', '2025-06-01 11:12:30'),
(2, 2, 1, 'Cas simple', '2025-06-01 14:11:14', '2025-06-01 14:11:14');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `age` int NOT NULL,
  `motif` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antecedents_medicaux` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `traitements` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordonnance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_soins` int NOT NULL DEFAULT '0',
  `dentiste_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `nom`, `prenom`, `date_naissance`, `age`, `motif`, `antecedents_medicaux`, `traitements`, `ordonnance`, `total_soins`, `dentiste_id`, `created_at`, `updated_at`) VALUES
(1, 'renel', 'vfe', '2025-06-05', 0, NULL, 'RAS', NULL, NULL, 0, 1, '2025-06-05 13:59:54', '2025-06-05 13:59:54'),
(2, 'dh', 'fds', '2025-06-06', 0, NULL, 'RAS', NULL, NULL, 0, 1, '2025-06-06 04:14:59', '2025-06-06 04:14:59'),
(3, 'gvyt', 'hvy', '2025-06-06', 0, NULL, 'RAS', NULL, NULL, 0, 1, '2025-06-06 04:27:17', '2025-06-06 04:27:17'),
(4, 'dffd', 'vd', '2025-05-27', 0, NULL, 'RAS', NULL, NULL, 0, 1, '2025-06-06 06:10:31', '2025-06-06 06:10:31');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vouses`
--

DROP TABLE IF EXISTS `rendez_vouses`;
CREATE TABLE IF NOT EXISTS `rendez_vouses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` bigint UNSIGNED NOT NULL,
  `date_heure_rdv` datetime NOT NULL,
  `heure_fin` time NOT NULL,
  `statut` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rendez_vouses_patient_id_foreign` (`patient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `soins`
--

DROP TABLE IF EXISTS `soins`;
CREATE TABLE IF NOT EXISTS `soins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` bigint UNSIGNED NOT NULL,
  `dent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `traitement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_dent` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int NOT NULL,
  `recu` int NOT NULL,
  `reste` int NOT NULL,
  `overlay_position` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `soins_patient_id_foreign` (`patient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `soins`
--

INSERT INTO `soins` (`id`, `patient_id`, `dent`, `traitement`, `type_dent`, `prix`, `recu`, `reste`, `overlay_position`, `created_at`, `updated_at`) VALUES
(1, 1, '48', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":20,\"y1\":240,\"x2\":90,\"y2\":420}', '2025-06-05 13:59:54', '2025-06-05 13:59:54'),
(2, 2, '23', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":470,\"y1\":70,\"x2\":510,\"y2\":240}', '2025-06-06 04:14:59', '2025-06-06 04:14:59'),
(3, 2, '15', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":175,\"y1\":70,\"x2\":230,\"y2\":240}', '2025-06-06 04:16:46', '2025-06-06 04:16:46'),
(4, 3, '47', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":90,\"y1\":240,\"x2\":150,\"y2\":420}', '2025-06-06 04:27:17', '2025-06-06 04:27:17'),
(5, 3, '46', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":150,\"y1\":240,\"x2\":205,\"y2\":420}', '2025-06-06 04:44:57', '2025-06-06 04:44:57'),
(6, 3, '14', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":230,\"y1\":70,\"x2\":270,\"y2\":240}', '2025-06-06 04:44:57', '2025-06-06 04:44:57'),
(7, 3, '21', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":390,\"y1\":70,\"x2\":427,\"y2\":240}', '2025-06-06 05:25:35', '2025-06-06 05:25:35'),
(8, 3, '16', 'ODF', 'Dent Permanente', 0, 0, 0, '{\"x1\":120,\"y1\":70,\"x2\":175,\"y2\":240}', '2025-06-06 05:25:35', '2025-06-06 05:25:35'),
(9, 3, '45', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":205,\"y1\":240,\"x2\":245,\"y2\":420}', '2025-06-06 05:37:17', '2025-06-06 05:37:17'),
(10, 3, '16', 'Plombage', 'Dent Permanente', 0, 0, 0, '{\"x1\":120,\"y1\":70,\"x2\":175,\"y2\":240}', '2025-06-06 05:37:17', '2025-06-06 05:37:17'),
(11, 3, '41', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":350,\"y1\":240,\"x2\":387,\"y2\":420}', '2025-06-06 05:37:17', '2025-06-06 05:37:17'),
(12, 3, '25', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":548,\"y1\":70,\"x2\":592,\"y2\":240}', '2025-06-06 05:37:17', '2025-06-06 05:37:17'),
(13, 3, '38', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":680,\"y1\":240,\"x2\":750,\"y2\":420}', '2025-06-06 05:37:49', '2025-06-06 05:37:49'),
(14, 4, '46', 'Absente', 'Dent Permanente', 0, 0, 0, '{\"x1\":150,\"y1\":240,\"x2\":205,\"y2\":420}', '2025-06-06 06:10:31', '2025-06-06 06:10:31');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

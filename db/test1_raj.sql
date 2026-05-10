CREATE TABLE `analytics_ip_exclusions` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `analytics_ip_exclusions` (`id`, `ip_address`, `note`, `created_at`) VALUES
(1, 'YOUR.IP.ADDR.ESS', 'Admin exclusion', '2026-05-10 11:37:43');
-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2020 at 12:19 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `id_foto` int(11) NOT NULL,
  `nama_tabel` varchar(100) NOT NULL,
  `id_tabel` int(11) NOT NULL,
  `foto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` bigint(20) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `username` varchar(21) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(21) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `username`, `password`, `nama`, `foto`) VALUES
(1, 'daniel', 'd4c143f004d88b7286e6f999dea9d0d7', 'Daniel GSS', 'avatar5.png'),
(2, 'gss', '1e21d885875ce28ecd17872f40e67e05', 'Administrator GSS', 'avatar5.png');

-- --------------------------------------------------------

--
-- Table structure for table `menu_navigasi`
--

CREATE TABLE `menu_navigasi` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `no_urut` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_navigasi`
--

INSERT INTO `menu_navigasi` (`id_menu`, `nama_menu`, `url`, `id_parent`, `no_urut`, `icon`, `status`) VALUES
(1, 'MASTER DATA', '#', 0, 1, 'database', 0),
(2, 'Menu Navigasi', 'menu-navigasi', 1, 1, 'tachometer-alt', 0),
(3, 'Login', 'login', 1, 2, 'user', 0),
(60, 'LOG USER ACTIVITY', '#', 0, 8, 'check-circle', 0),
(61, 'Log Users', 'log', 60, 1, 'user', 0),
(62, 'Log Rekap User', 'log/rekap-log', 60, 2, 'users', 0),
(74, 'Hak Akses', 'systemrole', 1, 3, 'list', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_navigasi_role`
--

CREATE TABLE `menu_navigasi_role` (
  `id_menu_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_system_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_navigasi_role`
--

INSERT INTO `menu_navigasi_role` (`id_menu_role`, `id_menu`, `id_system_role`) VALUES
(2, 2, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(17, 15, 1),
(18, 16, 2),
(19, 16, 3),
(20, 16, 4),
(21, 16, 1),
(26, 17, 2),
(27, 17, 3),
(28, 17, 4),
(29, 17, 1),
(38, 18, 2),
(39, 18, 3),
(40, 18, 4),
(41, 18, 1),
(42, 19, 2),
(43, 19, 3),
(44, 19, 4),
(45, 19, 1),
(46, 20, 2),
(47, 20, 3),
(48, 20, 4),
(49, 20, 1),
(52, 23, 2),
(53, 23, 3),
(54, 23, 4),
(55, 23, 1),
(60, 25, 2),
(61, 25, 3),
(62, 25, 4),
(63, 25, 1),
(64, 26, 2),
(65, 26, 3),
(66, 26, 4),
(67, 26, 1),
(68, 27, 2),
(69, 27, 3),
(70, 27, 4),
(71, 27, 1),
(72, 28, 2),
(73, 28, 3),
(74, 28, 4),
(75, 28, 1),
(76, 29, 1),
(77, 30, 1),
(86, 32, 2),
(87, 32, 3),
(88, 32, 4),
(89, 32, 1),
(90, 33, 2),
(91, 33, 3),
(92, 33, 4),
(93, 33, 1),
(94, 34, 2),
(95, 34, 3),
(96, 34, 4),
(97, 34, 1),
(98, 35, 1),
(99, 36, 1),
(100, 37, 4),
(101, 37, 1),
(102, 38, 2),
(103, 38, 3),
(104, 38, 4),
(105, 38, 1),
(114, 39, 2),
(115, 39, 3),
(116, 39, 4),
(117, 39, 1),
(118, 40, 2),
(119, 40, 3),
(120, 40, 4),
(121, 40, 1),
(122, 41, 2),
(123, 41, 3),
(124, 41, 4),
(125, 41, 1),
(126, 31, 1),
(131, 43, 2),
(132, 43, 3),
(133, 43, 4),
(134, 43, 1),
(143, 45, 2),
(144, 45, 3),
(145, 45, 4),
(146, 45, 1),
(147, 46, 2),
(148, 46, 3),
(149, 46, 4),
(150, 46, 1),
(155, 47, 2),
(156, 47, 3),
(157, 47, 4),
(158, 47, 1),
(159, 48, 2),
(160, 48, 3),
(161, 48, 4),
(162, 48, 1),
(163, 49, 4),
(164, 49, 1),
(165, 50, 2),
(166, 50, 3),
(167, 50, 4),
(168, 50, 1),
(169, 51, 2),
(170, 51, 3),
(171, 51, 4),
(172, 51, 1),
(173, 52, 2),
(174, 52, 3),
(175, 52, 4),
(176, 52, 1),
(177, 53, 4),
(178, 53, 1),
(179, 42, 2),
(180, 42, 3),
(181, 42, 4),
(182, 42, 1),
(187, 54, 2),
(188, 54, 3),
(189, 54, 4),
(190, 54, 1),
(191, 55, 2),
(192, 55, 3),
(193, 55, 4),
(194, 55, 1),
(197, 3, 1),
(198, 12, 4),
(199, 12, 1),
(202, 14, 4),
(203, 14, 1),
(204, 21, 4),
(205, 21, 1),
(206, 13, 4),
(207, 13, 1),
(220, 58, 2),
(221, 58, 3),
(222, 58, 4),
(223, 58, 1),
(236, 61, 2),
(237, 61, 3),
(238, 61, 4),
(239, 61, 1),
(244, 62, 2),
(245, 62, 3),
(246, 62, 4),
(247, 62, 1),
(260, 63, 2),
(261, 63, 3),
(262, 63, 4),
(263, 63, 1),
(264, 1, 1),
(288, 64, 2),
(289, 64, 3),
(290, 64, 4),
(291, 64, 1),
(292, 65, 2),
(293, 65, 3),
(294, 65, 4),
(295, 65, 1),
(297, 66, 2),
(298, 66, 3),
(299, 66, 4),
(300, 66, 1),
(305, 68, 2),
(306, 68, 3),
(307, 68, 4),
(308, 68, 1),
(314, 59, 4),
(315, 24, 4),
(316, 24, 1),
(317, 44, 4),
(318, 44, 1),
(319, 67, 4),
(320, 67, 1),
(321, 60, 1),
(326, 70, 2),
(327, 70, 3),
(328, 70, 4),
(329, 70, 1),
(336, 56, 2),
(337, 56, 1),
(338, 57, 3),
(339, 57, 1),
(340, 69, 4),
(341, 69, 1),
(342, 71, 5),
(343, 71, 1),
(344, 72, 4),
(345, 72, 1),
(348, 73, 4),
(349, 73, 1),
(350, 74, 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_role`
--

CREATE TABLE `system_role` (
  `id_system_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_role`
--

INSERT INTO `system_role` (`id_system_role`, `nama_role`) VALUES
(1, 'SYSTEM ADMINISTRATOR');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` int(11) NOT NULL,
  `id_system_role` int(11) NOT NULL,
  `id_login` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `id_system_role`, `id_login`) VALUES
(1, 1, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 4, 5),
(6, 4, 6),
(7, 4, 7),
(8, 4, 8),
(9, 4, 9),
(10, 4, 10),
(11, 4, 11),
(12, 4, 12),
(13, 4, 13),
(14, 4, 14),
(15, 4, 15),
(16, 4, 16),
(17, 4, 17),
(18, 4, 18),
(19, 4, 19),
(20, 4, 20),
(21, 4, 21),
(22, 4, 22),
(23, 4, 23),
(24, 4, 24),
(25, 4, 25),
(26, 4, 26),
(27, 4, 27),
(28, 4, 28),
(29, 4, 29),
(30, 4, 30),
(31, 4, 31),
(32, 4, 32),
(33, 4, 33),
(34, 4, 34),
(35, 4, 35),
(36, 4, 36),
(37, 4, 37),
(38, 4, 38),
(39, 4, 39),
(40, 4, 40),
(41, 4, 41),
(42, 4, 42),
(43, 4, 43),
(44, 4, 44),
(45, 4, 45),
(46, 4, 46),
(47, 4, 47),
(48, 4, 48),
(49, 4, 49),
(50, 4, 50),
(51, 4, 51),
(52, 4, 52),
(53, 4, 53),
(54, 4, 54),
(55, 4, 55),
(56, 4, 56),
(57, 4, 57),
(58, 4, 58),
(59, 4, 59),
(60, 4, 60),
(61, 4, 61),
(62, 4, 62),
(63, 4, 63),
(64, 4, 64),
(65, 4, 65),
(66, 4, 66),
(67, 4, 67),
(68, 4, 68),
(69, 4, 69),
(70, 4, 70),
(71, 4, 71),
(72, 4, 72),
(73, 4, 73),
(74, 4, 74),
(75, 4, 75),
(76, 4, 76),
(77, 4, 77),
(78, 4, 78),
(79, 4, 79),
(80, 4, 80),
(313, 4, 81),
(82, 4, 82),
(83, 4, 83),
(84, 4, 84),
(85, 4, 85),
(86, 4, 86),
(87, 4, 87),
(88, 4, 88),
(89, 4, 89),
(90, 4, 90),
(91, 4, 91),
(92, 4, 92),
(93, 4, 93),
(94, 4, 94),
(95, 4, 129),
(96, 4, 131),
(97, 4, 806),
(98, 4, 805),
(99, 4, 804),
(100, 4, 803),
(101, 4, 802),
(102, 4, 801),
(103, 4, 864),
(104, 4, 863),
(105, 4, 800),
(106, 4, 862),
(107, 4, 799),
(108, 4, 861),
(109, 4, 786),
(110, 4, 798),
(111, 4, 785),
(112, 4, 784),
(117, 4, 797),
(114, 4, 783),
(115, 4, 782),
(116, 4, 781),
(118, 4, 780),
(119, 4, 779),
(120, 4, 796),
(121, 4, 778),
(122, 4, 777),
(123, 4, 794),
(124, 4, 775),
(125, 4, 774),
(126, 4, 773),
(127, 4, 793),
(128, 4, 772),
(129, 4, 792),
(130, 4, 771),
(131, 4, 770),
(132, 4, 791),
(133, 4, 769),
(134, 4, 768),
(135, 4, 790),
(136, 4, 767),
(137, 4, 789),
(138, 4, 788),
(139, 4, 819),
(140, 4, 787),
(141, 4, 818),
(142, 4, 817),
(143, 4, 816),
(144, 4, 815),
(145, 4, 814),
(146, 4, 813),
(147, 4, 839),
(148, 4, 812),
(149, 4, 811),
(150, 4, 838),
(151, 4, 810),
(152, 4, 809),
(153, 4, 837),
(154, 4, 808),
(155, 4, 807),
(156, 4, 836),
(157, 4, 835),
(158, 4, 833),
(159, 4, 850),
(160, 4, 849),
(161, 4, 848),
(162, 4, 847),
(163, 4, 834),
(164, 4, 846),
(165, 4, 845),
(166, 4, 832),
(167, 4, 844),
(168, 4, 843),
(169, 4, 842),
(170, 4, 841),
(173, 4, 831),
(172, 4, 840),
(174, 4, 860),
(175, 4, 830),
(176, 4, 859),
(177, 4, 858),
(178, 4, 857),
(179, 4, 829),
(180, 4, 856),
(181, 4, 855),
(182, 4, 854),
(183, 4, 828),
(184, 4, 853),
(185, 4, 852),
(186, 4, 851),
(187, 4, 827),
(188, 4, 826),
(189, 4, 825),
(190, 4, 824),
(191, 4, 823),
(192, 4, 822),
(193, 4, 821),
(194, 4, 820),
(195, 4, 895),
(196, 2, 896),
(197, 3, 896),
(198, 4, 896),
(199, 1, 896),
(200, 4, 897),
(201, 4, 776),
(202, 4, 795),
(203, 4, 898),
(204, 4, 899),
(205, 4, 900),
(206, 4, 1058),
(207, 4, 1057),
(208, 4, 1056),
(209, 4, 1017),
(210, 4, 1055),
(211, 4, 1016),
(212, 4, 1015),
(213, 4, 1054),
(214, 4, 1014),
(215, 4, 1013),
(216, 4, 1053),
(217, 4, 1012),
(218, 4, 1011),
(219, 4, 1052),
(220, 4, 1010),
(221, 4, 1009),
(222, 4, 1051),
(223, 4, 1008),
(224, 4, 1007),
(225, 4, 1050),
(226, 4, 1006),
(227, 4, 1005),
(228, 4, 1049),
(229, 4, 1004),
(230, 4, 1003),
(231, 4, 1048),
(232, 4, 1002),
(233, 4, 1047),
(234, 4, 1001),
(235, 4, 1000),
(236, 4, 999),
(237, 4, 1046),
(238, 4, 998),
(239, 4, 997),
(240, 4, 1045),
(241, 4, 996),
(242, 4, 995),
(243, 4, 1044),
(244, 4, 1043),
(245, 4, 1042),
(246, 4, 1041),
(247, 4, 1040),
(248, 4, 1039),
(249, 4, 1038),
(250, 4, 1037),
(251, 4, 1096),
(252, 4, 1095),
(253, 4, 1094),
(254, 4, 1093),
(255, 4, 1092),
(256, 4, 1091),
(257, 4, 1090),
(258, 4, 1089),
(259, 4, 1088),
(260, 4, 1087),
(261, 4, 1086),
(262, 4, 1085),
(263, 4, 1084),
(264, 4, 1083),
(265, 4, 1082),
(266, 4, 1081),
(267, 4, 1080),
(268, 4, 1079),
(269, 4, 1078),
(270, 4, 1077),
(271, 4, 1076),
(272, 4, 1075),
(273, 4, 1074),
(274, 4, 1073),
(275, 4, 1072),
(276, 4, 1071),
(277, 4, 1036),
(278, 4, 1070),
(279, 4, 1035),
(280, 4, 1034),
(281, 4, 1069),
(282, 4, 1033),
(283, 4, 1032),
(284, 4, 1068),
(285, 4, 1031),
(286, 4, 1030),
(287, 4, 1067),
(288, 4, 1029),
(289, 4, 1028),
(290, 4, 1066),
(291, 4, 1027),
(292, 4, 1026),
(293, 4, 1065),
(294, 4, 1025),
(295, 4, 1024),
(296, 4, 1064),
(297, 4, 1023),
(298, 4, 1022),
(299, 4, 1063),
(300, 4, 1021),
(301, 4, 1020),
(302, 4, 1062),
(303, 4, 1019),
(304, 4, 1018),
(305, 4, 1061),
(306, 4, 1060),
(307, 4, 1059),
(308, 3, 1097),
(309, 4, 1098),
(310, 4, 1099),
(311, 2, 1100),
(312, 4, 1101),
(314, 4, 1102),
(315, 4, 1103),
(316, 4, 1104),
(321, 3, 1105),
(320, 2, 1106),
(322, 5, 1107),
(324, 2, 1108),
(345, 1, 1109),
(337, 1, 1112),
(336, 5, 1112),
(335, 4, 1112),
(334, 3, 1112),
(333, 2, 1112),
(338, 5, 1113),
(339, 5, 1114),
(340, 5, 1115),
(342, 2, 1116),
(343, 4, 1117),
(344, 4, 1118),
(346, 1, 1119);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `menu_navigasi`
--
ALTER TABLE `menu_navigasi`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_parent` (`id_parent`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `menu_navigasi_role`
--
ALTER TABLE `menu_navigasi_role`
  ADD PRIMARY KEY (`id_menu_role`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_system_role` (`id_system_role`);

--
-- Indexes for table `system_role`
--
ALTER TABLE `system_role`
  ADD PRIMARY KEY (`id_system_role`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user_role`),
  ADD KEY `id_system_role` (`id_system_role`),
  ADD KEY `id_login` (`id_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_navigasi`
--
ALTER TABLE `menu_navigasi`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `menu_navigasi_role`
--
ALTER TABLE `menu_navigasi_role`
  MODIFY `id_menu_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `system_role`
--
ALTER TABLE `system_role`
  MODIFY `id_system_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

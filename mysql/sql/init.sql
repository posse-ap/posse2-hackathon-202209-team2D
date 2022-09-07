-- DROP SCHEMA IF EXISTS posse;
-- CREATE SCHEMA posse;
-- USE posse;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `posse`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `name`, `detail`, `start_at`, `end_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '縦モク', '', '2022-08-01 21:00:00', '2022-08-01 23:00:00', '2022-09-06 12:20:48', '2022-09-07 02:09:34', NULL),
(2, '横モク', '', '2021-08-02 21:00:00', '2021-08-02 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(3, 'スペモク', '', '2021-08-03 20:00:00', '2021-08-03 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(4, '縦モク', '', '2021-08-08 21:00:00', '2021-08-08 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(5, '横モク', '', '2021-08-09 21:00:00', '2021-08-09 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(6, 'スペモク', '', '2021-08-10 20:00:00', '2021-08-10 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(7, '縦モク', '', '2021-08-15 21:00:00', '2021-08-15 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(8, '横モク', '', '2021-08-16 21:00:00', '2021-08-16 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(9, 'スペモク', '', '2021-08-17 20:00:00', '2021-08-17 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(10, '縦モク', '', '2021-08-22 21:00:00', '2021-08-22 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(11, '横モク', '', '2021-08-23 21:00:00', '2021-08-23 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(12, 'スペモク', '', '2021-08-24 20:00:00', '2021-08-24 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(13, '遊び', '', '2021-09-22 18:00:00', '2021-09-22 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(14, 'ハッカソン', '', '2021-09-03 10:00:00', '2021-09-03 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(15, '遊び', '', '2021-09-06 18:00:00', '2021-09-06 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(16, 'スペモク', '', '2022-10-01 20:00:00', '2022-10-01 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(17, '縦モク', '', '2022-10-01 21:00:00', '2022-10-01 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(18, '横モク', '', '2022-10-01 21:00:00', '2022-10-01 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(19, 'スペモク', '', '2022-10-01 20:00:00', '2022-10-01 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(20, '遊び', '', '2022-10-01 18:00:00', '2022-10-01 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(21, 'ハッカソン', '', '2022-10-01 10:00:00', '2022-10-01 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(22, '遊び', '', '2022-10-01 18:00:00', '2022-10-01 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(23, 'かれんちで宅飲み', '', '2022-09-08 15:31:00', '2022-09-08 15:31:00', '2022-09-07 15:31:27', '2022-09-07 06:37:03', NULL),
(24, 'おのかん家は快適？', '', '2022-09-08 15:35:00', '2022-09-08 18:35:00', '2022-09-07 15:35:42', '2022-09-07 06:35:42', NULL),
(25, 'all期生イベント', NULL, '2022-09-07 15:59:00', '2022-09-07 16:59:00', '2022-09-07 15:59:18', '2022-09-07 06:59:18', NULL),
(42, 'サイゼリヤ食べ放題', NULL, '2022-09-08 16:27:00', '2022-09-08 17:27:00', '2022-09-07 16:28:05', '2022-09-07 07:28:05', NULL),
(43, '二次会＠料理倶楽部', '料理倶楽部で二次会します。\r\nシンプルに楽しいと思います。', '2022-09-08 16:44:00', '2022-09-08 18:44:00', '2022-09-07 16:44:50', '2022-09-07 07:44:50', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `event_attendance`
--

CREATE TABLE `event_attendance` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `event_attendance`
--

INSERT INTO `event_attendance` (`id`, `event_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 1, 1, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(2, 1, 2, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 2),
(3, 1, 3, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(4, 2, 1, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 2),
(5, 2, 2, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(6, 3, 1, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(7, 15, 3, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(8, 15, 2, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(9, 17, 2, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login_pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slack_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `github_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login_pass`, `slack_id`, `github_id`, `role_id`) VALUES
(1, 'かしけん', 'kashiken@kashiken', '$2y$10$Irq4dHv0LhOPhTbX0VlQv.VMWHhn4SZ6hg171NkK95r9H57X4kRaG', 'U0258AY7KBR', 'kashiken4869', 2),
(2, 'かれん', 'karen@kk', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U0258AY7KBR', 'karen-812', 1),
(3, 'ポンタ', 'ponta@p', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U0258AY7KBR', 'ponta10', 1),
(4, '姑', 'email@email', '$2y$10$CCzvVNIVoilFoqhYtnVu7etRL4R93AvmpWSkr522zreotkdvEsc72', 'っっっf', 'っっっっf', 2),
(5, 'りさ', 'lisa@lisa', '$2y$10$sCTDksa1CGZXtlFp5RMjQOdbHpmUMY92.MpSAmR1jKxwQqb6npUka', 'lll', 'llll', 2),
(6, 'あきら', 'akira@uber', '$2y$10$eg6OvKvjSUsXLFdSbFe6P.jliQ7sT1TjT.GBM.15DaaaPtDImBSgG', 'akira', 'akira', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- テーブルの AUTO_INCREMENT `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

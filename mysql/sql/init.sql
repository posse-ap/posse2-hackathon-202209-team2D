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
(7, '縦モク', '', '2021-08-15 21:00:00', '2021-08-15 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(13, '遊び', '', '2021-09-22 18:00:00', '2021-09-22 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(14, 'ハッカソン', '', '2021-09-03 10:00:00', '2021-09-03 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(15, '遊び', '', '2021-09-06 18:00:00', '2021-09-06 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(23, 'かれんちで宅飲み', 'かれんのお家で宅飲みします！！！男子は2000円/人、女子は4000円/人です。 楽しい会にしましょう！！！！！！！！！', '2022-09-08 15:31:00', '2022-09-09 15:31:00', '2022-09-07 15:31:27', '2022-09-07 14:10:03', NULL),
(24, 'おのかん家は快適？', 'おのかんちは快適なのか、みんなで検証する会です。　男子は2000円/人、女子は4000円/人です。 楽しい会にしましょう！！！！！！！！！男子は2000円/人、女子は4000円/人です。 楽しい会にしましょう！！！！！！！！！', '2022-09-12 15:35:00', '2022-09-12 21:00:00', '2022-09-07 15:35:42', '2022-09-08 06:44:36', NULL),
(25, 'all期生イベント', '男子は2000円/人、女子は4000円/人です。\n楽しい会にしましょう！！！！！！！！！', '2022-09-07 15:59:00', '2022-09-07 16:59:00', '2022-09-07 15:59:18', '2022-09-07 13:20:43', NULL),
(42, 'サイゼリヤ食べ放題', '男子は2000円/人、女子は4000円/人です。\n楽しい会にしましょう！！！！！！！！！', '2022-09-10 16:27:00', '2022-09-10 17:27:00', '2022-09-07 16:28:05', '2022-09-08 06:46:20', NULL),
(43, '二次会＠料理倶楽部', '料理倶楽部で二次会します。\r\nシンプルに楽しいと思います。', '2022-09-11 00:00:00', '2022-09-11 18:44:00', '2022-09-07 16:44:50', '2022-09-08 06:43:12', NULL),
(44, '料理倶楽部３次会', '料理倶楽部で３次会やります。\n男子は2000円/人、女子は4000円/人です。\n楽しい会にしましょう！！！！！！！！！！', '2022-09-08 18:00:00', '2022-09-08 23:00:00', '2022-09-07 16:56:43', '2022-09-07 11:09:03', NULL),
(45, 'タワタワ 0911', 'タワーtoタワーです。\r\n楽しいです。\r\n歩きましょう。', '2022-09-09 03:18:00', '2022-09-09 08:18:00', '2022-09-08 03:19:00', '2022-09-08 06:46:30', NULL),
(46, 'なおきが施す会912', 'なおきに施される会。\r\nそのままです。\r\n全員無料です。', '2022-09-12 16:20:00', '2022-09-12 22:20:00', '2022-09-08 03:20:27', '2022-09-07 18:20:27', NULL);

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
(1, 23, 5, '2022-09-06 12:20:48', '2022-09-07 09:26:33', NULL, 1),
(2, 23, 2, '2022-09-06 12:20:48', '2022-09-07 09:25:31', NULL, 2),
(3, 23, 3, '2022-09-06 12:20:48', '2022-09-07 09:25:34', NULL, 1),
(4, 24, 5, '2022-09-06 12:20:48', '2022-09-07 09:26:37', NULL, 2),
(5, 24, 2, '2022-09-06 12:20:48', '2022-09-07 09:25:38', NULL, 1),
(6, 25, 5, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 1),
(7, 44, 5, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 1),
(8, 25, 6, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 1),
(9, 25, 2, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2),
(10, 42, 1, '2022-09-06 12:20:48', '2022-09-07 09:25:38', NULL, 1),
(11, 42, 2, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 1),
(12, 42, 3, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2),
(13, 42, 4, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2),
(14, 44, 6, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2),
(15, 43, 1, '2022-09-06 12:20:48', '2022-09-07 09:25:38', NULL, 1),
(16, 43, 2, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 1),
(17, 43, 3, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2),
(18, 43, 5, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2),
(19, 45, 2, '2022-09-06 12:20:48', '2022-09-08 06:47:08', NULL, 1),
(20, 45, 3, '2022-09-06 12:20:48', '2022-09-08 06:47:11', NULL, 1),
(21, 45, 1, '2022-09-06 12:20:48', '2022-09-08 06:48:56', NULL, 2),
(22, 45, 6, '2022-09-06 12:20:48', '2022-09-08 06:44:00', NULL, 2),
(23, 46, 5, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 1),
(24, 46, 6, '2022-09-06 12:20:48', '2022-09-07 09:26:40', NULL, 2);

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
(1, 'かしけん', 'kashiken@kashiken', '$2y$10$Irq4dHv0LhOPhTbX0VlQv.VMWHhn4SZ6hg171NkK95r9H57X4kRaG', 'U041KN8C6TW', 'kashiken4869', 2),
(2, 'かれん', 'karen@kk', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U042729EW64', 'karen-812', 1),
(3, 'ポンタ', 'ponta@p', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U041HQCGYLB', 'ponta10', 1),
(4, '姑', 'email@email', '$2y$10$CCzvVNIVoilFoqhYtnVu7etRL4R93AvmpWSkr522zreotkdvEsc72', 'U042729EW64', 'U042729EW64', 2),
(5, 'りさ', 'lisa@lisa', '$2y$10$sCTDksa1CGZXtlFp5RMjQOdbHpmUMY92.MpSAmR1jKxwQqb6npUka', 'U042729EW64', 'U042729EW64', 2),
(6, 'あきら', 'akira@uber', '$2y$10$eg6OvKvjSUsXLFdSbFe6P.jliQ7sT1TjT.GBM.15DaaaPtDImBSgG', 'U041KN8C6TW', 'akira', 1);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- テーブルの AUTO_INCREMENT `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- DROP SCHEMA IF EXISTS posse;
-- CREATE SCHEMA posse;
-- USE posse;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `name`, `start_at`, `end_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '縦モク', '2021-08-01 21:00:00', '2021-08-01 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(2, '横モク', '2021-08-02 21:00:00', '2021-08-02 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(3, 'スペモク', '2021-08-03 20:00:00', '2021-08-03 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(4, '縦モク', '2021-08-08 21:00:00', '2021-08-08 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(5, '横モク', '2021-08-09 21:00:00', '2021-08-09 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(6, 'スペモク', '2021-08-10 20:00:00', '2021-08-10 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(7, '縦モク', '2021-08-15 21:00:00', '2021-08-15 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(8, '横モク', '2021-08-16 21:00:00', '2021-08-16 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(9, 'スペモク', '2021-08-17 20:00:00', '2021-08-17 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(10, '縦モク', '2021-08-22 21:00:00', '2021-08-22 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(11, '横モク', '2021-08-23 21:00:00', '2021-08-23 23:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(12, 'スペモク', '2021-08-24 20:00:00', '2021-08-24 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(13, '遊び', '2021-09-22 18:00:00', '2021-09-22 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(14, 'ハッカソン', '2021-09-03 10:00:00', '2021-09-03 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL),
(15, '遊び', '2021-09-06 18:00:00', '2021-09-06 22:00:00', '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL);

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
(1, 1, 0, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(2, 1, 1, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 2),
(3, 1, 2, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(4, 2, 0, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 2),
(5, 2, 1, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1),
(6, 3, 2, '2022-09-06 12:20:48', '2022-09-06 12:20:48', NULL, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` INT NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login_pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slack_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `github_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login_pass`, `slack_id`, `github_id`) VALUES
(1, 'かしけん', 'kashiken@kashiken', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U0258AY7KBR', 'kashiken4869'),
(2, 'かれん', 'karen@kk', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U0258AY7KBR', 'karen-kk'),
(3, 'ポンタ', 'ponta@p', '$2y$10$7EYUohG.DqNb.tLpvvub9esviI3baz3y/p01YsmD/cRaKUS6/ZdQG', 'U0258AY7KBR', 'ponta10');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

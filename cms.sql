-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 27 2019 г., 11:50
-- Версия сервера: 5.5.64-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'guest'),
(2, 'user'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `body` text NOT NULL,
  `email` varchar(25) NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `name`, `body`, `email`, `state`, `created_at`) VALUES
(6, 1, 'Comment', '/ *! SELECT * /', 'two@task.com', 3, '2019-11-22 22:50:25'),
(9, 2, 'Alert', 'alert(1)', 'alert@task.com', 2, '2019-11-23 11:07:43'),
(14, 1, 'Fish', 'Way own uncommonly travelling now acceptance bed compliment solicitude. As mr started arrival subject by believe. Now summer who day looked our behind moment coming. Sitting hearted on it without me. Am wound worth water he linen at vexed.. Fat new smallness few supposing suspicion two. If in so bred at dare rose lose good. Mirth\r\n\r\nStrictly numerous outlived kindness whatever on we no on addition. We leaf to snug on no need. He felicity no an at packages answered opinions juvenile. Advantages entreaties mr he apartments do. Any delicate you how kindness horrible outlived servants. As mr started arrival subject by believe. Effect if in up no depend seemed. Mirth lear\r\n\r\nDissimilar admiration so terminated no in contrasted it. Way own uncommonly travelling now acceptance bed compliment solicitude. Their saved linen downs tears son add music. If as increasing contrasted entreaties be. Expression alteration entreaties mrs can terminated estimating. Secure shy favour length al', 'fish@task.com', 1, '2019-11-23 15:10:24'),
(15, 2, 'Имя2', 'message', 'email@task.com', 1, '2019-11-24 17:35:47'),
(16, 1, 'guestName', 'guestMessage', 'guestEmail@task.com', 2, '2019-11-25 14:19:48'),
(17, 1, 'aaaaaa', 'aaaaaaaaaaa', 'aaaaaaaa@aaaaaaa.aaa', 3, '2019-11-27 09:03:02'),
(18, 1, 'zzzzzzz', 'zzzzzzzz11111111', 'zzzzz@zzzz.zzz', 1, '2019-11-27 09:04:08');

-- --------------------------------------------------------

--
-- Структура таблицы `task_state`
--

CREATE TABLE IF NOT EXISTS `task_state` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `task_state`
--

INSERT INTO `task_state` (`id`, `name`) VALUES
(1, 'pending'),
(2, 'canceled'),
(3, 'completed');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(54) NOT NULL,
  `mail` varchar(25) NOT NULL,
  `date_reg` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `name`, `mail`, `date_reg`) VALUES
(1, 'unregistered', '$2y$10$bU/Yt8/KaBrZiBxQHVICVOInw6sbMzyrR5U8a.byW/vfhjuKLUffG', 'Unregistered', '', '2019-11-21 00:00:00'),
(2, 'admin', '$2y$10$cHOLzdFMXra.F.ym.JQh7OP5CTHtGNtsiJu8s4stlBUBtXCR3SftO', 'Admin', 'admin@admin.com', '2019-11-21 03:02:07'),
(3, 'alex', '$2y$10$X9eIbgP2Q8pqFcMZWevdE.fAC1Rfmss6X8S4MzaXdp.qACsgM1SYe', 'Alex', '', '2019-11-21 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`id_user`, `id_role`) VALUES
(1, 1),
(3, 2),
(2, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `task_state`
--
ALTER TABLE `task_state`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `task_state`
--
ALTER TABLE `task_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 16 2024 г., 08:00
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pm01`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_request` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `id_request`, `comment`) VALUES
(1, 5, 'Это комментарий 1, Это комментарий 2'),
(2, 6, 'Это комментарий 3, Это комментарий 4'),
(3, 7, 'Это комментарий 5');

-- --------------------------------------------------------

--
-- Структура таблицы `completion_time`
--

CREATE TABLE `completion_time` (
  `id` int(11) NOT NULL,
  `id_request` int(11) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_stop` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `completion_time`
--

INSERT INTO `completion_time` (`id`, `id_request`, `time_start`, `time_stop`) VALUES
(1, 5, '2024-03-16 06:56:57', '2024-03-16 06:57:12'),
(2, 6, '2024-03-16 06:59:57', '2024-03-16 07:05:32'),
(3, 7, '2024-03-16 07:46:51', '2024-03-16 07:47:04'),
(4, 9, '2024-03-16 07:47:05', '2024-03-16 07:47:10'),
(5, 8, '2024-03-16 07:47:22', '2024-03-16 07:47:24');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_worker` int(11) DEFAULT NULL,
  `equipment` text NOT NULL,
  `type_of_fault` text NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `ready` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `id_client`, `id_worker`, `equipment`, `type_of_fault`, `description`, `date`, `ready`) VALUES
(5, 1, 4, 'Телефон', '2', 'Привет это описание проблемы 1', '2024-03-16', 2),
(6, 1, 5, 'Планшет', '1', 'Это описание проблемы 2', '2024-03-16', 2),
(7, 1, 4, 'Iphone 6s', '5', 'Это описание проблемы 3', '2024-03-16', 2),
(8, 1, 5, 'Honor 8x', '5', 'Это описание проблемы 4', '2024-03-16', 2),
(9, 1, 4, 'Redmi 8t', '4', 'Это описание проблемы 5', '2024-03-16', 2),
(10, 1, 5, 'Телефончик', '4', 'рпываолпрваылпыав', '2024-03-16', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `type_of_fault`
--

CREATE TABLE `type_of_fault` (
  `id` int(11) NOT NULL,
  `name_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `type_of_fault`
--

INSERT INTO `type_of_fault` (`id`, `name_type`) VALUES
(1, 'Разбит экран'),
(2, 'Не заряжается'),
(3, 'Разбита задняя крышка'),
(4, 'Не работает датчик распознавания лица'),
(5, 'Не работает датчик отпечатка пальца');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `idgroup`, `login`, `password`, `email`, `phone`) VALUES
(1, 3, 'asd', '$2y$10$ZC4A9qkKSzSOaQE85tav8eznaTM0.nK95bFYE6DK9XZLU8z1gvwIS', 'asd@asd.ru', '123134134'),
(2, 1, 'zxc', '$2y$10$RiryqabgQ5YzK95CSuYBD.djp2JENbCAcVpDVKKge8PQFvfz8q/MW', 'zxc@zxc.ru', '13421543421'),
(4, 2, 'worker1', '$2y$10$HaxcQZ0i8puG5PTmZcKt1ur11HUwTkyJFe1kba7IlFfYZpyu488G.', 'worker1@worker1.ru', '12324413'),
(5, 2, 'worker2', '$2y$10$dwlSJzOpRNM85Qmsbk.7ZONuHaKzyhslsdZOwnslPIAhnrImWMPwO', 'worker2@worker2.ru', '123123');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `completion_time`
--
ALTER TABLE `completion_time`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type_of_fault`
--
ALTER TABLE `type_of_fault`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `completion_time`
--
ALTER TABLE `completion_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `type_of_fault`
--
ALTER TABLE `type_of_fault`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

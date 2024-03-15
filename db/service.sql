-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 19 2023 г., 13:29
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
-- База данных: `service`
--

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
(2, 1, 4, 'asd', 'asd', 'asd', '2023-09-18', 2),
(4, 1, 4, 'test', 'test', 'test', '2023-09-19', 2);

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
(4, 2, 'worker1', '$2y$10$HaxcQZ0i8puG5PTmZcKt1ur11HUwTkyJFe1kba7IlFfYZpyu488G.', 'worker1@worker1.ru', '12324413');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
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
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

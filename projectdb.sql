-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Лют 13 2026 р., 14:53
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `projectdb`
--

-- --------------------------------------------------------

--
-- Структура таблиці `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `price`, `category`, `image_path`) VALUES
(1, 'The Hobbit', 'J.R.R. Tolkien', 14.90, 'Fantasy', 'books_images/the hobbit.jpg'),
(2, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 13.50, 'Fantasy', 'books_images/harry potter.jpg'),
(3, 'Pride and Prejudice', 'Jane Austen', 9.99, 'Romance', 'books_images/pride and prejudice.jpg'),
(4, 'The Alchemist', 'Paulo Coelho', 12.00, 'Fiction', 'books_images/the alchemist.jpg'),
(5, 'Me Before You', 'Jojo Moyes', 11.50, 'Romance', 'books_images/me before you.jpg'),
(6, 'A Brief History of Time', 'Stephen Hawking', 16.25, 'Science', 'books_images/a brief history of time.jpg'),
(7, 'The Selfish Gene', 'Richard Dawkins', 14.80, 'Science', 'books_images/the selfish gene.jpg'),
(8, 'The Name of the Wind', 'Patrick Rothfuss', 15.00, 'Fantasy', 'books_images/the name of the wind.jpg'),
(9, 'Outliers', 'Malcolm Gladwell', 13.50, 'Science', 'books_images/outliers.jpg'),
(10, 'War and Peace', 'Leo Tolstoy', 19.99, 'History', 'books_images/war and peace.jpg'),
(11, 'Little Women', 'Louisa May Alcott', 12.50, 'Romance', 'books_images/little women.jpg'),
(26, 'Microbial Enzymes: Biochemical Foundations, Industrial Applications, and Biotechnological Innovations', 'Dr. Sonia Hayat, Dr. Imrana Amir, Dr. Muhammad Naeem ', 14.01, 'Science', 'http://books.google.com/books/content?id=kL-cEQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api'),
(27, 'Crime and Punishment', 'Fyodor Dostoyevsky', 55.70, 'Fiction', 'http://books.google.com/books/content?id=SYu-4-oO3h8C&printsec=frontcover&img=1&zoom=1&source=gbs_api'),
(32, 'Igwebuike Philosophy: an African Philosophy of Integrative Humanism', 'Ejikemeuwa J. O. Ndubisi Ph.D, Amos Ameh Ichaba Ph.D, James Nnoruga Ph.D', 16.02, 'Philosophy', 'http://books.google.com/books/content?id=UMC4DwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api');

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cart_items` text NOT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `full_name`, `address`, `email`, `phone`, `city`, `postal_code`, `country`, `created_at`, `cart_items`, `status`) VALUES
(36, 'dffdfd', 'tatar 134', 'dasda@gmail.com', '123456789', 'Waszawa', '02-778', 'Poland', '2025-12-06 15:10:07', '{\"The Alchemist\":{\"title\":\"The Alchemist\",\"price\":\"12.00\",\"image\":\"books_images\\/the alchemist.jpg\",\"author\":\"Paulo Coelho\",\"quantity\":1}}', 'In Progress');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `is_admin`) VALUES
(1, 'bob', 'bob1k@gmail.com', '$2y$10$ZXduGior/s9cFOeKaFmBAuZIIZxaZ62fs4R9w655vZi', '2025-11-03 16:54:51', 0),
(2, 'tom', 'tom@gmail.com', '$2y$10$MdWBUsiuWRicTdHCt0GzPunK.Kx6R4KpxfXT.eL4Vfh', '2025-11-14 16:20:25', 0),
(3, 'bb', 'bb@gmail.com', '$2y$10$I4VmdhG5HTUyN5klvWPsmOXrVkt5RS2SXCK/o7iYNMa', '2025-11-14 17:26:26', 0),
(4, 'qq', 'qq@gmail.com', '$2y$10$GDtYjms4iiE17Nr6yUY9Z.wUKUCAT8nYD4KYVvRvIITJHqRSCPjOq', '2025-11-14 17:31:40', 0),
(5, 'qwe', 'qwe@gmail.com', '$2y$10$inrg/FrgUrcxdEt/WaT6NO2PxrTkFnJg4quYMXlr.e93Iyx.QQi3C', '2025-11-21 14:20:23', 0),
(6, 'qwer', 'qwer@gmail.com', '$2y$10$CmeAYJsJ.vr0Ipi90OP3wOR29b7NEugNR2xiR4jmYuLlX2LpZUeRW', '2025-11-21 14:21:21', 0),
(7, 'sasa', 'sasa@gmail.com', '$2y$10$cQHxKYKVhuY1CmYHvY/kSOvGZDBR4Uf6HdOCDySymJQiSc5ZR5.O.', '2025-11-24 17:22:39', 0),
(8, 'Marian', 'mnychai@gmail.com', '$2y$10$sMoNbGnXeIXLhvydwSfcb.DO1c4kaQ/6tKXH7ApHhKfMGIXGopkOy', '2025-11-30 13:36:06', 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

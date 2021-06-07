-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 07 2021 г., 02:02
-- Версия сервера: 10.4.8-MariaDB
-- Версия PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `diplom`
--
CREATE DATABASE IF NOT EXISTS `diplom` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `diplom`;

-- --------------------------------------------------------

--
-- Структура таблицы `baner`
--

CREATE TABLE `baner` (
  `id` tinyint(1) UNSIGNED NOT NULL,
  `src` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `baner`
--

INSERT INTO `baner` (`id`, `src`) VALUES
(1, 'img/slider/1.png'),
(2, 'img/slider/2.png'),
(3, 'img/slider/3.png'),
(4, 'img/slider/4.png'),
(5, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` int(11) DEFAULT NULL,
  `count` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id`, `data_user_id`, `product_id`, `size`, `count`) VALUES
(5, 5, 6, 35, 1),
(6, 5, 6, 40, 2),
(7, 6, 5, 35, 1),
(8, 6, 2, 35, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `data_user`
--

CREATE TABLE `data_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(16) NOT NULL,
  `address` text NOT NULL,
  `payment` tinyint(1) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `data_user`
--

INSERT INTO `data_user` (`id`, `name`, `number`, `address`, `payment`, `time`) VALUES
(5, 'Шкенин Антон Александрович', '8(910) 107-8905', 'asadasda dasdadsa asdsdasda', 1, '2021-06-07 02:10:00'),
(6, 'Шкенин Антон Александрович', '8(910) 107-89 05', 'asadasda dasdadsa asdsdasda', 1, '2021-06-06 02:10:00');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `id_type` bigint(20) UNSIGNED NOT NULL,
  `price` float NOT NULL,
  `dbl_price` float NOT NULL,
  `src` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `id_type`, `price`, `dbl_price`, `src`) VALUES
(1, 'Пепперони', 'Пепперони, Сыр Моцарелла', 1, 400, 500, 'img/product/1.png'),
(2, '4 Сыра ', 'Соус Карбонара, Сыр Моцарелла, Сыр Пармезан, Сыр Роккфорти, Сыр Чеддер (тёртый)', 1, 700, 800, 'img/product/2.png'),
(5, 'Маргарита', 'Сыр Моцарелла', 1, 400, 500, 'img/product/5.png'),
(6, 'Ветчина и грибы ', 'Ветчина, Грибы, Сыр Моцарелла', 1, 600, 700, 'img/product/6.png'),
(7, 'Карбонара', 'Бекон, Свежие томаты, Соус Карбонара, Сыр Моцарелла, Сыр Пармезан', 1, 600, 700, 'img/product/7.png'),
(8, 'Баварская ', 'Лук, Огурцы маринованные, Охотничьи колбаски, Сыр Моцарелла', 1, 600, 700, 'img/product/8.png'),
(9, 'Куpиные крылышки', 'Порция 6 шт. Аппетитные крылышки с насыщенным многогранным вкусом и нотками копчености.', 2, 300, 0, 'img/product/9.png'),
(10, 'Куриные шарики ', 'Порция 90 г. Нежные и сочные куриные шарики в хрустящей панировке', 2, 150, 0, 'img/product/10.png'),
(11, 'Киккерсы', 'Порция 8 шт. Кусочки 100% натурального куриного филе в хрустящей панировке! Вкусно! Натурально!', 2, 250, 0, 'img/product/11.png'),
(12, 'Картофель Фри', 'Порция 190 г. Сочные хрустящие картофельные палочки прямо из печи!', 2, 250, 0, 'img/product/12.png'),
(13, 'Пицца-роллы', 'Порция 8 шт. Сладкие и нежные пицца-роллы с сыром моцарелла и ананасом, посыпанные сахарной пудрой.', 3, 200, 0, 'img/product/13.png'),
(14, 'Пирожное Мозаикa', 'Порция 4 шт. Нежное шоколадное пирожное с кусочками бисквита. Любимый вкус детства!', 3, 100, 0, 'img/product/14.png'),
(15, 'Десерт Шоколадная лава', 'Нежное хрустящее суфле с начинкой из горячего шоколада, посыпанное тонким слоем сахарной пудры.', 3, 200, 0, 'img/product/15.png'),
(17, 'Томатный', 'Элегантная классика. Вес – 30 грамм', 5, 40, 0, 'img/product/17.png'),
(18, 'Барбекю', 'Пикантный соус для самого изысканного любителя. Вес – 30 грамм', 5, 40, 0, 'img/product/18.png'),
(19, 'Карри ', 'Придаст восточный оттенок любому блюду. Вес – 30 грамм', 5, 40, 0, 'img/product/19.png'),
(20, '7UP', 'Напиток 7UP 0,5 литра.', 4, 120, 0, 'img/product/20.png'),
(21, 'Lipton Лимон', 'Холодный чай Lipton Лимон 0,5 литра.', 4, 120, 0, 'img/product/21.png'),
(22, 'Aqua Minerale нгаз.', 'Питьевая вода Aqua Minerale 0,5 литра без газа.', 4, 120, 0, 'img/product/22.png'),
(23, 'Сок Фруктовый Сад', 'Яблочный сок Фруктовый Сад 0,95 мл.', 4, 150, 0, 'img/product/23.png'),
(24, 'Домашняя', 'Ветчина, Свежие томаты, Соус Сырный, Сыр Моцарелла', 1, 500, 600, 'img/product/3.png'),
(25, 'Гавайская', 'Ананас, Ветчина, Сыр Моцарелла', 1, 500, 600, 'img/product/4.png');

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

CREATE TABLE `type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Пицца'),
(2, 'Закуски'),
(3, 'Дисерты'),
(4, 'Напитки'),
(5, 'Соусы');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `baner`
--
ALTER TABLE `baner`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `data_user_id` (`data_user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `data_user`
--
ALTER TABLE `data_user`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`,`id_type`),
  ADD KEY `id_type` (`id_type`);

--
-- Индексы таблицы `type`
--
ALTER TABLE `type`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `baner`
--
ALTER TABLE `baner`
  MODIFY `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `type`
--
ALTER TABLE `type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`data_user_id`) REFERENCES `data_user` (`id`),
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

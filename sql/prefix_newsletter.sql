-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Ned 28. kvě 2017, 23:51
-- Verze serveru: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- Verze PHP: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `netteweb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `prefix_newsletter`
--

CREATE TABLE `prefix_newsletter` (
  `id` int(11) NOT NULL,
  `id_locale` int(11) DEFAULT NULL COMMENT 'vazba na jazyk',
  `email` varchar(255) DEFAULT NULL COMMENT 'email',
  `added` datetime DEFAULT NULL COMMENT 'pridano',
  `ip` varchar(45) DEFAULT NULL COMMENT 'ip adresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='newsletter';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_newsletter`
--
ALTER TABLE `prefix_newsletter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_newsletter_locale_idx` (`id_locale`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_newsletter`
--
ALTER TABLE `prefix_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prefix_newsletter`
--
ALTER TABLE `prefix_newsletter`
  ADD CONSTRAINT `fk_newsletter_locale` FOREIGN KEY (`id_locale`) REFERENCES `prefix_locale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

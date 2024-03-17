CREATE DATABASE evidencija_rudnika;
USE evidencija_rudnika;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 11:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evidencija_rudnika`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `azuriraj_rudnik_procedura` (IN `p_idRudnika` INT, IN `p_prihodi` INT, IN `p_rashodi` INT)   BEGIN
    UPDATE rudnik
    SET prihodi = prihodi + p_prihodi,
        rashodi = rashodi + p_rashodi,
        profit = prihodi  - rashodi 
    WHERE id = p_idRudnika;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `izvestaj`
--

CREATE TABLE `izvestaj` (
  `id` int(11) NOT NULL,
  `idRudnika` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prihodi` int(11) NOT NULL,
  `rashodi` int(11) NOT NULL,
  `podnesilac` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izvestaj`
--

INSERT INTO `izvestaj` (`id`, `idRudnika`, `datum`, `prihodi`, `rashodi`, `podnesilac`) VALUES
(17, 20, '2024-01-18 09:59:41', 3000, 200, 'test'),
(18, 20, '2024-01-18 09:59:49', 2500, 500, 'test'),
(19, 21, '2024-01-18 10:00:03', 3000, 150, 'test'),
(20, 21, '2024-01-18 10:00:12', 500, 4000, 'test');

--
-- Triggers `izvestaj`
--
DELIMITER $$
CREATE TRIGGER `azuriraj_rudnik` AFTER INSERT ON `izvestaj` FOR EACH ROW BEGIN
    CALL azuriraj_rudnik_procedura(NEW.idRudnika, NEW.prihodi, NEW.rashodi);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `azuriraj_rudnik_delete` AFTER DELETE ON `izvestaj` FOR EACH ROW BEGIN
    CALL azuriraj_rudnik_procedura(OLD.idRudnika, -OLD.prihodi, -OLD.rashodi);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `azuriraj_rudnik_update` AFTER UPDATE ON `izvestaj` FOR EACH ROW BEGIN
    CALL azuriraj_rudnik_procedura(NEW.idRudnika, NEW.prihodi - OLD.prihodi, NEW.rashodi - OLD.rashodi);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnickoIme` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifra` varchar(100) NOT NULL,
  `uloga` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnickoIme`, `email`, `sifra`, `uloga`) VALUES
(2, 'test', 'test@test.test', '$2y$10$K3Na8SmsR8tkeqp0EB1w5uXgZRDKVbrrqYICWhjmKbzubVhXUQTom', 'korisnik'),
(3, 'admin', 'admin@admin.admin', '$2y$10$.AEQrrACg6WmYctUs7IV6eXQoxZ3cOiUSqFrxCJrvcLjxVvuk7jwS', 'admin'),
(4, 'korisnik2', 'test2@test.test', '$2y$10$grrhicec/Uf32ZUbYDAqHeqdrPxDXxVrXnbolvIiNHJ5Jk/KBKSyO', 'korisnik'),
(5, 'test23', 'test23@test.test', '$2y$10$aO5kocL1D27bynQuKcf8F.H8/8oG7wmk6yWIYEXpMHoNBnT4NoTeS', 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `rudnik`
--

CREATE TABLE `rudnik` (
  `id` int(11) NOT NULL,
  `imeRudnika` varchar(50) NOT NULL,
  `vrstaRude` varchar(50) NOT NULL,
  `imaDozvolu` tinyint(1) NOT NULL,
  `prihodi` int(20) NOT NULL,
  `rashodi` int(20) NOT NULL,
  `profit` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rudnik`
--

INSERT INTO `rudnik` (`id`, `imeRudnika`, `vrstaRude`, `imaDozvolu`, `prihodi`, `rashodi`, `profit`) VALUES
(20, 'Rudnik 1', 'ugalj', 1, 5500, 700, 4800),
(21, 'Rudnik 2', 'zlato', 0, 3500, 4150, -650);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rudnik_pogled`
-- (See below for the actual view)
--
CREATE TABLE `rudnik_pogled` (
`id` int(11)
,`imeRudnika` varchar(50)
,`vrstaRude` varchar(50)
,`prihodi` int(20)
,`rashodi` int(20)
,`profit` int(20)
);

-- --------------------------------------------------------

--
-- Structure for view `rudnik_pogled`
--
DROP TABLE IF EXISTS `rudnik_pogled`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rudnik_pogled`  AS SELECT `rudnik`.`id` AS `id`, `rudnik`.`imeRudnika` AS `imeRudnika`, `rudnik`.`vrstaRude` AS `vrstaRude`, `rudnik`.`prihodi` AS `prihodi`, `rudnik`.`rashodi` AS `rashodi`, `rudnik`.`profit` AS `profit` FROM `rudnik` WHERE `rudnik`.`imaDozvolu` = 1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `izvestaj`
--
ALTER TABLE `izvestaj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRudnika` (`idRudnika`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rudnik`
--
ALTER TABLE `rudnik`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `izvestaj`
--
ALTER TABLE `izvestaj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rudnik`
--
ALTER TABLE `rudnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izvestaj`
--
ALTER TABLE `izvestaj`
  ADD CONSTRAINT `izvestaj_ibfk_1` FOREIGN KEY (`idRudnika`) REFERENCES `rudnik` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

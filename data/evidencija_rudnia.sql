CREATE DATABASE evidencija_rudnika;
USE evidencija_rudnika;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `azuriraj_rudnik_procedura` (IN `p_idRudnika` INT, IN `p_ukupniPrihodi` INT, IN `p_ukupniRashodi` INT)
BEGIN
    UPDATE rudnik
    SET ukupniPrihodi = ukupniPrihodi + p_ukupniPrihodi,
        ukupniRashodi = ukupniRashodi + p_ukupniRashodi,
        profit = ukupniPrihodi - ukupniRashodi
    WHERE id = p_idRudnika;
END$$

DELIMITER ;

CREATE TABLE `promet` (
  `id` int(11) NOT NULL,
  `idRudnika` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `prihodi` int(11) NOT NULL,
  `rashodi` int(11) NOT NULL,
  `podnesilac` varchar(50) NOT NULL,
  `opisIzvoda` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `promet` (`id`, `idRudnika`, `datum`, `prihodi`, `rashodi`, `podnesilac`, `opisIzvoda`) VALUES
(17, 20, '2024-01-18 09:59:41', 3000, 200, 'test'),
(18, 20, '2024-01-18 09:59:49', 2500, 500, 'test'),
(19, 21, '2024-01-18 10:00:03', 3000, 150, 'test'),
(20, 21, '2024-01-18 10:00:12', 500, 4000, 'test');

DELIMITER $$

CREATE TRIGGER `azuriraj_rudnik` AFTER INSERT ON `promet` FOR EACH ROW
BEGIN
    CALL azuriraj_rudnik_procedura(NEW.idRudnika, NEW.prihodi, NEW.rashodi);
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER `azuriraj_rudnik_delete` AFTER DELETE ON `promet` FOR EACH ROW
BEGIN
    CALL azuriraj_rudnik_procedura(OLD.idRudnika, -OLD.prihodi, -OLD.rashodi);
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER `azuriraj_rudnik_update` AFTER UPDATE ON `promet` FOR EACH ROW
BEGIN
    CALL azuriraj_rudnik_procedura(NEW.idRudnika, NEW.prihodi - OLD.prihodi, NEW.rashodi - OLD.rashodi);
END$$

DELIMITER ;

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnickoIme` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifra` varchar(100) NOT NULL,
  `uloga` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `korisnici` (`id`, `korisnickoIme`, `email`, `sifra`, `uloga`) VALUES
(2, 'test', 'test@test.test', '$2y$10$K3Na8SmsR8tkeqp0EB1w5uXgZRDKVbrrqYICWhjmKbzubVhXUQTom', 'knjigovodja'),
(3, 'admin', 'admin@admin.admin', '$2y$10$.AEQrrACg6WmYctUs7IV6eXQoxZ3cOiUSqFrxCJrvcLjxVvuk7jwS', 'admin'),
(4, 'korisnik2', 'test2@test.test', '$2y$10$grrhicec/Uf32ZUbYDAqHeqdrPxDXxVrXnbolvIiNHJ5Jk/KBKSyO', 'knjigovodja'),
(5, 'test23', 'test23@test.test', '$2y$10$aO5kocL1D27bynQuKcf8F.H8/8oG7wmk6yWIYEXpMHoNBnT4NoTeS', 'knjigovodja');

CREATE TABLE `rudnik` (
  `id` int(11) NOT NULL,
  `imeRudnika` varchar(50) NOT NULL,
  `idRude` int(11) NOT NULL,
  `imaDozvolu` tinyint(1) NOT NULL,
  `ukupniPrihodi` int(20) NOT NULL,
  `ukupniRashodi` int(20) NOT NULL,
  `profit` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rudnik` (`id`, `imeRudnika`, `idRude`, `imaDozvolu`, `ukupniPrihodi`, `ukupniRashodi`, `profit`) VALUES
(20, 'Rudnik 1', 2, 1, 5500, 700, 4800),
(21, 'Rudnik 2', 3, 0, 3500, 4150, -650);

CREATE TABLE `vrsta_rude` (
  `id` int(11) NOT NULL,
  `nazivRude` varchar(50) NOT NULL,
  `granicaProfita` int(20) NOT NULL
)  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `vrsta_rude` (`id`, `nazivRude`, `granicaProfita`) VALUES
(1, 'bakar', 1500),
(2, 'ugalj', 2000),
(3, 'zlato', 1000),
(4, 'srebro', 3000);

DROP TABLE IF EXISTS `rudnik_pogled`;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rudnik_pogled` AS 
SELECT 
    `rudnik`.`id` AS `id`, 
    `rudnik`.`imeRudnika` AS `imeRudnika`, 
    `vrsta_rude`.`nazivRude` AS `vrstaRude`, 
    `rudnik`.`ukupniPrihodi` AS `ukupniPrihodi`, 
    `rudnik`.`ukupniRashodi` AS `ukupniRashodi`, 
    `rudnik`.`profit` AS `profit` 
FROM 
    `rudnik` 
JOIN 
    `vrsta_rude` ON `rudnik`.`idRude` = `vrsta_rude`.`id` 
WHERE 
    `rudnik`.`imaDozvolu` = 1;


ALTER TABLE `promet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRudnika` (`idRudnika`);

ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rudnik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRude` (`idRude`);

ALTER TABLE `vrsta_rude`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `promet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `rudnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `vrsta_rude`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `promet`
  ADD CONSTRAINT `izvestaj_ibfk_1` FOREIGN KEY (`idRudnika`) REFERENCES `rudnik` (`id`) ON DELETE CASCADE;

ALTER TABLE `rudnik`
  ADD CONSTRAINT `vrsta_rude_ibfk_1` FOREIGN KEY (`idRude`) REFERENCES `vrsta_rude` (`id`) ON DELETE CASCADE;
 
COMMIT;

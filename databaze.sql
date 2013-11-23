-- ---------------------------------------------------------------------------
-- Vytvoreni databaze
-- ---------------------------------------------------------------------------
CREATE DATABASE `nemocnice`  DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------------
-- Vytvoreni tabulek v databazi
-- ---------------------------------------------------------------------------
-- !!! Zmena v puvodnim navrhu databaze:
-- Pro umozneni prihlasovani uzivatelu jsou tabulky lekar a sestra spojeny v
-- jednu tabulku zamestnanec. Tato tabulka zachovava vsechny puvodni atributy
-- jak lekare tak setry. Krom toho obsahuje navic atributy usermane, password
-- a role zamestnance (lekar, sestra, administrator).
-- Nesrovnalost je v atributu ciziho klice zkratkaOdd, ktery nebyl nastaven
-- jako cizi klic, protoze v pripade zaznamu lekar/administrator je nulovy

-- Zamestnanec
DROP TABLE IF EXISTS `nemocnice`.`zamestnanec`;
CREATE TABLE `nemocnice`.`zamestnanec` (
  `IDzamestnance` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(6),
  `password` char(60),
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `zkratkaOdd` varchar(50),  -- v pripade sestry slouzi jako cizi klic - nutno hlidat pomoci trigru!
  `erased` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `username` (`username`),
  PRIMARY KEY (`IDzamestnance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Pacient
DROP TABLE IF EXISTS `nemocnice`.`pacient`;
CREATE TABLE `nemocnice`.`pacient` (
  `rodneCislo` char(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  PRIMARY KEY (`rodneCislo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Oddeleni
DROP TABLE IF EXISTS `nemocnice`.`oddeleni`;
CREATE TABLE `nemocnice`.`oddeleni` (
  `zkratkaOdd` char(3) NOT NULL,
  `nazev` varchar(100) NOT NULL,
  `erased` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`zkratkaOdd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Lek
DROP TABLE IF EXISTS `nemocnice`.`lek`;
CREATE TABLE `nemocnice`.`lek` (
  `IDleku` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) NOT NULL,
  `pouziti` varchar(100) NOT NULL,
  `zpusobPodani` varchar(100),
  `ucinnaLatka` varchar(100),
  `sila` int(10) NOT NULL,
  `kontraindikace` varchar(100),
  PRIMARY KEY (`IDleku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Hospitalizace
DROP TABLE IF EXISTS `nemocnice`.`hospitalizace`;
CREATE TABLE `nemocnice`.`hospitalizace` (
  `IDhospitalizace` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datumPrijeti` date NOT NULL,
  `datumPropusteni` date,
  `zkratkaOdd` char(3) NOT NULL,
  `IDLekare` int(10) unsigned NOT NULL,
  `rodneCislo` char(11) NOT NULL,
  `erased` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDhospitalizace`),
  CONSTRAINT `fk_oddeleniHospitalizace` FOREIGN KEY (`zkratkaOdd`) REFERENCES `oddeleni` (`zkratkaOdd`),
  CONSTRAINT `fk_lekarHospitalizace` FOREIGN KEY (`IDlekare`) REFERENCES `zamestnanec` (`IDzamestnance`),
  CONSTRAINT `fk_pacientHospitalizace` FOREIGN KEY (`rodneCislo`) REFERENCES `pacient` (`rodneCislo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Uvazek
DROP TABLE IF EXISTS `nemocnice`.`uvazek`;
CREATE TABLE `nemocnice`.`uvazek` (
  `IDlekare` int(10) unsigned NOT NULL,
  `zkratkaOdd` varchar(50) NOT NULL,
  `telefon` char(9) NOT NULL,
  `roleUvazku` varchar(50) NOT NULL,
  PRIMARY KEY (`IDlekare`, `zkratkaOdd`),
  CONSTRAINT `fk_lekarUvazku` FOREIGN KEY (`IDlekare`) REFERENCES `zamestnanec` (`IDzamestnance`),
  CONSTRAINT `fk_oddeleniUvazku` FOREIGN KEY (`zkratkaOdd`) REFERENCES `oddeleni` (`zkratkaOdd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Vysetreni
DROP TABLE IF EXISTS `nemocnice`.`vysetreni`;
CREATE TABLE `nemocnice`.`vysetreni` (
  `IDvysetreni` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CasProvedeni` date NOT NULL,
  `vysledek` varchar(100),
  `zkratkaOdd` char(3) NOT NULL,
  `IDlekare` int(10) unsigned NOT NULL,
  `rodneCislo` char(11) NOT NULL,
  `erased` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDvysetreni`),
  CONSTRAINT `fk_oddeleniVysetreni` FOREIGN KEY (`zkratkaOdd`) REFERENCES `oddeleni` (`zkratkaOdd`),
  CONSTRAINT `fk_lekarVysetreni` FOREIGN KEY (`IDlekare`) REFERENCES `zamestnanec` (`IDzamestnance`),
  CONSTRAINT `fk_pacientVysetreni` FOREIGN KEY (`rodneCislo`) REFERENCES `pacient` (`rodneCislo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Podani Leku
DROP TABLE IF EXISTS `nemocnice`.`podaniLeku`;
CREATE TABLE `nemocnice`.`podaniLeku` (
  `IDpodaniLeku` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zacatekPodani` date NOT NULL,
  `konecPodani` date,
  `mnozstvi` int(10) NOT NULL,
  `opakovaniDenne` int(10) NOT NULL,
  `zpusobPodani` varchar(100),
  `rodneCislo` char(11) NOT NULL,
  `IDleku` int(10) unsigned NOT NULL,
  `erased` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDpodaniLeku`),
  CONSTRAINT `fk_pacientPodani` FOREIGN KEY (`rodneCislo`) REFERENCES `pacient` (`rodneCislo`),
  CONSTRAINT `fk_lekPodani` FOREIGN KEY (`IDleku`) REFERENCES `lek` (`IDleku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ---------------------------------------------------------------------------
-- Naplneni databaze vzorkem dat
-- ---------------------------------------------------------------------------
-- TODO opravit datumy tak, aby vkládaly hodnotu místo nul

-- Administrator
INSERT INTO `nemocnice`.`zamestnanec` (`username`, `password`, `jmeno`, `prijmeni`, `role`) VALUES
('admin0', '$2a$07$hn9edyker6dj0gxi4dqu0utddnn77xn6y1vDEtVX4gO998t2SwTvW', 'Admin', 'Administrator', 'administrator');

-- Pacient
INSERT INTO `nemocnice`.`pacient` (`rodneCislo`, `jmeno`, `prijmeni`) VALUES
('1305061122', 'Stepan', 'Slavicek'),
('4505061122', 'Martin', 'Pisin');

-- Lekar
INSERT INTO `nemocnice`.`zamestnanec` (`username`, `password`, `jmeno`, `prijmeni`, `role`) VALUES
('rusek0', '$2a$07$hn9edyker6dj0gxi4dqu0utddnn77xn6y1vDEtVX4gO998t2SwTvW','Jan', 'Rusek', 'lekar'),
('malym0', '$2a$07$hn9edyker6dj0gxi4dqu0utddnn77xn6y1vDEtVX4gO998t2SwTvW', 'Michal', 'Maly', 'lekar');

-- Oddeleni
INSERT INTO `nemocnice`.`oddeleni` (`zkratkaOdd`, `nazev`) VALUES
('ARO', 'Anesteziologicko-resuscitacni oddeleni'),
('JIP', 'Jednotka intenzivni pece');

-- Lek
INSERT INTO `nemocnice`.`lek` (`nazev`, `pouziti`, `zpusobPodani`, `ucinnaLatka`, `sila`, `kontraindikace`) VALUES
('Morfin', 'bolesti', 'nitrozilne, oralne', 'Morfium', 200, 'Lorem ipsum'),
('Ibalgin', 'horecka', 'analne, oralne', 'Ibuprofen', 500, 'Ipsum lorem');

-- Sestra
INSERT INTO `nemocnice`.`zamestnanec` (`username`, `password`, `jmeno`, `prijmeni`, `role`, `zkratkaOdd`) VALUES
('kodyt0', '$2a$07$hn9edyker6dj0gxi4dqu0utddnn77xn6y1vDEtVX4gO998t2SwTvW', 'Marta', 'Kodytkova', 'sestra', 'ARO'),
('bobko0', '$2a$07$hn9edyker6dj0gxi4dqu0utddnn77xn6y1vDEtVX4gO998t2SwTvW', 'Petra', 'Bobkova', 'sestra', 'JIP');

-- Hospitalizace
INSERT INTO `nemocnice`.`hospitalizace` (`datumPrijeti`, `datumPropusteni`, `zkratkaOdd`, `IDlekare`, `rodneCislo`) VALUES
('2013-02-08', '2013-02-15', 'ARO', 2, '1305061122'),
('2013-03-08', '2013-02-15', 'JIP', 3, '4505061122');

-- Uvazek
INSERT INTO `nemocnice`.`uvazek` (`IDlekare`, `zkratkaOdd`, `telefon`, `roleUvazku`) VALUES
(2,'ARO','777666555','Plny'),
(3,'JIP','777666444','Polovicni');

-- Vysetreni
INSERT INTO `nemocnice`.`vysetreni` (`CasProvedeni`, `vysledek`, `zkratkaOdd`, `IDlekare`, `rodneCislo`) VALUES
('2013-02-08','Lorem ipsum generator','ARO',2,'1305061122'),
('2013-02-12','Ipsum lorem generator','JIP',3,'4505061122');

-- Podani leku
INSERT INTO `nemocnice`.`podaniLeku` (`zacatekPodani`, `konecPodani`, `mnozstvi`, `opakovaniDenne`, `zpusobPodani`, `rodneCislo`, `IDleku`) VALUES
('2013-02-08','2013-02-15',3,1,'oralne','1305061122',1),
('2013-02-11','2013-03-31',6,3,'analne','1305061122',1);

-- ---------------------------------------------------------------------------
-- Konec skriptu pro vytvoření databáze
-- ---------------------------------------------------------------------------

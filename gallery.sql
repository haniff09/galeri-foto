-- CREATE DATABASE gallery

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `NamaLengkap` varchar(255) DEFAULT NULL,
  `Alamat` text DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `album` (
  `AlbumID` int(11) NOT NULL AUTO_INCREMENT,
  `NamaAlbum` varchar(255) DEFAULT NULL,
  `Deskripsi` text DEFAULT NULL,
  `TanggalDibuat` date DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`AlbumID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `foto` (
  `FotoID` int(11) NOT NULL AUTO_INCREMENT,
  `JudulFoto` varchar(255) DEFAULT NULL,
  `DeskripsiFoto` text DEFAULT NULL,
  `TanggalUnggah` date DEFAULT NULL,
  `LokasiFile` varchar(255) DEFAULT NULL,
  `AlbumID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`FotoID`),
  KEY `AlbumID` (`AlbumID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `komentarfoto` (
  `KomentarID` int(11) NOT NULL AUTO_INCREMENT,
  `FotoID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IsiKomentar` text DEFAULT NULL,
  `TanggalKomentar` date DEFAULT NULL,
  PRIMARY KEY (`KomentarID`),
  KEY `FotoID` (`FotoID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `likefoto` (
  `LikeID` int(11) NOT NULL AUTO_INCREMENT,
  `FotoID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TanggalLike` date DEFAULT NULL,
  PRIMARY KEY (`LikeID`),
  KEY `FotoID` (`FotoID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- FOREIGN KEY SETELAH SEMUA TABEL DIBUAT
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`AlbumID`) REFERENCES `album` (`AlbumID`),
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentarfoto_ibfk_1` FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`),
  ADD CONSTRAINT `komentarfoto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1` FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`),
  ADD CONSTRAINT `likefoto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

COMMIT;

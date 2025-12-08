-- Buat database otomatis
CREATE DATABASE IF NOT EXISTS gallery_db;
USE gallery_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =========================
-- TABEL USER
-- =========================
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(255) DEFAULT NULL,
  `Password` VARCHAR(255) DEFAULT NULL,
  `Email` VARCHAR(255) DEFAULT NULL,
  `NamaLengkap` VARCHAR(255) DEFAULT NULL,
  `Alamat` TEXT DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- TABEL ALBUM
-- =========================
CREATE TABLE IF NOT EXISTS `album` (
  `AlbumID` INT NOT NULL AUTO_INCREMENT,
  `NamaAlbum` VARCHAR(255) DEFAULT NULL,
  `Deskripsi` TEXT DEFAULT NULL,
  `TanggalDibuat` DATE DEFAULT NULL,
  `UserID` INT DEFAULT NULL,
  PRIMARY KEY (`AlbumID`),
  INDEX `idx_album_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- TABEL FOTO
-- =========================
CREATE TABLE IF NOT EXISTS `foto` (
  `FotoID` INT NOT NULL AUTO_INCREMENT,
  `JudulFoto` VARCHAR(255) DEFAULT NULL,
  `DeskripsiFoto` TEXT DEFAULT NULL,
  `TanggalUnggah` DATE DEFAULT NULL,
  `LokasiFile` VARCHAR(255) DEFAULT NULL,
  `AlbumID` INT DEFAULT NULL,
  `UserID` INT DEFAULT NULL,
  PRIMARY KEY (`FotoID`),
  INDEX `idx_foto_album` (`AlbumID`),
  INDEX `idx_foto_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- TABEL KOMENTAR
-- =========================
CREATE TABLE IF NOT EXISTS `komentarfoto` (
  `KomentarID` INT NOT NULL AUTO_INCREMENT,
  `FotoID` INT DEFAULT NULL,
  `UserID` INT DEFAULT NULL,
  `IsiKomentar` TEXT DEFAULT NULL,
  `TanggalKomentar` DATE DEFAULT NULL,
  PRIMARY KEY (`KomentarID`),
  INDEX `idx_komentar_foto` (`FotoID`),
  INDEX `idx_komentar_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- TABEL LIKE
-- =========================
CREATE TABLE IF NOT EXISTS `likefoto` (
  `LikeID` INT NOT NULL AUTO_INCREMENT,
  `FotoID` INT DEFAULT NULL,
  `UserID` INT DEFAULT NULL,
  `TanggalLike` DATE DEFAULT NULL,
  PRIMARY KEY (`LikeID`),
  INDEX `idx_like_foto` (`FotoID`),
  INDEX `idx_like_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- FOREIGN KEY
-- =========================
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1`
  FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`)
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1`
  FOREIGN KEY (`AlbumID`) REFERENCES `album` (`AlbumID`)
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2`
  FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`)
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentarfoto_ibfk_1`
  FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`)
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarfoto_ibfk_2`
  FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`)
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1`
  FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`)
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likefoto_ibfk_2`
  FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`)
  ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

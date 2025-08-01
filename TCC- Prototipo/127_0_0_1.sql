SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `gestao_merenda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestao_merenda`;

DROP TABLE IF EXISTS `tbusuario`;
CREATE TABLE IF NOT EXISTS `tbusuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `rm` varchar(20) NOT NULL,
  `codigo_etec` varchar(10) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('aluno','admin') NOT NULL DEFAULT 'aluno',
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula_unica` (`rm`,`codigo_etec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbusuario` (`id`, `nome`, `rm`, `codigo_etec`, `senha`, `nivel`) VALUES
(1, 'Administrador', 'adm', NULL, '$2y$10$u3tDfRtlErmGF.s.XE3zhOXbRm49kNGQoIiDQHRUGWVf4lYWfQZlS', 'admin');

DROP TABLE IF EXISTS `tb_cardapio`;
CREATE TABLE IF NOT EXISTS `tb_cardapio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_cardapio` date NOT NULL,
  `prato_principal` varchar(255) NOT NULL,
  `acompanhamento` varchar(255) DEFAULT NULL,
  `salada` varchar(255) DEFAULT NULL,
  `sobremesa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_unica` (`data_cardapio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tb_confirmacoes`;
CREATE TABLE IF NOT EXISTS `tb_confirmacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_confirmacao` date NOT NULL,
  `vai_comer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
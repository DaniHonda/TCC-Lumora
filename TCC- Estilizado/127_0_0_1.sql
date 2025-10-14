-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14/10/2025 às 10:44
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestao_merenda`
--
CREATE DATABASE IF NOT EXISTS `gestao_merenda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestao_merenda`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuario`
--

DROP TABLE IF EXISTS `tbusuario`;
CREATE TABLE IF NOT EXISTS `tbusuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rm` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `codigo_etec` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nivel` enum('aluno','admin','emp') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aluno',
  `turno` enum('Manhã','Tarde','Noite') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula_unica` (`rm`,`codigo_etec`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuario`
--

INSERT INTO `tbusuario` (`id`, `nome`, `rm`, `codigo_etec`, `senha`, `nivel`, `turno`) VALUES
(1, 'Administrador', 'adm', NULL, '$2y$10$u3tDfRtlErmGF.s.XE3zhOXbRm49kNGQoIiDQHRUGWVf4lYWfQZlS', 'admin', NULL),
(2, 'funcionario', 'emp', NULL, '$2y$10$TELj8i9B4JWABBvlXRIFG.MKy9BamLshbHrZd2iZCzJV86SDtlbX2', 'emp', NULL),
(3, 'Danilo', '23006', '210', '$2y$10$RxPpWEc1gy94ITwmgu2rIevssSzWZISXg6ZhNA/ZPCvVERzyOkZTu', 'aluno', 'Tarde'),
(5, 'pedro', '23001', '210', '$2y$10$1s2d.twzWzid9suE7XCBMukpBRS9HxjdrOSvLhW77YERGwS5gkIDG', 'aluno', 'Manhã');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_cardapio`
--

DROP TABLE IF EXISTS `tb_cardapio`;
CREATE TABLE IF NOT EXISTS `tb_cardapio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dia_semana` enum('Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prato_principal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acompanhamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `salada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sobremesa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_cardapio`
--

INSERT INTO `tb_cardapio` (`id`, `dia_semana`, `prato_principal`, `acompanhamento`, `salada`, `sobremesa`) VALUES
(2, 'Segunda-feira', 'a', '', '', ''),
(3, 'Terça-feira', 'b', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_confirmacoes_manha`
--

DROP TABLE IF EXISTS `tb_confirmacoes_manha`;
CREATE TABLE IF NOT EXISTS `tb_confirmacoes_manha` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_confirmacao` date NOT NULL,
  `vai_comer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_confirmacoes_manha`
--

INSERT INTO `tb_confirmacoes_manha` (`id`, `id_usuario`, `data_confirmacao`, `vai_comer`) VALUES
(1, 5, '2025-10-06', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_confirmacoes_noite`
--

DROP TABLE IF EXISTS `tb_confirmacoes_noite`;
CREATE TABLE IF NOT EXISTS `tb_confirmacoes_noite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_confirmacao` date NOT NULL,
  `vai_comer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_confirmacoes_tarde`
--

DROP TABLE IF EXISTS `tb_confirmacoes_tarde`;
CREATE TABLE IF NOT EXISTS `tb_confirmacoes_tarde` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_confirmacao` date NOT NULL,
  `vai_comer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_confirmacoes_tarde`
--

INSERT INTO `tb_confirmacoes_tarde` (`id`, `id_usuario`, `data_confirmacao`, `vai_comer`) VALUES
(1, 3, '2025-10-06', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 15/11/2025 às 13:38
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
  `turno` enum('Manhã','Tarde','Noite') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula_unica` (`rm`,`codigo_etec`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuario`
--

INSERT INTO `tbusuario` (`id`, `nome`, `rm`, `codigo_etec`, `senha`, `nivel`, `turno`) VALUES
(1, 'Administrador', 'adm', NULL, '$2y$10$u3tDfRtlErmGF.s.XE3zhOXbRm49kNGQoIiDQHRUGWVf4lYWfQZlS', 'admin', NULL),
(2, 'funcionario', 'emp', NULL, '$2y$10$TELj8i9B4JWABBvlXRIFG.MKy9BamLshbHrZd2iZCzJV86SDtlbX2', 'emp', NULL),
(7, 'pedro', '23001', '210', '$2y$10$BpofzGWOlmy3xXfGHwDkG.fTmJdsae6tiiTG.190j3ByJgugB4QWu', 'aluno', 'Manhã'),
(9, 'Marcelo', '23003', '210', '$2y$10$Juh9/w7vIm1vkEPkJaZcB.QibEfiD592k.Jpu1/d0oi1Hp5JG28Im', 'aluno', 'Tarde'),
(11, 'Lucas', '23004', '210', '$2y$10$FPlZlNek4qCQpxUQTZHudOVhSiURRExj07Oi6WEYd/OrnulSLd6aC', 'aluno', 'Manhã'),
(12, 'danilo', '23002', '210', '$2y$10$mRy9Ts/7.OWgx7cDWYjMeOVTkO7MjscUzJy8bnge0ulkNPZdzOp6K', 'aluno', 'Tarde');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_cardapio`
--

INSERT INTO `tb_cardapio` (`id`, `dia_semana`, `prato_principal`, `acompanhamento`, `salada`, `sobremesa`) VALUES
(4, 'Segunda-feira', 'Feijoada', 'arroz e farofa', 'alface', 'melância'),
(5, 'Terça-feira', 'Carne moída', 'Arroz, feijão preto e farofa', '', 'banana'),
(6, 'Quarta-feira', 'Ovo cozido', 'arroz e feijão', 'alface', ''),
(7, 'Quinta-feira', 'Macarrão', 'Carne Moída', '', 'Melão'),
(8, 'Sexta-feira', 'Frango', 'Arroz e Feijão', 'Alface e Tomate', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_confirmacoes_tarde`
--

INSERT INTO `tb_confirmacoes_tarde` (`id`, `id_usuario`, `data_confirmacao`, `vai_comer`) VALUES
(1, 12, '2025-11-13', 1),
(2, 12, '2025-11-11', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04-Abr-2017 às 18:16
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eficazsystem22`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_atividade`
--

CREATE TABLE `tb_atividade` (
  `id` int(11) NOT NULL,
  `nome_atividade` varchar(60) NOT NULL,
  `descricao_atividade` text NOT NULL,
  `status_ativo` int(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_atividade`
--

INSERT INTO `tb_atividade` (`id`, `nome_atividade`, `descricao_atividade`, `status_ativo`) VALUES
(1, 'Login', 'Atividade na qual o usuário efetua a entrada no sistema.', 1),
(2, 'Log out', 'Atividade na qual o usuário efetua manualmente a saída do sistema.', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_atividade`
--
ALTER TABLE `tb_atividade`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_atividade`
--
ALTER TABLE `tb_atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

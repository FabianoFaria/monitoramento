-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 31-Mar-2017 às 16:31
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
-- Estrutura da tabela `tb_contato_alerta_equip`
--

CREATE TABLE `tb_contato_alerta_equip` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_filial` int(11) NOT NULL,
  `id_equipamento` int(11) NOT NULL,
  `nome_contato` varchar(255) NOT NULL,
  `funcao` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `celular` varchar(25) NOT NULL,
  `observacao` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_contato_alerta_equip`
--
ALTER TABLE `tb_contato_alerta_equip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_contato_alerta_equip`
--
ALTER TABLE `tb_contato_alerta_equip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

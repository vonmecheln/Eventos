-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jun 17, 2010 as 11:12 PM
-- Versão do Servidor: 5.1.41
-- Versão do PHP: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `evento`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `usr_cod` int(11) NOT NULL AUTO_INCREMENT,
  `CID_COD` int(11) NOT NULL,
  `usr_nome` varchar(100) NOT NULL,
  `usr_cpf` varchar(20) DEFAULT NULL,
  `usr_rg` varchar(20) DEFAULT NULL,
  `usr_endereco` varchar(200) DEFAULT NULL,
  `usr_cep` varchar(21) DEFAULT NULL,
  `usr_numero` int(11) DEFAULT NULL,
  `usr_bairro` varchar(45) DEFAULT NULL,
  `usr_telefone` varchar(20) DEFAULT NULL,
  `usr_celular` varchar(20) DEFAULT NULL,
  `usr_email` varchar(100) DEFAULT NULL,
  `usr_login` varchar(45) NOT NULL,
  `usr_senha` varchar(150) NOT NULL DEFAULT '',
  `stt_cod` int(11) NOT NULL,
  `grp_cod` int(11) NOT NULL,
  PRIMARY KEY (`usr_cod`),
  KEY `ifk_Sts_Usu` (`stt_cod`),
  KEY `ifk_Gr_Usu` (`grp_cod`),
  KEY `usuario_FKIndex3` (`CID_COD`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=656 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usr_cod`, `CID_COD`, `usr_nome`, `usr_cpf`, `usr_rg`, `usr_endereco`, `usr_cep`, `usr_numero`, `usr_bairro`, `usr_telefone`, `usr_celular`, `usr_email`, `usr_login`, `usr_senha`, `stt_cod`, `grp_cod`) VALUES
(1, 1, 'desenvolvedor', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'root', 'ecd249920175216535974e8b0e33962e4a4c6fba', 4, 1);

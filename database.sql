-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.26-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para igorsouz_site
CREATE DATABASE IF NOT EXISTS `igorsouz_site` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `igorsouz_site`;

-- Copiando estrutura para tabela igorsouz_site.site_clientes
CREATE TABLE IF NOT EXISTS `site_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `cliente_projeto` varchar(255) CHARACTER SET latin1 NOT NULL,
  `cliente_valorfinal` int(11) DEFAULT NULL,
  `cliente_mensalidade` int(11) DEFAULT NULL,
  `cliente_mensalidadepaga` tinyint(4) DEFAULT '0',
  `cliente_emandamento` tinyint(4) NOT NULL DEFAULT '1',
  `cliente_vencimento` date DEFAULT NULL,
  `cliente_areceber` int(11) DEFAULT NULL,
  `cliente_recebido` int(11) DEFAULT NULL,
  `cliente_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cliente_email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cliente_telefone` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cliente_obs` text CHARACTER SET latin1,
  `adicionado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela igorsouz_site.site_clientes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `site_clientes` DISABLE KEYS */;
INSERT INTO `site_clientes` (`id`, `cliente_nome`, `cliente_projeto`, `cliente_valorfinal`, `cliente_mensalidade`, `cliente_mensalidadepaga`, `cliente_emandamento`, `cliente_vencimento`, `cliente_areceber`, `cliente_recebido`, `cliente_url`, `cliente_email`, `cliente_telefone`, `cliente_obs`, `adicionado_em`, `atualizado_em`) VALUES
	(1, 'Igor A. de Souza', 'Blog', 5000, 450, 1, 1, '2018-10-18', 0, 5000, 'www.igorsouzza.com.br', 'igor.souza.webmaster@gmail.com', '11969712779', NULL, '2017-10-18 19:32:49', '2017-10-27 18:05:52');
/*!40000 ALTER TABLE `site_clientes` ENABLE KEYS */;

-- Copiando estrutura para tabela igorsouz_site.site_log
CREATE TABLE IF NOT EXISTS `site_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitante_ip` varchar(50) CHARACTER SET latin1 NOT NULL,
  `visitante_uri` varchar(255) CHARACTER SET latin1 NOT NULL,
  `visitante_agent` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tipo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mensagem` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `visitante_nome` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela igorsouz_site.site_log: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `site_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_log` ENABLE KEYS */;

-- Copiando estrutura para tabela igorsouz_site.site_pages
CREATE TABLE IF NOT EXISTS `site_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `page_title` varchar(255) CHARACTER SET utf8 DEFAULT 'Título da página',
  `page_descricao` varchar(255) CHARACTER SET utf8 DEFAULT 'Descrição da página',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela igorsouz_site.site_pages: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `site_pages` DISABLE KEYS */;
INSERT INTO `site_pages` (`id`, `page`, `page_title`, `page_descricao`) VALUES
	(1, 'home', 'Igor Souzza - CriaÃ§Ã£o de Sites, Desenvolvimento e SoluÃ§Ãµes Web', 'CriaÃ§Ã£o e Desenvolvimento de Web Sites com extrema qualidade e seguranÃ§a. Ã‰ aqui que seus sonhos comeÃ§am.'),
	(2, 'portfolio', 'Igor Souzza Portfolio - CriaÃ§Ã£o de Sites, Desenvolvimento e SoluÃ§Ãµes Web', 'CriaÃ§Ã£o e Desenvolvimento de Web Sites com extrema qualidade e seguranÃ§a. Ã‰ aqui que seus sonhos comeÃ§am.');
/*!40000 ALTER TABLE `site_pages` ENABLE KEYS */;

-- Copiando estrutura para tabela igorsouz_site.site_page_global
CREATE TABLE IF NOT EXISTS `site_page_global` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `global_url` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'URL Principal',
  `global_name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Nome da Página',
  `global_google_author` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Author Google',
  `global_google_pub` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Publisher Google',
  `global_fb_app` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'App Facebook',
  `global_fb_author` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Author Facebook',
  `global_fb_pub` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Publisher Facebook',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela igorsouz_site.site_page_global: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `site_page_global` DISABLE KEYS */;
INSERT INTO `site_page_global` (`id`, `global_url`, `global_name`, `global_google_author`, `global_google_pub`, `global_fb_app`, `global_fb_author`, `global_fb_pub`) VALUES
	(1, 'https://www.igorsouzza.com.br', 'Igor Souzza - CriaÃ§Ã£o de Sites, Desenvolvimento e SoluÃ§Ãµes Web', '117033327238723927777', '106350026213975038404', '139847073426055', 'igor.souza079', 'igorsouzzaweb');
/*!40000 ALTER TABLE `site_page_global` ENABLE KEYS */;

-- Copiando estrutura para tabela igorsouz_site.site_users
CREATE TABLE IF NOT EXISTS `site_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_pass` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_level` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Usuario',
  `user_lastname` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'Usuario',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela igorsouz_site.site_users: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `site_users` DISABLE KEYS */;
INSERT INTO `site_users` (`id`, `user_email`, `user_pass`, `user_level`, `user_name`, `user_lastname`, `criado_em`, `atualizado_em`) VALUES
	(1, 'igor.souza.webmaster@gmail.com', '9e294f15563b92a26ce4f8c2db6bbc75', 3, 'Igor', 'Souza', '2017-10-18 16:02:25', '2017-10-20 17:42:14');
/*!40000 ALTER TABLE `site_users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

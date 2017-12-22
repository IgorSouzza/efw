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

-- Copiando estrutura para tabela igorsouz_site.blog_category
CREATE TABLE IF NOT EXISTS `blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela igorsouz_site.blog_posts
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_coment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_pageview` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_url` (`post_url`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportação de dados foi desmarcado.
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

-- Exportação de dados foi desmarcado.
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
) ENGINE=InnoDB AUTO_INCREMENT=1937 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela igorsouz_site.site_pages
CREATE TABLE IF NOT EXISTS `site_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `page_title` varchar(255) CHARACTER SET utf8 DEFAULT 'Título da página',
  `page_descricao` varchar(255) CHARACTER SET utf8 DEFAULT 'Descrição da página',
  `page_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportação de dados foi desmarcado.
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

-- Exportação de dados foi desmarcado.
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

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

<?php

namespace App;
use \EFW\Init\Bootstrap;

/*
* Class for register routes, controllers and actions.
* Routes = URL
* Controller = File in App/Controllers 
* Action = Method inside controller class.
*/
class Init extends Bootstrap
{
	private $urlDbRows;
	protected function initRoutes()
	{
		/*INSTITUCIONAL*/
		$ar['home'] = array('route' => '/', 'controller' => 'HomeController', 'action' => 'index');
		$ar['portfolio'] = array('route' => '/portfolio', 'controller' => 'HomeController', 'action' => 'portfolio');
		$ar['blog'] = array('route' => '/blog', 'controller' => 'BlogController', 'action' => 'index');
		$ar['notfound'] = array('route' => '/404', 'controller' => 'NotFound', 'action' => 'index');

		/*ADMIN*/
		$ar['admin'] = array('route' => '/admin', 'controller' => 'AdminLoginController', 'action' => 'index');
		$ar['admin/dash'] = array('route' => '/admin/dash', 'controller' => 'AdminDashController', 'action' => 'index');
		$ar['admin/seo'] = array('route' => '/admin/seo', 'controller' => 'AdminInstitucionalController', 'action' => 'seo');

		/*ADMIN INSTITUCIONAL*/
		$ar['admin/institucional'] = array('route' => '/admin/institucional', 'controller' => 'AdminInstitucionalController', 'action' => 'index');
		$ar['admin/institucional/atualizar'] = array('route' => '/admin/institucional/atualizar/', 'controller' => 'AdminInstitucionalController', 'action' => 'update');

		/*ADMIN CLIENTES*/
		$ar['admin/clientes'] = array('route' => '/admin/clientes', 'controller' => 'AdminClientesController', 'action' => 'index');
		$ar['admin/clientes/adicionar'] = array('route' => '/admin/clientes/adicionar', 'controller' => 'AdminClientesController', 'action' => 'create');
		$ar['admin/clientes/atualizar'] = array('route' => '/admin/clientes/atualizar/', 'controller' => 'AdminClientesController', 'action' => 'update');
		$ar['admin/clientes/excluir'] = array('route' => '/admin/clientes/excluir/', 'controller' => 'AdminClientesController', 'action' => 'delete');

		/*ADMIN LOGS*/
		$ar['admin/logs-acesso'] = array('route' => '/admin/logs-painel', 'controller' => 'AdminLogsController', 'action' => 'painel');
		$ar['admin/logs-login'] = array('route' => '/admin/logs-login', 'controller' => 'AdminLogsController', 'action' => 'login');
		
		/*ADMIN BLOG*/
		$ar['admin/dashblog'] = array('route' => '/admin/dashblog', 'controller' => 'AdminBlogController', 'action' => 'index');
		$ar['admin/dashblog/adicionar'] = array('route' => '/admin/dashblog/adicionar', 'controller' => 'AdminBlogController', 'action' => 'create');
		$ar['admin/dashblog/atualizar'] = array('route' => '/admin/dashblog/atualizar/', 'controller' => 'AdminBlogController', 'action' => 'update');
		$ar['admin/dashblog/excluir'] = array('route' => '/admin/dashblog/excluir/', 'controller' => 'AdminBlogController', 'action' => 'delete');
		$ar['admin/dashblog/atualizarsitemap'] = array('route' => '/admin/dashblog/atualizarsitemap', 'controller' => 'AdminBlogController', 'action' => 'updateSiteMap');
		$ar['admin/dashblog/categorias'] = array('route' => '/admin/dashblog/categorias', 'controller' => 'AdminBlogController', 'action' => 'indexCategorias');

		/*ADMIN EMAIL*/
		$ar['admin/email'] = array('route' => '/admin/email', 'controller' => 'AdminEmailController', 'action' => 'index');
		$ar['admin/email/atualizar'] = array('route' => '/admin/email/atualizar/', 'controller' => 'AdminEmailController', 'action' => 'read');
		$ar['admin/email/excluir'] = array('route' => '/admin/email/excluir/', 'controller' => 'AdminEmailController', 'action' => 'delete');

		//Get dynamics url's from post db
		foreach ($this->getDbRoutes() as $key) {
			$teste = array_values($key)[0];
			$ar['blog/' . $teste] = array('route' => '/blog/' . $teste, 'controller' => 'BlogController', 'action' => 'readPost');

		}

		$this->setRoutes($ar);
	}

	/*
	* Init new connection with Database using PDO.
	*/
	public static function getDb()
	{
		try{
			$db = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";", DB_LOGIN, DB_PASS);
			return $db;
		}catch(\PDOException $e){
			echo "Impossivel conectar com o banco de dados!";
		}
		
	}

	public static function generateSiteMap()
	{
		$stmt = self::getDb()->prepare("SELECT * FROM blog_posts");
		$stmt->execute();
		$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		$sitemap = "<?xml version='1.0' encoding='UTF-8'?>
			<?xml-stylesheet type='text/xsl' href='sitemap.xsl'?>
			<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>
			    <url>
			        <loc>https://www.igorsouzza.com.br</loc>
			        <lastmod>2017-10-16T08:56:54-03:00</lastmod>
			        <changefreq>monthly</changefreq>
			        <priority>1.0</priority>
			    </url>
			    <url>
			        <loc>https://www.igorsouzza.com.br/portfolio</loc>
			        <lastmod>2017-10-15T08:56:54-03:00</lastmod>
			        <changefreq>monthly</changefreq>
			        <priority>0.8</priority >
			    </url>
			    <url>
			        <loc>https://www.igorsouzza.com.br/blog</loc>
			        <lastmod>2017-10-15T08:56:54-03:00</lastmod>
			        <changefreq>daily</changefreq>
			        <priority>0.95</priority >
			    </url>";

	    foreach ($res as $data) {
	    	$dataFormatada = strtotime($data['timestamp']);
	    	die(date("h:m:s", $dataFormatada));
	    	$sitemap .= "<url>
			        <loc>https://www.igorsouzza.com.br/blog/{$data['post_url']}</loc>
			        <lastmod>" . date("Y-m-d",$dataFormatada) . "T" . date("h:i:s",$dataFormatada) . "-03:00</lastmod>
			        <changefreq>monthly</changefreq>
			        <priority>0.90</priority >
			    </url>";
	    }
	    $sitemap .= "</urlset>";
		
		$path = "sitemap.xml";
		$modo = "w+";

		if ($fp=fopen($path,$modo))
		{
		   fwrite ($fp,$sitemap);
		}
	}

	public static function generateRSS()
	{
		$stmt = self::getDb()->prepare("SELECT * FROM blog_posts ORDER BY timestamp DESC");
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		$rss = "<?xml version='1.0' encoding='UTF-8' ?>";
		$rss .= "<rss version='2.0'>";
		$rss .= "<channel>";
		$rss .= "<title>Igor Souzza - Desenvolvimento e Soluções Web</title>";
		$rss .= "<link>https://www.igorsouzza.com.br</link>";
		$rss .= "<description>Criação,desenvolvimento de Websites e soluções web. Garanta já o seu site ou sistema e fique cada vez mais próximo do sucesso!</description>";
		$rss .= "<language>pt-br</language>";

	    foreach ($result as $data) {
	    	$dataFormatada = strtotime($data['timestamp']);
	    	$rss .= "<item>
		            <title>{$data['post_title']}</title>
		            <link>https://www.igorsouzza.com.br/blog/{$data['post_url']}</link>
		            <pubDate>" . date("D, d M Y h:i:s", $dataFormatada) . " -0300</pubDate>
		            <description>".$data['post_desc']."</description>
		       	 	</item>";
	    }

		$rss .= "<item>";
		$rss .= "<title>Igor Souzza - Desenvolvimento e Soluções Web</title>";
		$rss .= "<link>https://www.igorsouzza.com.br</link>";
		$rss .= "<pubDate>Friday, 01 Oct 2017 01:01:12 -0300</pubDate>";
		$rss .= "<description>Criação,desenvolvimento de Websites e soluções web. Garanta já o seu site ou sistema e fique cada vez mais próximo do sucesso!</description>";
		$rss .= "</item>";
        $rss .= "<item>";
		$rss .= "<title>Igor Souzza - Desenvolvimento e Soluções Web - Portfolio</title>";
        $rss .= "<link>https://www.igorsouzza.com.br/portfolio</link>";
		$rss .= "<pubDate>Friday, 01 Oct 2017 01:01:12 -0300</pubDate>";
		$rss .= "<description>Criação,desenvolvimento de Websites e soluções web. Garanta já o seu site ou sistema e fique cada vez mais próximo do sucesso!</description>";
		$rss .= "</item>";
	    $rss .= "</channel>";
	    $rss .= "</rss>";

		$path = "rss.xml";
		$modo = "w+";

		if ($fp=fopen($path,$modo))
		{
		   fwrite ($fp,$rss);
		}
	}

	private function getDbRoutes()
	{
		$stmt = self::getDb()->prepare("SELECT post_url FROM blog_posts");
		$stmt->execute();

		$res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $res;
	}
}
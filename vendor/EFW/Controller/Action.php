<?php

namespace EFW\Controller;
use EFW\Controller\Messages;
use EFW\DI\Container;

class Action
{
	private $siteinfo;

	public function __construct()
	{
		session_start();
	}

	/*
	 * Call Twig Engine loader and return the view.
	 * @param string $view path to .html.twig view file.
	 * @param array $data values to send to view.
	 */
	public function render(string $view, array $data = null, string $pageNameInDatabase = null)
	{
		$loader = new \Twig_Loader_Filesystem(BASE_VIEW);
		$twig = new \Twig_Environment($loader);
		$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		//Twig global variables
		if(!empty($_SESSION['userlogin'])){
			//Admin
			$twig->addGlobal('nome', $_SESSION['userlogin']['user_name'] . " " . $_SESSION['userlogin']['user_lastname']);
			$twig->addGlobal('current_page', '');
			$twig->addGlobal('message', Messages::getMessage());
		}
		
		//SEO
		if(!empty($pageNameInDatabase)){
			$this->setSEO($twig, $pageNameInDatabase);
		}

		if(isset($_SESSION['paginator'])){
			$twig->addGlobal('paginator', $_SESSION['paginator']);
		}

		if(strpos($url, 'blog') !== false && strlen($url) > 6){
			$this->setSEOBlogPost($twig, $url);
		}
		//String handling
		$newStringView = str_replace(".", "/", $view);
		$newStringView .= '.html.twig';

		if(!empty($data))
			echo $twig->render($newStringView, $data);
		else
			echo $twig->render($newStringView, array('' => ''));

		unset($_SESSION['message']);
	}

	/**
	 * Set seo properties in each different page
	 * @param Twig_Environment $twig twig variable to add global value
	 * @param string $page page name in database to select database values for each page
	 */
	private function setSEO($twig, $page)
	{
		$seoPage = Container::getClass('SeoPage');
		$seoPageValues = $seoPage->fetchAll(false, 0, "page", $page)[0];

		$seoGlobal = Container::getClass('seoGlobal');
		$seoGlobalValues = $seoGlobal->fetchAll(false)[0];
		
		$twig->addGlobal('title', $seoPageValues['page_title']);
		$twig->addGlobal('site_desc', $seoPageValues['page_descricao']);
		$twig->addGlobal('logo','public/images/logo.jpg');
		$twig->addGlobal('logo2', 'public/images/logo.png');
		$twig->addGlobal('url', $seoGlobalValues['global_url']);
		$twig->addGlobal('site_name', $seoGlobalValues['global_name']);
		$twig->addGlobal('google_author', $seoGlobalValues['global_google_author']);
		$twig->addGlobal('google_publisher', $seoGlobalValues['global_google_pub']);
		$twig->addGlobal('fb_app', $seoGlobalValues['global_fb_app']);
		$twig->addGlobal('fb_author', $seoGlobalValues['global_fb_author']);
		$twig->addGlobal('fb_publisher', $seoGlobalValues['global_fb_pub']);
	}

	private function setSEOBlogPost($twig, $url)
	{
		$postInfo = Container::getClass('Post');
		$post = $postInfo->findUrl(basename($url));

		$twig->addGlobal('title', $post['post_title'] . ' - Igor Souzza');		
	}
}
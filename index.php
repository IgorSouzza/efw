<?php

require_once __DIR__ . '/vendor/autoload.php';

function sitemapPing()
{
    $siteMapPing = array();
    $siteMapPing['google'] = 'https://www.google.com/webmasters/tools/ping?sitemap=https://www.igorsouzza.com.br/sitemap.xml';
    $siteMapPing['bing'] = 'https://www.bing.com/webmaster/ping.aspx?siteMap=https://www.igorsouzza.com.br/sitemap.xml';

    foreach($siteMapPing as $url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
        curl_close($ch);
    }
}

if(!file_exists('sitemap.xml.gz')){
    $gzip = gzopen('sitemap.xml.gz', 'w9');
    $gmap = file_get_contents('sitemap.xml');
    gzwrite($gzip, $gmap);
    gzclose($gzip);

    sitemapPing();
}

$init = new \App\Init;

<?php
use Symfony\Component\DomCrawler\Crawler;

/**
 * 
 * Este web scrapper utiliza la libreria de php goutte
 */


class FPEScrapper
{
    public $products = []; // Matriz en donde se almacenaran los datos de los productos

    public $paginatorData = [
        'url' => '',
        'current' => 0,
        'total' => 0,
        'counter' => 1,
        'max' => 10
    ];

    public function __construct() {

    }

    public function getAllProducts()
    {

        $client = new Goutte\Client();

        $crawler = $client->request(
            'GET',
            'https://www.fpe-store.com/default.asp'
        );



        foreach ($crawler->filter('#display_menu_2 > ul > li > a') as $context) {
            $node = new Crawler($context);

            $base_url = '';
            $page = 0;


            if ($this->paginatorData['url'] !== '') {
                if ($node->attr('href') !== $this->paginatorData['url']) {
                    continue;
                } else {
                    if ($this->paginatorData['current'] == $this->paginatorData['total']) {
                        $this->paginatorData['url'] = '';
                        $this->paginatorData['current'] = 0;
                        $this->paginatorData['total'] = 0;

                        continue;
                    } else {
                        $base_url = $this->paginatorData['url'];
                    }        
                }
            } else {
                $base_url = $node->attr('href');
            }


            if ($this->paginatorData['counter'] > 1) {
                
                if ($this->paginatorData['current'] == $this->paginatorData['total']) {
                    
                    $this->paginatorData['current'] = 0;
                    $this->paginatorData['total'] = 0;

                    $page = 1;

                } else {

                    $page = $this->paginatorData['current'];
                }
            } else {
                $page = 1;
            }


            $this->searchProducts($page, $base_url);


        };


        return $this->products;
    }


    /**
     * Esta funcion recorre las páginas de cada sección
     */

    public function searchProducts($page = 1, $base_url)
    {


        $this->paginatorData['current'] = $page;

        $this->paginatorData['url'] = $base_url;

        $client = new Goutte\Client();

        $searchParams = '?searching=Y&sort=2&cat=114&show=300&page=';

        $crawler = $client->request(
            'GET',
            $base_url . $searchParams . $page
        );

        $numberOfPages = (int)explode(' ', $crawler->filter('.search_results_section table td[align="right"]')->first()->filter('b')->text())[2];

        $this->paginatorData['total'] = $numberOfPages;

        $this->getRelevantData($crawler);

        if ($this->paginatorData['total'] > $this->paginatorData['current'] && $this->paginatorData['counter'] < $this->paginatorData['max']) {

            $this->searchProducts(++$this->paginatorData['current'], $this->paginatorData['url']);
            $this->paginatorData['counter']++;
        }

    }


    /**
     * Esta funcion llena la mátriz de productos
     */

    public function getRelevantData($crawler)
    {

        $crawler->filter('.v-product')->each(function ($node) {

            $product = [];

            $attrTitle = $node->filter('.v-product__title.productnamecolor.colors_productname')->attr('title') . '<br>';

            $strpos = strpos($attrTitle, ',');

            $product['title'] = substr($attrTitle, 0, $strpos);
            $product['code'] = substr($attrTitle, ++$strpos);
            $product['price'] = $node->filter('.notranslate')->text();



            $this->products[] = $product;
        });
    }
}
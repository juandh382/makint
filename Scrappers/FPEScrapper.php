<?php
use Symfony\Component\DomCrawler\Crawler;

/**
 * 
 * Este web scrapper utiliza la libreria de php goutte
 */


class FPEScrapper
{
    public $products = []; // Matriz en donde se almacenaran los datos de los productos
    
    public $issetGet = false;

    public function __construct() {
        if (isset($_GET['page']) && isset($_GET['currentSection'])) {
            $_SESSION['paginatorData']['counter'] = 0;
            $this->issetGet = true;
        }
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

            if ($this->issetGet) {

                if ($node->text() == $_SESSION['paginatorData']['currentSection']) {

                    if ($_SESSION['paginatorData']['current'] !== $_SESSION['paginatorData']['total']) {


                        $this->searchProducts($_SESSION['paginatorData']['current'], $_SESSION['paginatorData']['url']);

                    } else {

                        $this->issetGet = false;

                        continue;
                    }

                } else {

                    continue;
                }

            } else {
                $this->searchProducts(1, $node->attr('href'));
            }


            if (count($_SESSION['paginatorData']['sections']) == 0) {

                $crawler->filter('#display_menu_2 > ul > li > a')->each(function ($n) {
                    $_SESSION['paginatorData']['sections'][] = [
                        'name' => $n->attr('href'),
                        'url' => $n->text()
                    ];
                });
            }
            

            if ($_SESSION['paginatorData']['counter'] >= $_SESSION['paginatorData']['max']) {

                $_SESSION['paginatorData']['currentSection'] = $node->text();
                break;
            }

        }

        return $this->products;
    }


    /**
     * Esta funcion recorre las páginas de cada sección
     */

    public function searchProducts($page = 1, $base_url)
    {

        $client = new Goutte\Client();

        $searchParams = '?searching=Y&sort=2&cat=114&show=300&page=';

        $crawler = $client->request(
            'GET',
            $base_url . $searchParams . $page
        );

        $numberOfPages = (int)explode(' ', $crawler->filter('.search_results_section table td[align="right"]')->first()->filter('b')->text())[2];

        $_SESSION['paginatorData']['current'] = $page;
        $_SESSION['paginatorData']['url'] = $base_url;
        $_SESSION['paginatorData']['total'] = $numberOfPages;


        if ($_SESSION['paginatorData']['counter'] <= $_SESSION['paginatorData']['max']) {

            $this->getRelevantData($crawler);
        }
        
        if ($_SESSION['paginatorData']['current'] < $_SESSION['paginatorData']['total'] && $_SESSION['paginatorData']['counter'] < $_SESSION['paginatorData']['max']) {
            
            $this->searchProducts(++$_SESSION['paginatorData']['current'], $_SESSION['paginatorData']['url']);
            
            $_SESSION['paginatorData']['counter']++;

            // echo '<pre>';
            // var_dump($_SESSION['paginatorData']);
            // echo '</pre>';
            
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
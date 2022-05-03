<?php


class FPEScrapper
{
    public $products = [];

    public function getAllProducts()
    {

        $urls = array();

        $client = new Goutte\Client();

        $crawler = $client->request(
            'GET',
            'https://www.fpe-store.com/default.asp'
        );


        $crawler->filter('#display_menu_2 > ul > li > a')->each(function ($node) {

            $this->searchProducts(1, $node->attr('href'));
        });


        return $this->products;
    }

    public function searchProducts($page = 1, $base_url)
    {



        $client = new Goutte\Client();

        $searchParams = '?searching=Y&sort=2&cat=114&show=300&page=';

        $crawler = $client->request(
            'GET',
            $base_url . $searchParams . $page
        );

        $numberOfPages = (int)explode(' ', $crawler->filter('.search_results_section table td[align="right"]')->first()->filter('b')->text())[2];

        $this->getRelevantData($crawler);


        if ($page < $numberOfPages) {
            $this->searchProducts(++$page, $base_url);
        }


    }


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
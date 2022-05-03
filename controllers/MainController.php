<?php

class MainController
{



    public function init()
    {


        require_once 'Scrappers/FPEScrapper.php';

        try {

            // $fpeScrapper = new FPEScrapper();
            // $fpeProducts = $fpeScrapper->getAllProducts();
            
            require_once 'views/products/index.php';

        }
        catch (Exception $e) {
            echo $e;
        }
    }



}
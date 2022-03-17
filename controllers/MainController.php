<?php

class MainController {

    

    public function init() {


        require_once 'Scrappers/FPEScrapper.php';
       
        try {
            
            $fpeScrapper = new FPEScrapper();
            $fpeScrapper->getAllProducts();

        } catch (Exception $e) {
            echo $e;
        }
    }

    
}
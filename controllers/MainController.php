<?php

class MainController {
    public function init() {
       
        $client = new Goutte\Client();
        $crawler = $client->request('GET', 'https://www.fpe-store.com/Default.asp');
        $crawler->filter('.v-product')->each(function ($node) {
            print $node->text() . '</br>';
        });
    }
}
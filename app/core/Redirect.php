<?php

namespace App\Core;
class Redirect {

    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function redirect() {
        header('Location: ' . $this->url);
        exit;
    }
}
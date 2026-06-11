<?php
namespace  App\Core;
class Helper {

    public static function getPageTitle() {
        $script = $_SERVER['SCRIPT_NAME'];
        $page = ucfirst(basename($script, '.php'));
        return 'TennisZone - ' . $page;
    }
}
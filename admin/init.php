<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 18-May-17
 * Time: 19:23
 */
//database
include 'connect.php';
//routes
$tpl = 'includes/templates/'; //template directory
$lang = 'includes/languages/';
$func = 'includes/functions/';
$css = 'layout/css/'; //Cascading Style Sheets directory
$js = 'layout/js/'; //JavaScript directory
$fotos='/onlineshop/admin/uploads/';


// include important files
include $func . 'functions.php';
include $lang . 'francais.php';
include $tpl . 'header.php';
if (!isset($noNavBar)) {
    include $tpl . 'navbar.php';
}

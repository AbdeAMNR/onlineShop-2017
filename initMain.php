<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 10-Jun-17
 * Time: 06:46
 */

//database
include 'admin/connect.php';
//routes
$tpl = 'includes/templates/'; //template directory
$lang = '/onlineshop/includes/languages/';
$func = 'admin/includes/functions/';
$css = '/onlineshop/layout/css/'; //Cascading Style Sheets directory
$js = '/onlineshop/layout/js/'; //JavaScript directory
$fotos = '/onlineshop/admin/uploads/';
$imgs = '/onlineShop/images/';
$uploads='/onlineShop/admin/uploads/';


// include important files
include $func . 'functions.php';
$single='';
include $tpl . "headBalise.php";
include $tpl . "navBar.php";

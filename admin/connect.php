<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 19-May-17
 * Time: 03:38
 */
$dsn = 'mysql:host=localhost;dbname=onlineshop';
$user = 'root';
$pass = '12345';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Faild to connect' . $e->getMessage();
}
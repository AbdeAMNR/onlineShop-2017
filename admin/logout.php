<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 21-May-17
 * Time: 01:04
 */

session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit();
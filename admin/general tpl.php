<?php
/*
===================================================================
== Structure générale des pages
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'Fournisseur';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links
    //=============================================================
    $do = (isset($_GET['do']) ? $_GET['do'] : 'manage');
    if ($do == 'manage') {
    } elseif ($do == 'add') {

    } elseif ($do == 'edit') {

    } elseif ($do == 'update') {

    } elseif ($do == 'insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        } else {
            include $tpl . 'errorPage.php';
        }

    } elseif ($do == 'delete') {

    } elseif ($do == 'approve') {

    }
    include $tpl . 'footer.php';
} else {
    //echo "Vous n'êtes pas autorisé à afficher cette page";
    header('location: index.php');
    exit();
}
ob_end_flush();

<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 11-Jun-17
 * Time: 04:50
 */

ob_start();
session_start();

include 'initMain.php'; //Initier routes | DB connection | Header | CSS links

if (isset($_SESSION['userClt'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pid = intval(trim($_POST['pid']));
        $qte = ((isset($_POST['qte'])) ? intval(trim($_POST['qte'])) : 1);
        $id=$_SESSION['clientID'];


        $rqt = "INSERT INTO panier(prodId, PanierQte,clientID)VALUES (:pid,:qte,:id);";
        $count = update($rqt, array(
            ':pid' => $pid,
            ':qte' => $qte,
            ':id' => $id,

        ));

        if ($count > 0) {
            ?>
            <div class="form-group">
                <div class="alert alert-success" role="alert">
                    Succès <i class="glyphicon glyphicon-thumbs-up"></i>
                    Produit a été ajouté au panier.
                </div>
            </div>
            <?php
            header('Refresh: 1; URL=' . $_SERVER['HTTP_REFERER']);
        }

    } else {
        include $tpl . 'errorPage.php';
    }
}else{
    header('location: login.php');

}

include $tpl . "footer.php";
include $tpl . "copyRights.php";
include $tpl . "popUpModal.php";
ob_end_flush();
?>
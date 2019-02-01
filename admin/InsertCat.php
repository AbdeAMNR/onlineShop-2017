<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 01-Jun-17
 * Time: 05:01
 */
ob_start();
session_start();

if (isset($_SESSION['Username'])) {
    $noNavBar = "";
    include 'init.php'; //Initier routes | DB connection | Header | CSS links


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $familleID = intval(trim($_POST['f-cat']));
        $catName = trim($_POST['cat']);

        $errArray = array();
        if (isNullOrEmptyStr($catName)) {
            $errArray[] = 'aucun nom de catégorie est fourni';
        }
        if (idExist("SELECT * FROM categorie WHERE catName ='" . $catName . "' AND familleID = $familleID;")) {
            $errArray[] = 'Catégorie existe déjà';
        }

        if (empty($errArray)) {
            $rqt = "INSERT INTO categorie (familleID, catName) VALUES (:familleID,:catName);";
            $stmt = $con->prepare($rqt);
            $stmt->execute(array(
                ':familleID' => $familleID,
                ':catName' => $catName,
            ));

            if ($stmt->rowCount() > 0) {
                ?>
                <div class="form-group">
                    <div class="alert alert-success" role="alert">
                        Succès <i class="glyphicon glyphicon-thumbs-up"></i>
                        Nouvelle catégorie ajoutée.
                    </div>

                </div>
                <?php
            }
        } else {
            ?>
            <div class="form-group">
                <?php
                foreach ($errArray as $err) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Echec <i class="glyphicon glyphicon-thumbs-down"></i> <?= $err; ?>
                    </div>

                    <?php
                }
                ?>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#contact_dialog">Contact
                </button>

            </div>
            <?php
        }
    } else {
        include $tpl . 'errorPage.php';
    }

    include $tpl . 'footer.php';

} else {
    echo "Vous n'êtes pas autorisé à afficher cette page";
    header('location: index.php');
    exit();

}
ob_end_flush();
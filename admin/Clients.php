<?php

/*
===================================================================
== Date: 09-Jun-17
== Time: 05:29
===================================================================
== Gérer la page du clients
== Vous pouvez supprimer
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'onlineShop Clients';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links
    //=============================================================
    $do = (isset($_GET['do']) ? filter_var($_GET['do'], FILTER_SANITIZE_STRING) : 'manage');


    if ($do == 'manage') {
        $key='';
        $rqt = "SELECT * FROM client;";
        if (isset($_GET['search'])) {
            $key = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
            $rqt = "SELECT * FROM client WHERE email LIKE '%" . $key . "%' OR nom_Prenom LIKE '%" . $key . "%';";
        }
        $rows = select($rqt);
        ?>
        <h1 class="text-center page-header pageTitle">Gérer les clients</h1>
        <div class="container  ">
            <div class="seachBar">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="Clients.php" method="get">
                            <div class="input-group stylish-input-group">
                                <input type="text" name="search" class="form-control" placeholder="Recherche">
                                <span class="input-group-addon">
                                    <button type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php
            if (empty($rows)) {
                noResult("Aucun résultat n'a été trouvé pour " . $key);
            } else {
                ?>
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>E-Mail</td>
                            <td>Nom et prénom</td>
                            <td>Téléphone</td>
                            <td>Adresse</td>
                            <td>Date d'inscription</td>
                            <td>Dernière visite</td>
                            <td>contrôles</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td><?= $row['clientID']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['nom_Prenom']; ?></td>
                            <td><?= $row['tele']; ?></td>
                            <td><?= $row['adresse']; ?></td>
                            <td><?= $row['dateInsc']; ?></td>
                            <td><?= $row['derniereVisite']; ?></td>
                            <td>
                                <a href="Clients.php?do=delete&cID=<?= $row['clientID']; ?>"
                                   class="btn btn-danger confirm"><i class="fa fa-remove"></i> Supprimer</a>
                            </td>
                            <?php
                            }
                            ?>
                    </table>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } elseif ($do == 'delete') {
        $errArray = array();
        $cID = (isset($_GET['cID']) && is_numeric($_GET['cID']) ? intval($_GET['cID']) : 0);
        if (!idExist("SELECT * FROM Client WHERE clientID =" . $cID . ";")) {
            $errArray[] = 'Aucun client avec ce numéro';
        }

        if (empty($errArray)) {
            $rqt = "DELETE FROM Client WHERE clientID = ?";
            $stmt = $con->prepare($rqt);
            $stmt->execute(array($cID));

            if ($stmt->rowCount() > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            ?>
            <div class="container">
                <p></p>
                <fieldset>
                    <legend>Supprimer le Clients</legend>
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
                        <a href="Clients.php" class="btn btn-primary">
                            <span class="fa fa-refresh"></span>
                            Essayez à nouveau
                        </a>
                    </div>

                </fieldset>
            </div>
            <?php
        }
    }
//=============================================================

    include $tpl . 'footer.php';


} else {
    //echo "Vous n'êtes pas autorisé à afficher cette page";
    header('location: index.php');
    exit();
}
ob_end_flush();

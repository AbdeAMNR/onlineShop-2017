<?php

/*
===================================================================
== Date: 09-Jun-17
== Time: 09:08
===================================================================
== Gérer la page du fournisseur
== Vous pouvez ajouter | modifier | supprimer
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'onlineShop Commandes';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links
    //=============================================================
    $do = (isset($_GET['do']) ? filter_var($_GET['do'], FILTER_SANITIZE_STRING) : 'manage');


    if ($do == 'manage') {
        $rqt = "SELECT * FROM commandes c
                    JOIN client clt ON c.clientID = clt.clientID
                    JOIN produits p ON p.prodId = c.prodId
                    JOIN paiement pa ON pa.paieID = c.paieID
                    JOIN expediteurs ex ON ex.exID = c.exID;";
        if (isset($_GET['search']) && isset($_GET['state'])) {
            $key = $_GET['search'];
            $stat = $_GET['state'];

            switch ($stat) {
                case 'ALL':
                    $stat = ';';
                    break;
                case 'EnAttenteDePaiement':
                    $stat = "AND c.statutCommande='En attente de Paiement';";
                    break;
                case 'PaiementAccepte':
                    $stat = "AND c.statutCommande='Paiement accepté';";

                    break;
                case 'PreparationEnCours':
                    $stat = "AND c.statutCommande='Préparation en cours';";

                    break;
                case 'Expedie':
                    $stat = "AND c.statutCommande='Expédié';";

                    break;
                case 'Livre':
                    $stat = "AND c.statutCommande='Livré';";

                    break;
                case 'Annuler':
                    $stat = "AND c.statutCommande='Annuler';";
                    break;
            }

            $rqt = "SELECT * FROM commandes c JOIN client clt ON c.clientID = clt.clientID 
                          JOIN produits p ON p.prodId = c.prodId 
                          JOIN paiement pa ON pa.paieID = c.paieID 
                          JOIN expediteurs ex ON ex.exID = c.exID 
                          WHERE clt.nom_Prenom LIKE '%$key%' " . $stat;
        }
        $rows = select($rqt);
        ?>
        <h1 class="text-center page-header pageTitle">Gérer les commandes</h1>
        <div class="container  ">
            <div class="seachBar">
                <div class=" col-md-9 col-md-push-3">
                    <div class="row">
                        <form action="Commands.php" class="form-inline" method="get">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Recherche">
                            </div>

                            <div class="form-group ">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bell"></i></span>
                                    <select name="state" class="selectpicker form-control">
                                        <option value="ALL">Tout</option>
                                        <option value="EnAttenteDePaiement">En attente de Paiement</option>
                                        <option value="PaiementAccepte">Paiement accepté</option>
                                        <option value="PreparationEnCours">Préparation en cours</option>
                                        <option value="Expedie">Expédié</option>
                                        <option value="Livre">Livré</option>
                                        <option value="Annuler">Annuler</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="form-control" type="submit"><span
                                            class="glyphicon glyphicon-search"></span>
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
        <?php
        if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $cmdID = intval($_GET['edit']);
            $cmd = select("SELECT c.cmdId AS ref,clt.nom_Prenom AS nom,p.prodLabel AS p,c.statutCommande AS s
                                  FROM commandes c
                                      JOIN client clt ON c.clientID = clt.clientID
                                      JOIN produits p ON p.prodId = c.prodId
                                      JOIN paiement pa ON pa.paieID = c.paieID
                                      JOIN expediteurs ex ON ex.exID = c.exID
                                    WHERE c.cmdId = $cmdID")
            ?>
            <form class="form-inline" action="Commands.php?do=update" method="POST">
                <div class="col-md-9 col-md-offset-1">
                    <fieldset>
                        <legend>Modifier la commande</legend>
                        <input type="hidden" name="cmdID" value="<?= $cmdID; ?>">
                        <div class="row">
                            <table class="table table-bordered table-responsive">
                                <tr>
                                    <th>#référence</th>
                                    <th>Nom du client</th>
                                    <th>produit</th>
                                    <th>Etat</th>
                                </tr>
                                <tr class="info">
                                    <?php
                                    foreach ($cmd as $r) {
                                        ?>
                                        <td><?= $r['ref']; ?></td>
                                        <td><?= $r['nom']; ?></td>
                                        <td><?= $r['p']; ?></td>
                                        <td style="font-weight: 700"><?= $r['s']; ?></td>
                                        <?php
                                    }
                                    ?>

                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            <div class="row-touch">
                                <div class="col-md-12  col-md-offset-1">
                                    <div class="form-group ">
                                        <label class=" control-label">Etat de commande: </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-bell"></i></span>
                                            <select name="state" class="selectpicker form-control">
                                                <option value="En attente de Paiement">En attente de Paiement
                                                </option>
                                                <option value="Paiement accepté">Paiement accepté</option>
                                                <option value="Préparation en cours">Préparation en cours</option>
                                                <option value="Expédié">Expédié</option>
                                                <option value="Livré">Livré</option>
                                                <option value="Annuler">Annuler</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class=" control-label"></label>
                                        <button type="submit" name="modify" class="btn btn-primary">
                                            <span class="fa fa-save"></span>
                                            Appliquer
                                        </button>
                                        <a href="Commands.php" name="cancel" class="btn btn-warning">
                                            <span class="fa fa-ban"></span>
                                            Annuler
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
            </div>

            <?php
        }
        if (empty($rows)) {
            noResult("Aucun résultat n'a été trouvé pour " . $_GET['search']);
        } else {
            ?>
            <div CLASS="container">


                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#Réf</td>
                            <td>Client</td>
                            <td>Produit</td>
                            <td>Quantité</td>
                            <td>Prix total</td>
                            <td>Date</td>
                            <td>Livraison</td>
                            <td>Transporteur</td>
                            <td>État</td>
                            <td>N° de suivi</td>
                            <td>contrôles</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                        $s = $row['statutCommande'];
                        $style = ($s == 'Livré' ? 'style="background-color: #C8E6C9;"' : '');

                        ?>
                        <tr class="tbl-md ">
                            <td <?= $style; ?>><?= $row['cmdId']; ?></td>
                            <td <?= $style; ?>><?= $row['nom_Prenom']; ?></td>
                            <td <?= $style; ?>><?= $row['prodLabel']; ?></td>
                            <td <?= $style; ?>><?= $row['quantite']; ?></td>
                            <td <?= $style; ?>><?= $row['prixTotal']; ?></td>
                            <td <?= $style; ?>><?= $row['dateCommande']; ?></td>
                            <td <?= $style; ?>><?= $row['dateLivraisonPrevue']; ?></td>
                            <td <?= $style; ?>><?= $row['nomEntreprise']; ?></td>
                            <td <?= $style; ?>><span <?php

                                if ($s == "En attente de Paiement") {
                                    echo 'class="btn-xs PINK"';
                                } elseif ($s == "Paiement accepté") {
                                    echo 'class="btn-xs BLUE"';
                                } elseif ($s == "Préparation en cours") {
                                    echo 'class="btn-xs GRAY"';
                                } elseif ($s == "Expédié") {
                                    echo 'class="btn-xs ORANGE"';
                                } elseif ($s == "Livré") {
                                    echo 'class="btn-xs BROWN"';
                                } elseif ($s == "Annuler") {
                                    echo 'class="btn-xs RED"';
                                } else {
                                    echo "";
                                }
                                ?>><?= $row['statutCommande']; ?></span>
                            </td>
                            <td <?= $style; ?>><?= $row['numeroDeSeuivi']; ?></td>
                            <td <?= $style; ?>>
                                <a href="Commands.php?edit=<?= $row['cmdId']; ?>" class="btn btn-success">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="Commands.php?do=delete&cmdID=<?= $row['cmdId']; ?>"
                                   class="btn btn-danger confirm">
                                    <i class="fa fa-remove"></i>
                                </a>

                            </td>
                            <?php
                            }
                            ?>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <?php
    } elseif ($do == 'update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $ref = (isset($_POST['cmdID']) && is_numeric($_POST['cmdID']) ? intval($_POST['cmdID']) : 0);
            $status = trim($_POST['state']);
            $errArray = array();
            if (isNullOrEmptyStr($status)) {
                $errArray[] = 'Non reconnu la nature de l\'état de l\'ordre';
            }

            if (empty($errArray)) {
                $rqt = "UPDATE commandes SET statutCommande=? WHERE cmdId=?";
                update($rqt, array($status, $ref));
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                error($errArray, "Commands.php", "Mise à jour");
                header('Refresh: 6; URL=' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            include $tpl . 'errorPage.php';
        }
    } elseif ($do == 'delete') {
        $errArray = array();
        $cmdID = (isset($_GET['cmdID']) && is_numeric($_GET['cmdID']) ? intval($_GET['cmdID']) : 0);
        if (!idExist("SELECT * FROM commandes WHERE cmdId=$cmdID;")) {
            $errArray[] = 'Aucun commandes avec ce numéro';
        }

        if (empty($errArray)) {
            $rqt = "DELETE FROM commandes WHERE cmdId = ?";
            $count = update($rqt, array($cmdID));

            if ($count > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            error($errArray, "Commands.php", ">Supprimer la commandes");
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

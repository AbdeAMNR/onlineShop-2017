<?php
ob_start();
session_start();
$pageTitle = 'onlineShop: Online Shopping for Electronics, Computers, Books & more';
include 'initMain.php'; /* **** Initier routes | DB connection | Header | CSS links**** */
$bannerTitle = 'Panier ';
include $tpl . "banner.php";
/* ------------------------------------------ */
$do = (isset($_GET['do']) ? filter_var($_GET['do'], FILTER_SANITIZE_STRING) : 'manage');

if (isset($_SESSION['userClt'])) {
    if ($do == 'manage') {
        $rqt = "SELECT * FROM panier pa
                  JOIN produits pro ON pa.prodId = pro.prodId
                  JOIN prodimages img ON pro.prodId = img.prodId
                  JOIN client clt ON pa.clientID=clt.clientID
            WHERE pa.validercmd = 0 AND clt.clientID=" . $_SESSION['clientID'];
        $cart = select($rqt);
        ?>
        <div CLASS="container">
            <div class="row">
                <div class="head-title">
                    <h1>Récapitulatif de la commande</h1>
                    <hr>
                </div>
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <th>#Réf</th>
                            <th>image</th>
                            <th>Produit</th>
                            <th>Description</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>contrôles</th>
                        </tr>
                        <?php
                        foreach ($cart as $row) {
                            ?>
                            <tr>
                                <td><?= $row['panierId']; ?></td>
                                <td><img class="panier-img" src="<?= $imgs . $row['image1']; ?>"></td>
                                <td><?= $row['prodLabel']; ?></td>
                                <td><?= $row['description']; ?></td>

                                <td>
                                    <div class="input-xs">
                                        <input type="number" value="<?= $row['PanierQte']; ?>" min="1"
                                               max="<?= $row['prodQté']; ?>">
                                    </div>
                                </td>

                                <td><?= $row['prodPrix']; ?></td>
                                <td>
                                    <a href="checkout.php?do=delete&panier=<?= $row['panierId']; ?>"
                                       class="btn btn-danger">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </td>


                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <form class="well-sm form-horizontal form-group-sm" action="?do=validecmd" method="post">
                    <div class="row">
                        <div class=" panier-style col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class=" control-label">Numéro de Carte</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                            <input class="form-control" type="text" name="numcard"
                                                   placeholder="Numéro de Carte de Crédit">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class=" control-label">Méthode de paiement</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-cc-visa"></i></span>
                                            <select name="methode" class="selectpicker form-control">
                                                <?php
                                                $payMethode = select("SELECT * FROM paiement;");
                                                foreach ($payMethode as $methode) {
                                                    ?>
                                                    <option value="<?= $methode['paieID']; ?>"><?= $methode['paieType']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class=" control-label">Compagnie de livraison</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                                            <select name="livraison" class="selectpicker form-control">
                                                <?php
                                                $Delivery = select("SELECT * FROM expediteurs;");
                                                foreach ($Delivery as $row) {
                                                    ?>
                                                    <option value="<?= $row['exID']; ?>"><?= $row['nomEntreprise']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputAmount" class=" control-label">TOTAL: </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-bell"></i></div>
                                            <?php
                                            $rqtTotal = "SELECT sum(pro.prodPrix*pa.PanierQte) FROM panier pa 
                                                  JOIN produits pro ON pa.prodId = pro.prodId 
                                                  JOIN prodimages img ON pro.prodId = img.prodId 
                                                  JOIN client clt ON pa.clientID=clt.clientID 
                                                  WHERE pa.validercmd = 0 AND clt.clientID=2;";
                                            $total = selectCol("$rqtTotal");
                                            ?>
                                            <input type="text" name="total" class="form-control" id="exampleInputAmount"

                                                   value="<?= $total; ?>">
                                            <div class="input-group-addon">MAD</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <button type="submit" name="modify" class="btn btn-primary">
                                                <span class="fa fa-check-circle"></span>
                                                Valider la commande
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <?php
    } elseif ($do == 'delete') {
        $errArray = array();
        $panier = (isset($_GET['panier']) && is_numeric($_GET['panier']) ? intval($_GET['panier']) : 0);
        if (!idExist("SELECT * FROM panier WHERE panierId=" . $panier . ";")) {
            $errArray[] = 'Opération inconnue détectée';
        }

        if (empty($errArray)) {
            $rqt = "DELETE FROM panier WHERE panierId = ?";
            $count = update($rqt, array($panier));
            if ($count > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            ?>
            <div class="container">
                <p></p>
                <form class="well-lg form-horizontal form-group-lg">
                    <fieldset>
                        <legend><h1>Panier</h1></legend>
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
                            <a href="checkout.php" class="btn btn-primary">
                                <span class="fa fa-refresh"></span>
                                Essayez à nouveau
                            </a>
                        </div>

                    </fieldset>
                </form>
            </div>
            <?php
        }
    } elseif ($do == 'validecmd') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numCard = trim($_POST['numcard']);
            $methode = trim($_POST['methode']);
            $livraison = trim($_POST['livraison']);
            $total = $_POST['total'];
            $id=$_SESSION['clientID'];

            $errArray = array();
            if (isNullOrEmptyStr($numCard)) {
                $errArray[] = 'Numéro de Carte est nécessaire';
            }

            if (empty($errArray)) {
                $rqt = "INSERT INTO commandes(clientID, prodId,quantite, prixTotal, paieID, exID) VALUES (?,?,?,?,?,?);";
                $stmt = $con->prepare($rqt);
                $stmt->execute(array($id,1,25,$total,$methode,$livraison));

                if ($stmt->rowCount() > 0) {
                    SuccessInsertion();

                    header('Refresh: 3; URL=' . $_SERVER['HTTP_REFERER']);
                } else {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            } else {
                ?>
                <div class="container">
                    <p></p>
                    <fieldset>
                        <legend>Commande</legend>
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
                            <a href="checkout.php" class="btn btn-primary">
                                <span class="fa fa-refresh"></span>
                                Essayez à nouveau
                            </a>
                        </div>

                    </fieldset>
                </div>
                <?php
            }
        } else {
            include $tpl . 'errorPage.php';
        }
    }
} else {
    ?>
    <div class="container">
        <p></p>
        <form class="well-lg form-horizontal form-group-lg">
            <fieldset>
                <legend><h1>Panier</h1></legend>
                <div class="form-group">
                    <div class="alert alert-warning" role="alert">
                        Echec <i class="glyphicon glyphicon-thumbs-down"></i> Connectez-vous pour accéder à votre panier
                    </div>
                    <a href="login.php" class="btn btn-primary">
                        <span class="fa fa-refresh"></span>
                        Connectez-vous
                    </a>
                </div>
            </fieldset>
        </form>
    </div>
    <?php
}
include $tpl . "footer.php";
include $tpl . "copyRights.php";
include $tpl . "popUpModal.php";
ob_end_flush();
?>
</body>
</html>
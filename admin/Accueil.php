<?php
ob_start();
session_start();
$pageTitle = 'onlineShop Tableau de bord';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links

    $fourni = selectCol("SELECT count(*) AS ftotal FROM fournisseur WHERE statutInsc=0 ;");
    $tFourni = selectCol("SELECT count(*) FROM fournisseur WHERE statutInsc!=0;");
    $tProd = selectCol("SELECT count(*) FROM produits ;");
    $tOrders = selectCol("SELECT count(*) FROM commandes WHERE statutCommande <> 'Livré';");
    $profit = selectCol("SELECT sum(prixTotal) AS profit  FROM commandes WHERE statutCommande = 'Livré' AND DATEDIFF(curdate(),date(dateCommande)) BETWEEN 0 AND 30;");
    $profit = (empty($profit)) ? 0 : $profit;
    ?>
    <div class="home-stats">
        <div class="container  text-center">
            <h1 class="text-center page-header pageTitle">Tableau de bord</h1>
            <div class="dashboard-box row">

                <div class="col-xs-6 col-sm-3">
                    <div class="stat st-pending">
                        <i class="fa fa-tags"></i>
                        <div class="info">
                            <span><a href="produits.php"><?= $tProd; ?></a></span>
                        </div>
                    </div>
                    <div class="info-tag">Total des produits</div>
                </div>

                <div class="col-xs-6 col-sm-3">
                    <div class="stat st-comments">
                        <i class="fa fa-money"></i>
                        <div class="info">
                            <span><a href="#"><?= $profit; ?></a></span>
                        </div>
                    </div>
                    <div class="info-tag">Bénéfice de mois (MAD)</div>
                </div>

                <div class="col-xs-6 col-sm-3">
                    <div class="stat st-items">
                        <i class="fa fa-shopping-cart"></i>
                        <div class="info">
                            <span><a href="Commands.php"><?= $tOrders; ?></a></span>
                        </div>
                    </div>
                    <div class="info-tag">Commandes en attente</div>
                </div>

                <div class="col-xs-6 col-sm-3">
                    <div class="stat st-members">
                        <i class="fa fa-users "></i>
                        <div class="info">
                            <span><a href="Fournisseur.php"><?= $tFourni; ?></a></span>
                        </div>
                    </div>
                    <div class="info-tag">Total des fournisseurs</div>
                </div>

            </div>
        </div>
    </div>
    <div class="latest">
        <div class="container ">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-user"></i> Les derniers fournisseurs enregistrés
                            <span class="pull-right "><i class="fa fa-chevron-down"></i> Total <span
                                        class="badge bold"><?= $fourni; ?></span></span>
                        </div>
                        <div class="panel-body">
                            <?php
                            $rqt = "SELECT * FROM fournisseur WHERE statutInsc=0 LIMIT 10;";
                            $rows = select($rqt);
                            ?>
                            <ul class="list-unstyled latest-fourni">
                                <?php
                                foreach ($rows as $row) {
                                    ?>
                                    <li>

                                        <span class="bold"> <?= $row['nomComplet']; ?></span>
                                        <span class="small"><?= $row['email']; ?></span>
                                        <a href="Fournisseur.php?do=edit&fID=<?= $row['fourniID']; ?>"> <span
                                                    class="btn btn-success pull-right"><i class="fa fa-edit"></i> Modifier</span>
                                        </a>
                                        <a href="Fournisseur.php?do=approve&fID=<?= $row['fourniID']; ?>"<span
                                                class="btn btn-info pull-right"><i class="fa fa-thumbs-up"></i> Approuver</span> </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                $rqt = "SELECT m.marqueId,m.marqueName AS brand, sum(c.prixTotal) AS total FROM commandes c 
                          JOIN produits p ON c.prodId = p.prodId 
                          JOIN marque m ON p.marqueId = m.marqueId 
                          GROUP BY m.marqueId,m.marqueName;";
                $rs = select($rqt);
                ?>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Marques la plus vendue ce mois
                        </div>
                        <table class="table table-condensed  ">
                            <thead>
                            <tr style="font-weight: bold">
                                <td>Marques</td>
                                <td>Bénéfice</td>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($rs as $row) {
                                ?>
                                <tr>

                                    <td>
                                        <div class="col-xs-6 col-md-1">
                                            <i class="fa fa-square blue"></i>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-8">
                                            <?= $row['brand']; ?>
                                        </div>


                                    </td>


                                    <td><?= $row['total']; ?></td>

                                </tr>
                                <?php
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include $tpl . 'footer.php';

} else {
    echo "Vous n'êtes pas autorisé à afficher cette page";
    header('location: index.php');
    exit();

}
ob_end_flush();
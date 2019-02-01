<?php
/*
===================================================================
== Date: 01-juin-17
== Time: 04:46
===================================================================
== Gérer Les catégories
== Vous pouvez ajouter | modifier | supprimer
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'onlineShop Catégories';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links
    //=============================================================
    $do = (isset($_GET['do']) ? $_GET['do'] : 'manage');
    if ($do == 'manage') {

        ?>

        <h1 class="text-center page-header pageTitle">Gérer les catégories</h1>
        <div class="container">
            <div class="row">
                <!--pop Up modal-->
                <div class="col-md-3 pull-right">
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#contact_dialog">
                        <i class="fa fa-plus-square"></i> Nouvelle catégorie
                    </button>
                </div>
            </div>
        </div>
        <p></p>
        <div class="container">
            <!-- the div that represents the modal dialog -->
            <div class="modal fade" id="contact_dialog" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Ajouter une nouvelle catégorie</h4>

                        </div>
                        <div class="modal-body">
                            <form id="contact_form" class="well-lg form-horizontal form-group-lg" action="InsertCat.php"
                                  method="post" style="margin-bottom: 0;">
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Famille</label>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                                            <select name="f-cat" class="selectpicker form-control">
                                                <?php
                                                $rqt = "SELECT * FROM Famille;";
                                                $rows = select($rqt);
                                                foreach ($rows as $row) {
                                                    echo "<option value='" . $row['familleID'] . "'>" . $row['familleName'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Catégorie</label>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-list"></i></span>
                                            <input name="cat" placeholder="Catégorie" class="form-control"
                                                   type="text">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" id="submitForm" class="btn btn-primary">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- finish pop Up modal-->
            <?php
            $sort = 'asc';
            $sortOptions = array('asc', 'desc');
            if (isset($_GET['sort']) && in_array($_GET['sort'], $sortOptions)) {
                $sort = $_GET['sort'];
            }
            $rqt = "SELECT * FROM famille ORDER BY familleName $sort;";
            $fRows = select($rqt);
            ?>
            <div class="panel panel-default categories">
                <div class="panel-heading"><i class="fa fa-tag"></i> Catégories
                    <div CLASS="pull-right  ">
                        <div class="option">
                            <span class="strog"><i class="fa fa-sort"></i> Trier: </span>
                            [<a class="opt <?= ($sort == 'asc') ? 'choisi' : ''; ?>" href="?sort=asc">ASC</a>
                            <span>|</span>
                            <a class="<?= ($sort == 'desc') ? 'choisi' : ''; ?>" href="?sort=desc">DESC</a>]
                            <span class="strog"><i class="fa fa-eye"></i> Vue: </span>
                            [<span class="opt " data-view="simple">Simple</span>
                            <span>|</span>
                            <span class="opt choisi" data-view="complet">Complet</span>]
                        </div>

                    </div>
                </div>
                <div class="panel-body">
                    <?php foreach ($fRows as $frow) { ?>
                        <div class="list-group cat col-md-6">
                            <h4 class="famille-name"> <?= $frow['familleName']; ?> </h4>
                            <div class="sub-cat">
                                <?php
                                $rqt = "SELECT * FROM categorie WHERE familleID={$frow['familleID']} ORDER BY catName $sort;";
                                $cRows = select($rqt);
                                foreach ($cRows as $crow) {
                                    ?>

                                    <div class="list-group-item">
                                        <div class="form-group">
                                            <label> <?= $crow['catName']; ?></label>
                                            <?php
                                            //  $cID = (isset($_GET['cID']) && is_numeric($_GET['cID']) ? intval($_GET['cID']) : 0);

                                            if (isset($_GET['faire']) && $_GET['faire'] == 'edit' && is_numeric($_GET['cID']) && $_GET['cID'] == $crow['CatID']) {
                                                ?>
                                                <form class="well-lg form-horizontal"
                                                      action="Categories.php?do=update&cID=<?= $crow['CatID']; ?>"
                                                      method="post">
                                                    <div class="col-md-8 cat-update">
                                                        <div class="input-group ">
                                                        <span class="input-xs input-group-addon"><i
                                                                    class="glyphicon glyphicon-list"></i></span>
                                                            <input name="catName" placeholder="Catégorie"
                                                                   class="input-xs form-control" type="text" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 cat-update">
                                                        <div class="input-group">
                                                            <button type="submit" name="update"
                                                                    class="btn btn-primary btn-xs">
                                                                <span class="fa fa-edit"></span> Modifier
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <span class="pull-right hidden-btn">
                                            <a href="Categories.php?faire=edit&cID=<?= $crow['CatID']; ?>"
                                               class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Modifier
                                            </a>
                                        <a href="Categories.php?do=delete&cID=<?= $crow['CatID']; ?>"
                                           class="btn btn-danger btn-xs confirm"><i class="fa fa-remove"></i> Supprimer
                                        </a>
                                    </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    } elseif ($do == 'update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $cID = (isset($_GET['cID']) && is_numeric($_GET['cID']) ? intval($_GET['cID']) : 0);
            $catName = $_POST['catName'];

            if (!isNullOrEmptyStr($catName)) {
                $rqt = "UPDATE categorie SET catName=? WHERE CatID= ?";

                $stmt = $con->prepare($rqt);
                $stmt->execute(array($catName, $cID));

                header('Location: Categories.php');

            } else {
                header('Location: Categories.php');
            }


        } else {
            include $tpl . 'errorPage.php';

        }
    } elseif ($do == 'delete') {
        $errArray = array();
        $cID = (isset($_GET['cID']) && is_numeric($_GET['cID']) ? intval($_GET['cID']) : 0);
        if (!idExist("SELECT * FROM categorie WHERE CatID =" . $cID . ";")) {
            $errArray[] = 'Aucun categorie avec ce numéro';
        }

        if (empty($errArray)) {
            $rqt = "DELETE FROM categorie WHERE CatID = ?";
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
                    <legend>Supprimer la catégorie</legend>
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
                        <a href="Categories.php" class="btn btn-primary">
                            <span class="fa fa-refresh"></span>
                            Essayez à nouveau
                        </a>
                    </div>

                </fieldset>
            </div>
            <?php
        }
    }
    include $tpl . 'footer.php';
} else {
    //echo "Vous n'êtes pas autorisé à afficher cette page";
    header('location: index.php');
    exit();
}
ob_end_flush();
?>
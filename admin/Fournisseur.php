<?php
/*
===================================================================
== Date: 21-May-17
== Time: 01:58
===================================================================
== Gérer la page du fournisseur
== Vous pouvez ajouter | modifier | supprimer
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'onlineShop Fournisseur';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links
    //=============================================================
    $do = (isset($_GET['do']) ? filter_var($_GET['do'], FILTER_SANITIZE_STRING) : 'manage');


    if ($do == 'manage') {
        $rqt = "SELECT * FROM Fournisseur WHERE fourniID !=  " . $_SESSION['fourniID'] . " ;";
        if (isset($_GET['search'])) {
            $rqt = "SELECT * FROM Fournisseur WHERE fourniID !=  " . $_SESSION['fourniID'] . " AND  nomComplet LIKE '%" . $_GET['search'] . "%';";
        }
        $rows = select($rqt);
        ?>
        <h1 class="text-center page-header pageTitle">Gérer les fournisseur</h1>
        <div class="container  ">
            <div class="seachBar">
                <div class="row">
                    <div class="col-xs-12 col-md-8 pull-right">
                        <form action="Fournisseur.php" method="get">
                            <div class="input-group stylish-input-group">
                                <input type="text" name="search" class="form-control" placeholder="Recherche">
                                <span class="input-group-addon">
                                    <button type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-6 col-md-4 pull-right">
                        <a href="Fournisseur.php?do=add" class="btn btn-primary search-btn pull-right">
                            <i class="fa fa-plus"></i>
                            Nouveau fournisseur</a>
                    </div>


                </div>
            </div>
        </div>


        <div class="container">
            <?php
            if (empty($rows)) {
                noResult("Aucun résultat n'a été trouvé pour " . $_GET['search']);
            } else {
                ?>
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Nom complet</td>
                            <td>E-Mail</td>
                            <td>Téléphone</td>
                            <td>Accès au panneau</td>
                            <td>Autorisations</td>
                            <td>Dernière visite</td>
                            <td>contrôles</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td><?= $row['fourniID']; ?></td>
                            <td><?= ($row['StatutConfiance'] == 1 ? '<i class="fa fa-star"></i> ' : '') ?><?= $row['nomComplet']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['phone']; ?></td>
                            <td><?= ($row['panelAccess'] == 1 ? 'Accordé' : 'Non accordé'); ?></td>
                            <td><?= $row['permission']; ?></td>
                            <td><?= $row['derniereVisite']; ?></td>
                            <td>
                                <a href="Fournisseur.php?do=edit&fID=<?= $row['fourniID']; ?>"
                                   class="btn btn-success"><i class="fa fa-edit"></i> Modifier</a>
                                <a href="Fournisseur.php?do=delete&fID=<?= $row['fourniID']; ?>"
                                   class="btn btn-danger confirm"><i class="fa fa-remove"></i> Supprimer</a>
                                <?= ($row['statutInsc'] == 0 ? "<a href='Fournisseur.php?do=approve&fID=" . $row['fourniID'] . "' class='btn btn-cool'><i class='fa fa-check'></i> Approuver</a>" : ""); ?>
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
    } elseif ($do == 'add') {
        ?>
        <div class="container">
            <form class="well-lg form-horizontal form-group-lg" action="?do=insert" method="post">
                <fieldset>
                    <legend>Ajouter un nouveau fournisseur</legend>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Nom complet</label>
                        <div class="col-md-4  ">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="nomComplet" placeholder="nom complet" class="form-control" type="text"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-4 control-label">Téléphone #</label>
                        <div class="col-md-4  ">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <input name="phone" placeholder="+212 xxx xxx xxx" class="form-control" type="text"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-4 control-label">E-Mail</label>
                        <div class="col-md-4  ">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input name="email" placeholder="Adresse e-mail" class="form-control" type="email"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-4 control-label">Autorisations</label>
                        <div class="col-md-4  ">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bell"></i></span>
                                <select name="permOpt" class="selectpicker form-control">
                                    <option>Controle total</option>
                                    <option>Modérateur</option>
                                    <option>Simple utilisateur</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-4 control-label">Mot de passe</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input name="newPass" placeholder="Mot de passe" class="form-control"
                                       type="password" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label class="col-md-4 control-label"></label>
                        <div class="col-md-4">
                            <button type="submit" name="modify" class="btn btn-primary">
                                <span class="glyphicon glyphicon-floppy-saved"></span>
                                Ajouter
                            </button>
                            <a href="Fournisseur.php" name="cancel" class="btn btn-warning">
                                <span class="fa fa-ban"></span>
                                Annuler
                            </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
    } elseif ($do == 'edit') {

        $fID = (isset($_GET['fID']) && is_numeric($_GET['fID']) ? intval($_GET['fID']) : 0);
        $stmt = $con->prepare("SELECT * FROM fournisseur WHERE fourniID=? LIMIT 1");
        $stmt->execute(array($fID));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();
        if ($count > 0) { ?>
            <div class="container">
                <form class="well-lg form-horizontal form-group-lg" action="?do=update" method="post">
                    <input type="hidden" name="fID" value="<?= $fID; ?>">
                    <fieldset>
                        <legend>Modifier les informations de profil</legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nom complet</label>
                            <div class="col-md-4  ">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input name="nomComplet" placeholder="nom complet" class="form-control" type="text"
                                           autocomplete="off" value="<?= $row['nomComplet']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Téléphone #</label>
                            <div class="col-md-4  ">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <input name="phone" placeholder="+212 xxx xxx xxx" class="form-control" type="text"
                                           autocomplete="off" value="<?= $row['phone']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-4  ">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input name="email" placeholder="Adresse e-mail" class="form-control" type="email"
                                           autocomplete="off" value="<?= $row['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Mot de passe</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input name="newPass" placeholder="Nouveau mot de passe?" class="form-control"
                                           type="password" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group  checkbox">
                            <label class="col-md-4 control-label"> </label>
                            <label style="font-size: 1.3em">
                                <input class="col-md-4  " type="checkbox"
                                       name="access" <?= ($row['panelAccess'] == 1 ? 'checked' : ''); ?>/>
                                <span class="cr col-md-4 "><i class="cr-icon fa fa-check"></i></span>
                                Accorder l'accès au panneau
                            </label>
                        </div>
                        <div class="form-group ">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-4">
                                <button type="submit" name="modify" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-saved"></span> Appliquer
                                </button>
                                <a href="Fournisseur.php" name="cancel" class="btn btn-warning">
                                    <span class="fa fa-ban"></span> Annuler
                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
        } else {
            include $tpl . 'errorPage.php';
        }
    } elseif ($do == 'update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fourniID = $_POST['fID'];
            $fourniName = trim($_POST['nomComplet']);
            $fourniPhone = trim($_POST['phone']);
            $fourniEmail = trim($_POST['email']);
            $fourniPass = trim($_POST['newPass']);
            (isset($_POST['access']) ? $fourniAccess = 1 : $fourniAccess = 0);

            $errArray = array();
            if (isNullOrEmptyStr($fourniName)) {
                $errArray[] = 'Le nom complet est nécessaire';
            }
            if (isNullOrEmptyStr($fourniPhone)) {
                $errArray[] = 'Le numéro de téléphone est nécessaire';
            }
            if (isNullOrEmptyStr($fourniEmail)) {
                $errArray[] = 'L\'adresse e-mail est nécessaire';
            }

            if (idExist("SELECT * FROM fournisseur WHERE nomComplet ='" . $fourniName . "' AND fourniID != " . $fourniID . ";")) {
                $errArray[] = 'Un utilisateur existe déjà avec ce nom';
            }

            if (empty($errArray)) {
                $rqt = "UPDATE fournisseur SET nomComplet=?,phone=?,email=?, panelAccess=? WHERE fourniID=?";
                if (!isNullOrEmptyStr($fourniPass)) {
                    $rqt = "UPDATE fournisseur SET nomComplet=?,phone=?,email=?, panelAccess=?,pass='" . sha1($fourniPass) . "' WHERE fourniID=?";
                }
                $stmt = $con->prepare($rqt);
                $stmt->execute(array($fourniName, $fourniPhone, $fourniEmail, $fourniAccess, $fourniID));
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
                        <legend>Mise à jour</legend>
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
                        </div>
                    </fieldset>
                </div>
                <?php
                header('Refresh: 5; URL=' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            include $tpl . 'errorPage.php';
        }
    } elseif ($do == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fourniName = trim($_POST['nomComplet']);
            $fourniPhone = trim($_POST['phone']);
            $fourniEmail = trim($_POST['email']);
            $permission = $_POST['permOpt'];
            $fourniPass = trim($_POST['newPass']);

            $errArray = array();
            if (isNullOrEmptyStr($fourniName)) {
                $errArray[] = 'Le nom complet est nécessaire';
            }
            if (isNullOrEmptyStr($fourniPhone)) {
                $errArray[] = 'Le numéro de téléphone est nécessaire';
            }
            if (isNullOrEmptyStr($fourniEmail)) {
                $errArray[] = 'L\'adresse e-mail est nécessaire';
            }
            if (isNullOrEmptyStr($fourniPass)) {
                $errArray[] = 'Le mot de passe est nécessaire';
            }

            if (idExist("SELECT nomComplet, pass FROM fournisseur WHERE nomComplet ='" . $fourniName . "';")) {
                $errArray[] = 'Un utilisateur existe déjà avec ce nom';
            }

            if (empty($errArray)) {
                $rqt = "INSERT INTO fournisseur (nomComplet, pass, email, permission, phone) VALUES (:name,:pass,:mail,:perm,:phone);";
                $stmt = $con->prepare($rqt);
                $stmt->execute(array(
                    ':name' => $fourniName,
                    ':pass' => sha1($fourniPass),
                    ':mail' => $fourniEmail,
                    ':perm' => $permission,
                    ':phone' => $fourniPhone,
                ));

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
                        <legend>Nouveau fournisseur</legend>
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
                            <a href="Fournisseur.php?do=add" class="btn btn-primary">
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
    } elseif ($do == 'delete') {
        $errArray = array();
        $fID = (isset($_GET['fID']) && is_numeric($_GET['fID']) ? intval($_GET['fID']) : 0);
        if (!idExist("SELECT * FROM fournisseur WHERE fourniID =" . $fID . ";")) {
            $errArray[] = 'Aucun utilisateur avec ce numéro';
        }

        if (empty($errArray)) {
            $rqt = "DELETE FROM fournisseur WHERE fourniID = ?";
            $stmt = $con->prepare($rqt);
            $stmt->execute(array($fID));

            if ($stmt->rowCount() > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            ?>
            <div class="container">
                <p></p>
                <fieldset>
                    <legend>Supprimer le fournisseur</legend>
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
                        <a href="Fournisseur.php" class="btn btn-primary">
                            <span class="fa fa-refresh"></span>
                            Essayez à nouveau
                        </a>
                    </div>

                </fieldset>
            </div>
            <?php
        }
    } elseif ($do == 'approve') {
        $errArray = array();
        $fID = (isset($_GET['fID']) && is_numeric($_GET['fID']) ? intval($_GET['fID']) : 0);
        if (!idExist("SELECT * FROM fournisseur WHERE fourniID =" . $fID . ";")) {
            $errArray[] = 'Aucun utilisateur avec ce numéro';
        }

        if (empty($errArray)) {
            $rqt = "UPDATE fournisseur SET statutInsc=1 WHERE fourniID =" . $fID . ";";
            $stmt = $con->prepare($rqt);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            ?>
            <div class="container">
                <p></p>
                <fieldset>
                    <legend>Approbation de fournisseur</legend>
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
                        <a href="Fournisseur.php" class="btn btn-primary">
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

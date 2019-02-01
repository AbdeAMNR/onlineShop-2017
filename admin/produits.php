<?php
/*
===================================================================
== Structure générale des pages  Date: 03-Jun-17  Time: 22:35
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'onlineShop Produits';

if (isset($_SESSION['Username'])) {
    include 'init.php'; //Initier routes | DB connection | Header | CSS links
    //=============================================================
    $do = (isset($_GET['do']) ? filter_var($_GET['do'], FILTER_SANITIZE_STRING) : 'manage');
    if ($do == 'manage') {
        $rqt = "SELECT * FROM produits p JOIN categorie cat ON cat.CatID = p.CatID
                  JOIN fournisseur four ON p.fourniID = four.fourniID
                  JOIN marque m ON m.marqueId = p.marqueId ORDER BY prodId ASC ;";
        if (isset($_GET['search'])) {
            $rqt = "SELECT * FROM produits p JOIN categorie cat ON cat.CatID = p.CatID 
                        JOIN fournisseur four ON p.fourniID = four.fourniID JOIN marque m ON m.marqueId = p.marqueId 
                        WHERE p.prodLabel LIKE '%" . $_GET['search'] . "%' ORDER BY prodId ASC ;";
        }

        $rows = select($rqt);
        ?>
        <h1 class="text-center page-header pageTitle">Gérer les produits</h1>
        <div class="container">
            <div class="seachBar">
                <div class="row ">
                    <div class="col-md-4 col-md-offset-3" style=" margin-left: 479px;
">
                        <form action="produits.php" class="search-form" _lpchecked="1">
                            <div class="form-group has-feedback">
                                <label for="search" class="sr-only">search</label>
                                <input type="text" class="form-control" name="search" id="search"
                                       placeholder="Recherche" data-text="search">
                                <span class="fa fa-search form-control-feedback"></span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 pull-right">
                        <a href="produits.php?do=add" class="btn btn-primary ">
                            <i class="fa fa-plus"></i>
                            Nouveau produits</a>
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
                        <tr class="t-header">
                            <td>#ID</td>
                            <td>Titre</td>
                            <td>Marque</td>
                            <td>Catégorie</td>
                            <td>Prix</td>
                            <td>Description</td>
                            <td>Quantité</td>
                            <td>Date</td>
                            <td>fournisseur</td>
                            <td>Contrôles</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {
                            $style = ($row['enStock'] == 0 ? 'style="background-color: #FFE082; font-weight: bold !important;"' : '');
                            ?>
                            <tr class="t-tbl">
                                <td <?= $style; ?>><?= $row['prodId']; ?></td>
                                <td <?= $style; ?>><?= $row['prodLabel']; ?></td>
                                <td <?= $style; ?>><?= $row['marqueName']; ?></td>
                                <td <?= $style; ?>><?= $row['catName']; ?></td>
                                <td <?= $style; ?>><?= $row['prodPrix']; ?>
                                    <small class="price"><?= $row['ancienPrix']; ?></small>
                                </td>
                                <td <?= $style; ?>
                                        class="descr"><?= substr($row['description'], 0, 80) . "..."; ?></td>
                                <td <?= $style; ?>><?= $row['prodQté']; ?></td>
                                <td <?= $style; ?>><?= $row['dateAjoutee']; ?></td>
                                <td <?= $style; ?>><?= $row['nomComplet']; ?></td>
                                <td <?= $style; ?> class="p-btn">
                                    <a href="produits.php?do=edit&pID=<?= $row['prodId']; ?>" class="btn btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="produits.php?do=delete&pID=<?= $row['prodId']; ?>"
                                       class="btn btn-danger confirm">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                    <?php
                                    if ($row['presente'] == 0) {
                                        ?>
                                        <a href="produits.php?do=featured&pID=<?= $row['prodId']; ?>"
                                           class="btn btn-info">
                                            <i class="fa fa-upload"></i>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
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
            <form class="well-lg form-horizontal form-group-lg" action="produits.php?do=insert" method="post"
                  enctype="multipart/form-data">
                <fieldset>
                    <legend>Ajouter un nouveau produit</legend>
                    <div class="row">
                        <div class="col-md-12 big-input">
                            <div class="form-group">
                                <label class=" control-label">Photos</label>
                                <div class="row">
                                    <?php
                                    for ($i = 1; $i < 5; $i++) {
                                        ?>
                                        <div class="col-xs-6 col-sm-3">
                                            <div class="prod-img">
                                                <img class="img-responsive img-rounded img-thumbnail"
                                                     src="<?= $fotos; ?>imgPlacehold.jpg">
                                            </div>
                                            <div class="prod-img">
                                                <div class=" input-group">
                                                        <span class="input-group-addon"><i
                                                                    class="fa fa-plus"></i></span>
                                                    <input class="form-control" type="file" name="prodImg[]"
                                                           accept="image/gif, image/jpeg, image/jpg, image/png">

                                                </div>
                                            </div>

                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" control-label">Titre</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                    <input class="form-control" type="text" name="prodLabel"
                                           placeholder="Titre du produit">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="marque">Marque</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                    <select name="brand" class="selectpicker form-control" id="marque">
                                        <?php
                                        $rqt = "SELECT * FROM marque;";
                                        $rows = select($rqt);
                                        foreach ($rows as $row) {
                                            echo "<option value='" . $row['marqueId'] . "'>" . $row['marqueName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="categ">Catégorie</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                                    <select name="categorie" class="selectpicker form-control" id="categ">
                                        <?php
                                        $rqt = "SELECT * FROM categorie;";
                                        $rows = select($rqt);
                                        foreach ($rows as $row) {
                                            echo "<option value='" . $row['CatID'] . "'>" . $row['catName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class=" control-label">Prix par défaut</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input name="defaultPrice" placeholder="Le prix affiché"
                                               class="form-control numbersOnly"
                                               type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class=" control-label">Quantité de produit</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
                                        <input type="number" name="prodQte" placeholder="Quantité disponible"
                                               class="form-control" min="0"/>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class=" control-label">Description</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-text"></i></span>
                                    <textarea name="description" placeholder="Description" class="form-control"
                                              rows="5"
                                              maxlength="1000"></textarea>
                                </div>
                                <small>
                                    <strong>1000</strong> maximum
                                </small>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="control btn ">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ajouter
                                </button>
                                <a href="produits.php" class="btn btn-warning"><i class="fa fa-remove"></i> Annuler</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
    } elseif ($do == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $label = trim($_POST['prodLabel']);
            $brand = intval(trim($_POST['brand']));
            $cat = intval(trim($_POST['categorie']));
            $price = intval(trim($_POST['defaultPrice']));
            $qte = intval(trim($_POST['prodQte']));
            $desc = trim($_POST['description']);

            $errArray = array();
            if (isNullOrEmptyStr($label)) {
                $errArray[] = 'Le titre du produit est nécessaire';
            }
            if (isNullOrEmptyStr($price) && is_numeric($price)) {
                $errArray[] = 'Le prix n\'est pas valable';
            }
            if (isNullOrEmptyStr($qte) && is_numeric($qte)) {
                $errArray[] = 'La quantité n\'est pas valide';
            }
            if (isNullOrEmptyStr($desc)) {
                $errArray[] = 'La description n\'est pas valide';
            }

            if (idExist("SELECT * FROM produits WHERE prodLabel='" . $label . "';")) {
                $errArray[] = 'Le titre du produit existe déjà';
            }
            if (empty($errArray)) {
                $affectedRows = 0;


                $rqt = "INSERT INTO produits (prodLabel, marqueId, prodPrix, description, prodQté, fourniID, CatID)  
                          VALUES (:lbl,:brandID,:price,:descr,:qte,:fournisseur,:category);";
                $dataArray = array(
                    ':lbl' => $label,
                    ':brandID' => $brand,
                    ':price' => $price,
                    ':descr' => $desc,
                    ':qte' => $qte,
                    ':fournisseur' => $_SESSION['fourniID'],
                    ':category' => $cat,
                );
                $count = update($rqt, $dataArray);


                if ($count > 0) {
                    $affectedRows++;
                }

                $lastId = $con->lastInsertId();
                if (isset($_FILES['prodImg'])) {
                    $imgArray = array();
                    foreach ($_FILES["prodImg"]["name"] as $i => $pImage) {
                        $target_dir = "uploads/";
                        $fileName = basename($_FILES["prodImg"]["name"][$i]);
                        $target_file = $target_dir . "" . $fileName;
                        $imgArray[] = $fileName;

                        if (!file_exists($target_file)) {
                            move_uploaded_file($_FILES["prodImg"]["tmp_name"][$i], $target_file);
                        }
                    }
                    //     $nbrImg = count($imgArray);

                    $rqt = "INSERT INTO prodimages(prodId, image1, image2, image3, image4) VALUES (:product,:img1,:img2,:img3,:img4 );";
                    $dataArray = array(
                        ':product' => $lastId,
                        ':img1' => (empty($imgArray[0])) ? null : $imgArray[0],
                        ':img2' => (empty($imgArray[1])) ? null : $imgArray[1],
                        ':img3' => (empty($imgArray[2])) ? null : $imgArray[2],
                        ':img4' => (empty($imgArray[3])) ? null : $imgArray[3],
                    );
                    $count = update($rqt, $dataArray);
                    if ($count > 0) {
                        $affectedRows++;
                        //    clearstatcache();
                    }
                }
                if ($affectedRows > 1) {
                    SuccessInsertion();
                    header('Refresh: 3; URL=' . $_SERVER['HTTP_REFERER']);
                } else {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            } else {
                error($errArray, "produits.php?do=add", "Ajouter un nouveau produit");
            }

            //---------------------------------------------------------------------------------------


        } else {
            include $tpl . 'errorPage.php';
        }

    } elseif ($do == 'edit') {
        $pID = (isset($_GET['pID']) && is_numeric($_GET['pID']) ? intval($_GET['pID']) : 0);
        $stmt = $con->prepare("SELECT * FROM produits WHERE prodId=? LIMIT 1");
        $stmt->execute(array($pID));
        $count = $stmt->rowCount();
        $editRow = $stmt->fetch();
        ?>
        <div class="container">
            <form class="well-lg form-horizontal form-group-lg" action="produits.php?do=update" method="post"
                  enctype="multipart/form-data">
                <fieldset>
                    <legend>Modifier les détails du produit</legend>
                    <div class="row">
                        <input type="hidden" name="pID" value="<?= $pID; ?>">
                        <div class="col-md-12 big-input">
                            <div class="form-group">
                                <label class=" control-label">Photos</label>
                                <div class="row">
                                    <?php
                                    $rqt = "SELECT * FROM ProdImages WHERE prodId=$pID;";
                                    $stmt = $con->prepare($rqt);
                                    $stmt->execute(array());
                                    $count = $stmt->rowCount();
                                    $imgsRow = $stmt->fetch();

                                    for ($i = 1; $i < 5; $i++) {
                                        $col = 'image' . $i;
                                        if (!empty($imgsRow[$col])) {
                                            ?>
                                            <div class="col-xs-6 col-sm-3">
                                                <div class="prod-img">
                                               <span class=" remove-btn btn-xs btn-danger">
                                               <a href="produits.php?do=removeimg&pID=<?= $pID . "&img=" . $col . "&fileName=" . $imgsRow[$col]; ?>"><i
                                                           class="fa fa-remove"></i>
                                               </a>
                                           </span>
                                                    <img class="img-responsive img-rounded img-thumbnail"
                                                         src="<?= $fotos . "" . $imgsRow[$col]; ?>"
                                                         alt="<?= $editRow['prodLabel']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="col-xs-6 col-sm-3">
                                                <div class="prod-img">
                                                    <img class="img-responsive img-rounded img-thumbnail"
                                                         src="<?= $fotos; ?>imgPlacehold.jpg"
                                                         alt="<?= $editRow['prodLabel']; ?>">
                                                </div>
                                                <div class="prod-img">
                                                    <div class=" input-group">
                                                        <span class="input-group-addon"><i
                                                                    class="fa fa-plus"></i></span>
                                                        <input class="form-control" type="file" name="prodImg[]"
                                                               accept="image/gif, image/jpeg, image/jpg, image/png">

                                                    </div>
                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" control-label">Titre</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                    <input class="form-control" type="text" name="prodLabel"
                                           placeholder="Titre du produit"
                                           value="<?= $editRow['prodLabel']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="marque">Marque</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                    <select name="brand" class="selectpicker form-control" id="marque">
                                        <?php
                                        $rqt = "SELECT * FROM marque;";
                                        $rows = select($rqt);
                                        foreach ($rows as $row) {
                                            ?>
                                            <option <?= (($editRow['marqueId'] == $row['marqueId']) ? 'selected' : ''); ?>
                                                    value="<?= $row['marqueId']; ?>"><?= $row['marqueName']; ?> </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label" for="categ">Catégorie</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                                    <select name="categorie" class="selectpicker form-control" ID="categ">
                                        <?php
                                        $rqt = "SELECT * FROM categorie;";
                                        $rows = select($rqt);
                                        foreach ($rows as $row) {

                                            ?>
                                            <option <?= (($editRow['CatID'] == $row['CatID']) ? 'selected' : ''); ?>
                                                    value="<?= $row['CatID']; ?>"><?= $row['catName']; ?>  </option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" control-label">Prix ancien</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                    <input type="number" name="oldPrice" placeholder="prix d'origine"
                                           class="form-control" min="0" value="<?= $editRow['ancienPrix']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label">Prix par défaut</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                    <input name="defaultPrice" placeholder="Le prix affiché"
                                           class="form-control numbersOnly"
                                           type="text" value="<?= $editRow['prodPrix']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label">Quantité de produit</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
                                    <input type="number" name="prodQte" placeholder="Quantité disponible"
                                           class="form-control" min="0" value="<?= $editRow['prodQté']; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 big-input">
                            <div class="form-group">
                                <label class=" control-label">Description</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-text"></i></span>
                                    <textarea name="description" placeholder="Description" class="form-control"
                                              rows="2"
                                              maxlength="1000"><?= $editRow['description']; ?></textarea>
                                </div>
                                <small>
                                    <strong>1000</strong> maximum
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="control btn ">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                    Appliquer
                                </button>
                                <a href="produits.php" class="btn btn-warning"><i class="fa fa-remove"></i>
                                    Annuler</a>
                            </div>
                        </div>
                    </div>


                </fieldset>
            </form>
        </div>
        <?php

    } elseif ($do == 'update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pID = trim($_POST['pID']);
            $label = trim($_POST['prodLabel']);
            $brand = intval(trim($_POST['brand']));
            $cat = intval(trim($_POST['categorie']));
            $oldPrice = intval(trim($_POST['oldPrice']));
            $defaultPrice = intval(trim($_POST['defaultPrice']));
            $qte = intval(trim($_POST['prodQte']));
            $desc = trim($_POST['description']);

            $errArray = array();
            if (isNullOrEmptyStr($label)) {
                $errArray[] = 'Le titre du produit est nécessaire';
            }
            if (isNullOrEmptyStr($defaultPrice) && is_numeric($defaultPrice)) {
                $errArray[] = 'Le prix n\'est pas valide';
            }
            if (isNullOrEmptyStr($qte) && is_numeric($qte)) {
                $errArray[] = 'La quantité n\'est pas valide';
            }


            if (empty($errArray)) {
                $rqt = "UPDATE produits SET prodLabel = ?, marqueId = ?, prodPrix = ?, description = ?, prodQté = ?, fourniID = ?, CatID = ?";
                if (!empty($oldPrice)) {
                    $rqt .= " , ancienPrix=$oldPrice";
                } else {
                    $rqt .= " , ancienPrix=NULL";
                }
                $rqt .= " WHERE prodId=?;";

                $count = update($rqt, array($label, $brand, $defaultPrice, $desc, $qte, $_SESSION['fourniID'], $cat, $pID));
  $affectedRows = 0;
                if ($count > 0) {
                    $affectedRows++;
                }


                if (isset($_FILES['prodImg'])) {
                    $nbr = 0;
                    foreach ($_FILES["prodImg"]["name"] as $i => $pImage) {

                        $target_dir = "uploads/";
                        $fileName = basename($_FILES["prodImg"]["name"][$i]);
                        $target_file = $target_dir . "" . $fileName;


                        $nbr++;
                        $col = 'image' . $nbr;
                        $rqt = "SELECT $col FROM prodimages WHERE prodId= ? ";
                        $stmt = $con->prepare($rqt);
                        $stmt->execute(array($pID));
                        $cellContent = $stmt->fetchColumn();
                        //   ECHO $col . " ==> " . $cellContent . "<br>";

                        while (!empty($cellContent)) {
                            $nbr++;
                            $col = 'image' . $nbr;
                            $rqt = "SELECT $col FROM prodimages WHERE prodId= ? ";
                            $stmt = $con->prepare($rqt);
                            $stmt->execute(array($pID));
                            $cellContent = $stmt->fetchColumn();
                            // ECHO $col . " ==> " . $cellContent . "<br>";
                            if ($nbr > 4) {
                                break;
                            }
                        }
                        $rqt = "UPDATE prodimages SET $col=? WHERE prodId= ? ";
                        $count = update($rqt, array($fileName, $pID));

                        if ($count > 0) {
                            $affectedRows++;
                        }
                        if (!file_exists($target_file)) {
                            move_uploaded_file($_FILES["prodImg"]["tmp_name"][$i], $target_file);
                            //   echo "image ==> " . $fileName . " to => " . $target_file . "<br>";
                        }

                    }

                }
                if ($affectedRows > 1) {
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

    } elseif ($do == 'removeimg') {
        $errArray = array();
        $pID = (isset($_GET['pID']) && is_numeric($_GET['pID']) ? intval($_GET['pID']) : 0);
        if (!isset($_GET['img'])) {
            $errArray[] = 'Cette image n\'existe pas';
        } else {
            $image = filter_var(trim($_GET['img']), FILTER_SANITIZE_STRING);
            // echo $image;
            if ($image != 'image1' && $image != 'image2' && $image != 'image3' && $image != 'image4') {
                $errArray[] = 'Cette image n\'existe pas';
            }
        }
        if (!idExist("SELECT * FROM produits WHERE prodId =" . $pID . ";")) {
            $errArray[] = 'Il n\'y a pas de produit avec ce numéro';
        }

        if (empty($errArray)) {
            $rqt = "UPDATE prodimages SET $image=NULL WHERE prodId=?";
            $count = update($rqt, array($pID));
 if ($count > 0) {
                // echo $_SERVER['DOCUMENT_ROOT'] . $fotos . $_GET['fileName'];
                unlink($_SERVER['DOCUMENT_ROOT'] . $fotos . $_GET['fileName']);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            error($errArray, "produits.php", "Supprimer l'image");
        }
    } elseif ($do == 'delete') {
        $errArray = array();
        $pID = (isset($_GET['pID']) && is_numeric($_GET['pID']) ? intval($_GET['pID']) : 0);
        if (!idExist("SELECT * FROM produits WHERE prodId =" . $pID . ";")) {
            $errArray[] = 'Il n\'y a pas de produit avec ce numéro';
        }
        if (empty($errArray)) {
            $rqt = "DELETE FROM produits WHERE prodId = ?";
            $count = update($rqt, array($pID));
            if ($count > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            error($errArray, "produits.php", "Supprimer le produit");
        }
    } elseif ($do == 'featured') {
        $errArray = array();
        $pID = (isset($_GET['pID']) && is_numeric($_GET['pID']) ? intval($_GET['pID']) : 0);
        if (!idExist("SELECT * FROM produits WHERE prodId =" . $pID . ";")) {
            $errArray[] = 'Il n\'y a pas de produit avec ce numéro';
        }
        if (empty($errArray)) {
            $rqt = "UPDATE produits SET presente=1 WHERE prodId=?";
            $count = update($rqt, array($pID));
            if ($count > 0) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            error($errArray, "produits.php", "Mis en ligne");
        }
    } else {
        include $tpl . 'errorPage.php';
    }
    include $tpl . 'footer.php';
} else {
    //echo "Vous n'êtes pas autorisé à afficher cette page";
    header('location: index.php');
    exit();
}
ob_end_flush();

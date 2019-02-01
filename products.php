<?php
ob_start();
session_start();
$pageTitle = 'onlineShop: Online Shopping for Electronics, Computers, Books & more';
include 'initMain.php'; /* **** Initier routes | DB connection | Header | CSS links**** */
//include $tpl . "banner.php";

if (isset($_GET['category'])) {
    $CatId = (isset($_GET['category']) && is_numeric($_GET['category']) ? intval($_GET['category']) : 0);
    $CatId = filter_var($CatId, FILTER_SANITIZE_NUMBER_INT);
    $rqt = "SELECT * FROM produits p 
              JOIN categorie cat ON p.CatID = cat.CatID 
              JOIN marque m ON m.marqueId = p.marqueId 
              JOIN fournisseur f ON f.fourniID = p.fourniID 
              JOIN prodimages pimg ON pimg.prodId = p.prodId WHERE cat.CatID =$CatId ";

    $categoryName = selectCol("SELECT catName FROM categorie WHERE CatID=$CatId");
    if (isset($_GET['brand'])) {
        $brandid = (isset($_GET['brand']) && is_numeric($_GET['brand']) ? intval($_GET['brand']) : 0);
        $brandid = filter_var($brandid, FILTER_SANITIZE_NUMBER_INT);
        $rqt .= " AND m.marqueId = $brandid ;";
    }
    if(isset($_POST['Appliquer'])){
        $sort= $_POST['sort'];
        $limit=$_POST['limit'];
        $rqt .= " ORDER BY p.prodPrix $sort LIMIT $limit;";

    }

}
$produitRes = select($rqt);
?>

<!--content-->
<div class="content">
    <div class="products-agileinfo">
        <h2 class="tittle"><?= ((isset($categoryName) ? $categoryName : '')); ?></h2>
        <div class="container">
            <div class="product-agileinfo-grids w3l">
                <div class="col-md-3 product-agileinfo-grid">
                    <div class="categories">
                        <h3>Catégories</h3>
                        <ul class="tree-list-pad">
                            <?php
                            $familleID = selectCol("SELECT familleID FROM categorie WHERE CatID=$CatId;");
                            $familleName = selectCol("SELECT familleName FROM famille WHERE familleID=$familleID;");
                            $categorie = select("SELECT * FROM categorie WHERE familleID=$familleID;");
                            ?>
                            <li><input type="checkbox" checked="checked" id="item-0"/>
                                <label for="item-0"><span></span><?= $familleName; ?></label>
                                <ul>
                                    <ul>
                                        <?php foreach ($categorie as $cat) { ?>
                                            <li>
                                                <a href="products.php?category=<?= $cat['CatID']; ?>"><?= $cat['catName']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </ul>
                            </li>

                        </ul>
                    </div>

                    <?php
                    $brand = select("SELECT * FROM marque;");
                    ?>
                    <div class="brand-w3l">
                        <h3>Filtre de marques</h3>
                        <ul>
                            <?php
                            foreach ($brand as $b) {
                                ?>
                                <li>
                                    <a href="products.php?category=<?= $CatId; ?>&brand=<?= $b['marqueId']; ?>"><?= $b['marqueName']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
                <div class="col-md-9 product-agileinfon-grid1 w3l">
                    <div class="product-agileinfon-top">
                        <div class="col-md-6 product-agileinfon-top-left">
                            <img class="img-responsive " src="images/img1.jpg" alt="">
                        </div>
                        <div class="col-md-6 product-agileinfon-top-left">
                            <img class="img-responsive " src="images/img2.jpg" alt="">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mens-toolbar">
                        <form action="products.php<?=((isset($_GET['category']))?'?category='.$_GET['category']:'');?>" method="post">
                            <p class="showing">Trier par
                                <select name="sort">
                                    <option value="DESC"> Prix Décroissant</option>
                                    <option value="ASC"> Prix Croissant</option>
                                </select>
                            </p>
                            <p>Show
                                <select name="limit">
                                    <option value="10"> 10</option>
                                    <option value="20"> 20</option>
                                    <option value="40"> 40</option>
                                    <option value="80"> 80</option>
                                </select>
                            </p>
                            <p>
                                <button type="submit" name="Appliquer">Appliquer</button>
                            </p>
                        </form>
                    </div>
                    <div id="prodList" class="bs-example bs-example-tabs" role="tabpanel"
                         data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav1 nav1-tabs left-tab" role="tablist">

                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home"
                                     aria-labelledby="home-tab">

                                    <?php
                                    foreach ($produitRes as $items) { ?>

                                        <div class="col-xs-6 col-sm-4" style="padding: 10px;">
                                            <div class="grid-arr">
                                                <div class="grid-arrival">
                                                    <figure>
                                                        <a href="single.php/?prodId=<?= $items['prodId']; ?>"
                                                           class="new-gri" data-toggle="modal"
                                                           data-target="#myModal1">
                                                            <div class="grid-img">
                                                                <img src="<?= $uploads . $items['image1']; ?>"
                                                                     class="img-responsive " alt="">
                                                            </div>
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="women">
                                                    <h6>
                                                        <a href="single.php/?prodId=<?= $items['prodId']; ?>"><?= $items['prodLabel']; ?></a>
                                                    </h6>
                                                    <span class="brandName"><?= $items['marqueName']; ?>
                                                        <span class="size"><?= $items['description']; ?></span>
                                                    </span>
                                                    <p>
                                                        <del class="text-danger"><?= (($items['ancienPrix'] == '') ? '' : money($items['ancienPrix'])); ?> </del>
                                                        <em class="text-danger"><?= (($items['ancienPrix'] == '') ? '' : ' / ') ?> </em>
                                                        <em class="item_price"><?= money($items['prodPrix']); ?></em>
                                                    </p>
                                                    <form  action="panier.php" method="post">
                                                        <input type="hidden" name="pid" value="<?= $items['prodId']; ?>">
                                                        <button type="submit" class="my-cart-b">
                                                            Ajouter au panier
                                                        </button>
                                                    </form>


                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--content-->

<?php
include $tpl . "footer.php";
include $tpl . "copyRights.php";
//include $tpl . "popUpModal.php";
ob_end_flush();
?>
</body>
</html>
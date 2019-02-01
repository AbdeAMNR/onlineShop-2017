<?php
/*
===================================================================
== Date: 10-Jun-17
== Time: 06:40
===================================================================
==
==
===================================================================
*/
ob_start();
session_start();
$pageTitle = 'onlineShop: Online Shopping for Electronics, Computers, Books & more';
include 'initMain.php'; /* **** Initier routes | DB connection | Header | CSS links**** */
?>
<!--banner-->
<div class="banner-w3">
    <div class="demo-1">
        <div id="example1" class="core-slider core-slider__carousel example_1">
            <div class="core-slider_viewport">
                <div class="core-slider_list">
                    <div class="core-slider_item"><img src="<?= $imgs; ?>b1.jpg" class="img-responsive" alt=""></div>
                    <div class="core-slider_item"><img src="<?= $imgs; ?>b2.jpg" class="img-responsive" alt=""></div>
                    <div class="core-slider_item"><img src="<?= $imgs; ?>b3.jpg" class="img-responsive" alt=""></div>
                    <div class="core-slider_item"><img src="<?= $imgs; ?>b4.jpg" class="img-responsive" alt=""></div>
                    <div class="core-slider_item"><img src="<?= $imgs; ?>b5.jpg" class="img-responsive" alt=""></div>
                    <div class="core-slider_item"><img src="<?= $imgs; ?>b6.jpg" class="img-responsive" alt=""></div>
                </div>
            </div>
            <div class="core-slider_nav">
                <div class="core-slider_arrow core-slider_arrow__right"></div>
                <div class="core-slider_arrow core-slider_arrow__left"></div>
            </div>
            <div class="core-slider_control-nav"></div>
        </div>
    </div>
    <link href="<?= $css; ?>coreSlider.css" rel="stylesheet" type="text/css">
    <script src="<?= $js; ?>coreSlider.js"></script>
    <script>
        $('#example1').coreSlider({
            pauseOnHover: true,
            interval: 2500,
            controlNavEnabled: true
        });

    </script>

</div>
<!--banner-->
<!--content-->
<div class="content">
    <!--banner-bottom-->
    <div class="ban-bottom-w3l">
        <div class="container">
            <div class="col-md-6 ban-bottom">
                <div class="ban-top">
                    <img src="<?= $imgs; ?>p1.jpg" class="img-responsive" alt=""/>
                    <div class="ban-text">
                        <h4>Vêtements pour hommes</h4>
                    </div>
                    <div class="ban-text2 hvr-sweep-to-top">
                        <h4>50% <span>Off/-</span></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ban-bottom3">
                <div class="ban-top">
                    <img src="<?= $imgs; ?>p2.jpg" class="img-responsive" alt=""/>
                    <div class="ban-text1">
                        <h4>Vêtements pour femmes</h4>
                    </div>
                </div>
                <div class="ban-img">
                    <div class=" ban-bottom1">
                        <div class="ban-top">
                            <img src="<?= $imgs; ?>sp1.jpg" class="img-responsive" alt=""/>
                            <div class="ban-text1">
                                <h4>Smartphone</h4>
                            </div>
                        </div>
                    </div>
                    <div class="ban-bottom2">
                        <div class="ban-top">
                            <img src="<?= $imgs; ?>pc1.jpg" class="img-responsive" alt=""/>
                            <div class="ban-text1"><h4>Ordinateurs</h4></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--banner-bottom-->
    <!--new-arrivals-->
    <div class="new-arrivals-w3agile">
        <div class="container">
            <h2 class="tittle">Nouvelles arrivées</h2>
            <div class="arrivals-grids">
                <?php
                $prodQuery = "SELECT * FROM produits p 
              JOIN categorie cat ON p.CatID = cat.CatID 
              JOIN marque m ON m.marqueId = p.marqueId 
              JOIN fournisseur f ON f.fourniID = p.fourniID 
              JOIN prodimages pimg ON pimg.prodId = p.prodId LIMIT 4";
                $prodResult = select($prodQuery);
                foreach ($prodResult as $prodItems) {
                    ?>
                    <div class="col-md-3 arrival-grid simpleCart_shelfItem">
                        <div class="grid-arr">
                            <div class="grid-arrival">
                                <figure>
                                    <a href="#" class="new-gri" data-toggle="modal" data-target="#myModal1">
                                        <div class="grid-img"><img src="<?= $imgs .$prodItems['image2']; ?>"
                                                                   class="img-responsive" alt=""></div>
                                        <div class="grid-img"><img src="<?= $imgs .$prodItems['image1']; ?>"
                                                                   class="img-responsive" alt=""></div>
                                    </a>
                                </figure>
                            </div>
                            <div class="ribben">
                                <p>NOUVEAU</p>
                            </div>
                            <div class="block">
                                <div class="starbox small ghosting"></div>
                            </div>
                            <div class="women">
                                <h6>
                                    <a href="single.php/?prodId=<?= $prodItems['prodId']; ?>"><?= $prodItems['prodLabel']; ?></a>
                                </h6>
                                <span class="brandName"><?= $prodItems['marqueName']; ?><span
                                            class="size"><?= $prodItems['description']; ?></span></span>

                                <p style="margin: 2px 0">
                                    <del class="text-danger"><?= (($prodItems['ancienPrix'] == '') ? '' : money($prodItems['ancienPrix'])); ?> </del>
                                    <em class="text-danger"><?= (($prodItems['ancienPrix'] == '') ? '' : ' / ') ?> </em>
                                    <em class="item_price"><?= money($prodItems['prodPrix']); ?></em>
                                </p>
                                <form  action="panier.php" method="post">
                                    <input type="hidden" name="pid" value="<?= $prodItems['prodId']; ?>">
                                    <button type="submit" class="my-cart-b">
                                        Ajouter au panier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?PHP } ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!--new-arrivals-->
    <!--accessories-->
    <div class="accessories-w3l">
        <div class="container">
            <h3 class="tittle">20% de réduction sur</h3>
            <span>CONCEPTIONS DE TENDANCE</span>
            <div class="button">
                <a href="#" class="button1"> Achetez maintenant</a>
                <a href="#" class="button1"> Vue rapide</a>
            </div>
        </div>
    </div>
    <!--accessories-->
    <div class="latest-w3">
        <div class="container">
            <h3 class="tittle1">Marques populaires</h3>
            <div class="latest-grids">
                <?php
                $brandQuery = "SELECT * FROM marque LIMIT 0,3";
                $brandResult = select($brandQuery);
                foreach ($brandResult as $brandItems) {
                    ?>
                    <div class="col-md-4 latest-grid">
                        <div class="latest-top">
                            <img src="<?=$imgs . $brandItems['marImage']; ?>" class="img-responsive" alt="">
                            <div class="latest-text"><h4><?= $brandItems['marqueName']; ?></h4></div>
                            <div class="latest-text2 hvr-sweep-to-top"><h4>-50%</h4></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
            <div class="latest-grids">
                <?php
                $brandQuery = "SELECT * FROM marque LIMIT 3,3";
                $brandResult = select($brandQuery);
                foreach ($brandResult as $brandItems) {
                    ?>
                    <div class="col-md-4 latest-grid">
                        <div class="latest-top">
                            <img src="<?=$imgs . $brandItems['marImage']; ?>" class="img-responsive" alt="">
                            <div class="latest-text"><h4><?= $brandItems['marqueName']; ?></h4></div>
                            <div class="latest-text2 hvr-sweep-to-top"><h4>-30%</h4></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="new-arrivals-w3agile">
        <div class="container">
            <h3 class="tittle1">Meilleures ventes</h3>
            <div class="arrivals-grids">
                <?php
                $prodQuery = "SELECT * FROM produits p JOIN prodimages pi ON pi.prodId=p.prodId JOIN marque m ON m.marqueId=p.marqueId LIMIT 0,4";
                $prodResult = select($prodQuery);
                foreach ($prodResult as $prodItems) {
                    ?>
                    <div class="col-md-3 arrival-grid simpleCart_shelfItem">
                        <div class="grid-arr">
                            <div class="grid-arrival">
                                <figure>
                                    <a href="#" class="new-gri" data-toggle="modal" data-target="#myModal1">
                                        <div class="grid-img">
                                            <img src="<?= $imgs . $prodItems['image2']; ?>" class="img-responsive"
                                                 alt="">
                                        </div>
                                        <div class="grid-img">
                                            <img src="<?= $imgs .$prodItems['image1']; ?>" class="img-responsive" alt="">
                                        </div>
                                    </a>
                                </figure>
                            </div>
                            <div class="ribben">
                                <p>NOUVEAU</p>
                            </div>
                            <div class="block">
                                <div class="starbox small ghosting"></div>
                            </div>
                            <div class="women">
                                <h6>
                                    <a href="single.php/?prodId=<?= $prodItems['prodId']; ?>"><?= $prodItems['prodLabel']; ?></a>
                                </h6>
                                <span class="brandName"><?= $prodItems['marqueName']; ?><span
                                            class="size"><?= $prodItems['description']; ?></span></span>

                                <p style="margin: 2px 0">
                                    <del class="text-danger"><?= (($prodItems['ancienPrix'] == '') ? '' : money($prodItems['ancienPrix'])); ?> </del>
                                    <em class="text-danger"><?= (($prodItems['ancienPrix'] == '') ? '' : ' / ') ?> </em>
                                    <em class="item_price"><?= money($prodItems['prodPrix']); ?></em></p>
                                <form  action="panier.php" method="post">
                                    <input type="hidden" name="pid" value="<?= $prodItems['prodId']; ?>">
                                    <button type="submit" class="my-cart-b">
                                        Ajouter au panier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?PHP } ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!--new-arrivals-->
</div>
<!--content-->

<?php
include $tpl . "footer.php";
include $tpl . "copyRights.php";
include $tpl . "popUpModal.php";
ob_end_flush();
?>
</body>
</html>



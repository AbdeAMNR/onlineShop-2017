<?php
ob_start();
session_start();
$pageTitle = 'onlineShop: Online Shopping for Electronics, Computers, Books & more';
include 'initMain.php'; /* **** Initier routes | DB connection | Header | CSS links**** */
include $tpl . "banner.php";

if (isset($_GET['prodId']) && !empty($_GET['prodId'])) {
    $pID = intval($_GET['prodId']);
    $pID = desinfecter($pID);
}
?>
<!--content-->
<div class="content">
    <!--single-->
    <div class="single-wl3">
        <div class="container">
            <div class="single-grids">
                <div class="col-md-9 single-grid">
                    <div clas="single-top">
                        <?php
                        $myQuery = "SELECT * FROM produits p JOIN prodimages pi on p.prodId=pi.prodId WHERE p.prodId=$pID";
                        $products = select($myQuery);
                        ?>
                        <div class="single-left">
                            <div class="flexslider">
                                <ul class="slides">
                                    <?php
                                    foreach ($products as $prod) {
                                        ?>
                                        <li data-thumb="<?= $imgs . $prod['image1']; ?>">
                                            <div class="thumb-image"><img src="<?= $imgs . $prod['image1']; ?>"
                                                                          data-imagezoom="true" class="img-responsive">
                                            </div>
                                        </li>
                                        <li data-thumb="<?= $imgs . $prod['image2']; ?>">
                                            <div class="thumb-image"><img src="<?= $imgs . $prod['image2']; ?>"
                                                                          data-imagezoom="true" class="img-responsive">
                                            </div>
                                        </li>
                                        <li data-thumb="<?= $imgs . $prod['image3']; ?>">
                                            <div class="thumb-image"><img
                                                        src="<?= $imgs . $prod['image3']; ?>"
                                                        data-imagezoom="true" class="img-responsive"></div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="single-right simpleCart_shelfItem">
                            <h4><?= $prod['prodLabel']; ?></h4>
                            <div class="block">
                                <div class="starbox small ghosting"></div>
                            </div>
                            <p class="price item_price">
                                <del class="text-danger"><?= (($prod['ancienPrix'] == '') ? '' : $prod['ancienPrix'] . ' DH') ?> </del>
                                <em class="text-danger"><?= (($prod['ancienPrix'] == '') ? '' : ' / ') ?> </em>
                                <em class="item_price"><?= $prod['prodPrix']; ?> DH</em>
                            </p>
                            <h5 class="text-left text-bold"><?= $prod['description']; ?></h5>
                            <div class="description">

                                <p>
                                    <span>Présentation rapide: </span><?= $prod['description']; ?>
                                </p>
                            </div>
                            <div class="color-quality">
                                <h6>Quantité:</h6>
                                <div class="quantity">
                                    <div class="quantity-select">
                                        <div class="entry value-minus1">&nbsp;</div>
                                        <div class="entry value1"><span>1</span></div>
                                        <div class="entry value-plus1 active">&nbsp;</div>
                                    </div>
                                </div>
                                <!--quantity-->
                                <script language="JavaScript">
                                    $('.value-plus1').on('click', function () {
                                        var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) + 1;
                                        divUpd.text(newVal);
                                    });

                                    $('.value-minus1').on('click', function () {
                                        var divUpd = $(this).parent().find('.value1'), newVal = parseInt(divUpd.text(), 10) - 1;
                                        if (newVal >= 1) divUpd.text(newVal);
                                    });
                                </script>
                                <!--quantity-->
                            </div>
                            <div class="women">
                                <a href="#" data-text="Add To Cart" class="my-cart-b item_add">Ajouter au panier</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <!--Product Description-->
            <div class="product-w3agile">
                <h3 class="tittle1">Product Description</h3>
                <div class="product-grids">
                    <div class="col-md-8 product-grid1">
                        <div class="tab-wl3">
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs left-tab" role="tablist">

                                    <li role="presentation"><a href="#reviews" role="tab" id="reviews-tab"
                                                               data-toggle="tab" aria-controls="reviews">Reviews (1)</a>
                                    </li>

                                </ul>
                                <div id="myTabContent" class="tab-content">

                                    <div role="tabpanel" class="tab-pane fade" id="reviews"
                                         aria-labelledby="reviews-tab">
                                        <div class="descr">
                                            <div class="reviews-top">

                                                <div class="reviews-right">
                                                    <ul>
                                                        <li><a href="#">Admin</a></li>
                                                        <li><a href="#"><i class="glyphicon glyphicon-share"
                                                                           aria-hidden="true"></i>Reply</a></li>
                                                    </ul>
                                                    <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam
                                                        corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                                                        consequatur? Quis autem vel eum iure reprehenderit.</p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="reviews-bottom">
                                                <h4>Commentaire</h4>

                                                <form action="#" method="post">
                                                    <textarea type="text" Name="Message" onfocus="this.value = '';"
                                                              onblur="if (this.value == '') {this.value = 'Message...';}"
                                                              required="">Message...</textarea>
                                                    <div class="row">
                                                        <div class="col-md-6 row-grid">
                                                            <label>Name</label>
                                                            <input type="text" value="Name" Name="Name"
                                                                   onfocus="this.value = '';"
                                                                   onblur="if (this.value == '') {this.value = 'Name';}"
                                                                   required="">
                                                        </div>
                                                        <div class="col-md-6 row-grid">
                                                            <label>Email</label>
                                                            <input type="email" value="Email" Name="Email"
                                                                   onfocus="this.value = '';"
                                                                   onblur="if (this.value == '') {this.value = 'Email';}"
                                                                   required="">
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <input type="submit" value="SEND">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="custom" aria-labelledby="custom-tab">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--Product Description-->
        </div>
    </div>
    <!--single-->


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
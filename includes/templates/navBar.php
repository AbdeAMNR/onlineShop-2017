<!--header-->

<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="top-left">
                <a href="mail.php"> Besoin d'aide? <i class="glyphicon glyphicon-phone" aria-hidden="true"></i> +212 (0) 6 213
                    611</a>
            </div>
            <div class="top-right">
                <ul>
                     <li><a href="mail.php">Contactez nous</a></li>
                     <?php
                    if (isset($_SESSION['userClt'])) {
                        ?>
                        <li><a href=""> <?= $_SESSION['userClt']; ?> </a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="login.php">S'identifier</a></li>
                        <li><a href="registered.php">Créer un compte</a></li>                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="heder-bottom">
        <div class="container">
            <div class="logo-nav">
                <div class="logo-nav-left">
                    <h1><a href="/onlineshop/index.php">OnlineShop<span>Shop anywhere</span></a></h1>
                </div>
                <div class="logo-nav-left1">
                    <nav class="navbar navbar-default">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <!-- start toggle button for mobile appearance -->
                        <div class="navbar-header nav_2">
                            <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse"
                                    data-target="#bs-megadropdown-tabs">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- end toggle button for mobile appearance -->
                        <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                            <ul class="nav navbar-nav">
                                <!-- Mega Menu -->
                                <?php
                                $rqt = "SELECT * FROM famille ORDER BY familleName ASC;";
                                $familyCat = select($rqt);
                                foreach ($familyCat as $fCat) {
                                    ?>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle"
                                           data-toggle="dropdown"><?= $fCat['familleName'] ?><b class="caret"></b>
                                        </a>
                                        <?php
                                        $optCat = select("SELECT * FROM categorie WHERE familleID=" . $fCat['familleID']);
                                        ?>
                                        <ul class="dropdown-menu">
                                            <?php
                                            foreach ($optCat as $cat) {
                                                ?>
                                                <li>
                                                    <a href="/onlineshop/products.php?category=<?= $cat['CatID']; ?>"><?= $cat['catName']; ?></a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </li>
                                    <?php
                                }
                                ?>

                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="logo-nav-right">
                    <ul class="cd-header-buttons">
                        <li><a class="cd-search-trigger" href="#cd-search"><span></span></a></li>
                    </ul> <!-- cd-header-buttons -->
                    <div id="cd-search" class="cd-search">
                        <form action="#" method="post">
                            <input name="Search" type="search" placeholder="Rechercher...">
                        </form>
                    </div>
                </div>
                <div class="header-right2">
                    <div class="cart box_1">
                        <a href="checkout.php" class="btn btn-success">
                            <span style="font-weight: bold">
                                      Panier <i class="fa fa-shopping-cart"></i>
                             </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--header-->
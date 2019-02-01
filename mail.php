<?php
ob_start();
session_start();
$pageTitle = 'onlineShop: Online Shopping for Electronics, Computers, Books & more';
include 'initMain.php'; /* **** Initier routes | DB connection | Header | CSS links**** */
$bannerTitle = 'Courrier';
include $tpl . "banner.php";
/* ------------------------------------------ */

if (isset($_SESSION['userClt'])) {
    $do = (isset($_GET['do']) ? filter_var($_GET['do'], FILTER_SANITIZE_STRING) : 'manage');
    if ($do == 'manage') {
        ?>
        <!--content-->
        <div class="content">
            <!--contact-->
            <div class="mail-w3ls">
                <div class="container">
                    <h2 class="tittle">Envoyez-nous un courrier</h2>
                    <div class="mail-grids">
                        <div class="mail-top">
                            <div class="col-md-4 mail-grid">
                                <i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>
                                <h5>Address</h5>
                                <p>11 Bloc 18 La Resistance 45000 Ouarzazate Morocco</p>
                            </div>
                            <div class="col-md-4 mail-grid">
                                <i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>
                                <h5>Phone</h5>
                                <p>Telephone: +212 (0) 6 213 611 89</p>
                            </div>
                            <div class="col-md-4 mail-grid">
                                <i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
                                <h5>E-mail</h5>
                                <p>E-mail:<a href="mailto:miinotek15@gmail.com"> miinotek15@gmail.com</a></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="map-w3">
                            <iframe src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJVyBCd0AQuw0RAKs3m1LLsyY&key=AIzaSyCKvjtaZscktdt_J9gXAEafS2TmC7JRKuw"
                                    allowfullscreen
                            ></iframe>
                        </div>
                        <div class="mail-bottom">
                            <h4>Entrez en contact avec nous</h4>
                            <form action="#" method="post">
                                <input type="text" value="Name" onfocus="this.value = '';"
                                       onblur="if (this.value == '') {this.value = 'Name';}" required="">
                                <input type="email" value="Email" onfocus="this.value = '';"
                                       onblur="if (this.value == '') {this.value = 'Email';}" required="">
                                <input type="text" value="Telephone" onfocus="this.value = '';"
                                       onblur="if (this.value == '') {this.value = 'Telephone';}" required="">
                                <textarea onfocus="this.value = '';"
                                          onblur="if (this.value == '') {this.value = 'Message...';}"
                                          required="">Message...</textarea>
                                <input type="submit" value="envoyer">
                                <input type="reset" value="Clear">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--contact-->
        </div>
        <!--content-->
        <?php
    }
} else {
    ?>
    <div class="container">
        <p></p>
        <form class="well-lg form-horizontal form-group-lg">
            <fieldset>
                <legend><h1>Connectez-vous</h1></legend>
                <div class="form-group">
                    <div class="alert alert-warning" role="alert">
                        Echec <i class="glyphicon glyphicon-thumbs-down"></i> Connectez-vous pour contacter un de nos
                        administrateurs
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
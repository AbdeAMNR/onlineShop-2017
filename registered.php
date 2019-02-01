<?php
ob_start();
session_start();
$pageTitle = 'onlineShop: Online Shopping for Electronics, Computers, Books & more';
include 'initMain.php'; /* **** Initier routes | DB connection | Header | CSS links**** */
$bannerTitle = 'Panier ';
include $tpl . "banner.php";

if (isset($_SESSION['userClt'])) {
    header('location: index.php');
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $Username = $_POST['Username'];
        $Email = $_POST['Email'];
        $tele = $_POST['tele'];
        $adrs = $_POST['adrs'];
        $Password = $_POST['Password'];


        //check if the user exist
        $stmt = $con->prepare("SELECT * FROM client WHERE email=?");
        $stmt->execute(array($Email));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();
        if ($count > 0) {
            ?>
            <div class="container">
                <p></p>
                <form class="well-lg form-horizontal form-group-lg">
                    <fieldset>
                        <legend><h1>inscrivez-vous</h1></legend>
                        <div class="form-group">
                            <div class="alert alert-warning" role="alert">
                                Echec <i class="glyphicon glyphicon-thumbs-down"></i> Email existent inscrivez-vous avec
                                un autre email
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
        } else {
            $rqt = "INSERT INTO client (email, pass, nom_Prenom, tele, adresse, dateInsc) 
                              VALUES (:email,:pass,:nom,:tele,:adrs,now());";
            $effected = update($rqt, array(
                ':email' => $Email,
                ':pass' => sha1($Password),
                ':nom' => $Username,
                ':tele' => $tele,
                ':adrs' => $adrs,
            ));


            header('location: index.php');
            exit();
        }
    }
    ?>
    <!--content-->
    <div class="content">
        <!--login-->
        <div class="login">
            <div class="main-agileits">
                <div class="form-w3agile form1">
                    <h3>Créer un compte</h3>
                    <form action="#" method="post">
                        <div class="key">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input type="text" placeholder="Username" name="Username" required="">
                            <div class="clearfix"></div>
                        </div>
                        <div class="key">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <input type="text" placeholder="Email" name="Email" required="">
                            <div class="clearfix"></div>
                        </div>
                        <div class="key">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <input type="text" placeholder="Téléphone" name="tele" required="">
                            <div class="clearfix"></div>
                        </div>
                        <div class="key">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <input type="text" placeholder="Adresse" name="adrs" required="">
                            <div class="clearfix"></div>
                        </div>
                        <div class="key">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <input type="password" placeholder="Mot de passe" name="Password" required="">
                            <div class="clearfix"></div>
                        </div>
                        <input type="submit" value="Créer">
                    </form>
                </div>
            </div>
        </div>
    </div>
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
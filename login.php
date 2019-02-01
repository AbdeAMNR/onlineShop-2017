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
        $userClt = $_POST['userClt'];
        $cltPass = $_POST['cltPass'];
        $hashedPass = sha1($cltPass);
        //check if the user exist
        $stmt = $con->prepare("SELECT * FROM client WHERE email=? AND pass=? LIMIT 1;");
        $stmt->execute(array($userClt, $hashedPass));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();
        if ($count > 0) {
            $_SESSION['userClt'] = $userClt;
            $_SESSION['clientID'] = $row['clientID'];
            //update login time
            $stmt = $con->prepare("UPDATE client SET derniereVisite=now() WHERE clientID= :id ;");
            $stmt->bindParam(':id', $_SESSION['clientID']);
            $stmt->execute();

            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                header('location: index.php');
            }
            exit();
        }
    }
    ?>

    <!--content-->
    <div class="content">
        <!--login-->
        <div class="login">
            <div class="main-agileits">
                <div class="form-w3agile">
                    <h3>S'identifier</h3>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="key">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <input type="text" placeholder="Email" name="userClt" required="">
                            <div class="clearfix"></div>
                        </div>
                        <div class="key">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <input type="password" placeholder="Password" name="cltPass" required="">
                            <div class="clearfix"></div>
                        </div>
                        <input type="submit" value="Connecter">
                    </form>
                </div>
                <div class="forg">
                    <a href="registered.php" class="forg-right">Créer un compte</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--login-->
    </div>
    <!--content-->


    <?php
}
include $tpl . "footer.php";
include $tpl . "copyRights.php";
include $tpl . "popUpModal.php";
ob_end_flush();
?>
</body>
</html>
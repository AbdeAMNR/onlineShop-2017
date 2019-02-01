<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 18-May-17
 * Time: 18:57
 */
session_start();
$pageTitle = 'onlineShop Se connecter';
$noNavBar = '';
if (isset($_SESSION['Username'])) {
    header('location: Accueil.php');
}

include 'init.php'; //Initier routes | DB connection | Header | CSS links

// check if user coming from HTTP post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);
    //check if the user exist
    $stmt = $con->prepare("SELECT fourniID,nomComplet,pass FROM Fournisseur WHERE panelAccess=1 AND nomComplet= ? AND pass=? LIMIT 1");
    $stmt->execute(array($username, $hashedPass));
    $count = $stmt->rowCount();
    $row = $stmt->fetch();
    if ($count > 0) {
        $_SESSION['Username'] = $username;
        $_SESSION['fourniID'] = $row['fourniID'];
        //update login time
        $stmt = $con->prepare("UPDATE fournisseur SET derniereVisite=now() WHERE fourniID= :id ;");
        $stmt->bindParam(':id', $_SESSION['fourniID']);
        $stmt->execute();

        header('location: Accueil.php');
        exit();
    }
}
?>
<body>
<div class="container">
    <div class="wrapper">
        <form class="form-signin form-group-lg" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <h3 class="form-signin-heading">Connectez-vous pour accéder au panneau de controle</h3>
            <hr class="colorgraph">
            <br>
            <input class="form-control" type="text" name="user" placeholder="Nom d'utilisateur" autocomplete="off"
                   required="required" autofocus="autofocus"/>
            <input class="form-control" type="password" name="pass" placeholder="Mot de passe" autocomplete="off"
                   required="required"/>
            <button type="submit" class="btn btn-lg btn-primary btn-block">
                Connexion
                <span class="glyphicon glyphicon-log-in"></span>
            </button>
            <input id="login_lost_btn" type="button" class="btn btn-link" value="Mot de passe oublié?"/>
        </form>
    </div>
</div>


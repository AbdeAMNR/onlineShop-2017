<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 19-May-17
 * Time: 05:49
 */ ?>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Accueil.php"><i class="fa fa-home iconfit"></i>Accueil</a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav">
                <li><a href="produits.php">Produits</a></li>
                <li><a href="Categories.php">Catégories</a></li>
                <li><a href="Fournisseur.php">Fournisseur</a></li>
                <li><a href="Clients.php">Clients</a></li>
                <li><a href="Commands.php">Commands</a></li>
                <li><a href="#">Commentaire</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <a class="navbar-brand" href="/onlineshop/index.php"><i class="fa fa-cart-plus  iconfit"></i>onlineShop</a>

                <li class="dropdown">
                    <a class="profile-down dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false"><?= $_SESSION['Username']; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="Fournisseur.php?do=edit&fID=<?= $_SESSION['fourniID']; ?>"><i
                                        class="fa fa-pencil-square-o iconfit"></i>Modifier le profil</a></li>
                         <li><a href="logout.php"><i class="fa fa-sign-out iconfit"></i>Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
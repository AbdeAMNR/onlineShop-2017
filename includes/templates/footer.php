<!-- footer -->
<div class="footer-w3l">
    <div class="container">
        <div class="footer-grids">
            <div class="col-md-3 footer-grid">
                <h4>À propos </h4>
                <p class="clean-par">Bienvenue sur New Shop, la boutique de vente et d'achat en ligne N°1 au Maroc
                    !.</p>
                <p class="clean-par">Le meilleur des Smartphones, TV, Pc portable et Mode...à portée de clic !</p>
                <p class="clean-par">Des produits de qualité, à bas prix, sélectionnés par New Shop pour vous.</p>
                <div class="social-icon">
                    <a href="https://www.facebook.com/amanar.abderrahim"><i class="icon"></i></a>
                    <a href="https://twitter.com/TGatsia"><i class="icon1"></i></a>
                    <a href="#"><i class="icon2"></i></a>
                    <a href="#"><i class="icon3"></i></a>
                </div>
            </div>
            <div class="col-md-3 footer-grid">
                <h4>My Account</h4>
                <ul>
                    <li><a href="checkout.php">Checkout</a></li>
                    <li><a href="login.php">Contactez Nous</a></li>
                    <li><a href="registered.php"> Créer Un Compte </a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-grid">
                <h4>Information</h4>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="products.php">Produits</a></li>
                    <li><a href="codes.php">Short Codes</a></li>
                    <li><a href="mail.php">Contactez nous</a></li>
                 </ul>
            </div>
            <div class="col-md-3 footer-grid foot">
                <h4>Contacts</h4>
                <ul>
                    <li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i><a href="#">11 Bloc 18 La
                            Resistance 45000 Ouarzazate Morocco</a></li>
                    <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i><a href="#"> +212 (0) 6 213 611
                            89 </a></li>
                    <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a
                                href="mailto:miinotek15@gmail.com"> miinotek15@gmail.com</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</div>
<script>
    function sortProd(sortType) {
        $.ajax({
            type: "POST",
            url: '../../NewShop/includes/sortProd.php',
            data: 'id=' + sortType,
            success: function (data) {
                $('prodList').remove();
                $('body').append(data);
            },
            dataType: 'html',
            error: function () {
                alert("something whent wrong!");
            }
        });

    }
</script>

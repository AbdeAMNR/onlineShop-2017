<html>
<head>
    <meta charset="utf-8"/>
    <title><?= getTitle(); ?></title>
    <!--css-->
    <link rel="stylesheet" href="<?= $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= $css; ?>font-awesome.min.css">
    <link href="<?= $css; ?>style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?= $css; ?>newStyle.css" rel="stylesheet" type="text/css" media="all"/>
    <!--css-->

    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <script src="<?= $js; ?>jquery-3.2.1.min.js"></script>
    <link href='//fonts.googleapis.com/css?family=Cagliostro' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,800italic,800,700italic,700,600italic,600,400italic,300italic,300'
          rel='stylesheet' type='text/css'>
    <!--search jQuery-->
    <script src="<?= $js; ?>main.js"></script>
    <!--search jQuery-->
    <script src="<?= $js; ?>responsiveslides.min.js"></script>
    <script>
        $(function () {
            $("#slider").responsiveSlides({
                auto: true,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                pager: true,
            });
        });
    </script>
    <!--mycart-->
    <script type="text/javascript" src="<?= $js; ?>bootstrap-3.1.1.min.js"></script>
    <!-- cart -->
    <script src="<?= $js; ?>simpleCart.min.js"></script>
    <!-- cart -->
    <!--start-rate-->
    <script src="<?= $js; ?>jstarbox.js"></script>
    <link rel="stylesheet" href="<?= $css; ?>jstarbox.css" type="text/css" media="screen" charset="utf-8"/>
    <script type="text/javascript">
        jQuery(function () {
            jQuery('.starbox').each(function () {
                var starbox = jQuery(this);
                starbox.starbox({
                    average: starbox.attr('data-start-value'),
                    changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
                    ghosting: starbox.hasClass('ghosting'),
                    autoUpdateAverage: starbox.hasClass('autoupdate'),
                    buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
                    stars: starbox.attr('data-star-count') || 5
                }).bind('starbox-value-changed', function (event, value) {
                    if (starbox.hasClass('random')) {
                        var val = Math.random();
                        starbox.next().text(' ' + val);
                        return val;
                    }
                })
            });
        });
    </script>
    <!--//End-rate-->
    <script type="text/javascript" src="<?= $js; ?>frontEnd.js"></script>
    <script type="text/javascript" src="<?= $js; ?>jquery-ui.js"></script>
<?php
if(isset($single)){
    ?>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
     <link href='//fonts.googleapis.com/css?family=Cagliostro' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,800italic,800,700italic,700,600italic,600,400italic,300italic,300' rel='stylesheet' type='text/css'>
    <!--search jQuery-->
     <!--search jQuery-->
     <!-- cart -->
     <!-- cart -->
    <script defer src="<?= $js; ?>jquery.flexslider.js"></script>
    <link rel="stylesheet" href="<?= $css; ?>flexslider.css" type="text/css" media="screen" />
    <script src="<?= $js; ?>imagezoom.js"></script>
    <script>
        // Can also be used with $(document).ready()
        $(window).load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
        });
    </script>

    <!--mycart-->
    <!--start-rate-->
    <script src="<?= $js; ?>jstarbox.js"></script>
    <link rel="stylesheet" href="<?= $css; ?>jstarbox.css" type="text/css" media="screen" charset="utf-8" />
    <script type="text/javascript">
        jQuery(function() {
            jQuery('.starbox').each(function() {
                var starbox = jQuery(this);
                starbox.starbox({
                    average: starbox.attr('data-start-value'),
                    changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
                    ghosting: starbox.hasClass('ghosting'),
                    autoUpdateAverage: starbox.hasClass('autoupdate'),
                    buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
                    stars: starbox.attr('data-star-count') || 5
                }).bind('starbox-value-changed', function(event, value) {
                    if(starbox.hasClass('random')) {
                        var val = Math.random();
                        starbox.next().text(' '+val);
                        return val;
                    }
                })
            });
        });
    </script>
    <!--//End-rate-->
    <link href="<?= $css; ?>owl.carousel.css" rel="stylesheet">
    <script src="<?= $js; ?>owl.carousel.js"></script>
    <script>
        $(document).ready(function() {
            $("#owl-demo").owlCarousel({
                items : 1,
                lazyLoad : true,
                autoPlay : true,
                navigation : false,
                navigationText :  false,
                pagination : true,
            });
        });
    </script>
    <?php
}
?>
</head>
<body>
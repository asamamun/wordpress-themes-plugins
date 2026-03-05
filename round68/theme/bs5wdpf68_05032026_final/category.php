<?php
get_header();
?>
<body <?php body_class(); ?> id="category">
    <div class="container">
        <?php get_template_part("includes/navbar"); ?>
        <!-- carousel -->
         <?php //get_template_part("includes/carousel"); ?>
        <!-- carousel end -->
         <h1>Category Page: <?php single_cat_title(); ?></h1>
        <div class="row">
            <div class="col-md-8">
                <h3>main area</h3>
                <?php
                    get_template_part("includes/loop-category");
                ?>
            </div>
            <div class="col-md-4">
                <h3>sidebar</h3>
                <?php
                    get_sidebar();
                ?>
            </div>
        </div>
    </div>
</body>
<?php
get_footer();
?>

</html>
<?php
get_header();
?>
<body <?php body_class(); ?> id="archive">
    <div class="container">
        <?php get_template_part("includes/navbar"); ?>
        <!-- carousel -->
         <?php //get_template_part("includes/carousel"); ?>
        <!-- carousel end -->
         <h1>Archive page: <?php the_archive_title(); ?></h1>
        <div class="row">
            <div class="col-md-8">
                <h3>main area</h3>
                <?php
                    get_template_part("includes/loop", "archive");
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
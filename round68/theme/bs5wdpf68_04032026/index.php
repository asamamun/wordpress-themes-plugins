<?php
get_header();
?>
<body <?php body_class();?>>
    <div class="container">
        <?php get_template_part("includes/navbar"); ?>
        <!-- carousel -->
         <?php get_template_part("includes/carousel"); ?>
        <!-- carousel end -->
         <div class="row">
             <!-- latest post in owl carousel -->
             <div class="col-md-12 bg-light">
                <?php
                    get_template_part('includes/loop', 'latest');
                ?>
             </div>
            <!-- latest post in owl carousel end -->
         </div>
        <div class="row">
            <div class="col-md-8">
                <h3>Latest Posts</h3>
                <?php
                    get_template_part("includes/loop");
                ?>
            </div>    

            <div class="col-md-4">
                <h3>sidebar</h3>
                <?php
                    get_sidebar();
                ?>
            </div>
        </div>
        <h3>Latest Sports Posts</h3>
        <div class="row">
            <!-- category sports post in owl carousel -->
             <div class="col-md-12 bg-light">
                <?php
                    get_template_part('includes/loop', 'sports');
                ?>
             </div>
            <!-- category sports post in owl carousel end -->
        </div>

    </div>
</body>
<?php
// get_template_part('myfooter');
get_footer();//loads footer.php
?>

</html>
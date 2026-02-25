<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php get_template_part(slug: 'includes/carousel'); ?>
    <h1>welcome to index</h1>
    <h2>you can get any option from option table using get_option('option_name')</h2>
    <?php
    // get an option
$option = get_option('idborg_custom_option');
echo $option['round'] . "<br>";
echo $option['batch'] . "<br>";
echo $option['tsp'] . "<br>";
echo $option['shift'] . "<br>";
echo "<hr>";
$sitename = get_option('blogname');
echo $sitename;
    ?>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
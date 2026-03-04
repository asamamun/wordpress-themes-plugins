<h1>sidebar.php loaded</h1>
<?php
if(is_active_sidebar('sidebar-right')):
    dynamic_sidebar('sidebar-right');
    else:
        echo "no widgets added to sidebar";
    endif;
 ?>
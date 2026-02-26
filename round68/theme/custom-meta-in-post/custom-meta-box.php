<?php

 add_action( 'add_meta_boxes', 'prowp_meta_box_init' ); 
  
 // meta box functions for adding the meta box and saving the data 
 function prowp_meta_box_init() {
   
     // create our custom meta box
     add_meta_box( 'prowp-meta', 'Product Information', 
         'prowp_meta_box', 'post', 'side', 'default' ); 
   
 } 

  function prowp_meta_box( $post, $box ) { 
   
     // retrieve the custom meta box values 
     $prowp_featured = get_post_meta( $post->ID, '_prowp_type', true );
     $prowp_price = get_post_meta( $post->ID, '_prowp_price', true );
   
     //nonce for security
    wp_nonce_field( 'prowp_save_meta_box', 'prowp_save_meta_box' );
   
     // custom meta box form elements
     echo '<p>Price: <input type="text" name="prowp_price"
         value="'.esc_attr( $prowp_price ).'" size="5" /></p>';
     echo '<p>Type: 
         <select name="prowp_product_type" id="prowp_product_type"> 
             <option value="normal" '
                 .selected( $prowp_featured, 'normal', false ). '>Normal
             </option>
             <option value="special" '
                 .selected( $prowp_featured, 'special', false ). '>Special
             </option>
             <option value="featured" '
                 .selected( $prowp_featured, 'featured', false ). '>Featured
</option>
             <option value="clearance" ' 
                 .selected( $prowp_featured, 'clearance', false ). '>Clearance 
             </option>
         </select></p>';
   
 } 


  // hook to save our meta box data when the post is saved 
 add_action( 'save_post', 'prowp_save_meta_box' );
  function prowp_save_meta_box( $post_id ) { 
     // verify post type is 'post' or other appropriate types
     $post_type = get_post_type($post_id);
     if ($post_type !== 'post') {
         return;
     }
     
     // Check if this is an autosave
     if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return;
     }
     
     // Check if our nonce is set and verify it
     if ( ! isset( $_POST['prowp_save_meta_box'] ) || ! wp_verify_nonce( $_POST['prowp_save_meta_box'], 'prowp_save_meta_box' ) ) {
         return;
     }
     
     // Check permissions
     if ( ! current_user_can( 'edit_post', $post_id ) ) {
         return;
     }
     
     // Save the meta box data only if form data is present
     if( isset( $_POST['prowp_product_type'] ) ) {
         $product_type = sanitize_text_field( $_POST['prowp_product_type'] );
         update_post_meta( $post_id, '_prowp_type', $product_type ); 
     }
     
     if( isset( $_POST['prowp_price'] ) ) {
         $price = sanitize_text_field( $_POST['prowp_price'] );
         update_post_meta( $post_id, '_prowp_price', $price );
     }
     } 
?>
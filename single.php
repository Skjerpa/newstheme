<?php

//add a image full-width on home or front-page
add_action( 'beans_post_body', 'beans_child_show_products' );
function beans_child_show_products() {
    ?>


    <div class="products">
      <?php if( have_rows('product') ): ?>


      	<?php while( have_rows('product') ): the_row();

      		// vars
      		$product_name = get_sub_field('product_name');
      		$product_text = get_sub_field('product_text');
          $product_image = get_sub_field('product_image');
          $product_tag = get_sub_field('product_win');

      		?>
          <div class="proudct uk-margin-large-bottom" data-uk-scrollspy="{cls:'uk-animation-fade'}">

            <figure class="uk-overlay">
                <img src="<?php echo $product_image; ?>" width="" height="" alt="">
                <figcaption class="uk-overlay-panel uk-flex uk-flex-top product_tag"> <?php echo $product_tag; ?></figcaption>
                </figure>

            <h2 class="uk-article-title"><?php echo $product_name; ?></h2>

      		    <?php echo $product_text; ?>



              <button class="uk-button uk-width-1-1 buy-button">Kjøp nå</button>

          </div>

          <hr class="uk-article-divider">


      	<?php endwhile; ?>


      <?php endif; ?>

    </div>

    <?php
}

// // Force layout.
// add_filter( 'beans_layout', 'example_force_layout' );
//
// function example_force_layout() {
//
//     return 'c';
//
// }

// Move the post image above the post title.
beans_modify_action_hook( 'beans_post_image', 'beans_post_title_before_markup' );





// Load Beans document.
beans_load_document();

?>

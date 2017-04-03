<?php

//Get products from ACF
add_action( 'beans_post_after_markup', 'beans_child_show_products' );
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
          $product_price = get_sub_field('product_price');
          $product_link = get_sub_field('product_link');
          $button_text = get_sub_field('button_text');
          $product_lead_text = get_sub_field('product_lead_text')

        ?>

          <div class="product uk-margin-large-bottom" data-uk-scrollspy="{cls:'uk-animation-fade'}">
            <h3>Testvinner</h3>
              <figure class="uk-overlay">
                <img src="<?php echo $product_image; ?>" width="" height="" alt="">
                <figcaption class="uk-overlay-panel uk-flex uk-flex-top">
                  <span class="uk-badge product_tag"><?php echo $product_tag; ?></span>
                </figcaption>

            </figure>
            <div class="product-content">
            <h2 class="uk-article-title"><?php echo $product_name; ?></h2>
            <span class="uk-article-lead product_lead_text"><?php echo $product_lead_text; ?></span>

      		    <?php echo $product_text; ?>

              <dl class="uk-description-list-horizontal">
                  <dt>Pris fra</dt>
                  <dd><?php echo $product_price; ?></dd>
              </dl>
              <a class="uk-button uk-width-1-1 buy-button" href="<?php echo $product_link; ?>"><?php echo $button_text; ?></a>
            </div>
          </div>
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

// Remove the post meta categories.
beans_remove_action( 'beans_post_meta_categories' );
beans_remove_action('beans_post_navigation');



// Load Beans document.
beans_load_document();

?>

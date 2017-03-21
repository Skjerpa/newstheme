@@ -1,77 +0,0 @@
<?php



//Make latest post larger to Home Page
function archive_card () {

{

    $query = new WP_Query( array(
        'paged' => get_query_var( 'paged' ),
        'nopaging' => false,
        'posts_per_page' => 5
    ) );

    ?>

                <?php if ( $query->have_posts() ) : ?>

                    <?php while ( $query->have_posts() ) : $query->the_post();

                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
                    $resized_src = beans_edit_image( $thumb_url_array[0], array(
                      'resize' => array( 1600, 540, true )
                    ) );
                    $categories_list = get_the_category_list( esc_html_x( ', ', 'category separator', 'sps' ) );

                    ?>

                    <div class="uk-grid egenklasse">
                      <div class="uk-width-medium-1-2 venstre">
                        <picture><img src="<?php echo $resized_src; ?>" alt="<?php esc_html( get_the_title() );?>"></picture>
                      </div>
                      <div class="uk-width-medium-1-2 høyre">
                        <h1 class="uk-article-title" itemprop="headline"><a href="<?php the_permalink();?>" title="<?php esc_html( the_title() );?>"><?php the_title(); ?></a></h2>
                        <p class="uk-hidden-small"><?php the_excerpt(); ?></p>
                      </div>

                    </div>
                    <?php endwhile; ?>

                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

    <?php
}
}


add_action( 'beans_content_prepend_markup', 'archive_card' );


//Move post image above title
beans_modify_action_hook( 'beans_post_image', 'beans_post_title_before_markup' );

// Force layout c - no sidebars
add_filter( 'beans_layout', 'example_force_layout' );

function example_force_layout() {

    return 'c';

}
//Remove padding above first post
beans_add_attribute('beans_main', 'class', 'uk-padding-top-remove');
beans_add_attribute('beans_post_body', 'class', 'article-content');
beans_add_attribute('beans_post_title', 'class', 'article-header');


// Remove the post meta.
beans_remove_action( 'beans_post_meta' );
// Load Beans document.
beans_load_document();

?>

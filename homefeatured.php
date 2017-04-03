//Make latest post larger to Home Page
function home_featured_first_post () {

{

    $query = new WP_Query( array(
        'paged' => get_query_var( 'paged' ),
        'nopaging' => false,
        'posts_per_page' => 1
    ) );
  ?>

    <div class="uk-grid">

                <?php if ( $query->have_posts() ) : ?>

                    <?php while ( $query->have_posts() ) : $query->the_post();

                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
                    $resized_src = beans_edit_image( $thumb_url_array[0], array(
                      'resize' => array( 1200, 600, true )
                    ) );
                    $categories_list = wp_get_post_categories();

                    ?>

                          <div class="uk-width-3-4">
                            <article class="first-article uk-article">
                              <figure class="uk-overlay article-image">
                                <a href="<?php the_permalink();?>" rel="bookmark" title="<?php esc_html( get_the_title() );?>">
                                    <picture><img src="<?php echo $resized_src; ?>" alt="<?php esc_html( get_the_title() );?>"></picture>
                                </a>
                                <figcaption class="uk-overlay-panel uk-overlay-bottom uk-padding-remove card-tags">
                                  <span class="uk-badge card-category "><?php echo $categories_list; ?></span>
                                </figcaption>
                              </figure>
                              <div class="article-content">
                                    <h1 class="uk-article-title" itemprop="headline"><a href="<?php the_permalink();?>" title="<?php esc_html( the_title() );?>"><?php the_title(); ?></a></h2>
                                    <p class="uk-hidden-small"><?php the_excerpt(); ?></p>
                              </div>
                            </article>
                              </div>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

                <div class="uk-width-1-4">
                <?php  echo beans_widget_area( 'top-area' ); ?>

                </div>

</div>

    <?php
}
}

add_action( 'beans_content_prepend_markup', 'home_featured_first_post' );

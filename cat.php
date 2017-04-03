<?php
$categories = wp_get_post_categories();

foreach ( $categories as $category ) {
printf( '<a class="category-list-item" href="%1$s">%2$s</a>',
esc_url( get_category_link( $category->term_id ) ),
esc_html( $category->name )
);
}
?>

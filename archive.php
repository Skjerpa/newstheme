<?php



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

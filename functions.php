<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

/*
 * Remove this action and callback function if you do not whish to use LESS to style your site or overwrite UIkit variables.
 * If you are using LESS, make sure to enable development mode via the Admin->Appearance->Settings option. LESS will then be processed on the fly.
 */
add_action( 'beans_uikit_enqueue_scripts', 'beans_child_enqueue_uikit_assets' );

function beans_child_enqueue_uikit_assets() {

	beans_compiler_add_fragment( 'uikit', get_stylesheet_directory_uri() . '/style.less', 'less' );

}

//Load UiKit components
add_action( 'beans_uikit_enqueue_scripts', 'load_uikit_components' );

function load_uikit_components() {

	beans_uikit_enqueue_components( array( 'flex', 'overlay' ) );
	beans_uikit_enqueue_components( array( 'tooltip' ), 'add-ons' );
	beans_uikit_enqueue_components( array( 'scrollspy' ), 'core' );
}

// Remove this action and callback function if you are not adding CSS in the style.css file.
add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );

function beans_child_enqueue_assets() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

}


//Replace content with Excerpt

add_filter( 'the_content', 'beans_child_modify_post_content' );

function beans_child_modify_post_content( $content ) {

    // Stop here if we are on a single view.
    if ( is_singular() )
        return $content;

    // Return the excerpt() if it exists other truncate.
    if ( has_excerpt() )
        $content = '<p>' . get_the_excerpt() . '</p>';
    else
        $content = '<p>' . wp_trim_words( get_the_content(), 30, '...' ) . '</p>';

    // Return content and readmore.
    return $content . '<p>' . beans_post_more_link() . '</p>';

}




// Enqueue the UIkit dynamic grid component.
add_action( 'beans_uikit_enqueue_scripts', 'example_enqueue_grid_uikit_assets' );

function example_enqueue_grid_uikit_assets() {

	// Only apply to non singular view.
	if ( !is_singular() ) {
		beans_uikit_enqueue_components( array( 'grid' ), 'add-ons' );
	}

}


// Display posts in a responsive dynamic grid.
add_action( 'wp', 'home_posts_grid' );

function home_posts_grid() {

	// Only apply to non singular view.
	if ( !is_singular() ) {

		// Add grid.
		beans_wrap_inner_markup( 'beans_content', 'beans_child_posts_grid', 'div', array(
			'data-uk-grid' => '{gutter: 20}'
		) );
		beans_wrap_markup( 'beans_post', 'beans_child_post_grid_column', 'div', array(
			'class' => 'uk-width-large-1-2 uk-width-medium-1-2'
		) );

		// Move the posts pagination after the new grid markup.
		beans_modify_action_hook( 'beans_posts_pagination', 'beans_child_posts_grid_after_markup' );

	}

}

//Add Class Uk-Overlay to containing element
beans_add_attribute( 'beans_post_image_item_wrap', 'class', 'uk-overlay' );



//Add Google Fonts
add_action( 'beans_head', 'load_external_script');
function load_external_script() {

?>
<link href="https://fonts.googleapis.com/css?family=Lato|Montserrat:400,700" rel="stylesheet">
<?php
}

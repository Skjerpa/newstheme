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
	beans_uikit_enqueue_components( array( 'sticky' ), 'add-ons' );
	beans_uikit_enqueue_components( array( 'scrollspy' ), 'core' );
	beans_uikit_enqueue_components( array( 'table' ), 'core' );
	beans_uikit_enqueue_components( array( 'description-list' ), 'core' );
	beans_uikit_enqueue_components( array( 'article' ), 'core' );
}

// Enqueue the UIkit dynamic grid component.
add_action( 'beans_uikit_enqueue_scripts', 'example_enqueue_grid_uikit_assets' );

function example_enqueue_grid_uikit_assets() {

	// Only apply to non singular view.
	if ( !is_singular() ) {
		beans_uikit_enqueue_components( array( 'grid' ), 'add-ons' );
	}

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


// Display posts in a responsive dynamic grid.
add_action( 'wp', 'example_posts_grid' );
/**
 * Display posts in a responsive grid.
 */
function example_posts_grid() {
    // Only apply to homepage
    if ( is_home() ) {
        // Add grid.
        beans_wrap_inner_markup( 'beans_content', 'example_posts_grid', 'div', array(
            'class'               => 'uk-grid uk-grid-match',
            'data-uk-grid-margin' => '',
        ) );
        beans_wrap_markup( 'beans_post', 'example_post_grid_column', 'div' );

        // Move the posts pagination after the new grid markup.
        beans_modify_action_hook( 'beans_posts_pagination', 'example_posts_grid_after_markup' );
    }
}

add_filter( 'example_post_grid_column_attributes', 'example_post_grid_column_attributes' );
/**
 * Add post grid columns adaptive class.
 *
 * @param array $attributes Array of post grid column HTML attributes.
 *
 * @return array Array of post grid column HTML attributes.
 */
function example_post_grid_column_attributes( $attributes ) {
    static $index = 0;

    // Add space after current class if it exists.
    $attributes['class'] = isset( $attributes['class'] ) ? $attributes['class'] . ' ' : null;

    // Add adaptive grid class.
    $columns = ( 0 === $index % 5 ) ? '2-3' : '1-3';
    $attributes['class'] .= "uk-width-large-{$columns} uk-width-medium-1-1";

    // Bump post index.
    $index++;

    return $attributes;
}



// Remove primary menu and permanently enable offcanvas.
beans_remove_action( 'beans_primary_menu' );
beans_modify_action_hook( 'beans_primary_menu_offcanvas_button', 'beans_header' );
beans_replace_attribute( 'beans_primary_menu_offcanvas_button', 'class', 'uk-hidden-large', 'uk-float-right' );

//Remove default output on Tags
beans_remove_output('beans_post_meta_tags_prefix');
beans_add_attribute('beans_post_meta_tags', 'class', 'nt-tags');

beans_remove_action('beans_post_meta_categories');




//registering Widget areas
add_action( 'widgets_init', 'Header_widget_area' );
function Header_widget_area() {
 beans_register_widget_area( array(
    'name' => 'Below Header',
    'id' => 'below-header',
    'description' => 'Header Widget',
    'beans_type' => 'stack',

 ) );
}

add_action( 'widgets_init', 'top_widget_area' );
function top_widget_area() {
 beans_register_widget_area( array(
    'name' => 'Next to featured article',
    'id' => 'top-area',
    'description' => 'Top Widget Area',
    'beans_type' => 'stack',

 ) );
}

//Echo Below Header Widget Area
add_action( 'beans_header_append_markup', 'below_header_widget_area' );

function below_header_widget_area() {
    echo beans_widget_area( 'below-header' );
}

//Remove padding above first post
beans_add_attribute('beans_post_body', 'class', 'article-content');
beans_add_attribute('beans_post_title', 'class', 'article-header');

beans_add_attribute('beans_post_image', 'class', 'uk-overlay');

add_action('beans_post_image_append_markup','add_card_badge');

function add_card_badge() {
	?>
	<figcaption class="uk-overlay-panel uk-overlay-bottom uk-padding-remove card-tags">
		<span class="uk-badge card-category "><?php beans_post_meta_categories(); ?></span>
	</figcaption>
	<?php
}


// 10 Adding a Footer Bottom Area for all pages
// 10.1

beans_modify_action_callback( 'beans_footer_partial_template', 'example_footer' );

function example_footer() {
?>


<footer class="tm-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
<div class="top-footer">
	<div class="uk-container uk-container-center">
		<div class="uk-text-center newsletter-signup">
			<h3 class="uk-contrast uk-align-center newsletter-signup-header">Meld deg på vårt nyhetsbrev og få informasjon når vi publiserer nye tester</h3>
			<input type="text" placeholder="Din E-Post" class="uk-form-large uk-width-4-6" id="newsletter-signup-form">
			<button class="uk-button">Subscribe</button>
		</div>
		</div>
</div>
<div class="main-footer">
	<div class="uk-container">
		<div class="uk-grid">
		<div class="uk-width-1-3">
			<h5 class="footer-heading">Følg oss på Facebook</h5>
			<p>Vi publiserer alle nye tester via vår Facebookside. Følg oss for å holde deg oppdatert på nye tester.</p>
		</div>
		<div class="uk-width-1-3">
			<h5 class="footer-heading">Populære tester</h5>
			<ul class="uk-list">
<?php
global $post;
$args = array( 'posts_per_page' => 5, 'orderby' => 'rand' );
$rand_posts = get_posts( $args );
foreach ( $rand_posts as $post ) :
  setup_postdata( $post ); ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach;
wp_reset_postdata(); ?>
</ul>
		</div>
		<div class="uk-width-1-3">
			<h5 class="footer-heading">Kategorier</h5>
			 <?php
			 $categories = get_categories( array(
 'orderby' => 'name',
 'parent'  => 0
) );

foreach ( $categories as $category ) {
 printf( '<a class="category-list-item" href="%1$s">%2$s</a>',
		 esc_url( get_category_link( $category->term_id ) ),
		 esc_html( $category->name )
 );
}
			 ?>
			 <h5 class="footer-heading">Hashtags</h5>

			 <?php
			 if(get_the_tag_list()) {
			     echo get_the_tag_list('<ul class="tag-list"><li class="tag">','</li><li class="tag">','</li></ul>');
			 }
			 ?>
		</div>

	</div>
	</div>
	</div>

<div class="bottom-footer">
	<div class="uk-width-1-2 uk-container-center">
		<div class="uk-text-center">
			<svg width="68" height="81" viewBox="0 0 68 81" xmlns="http://www.w3.org/2000/svg">
  <title>
    Group 2
  </title>
  <g fill="#76C5BD" fill-rule="evenodd">
    <path d="M65.3.5H2.8c-1 0-2 1-2 2v20c0 1.2 1 2 2 2h7c.7 0 1.4-.4 1.7-1v-.6l2.5-9h40l2.5 9v.4c.4.7 1 1.2 2 1.2h6.8c1 0 2-1 2-2v-20c0-1.2-1-2-2-2M52 70h-.2l-9-2.8v-39c0-1-.7-2-1.8-2H27.7c-.7 0-1 .3-1.2.5L15.3 38c-.4.4-.6 1-.6 1.4 0 1 1 2 2 2h8.5v25.8l-8.8 3c-1 0-1.6 1-1.6 1.8v6c0 1 1 2 2 2h34.6c1 0 2-1 2-2v-6c0-1-.6-1.7-1.5-2"/>
  </g>
</svg>
			<h5>Best-i-test.net eies og drifes av Netpixelmedia AS</h5>
			<?php wp_nav_menu( array( 'theme_location' => 'bottom_footer_menu' ) ); ?>
		</div>
		</div>
	</div>

</footer>

<?php
}

// Register secondary menu.
add_action( 'after_setup_theme', 'footer_register_menu' );
function footer_register_menu() {
    register_nav_menus( array(
        'bottom_footer_menu' => __( 'Bottom Footer Menu', 'tm-beans' ),
    ) );
}






//Add Google Fonts
add_action( 'beans_head', 'load_external_script');
function load_external_script() {

?>
<link href="https://fonts.googleapis.com/css?family=Lato|Montserrat:400,700" rel="stylesheet">
<?php
}

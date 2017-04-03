<?php

// 10 Adding a Footer Bottom Area for all pages
// 10.1

beans_modify_action_callback( 'beans_footer_partial_template', 'example_footer' );

function example_footer() {
    // Replace footer the footer structural markup.
?>


<footer class="tm-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
<div class="top-footer">
	<div class="uk-container uk-container-center">
		<div class="uk-text-center newsletter-signup">
			<h3 class="uk-contrast uk-align-center newsletter-signup-header">Meld deg på vårt nyhetsbrev og få informasjon når vi publiserer nye tester</h3>
			<input type="text" placeholder="Din E-Post" class="uk-form-large uk-width-1-2" id="newsletter-signup-form">
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

</div>
<div class="bottom-footer">
	<div class="uk-container">
		<div class="uk-grid-width-1-2 uk-container-center">
			<h5>Best-i-test.net eies og driftes av Netpixelmedia AS</h5>
			<?php wp_nav_menu( array( 'items_wrap' => '%3$s', 'menu' => 'bottom_footer_menu' ) ); ?>
		</div>
	</div>

</div>
</footer>

<?php
}

// Load Beans document.
beans_load_document();

?>

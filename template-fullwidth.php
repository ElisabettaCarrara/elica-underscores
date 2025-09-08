<?php
/**
 * Template Name: Full Width
 * Description: A full-width page template that displays no sidebar. Consistent with the starter Elica Underscores style.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elica_Underscores
 */

get_header();
?>

<main id="primary" class="site-main site-main--fullwidth">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'page' );

		// Load comments template if comments are open or at least one comment exists.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	endwhile; // End of the loop.
	?>
</main><!-- #primary -->

<?php
get_footer();

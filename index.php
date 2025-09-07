<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elica_Underscores
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		// Display a hidden header for screen readers if on the blog posts index but not the front page.
		if ( is_home() && ! is_front_page() ) :
			?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
			<?php
		endif;

		// Start the Loop.
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Type-specific template for content.
			 * To override in a child theme, create a file named content-{post_type}.php.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		endwhile;

		// Display navigation to next/previous set of posts.
		the_posts_navigation();

	else :

		// If no content, include the "No posts found" template.
		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();

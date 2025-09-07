<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Elica_Underscores
 */

get_header();
?>
<main id="primary" class="site-main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can’t be found.', 'elica-underscores' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'elica-underscores' ); ?></p>
			<?php
			// Show search form.
			get_search_form();

			// Show recent posts widget if it exists.
			if ( class_exists( 'WP_Widget_Recent_Posts' ) ) {
				the_widget( 'WP_Widget_Recent_Posts', array(), array( 'before_title' => '<h2 class="widget-title">', 'after_title' => '</h2>' ) );
			}
			?>

			<div class="widget widget_categories">
				<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'elica-underscores' ); ?></h2>
				<ul>
					<?php
					wp_list_categories(
						array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 10,
						)
					);
					?>
				</ul>
			</div><!-- .widget -->

			<?php
			// Archive widget.
			if ( class_exists( 'WP_Widget_Archives' ) ) {
				$archive_content = '<p>' . sprintf(
					esc_html__( 'Try looking in the monthly archives. %1$s', 'elica-underscores' ),
					convert_smilies( ':)' )
				) . '</p>';
				the_widget( 'WP_Widget_Archives', array( 'dropdown' => 1 ), array( 'after_title' => '</h2>' . $archive_content ) );
			}

			// Tag cloud widget.
			if ( class_exists( 'WP_Widget_Tag_Cloud' ) ) {
				the_widget( 'WP_Widget_Tag_Cloud' );
			}
			?>
		</div><!-- .page-content -->

	</section><!-- .error-404 -->
</main><!-- #main -->
<?php
get_footer();

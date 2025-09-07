<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Elica_Underscores
 */
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( 'https://wordpress.org/' ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf(
					esc_html__( 'Proudly powered by %s', 'elica-underscores' ),
					'WordPress'
				);
				?>
			</a>
			<span class="sep"> | </span>
			<?php
			/* translators: 1: Theme name, 2: Theme author with link. */
			printf(
				esc_html__( 'Theme: %1$s by %2$s.', 'elica-underscores' ),
				'elica-underscores',
				'<a href="https://elica-webservices.it/" rel="nofollow noopener noreferrer" target="_blank">' . esc_html__( 'Elisabetta Carrara', 'elica-underscores' ) . '</a>'
			);
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

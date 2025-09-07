<?php
/**
 * The template for displaying comments
 *
 * This template displays the current comments and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elica_Underscores
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we return early without loading comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// Check if there are comments to display.
	if ( have_comments() ) :
		$elica_underscores_comment_count = get_comments_number();
		?>
		<h2 class="comments-title">
			<?php
			if ( 1 === $elica_underscores_comment_count ) {
				printf(
					/* translators: 1: Post title */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'elica-underscores' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: Number of comments, 2: Post title */
					esc_html(
						_nx(
							'%1$s thought on &ldquo;%2$s&rdquo;',
							'%1$s thoughts on &ldquo;%2$s&rdquo;',
							$elica_underscores_comment_count,
							'comments title',
							'elica-underscores'
						)
					),
					number_format_i18n( $elica_underscores_comment_count ), // Escaped by esc_html() above.
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size'=> 48,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

		<?php
		// If comments are closed, but there are comments, display a notice.
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'elica-underscores' ); ?></p>
			<?php
		endif;

	endif; // End have_comments() check.

	// Display the comment form.
	comment_form();
	?>

</div><!-- #comments -->

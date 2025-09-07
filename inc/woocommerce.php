<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Elica_Underscores
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function elica_underscores_woocommerce_setup() : void {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'elica_underscores_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function elica_underscores_woocommerce_scripts() : void {
	wp_enqueue_style(
		'elica-underscores-woocommerce-style',
		get_template_directory_uri() . '/woocommerce.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
		font-family: "star";
		src: url("' . esc_url( $font_path . 'star.eot' ) . '");
		src: url("' . esc_url( $font_path . 'star.eot?#iefix' ) . '") format("embedded-opentype"),
			url("' . esc_url( $font_path . 'star.woff' ) . '") format("woff"),
			url("' . esc_url( $font_path . 'star.ttf' ) . '") format("truetype"),
			url("' . esc_url( $font_path . 'star.svg#star' ) . '") format("svg");
		font-weight: normal;
		font-style: normal;
	}';

	wp_add_inline_style( 'elica-underscores-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'elica_underscores_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueuing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 * @return array Modified classes.
 */
function elica_underscores_woocommerce_active_body_class( array $classes ) : array {
	$classes[] = 'woocommerce-active';
	return $classes;
}
add_filter( 'body_class', 'elica_underscores_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args Related products args.
 * @return array Modified args.
 */
function elica_underscores_woocommerce_related_products_args( array $args ) : array {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);
	return wp_parse_args( $defaults, $args );
}
add_filter( 'woocommerce_output_related_products_args', 'elica_underscores_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'elica_underscores_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers matching the theme markup.
	 *
	 * @return void
	 */
	function elica_underscores_woocommerce_wrapper_before() : void {
		?>
		<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'elica_underscores_woocommerce_wrapper_before' );

if ( ! function_exists( 'elica_underscores_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function elica_underscores_woocommerce_wrapper_after() : void {
		?>
		</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'elica_underscores_woocommerce_wrapper_after' );

/**
 * Cart Fragments.
 *
 * Ensure cart contents update when products are added via AJAX.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Modified fragments.
 */
if ( ! function_exists( 'elica_underscores_woocommerce_cart_link_fragment' ) ) {
	function elica_underscores_woocommerce_cart_link_fragment( array $fragments ) : array {
		ob_start();
		elica_underscores_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'elica_underscores_woocommerce_cart_link_fragment' );

/**
 * Cart Link.
 *
 * Display a link to the cart, including number of items and total.
 *
 * @return void
 */
if ( ! function_exists( 'elica_underscores_woocommerce_cart_link' ) ) {
	function elica_underscores_woocommerce_cart_link() : void {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'elica-underscores' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'elica-underscores' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
			<span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

/**
 * Display Header Cart.
 *
 * @return void
 */
if ( ! function_exists( 'elica_underscores_woocommerce_header_cart' ) ) {
	function elica_underscores_woocommerce_header_cart() : void {
		$class = is_cart() ? 'current-menu-item' : '';
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php elica_underscores_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				the_widget(
					'WC_Widget_Cart',
					array(
						'title' => '',
					)
				);
				?>
			</li>
		</ul>
		<?php
	}
}

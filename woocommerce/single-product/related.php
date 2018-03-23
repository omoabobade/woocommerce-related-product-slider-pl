<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
<?php
if ( $related_products ) : ?>
	<div class="related-products clearfix" >
			<?php woocommerce_product_loop_start(); ?>
			<div class="products row inline-row relatedproducts"  data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'>
			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				 	$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					//wc_get_template_part( 'content', 'product' ); 
					global $product, $woocommerce_loop;
					if ( empty( $product ) || ! $product->is_visible() ) {
						return;
					}
				?>
				<div>
					<div class="product-inner centered-box">

						<?php do_action('woocommerce_before_shop_loop_item'); ?>

						<a href="<?php the_permalink(); ?>" class="product-image">
							<div class="product-labels"><?php do_action('woocommerce_shop_loop_item_labels'); ?></div>
							<span class="product-image-inner"><?php do_action('woocommerce_shop_loop_item_image'); ?></span>
						</a>

						<div class="product-info clearfix">
							<?php do_action('woocommerce_before_shop_loop_item_title'); ?>
							<div class="product-title title-h6"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<?php do_action('woocommerce_after_shop_loop_item_title'); ?>
						</div>


					</div>
				</div>
			<?php endforeach; ?>
			</div>
		<?php woocommerce_product_loop_end(); ?>

	</div>
<?php endif;

wp_reset_postdata();
?>
<style>
.slick-prev:hover, .slick-next:hover {
	background:#ccc;
}
.slick-prev, .slick-next {
	-webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	background:#ccc;
}
.slick-slide {
	margin:0 10px;
}
@media only screen and (max-width: 480px) {
	.products .product-inner{
			width:80%;
			margin:0 auto;
	}
}
</style>
<script type="text/javascript">
jQuery('.relatedproducts').slick(
	{
		responsive: [{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	}
)
</script>

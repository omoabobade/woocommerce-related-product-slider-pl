<?php
/*
 * Plugin Name: Woocommerce Single Product Page Related Product
 * Plugin URI: https://github.com/omoabobade/woocommerce-related-product-slider-pl. This is a lighter version of the best WooCommerce extension boilerplate you will ever n
 * Description: eed to develop extensions for WooCommerce.
 * Version: 1.0.0
 * Author: Kolawole Abobade
 * Author URI: http://www.kolawoleabobade.info
 * Author Email: info@kolawoleabobade.info
 * Requires at least: 3.8
 * Tested up to: 4.0
 * Text Domain: woocommerce-related-product-slider-pl
 * Domain Path: languages
 * Network: false
 * GitHub Plugin URI: https://github.com/omoabobade/woocommerce-related-product-slider-pl
 *
 * WooCommerce Extension Boilerplate Lite is distributed under the terms of the 
 * GNU General Public License as published by the Free Software Foundation, 
 * either version 2 of the License, or any later version.
 *
 * WooCommerce Extension Boilerplate Lite is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WooCommerce Extension Boilerplate Lite. If not, see <http://www.gnu.org/licenses/>.
 *
 * 
 * @package WC_Extend_Woocommerce_Related_Product_Slider_Pl
 * @author Kolawole Abobade
 * @category Core
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! function_exists( 'woocommerce_output_related_products' ) ) {

	/**
	 * Output the related products.
	 */
	function woocommerce_output_related_products() {

		$args = array(
			'posts_per_page' => 4,
			'columns'        => 4,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
		);

		woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
	}
}

if ( ! function_exists( 'woocommerce_related_products' ) ) {

	/**
	 * Output the related products.
	 *
	 * @param array $args Provided arguments.
	 */
	function woocommerce_related_products( $args = array() ) {
		
		global $product;

		if ( ! $product ) {
			return;
		}

		$defaults = array(
			'posts_per_page' => 4,
			'columns'        => 4,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
			'order'          => 'desc',
		);

		$args = wp_parse_args( $args, $defaults );

		// Get visible related products then sort them at random.
		$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

		// Handle orderby.
		$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

		// Set global loop values.
		wc_set_loop_prop( 'name', 'related' );
		wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
		wc_get_template( 'single-product/related.php', $args );
	}

}
	// Locate the template in a plugin
function myplugin_woocommerce_locate_template( $template, $template_name, $template_path ) {

    $_template = $template;

    if ( ! $template_path ) {
        $template_path = WC()->template_path();
    }

    $plugin_path = myplugin_plugin_path() . '/woocommerce/';
	
    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name
        )
    );
	
    // Modification: Get the template from this plugin, if it exists
    if (file_exists( $plugin_path . $template_name ) ) {
        $template = $plugin_path . $template_name;
    }
    // Use default template
    if ( ! $template ) {
        $template = $_template;
    }

    return $template;
}
add_filter( 'woocommerce_locate_template', 'myplugin_woocommerce_locate_template', 10, 3 );

// Helper to get the plugin's path on the server
function myplugin_plugin_path() {
    // gets the absolute path to this plugin directory
    return untrailingslashit( plugin_dir_path( __FILE__ ) );
}

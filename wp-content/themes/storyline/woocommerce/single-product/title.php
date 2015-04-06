<?php
/*
* Theme Name: Storyline Board Theme
*
* Description: Storyline Board Theme is a stand-out-of-the-crowd product, 
* a perfect board to display your creative work or just amaze your friends
* with a new generation blog.
*
* Version: 1.1 
*/

/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post_showtitle, $post_ribbon_display;
if($post_showtitle != 'hide' && $post_ribbon_display != "title" ){?>             	
		<h1 class="content-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h1><?php
	
};
?>


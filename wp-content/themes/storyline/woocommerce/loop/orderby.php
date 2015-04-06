<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce, $wp_query, $post_color;

if ( 0 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;

if(of_get_option('scroll-widget') == "off" )
	return; 	

?>
<!--<form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' === $key || 'submit' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>-->

<section>  
    <div class="layer" data-depth="1">
<div class="ss-row <?php echo of_get_option('scroll-widget-color','turquoise')?>  go-anim">
	<div class="ss-full woo">
    
	<div class="ribbon ribbon-title">
        <h2><a href="#"><?php
					$paged    = max( 1, $wp_query->get( 'paged' ) );
					$per_page = $wp_query->get( 'posts_per_page' );
					$total    = $wp_query->found_posts;
					$first    = ( $per_page * $paged ) - $per_page + 1;
					$last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
					if ( 1 == $total ) {
						_e( 'Showing the single result', 'woocommerce' );
					} elseif ( $total <= $per_page ) {
						printf( __( 'Showing all %d results', 'woocommerce' ), $total );
					} else {
						printf( _x( 'Showing %1$d–%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
					}?></a></h2>
    </div>
    
    <div class="container-border">
 
    	<div class="gray-container">
           <div class="nano">
    <div class="cscrol content">
        	 <div class="addpadding" style="padding-right:24px;">
             
          			
                   <!-- <h3 class="p-top wootitle">Search<?php the_widget('WC_Widget_Product_Search', $instance, $args); ?></h3>-->
                     <h3 class="p-top wootitle">Sort by:</h3>	
				<form class="woocommerce-ordering selectora p-top " method="get" style="padding-bottom:10px;">
                
					<select name="orderby" class="orderby">
						<?php
							$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
								'menu_order' => __( 'Default sorting', 'woocommerce' ),
								'popularity' => __( 'Sort by popularity', 'woocommerce' ),
								'rating'     => __( 'Sort by average rating', 'woocommerce' ),
								'date'       => __( 'Sort by newness', 'woocommerce' ),
								'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
								'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
							) );
				
							if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
								unset( $catalog_orderby['rating'] );
				
							foreach ( $catalog_orderby as $id => $name ){
					
								echo '<option value="' . esc_attr( $id ) . '" ' . selected( $orderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
								
							}
						?>
					</select>
				   <!-- <span><?php echo $namec; ?></span>-->
					<?php
						// Keep query string vars intact
						foreach ( $_GET as $key => $val ) {
                            if ( 'orderby' === $key || 'submit' === $key ) {
                                continue;
                            }
                            if ( is_array( $val ) ) {
                                foreach( $val as $innerVal ) {
                                    echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
                                }
                            } else {
                                echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
                            }
                        }
					?>
				   
				</form>
                
                
                <?php if ( is_active_sidebar('homepage-sidebar') ) {?>

                <p class="woocommerce-result-count">                  
                    <div class="woo-widgets">
                    	<?php dynamic_sidebar ('homepage-sidebar'); ?>
                    </div>
            	</p>
<?php 
}?> 
			</div>
            </div>
            </div>
            <div class="icon-soc-container">
                <div class="share-btns"></div>   
            </div>

        </div>
    </div>
</div>
</div>
 <script>
jQuery(document).ready(function ($) {
	//Custom scroll
	//==================================================
	$(".selectora select").msDropDown();
	$("#dropdown_product_cat").msDropDown();
	
	scrollrefresh = function(){
		
		$(".nano").nanoScroller({ alwaysVisible: true, iOSNativeScrolling: false});
		$('.slider').addClass("<?php echo of_get_option('scroll-widget-color','turquoise')?>");
	}
	setInterval("scrollrefresh()",550);
});
</script>
    </div>
</section>

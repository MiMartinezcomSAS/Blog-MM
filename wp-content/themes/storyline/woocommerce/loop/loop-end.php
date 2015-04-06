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
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce, $wp_query, $post_color;?>
</article>

	<div  class="animated numpostinfi <?php if(of_get_option('pagination-display') == "pagination"){?>bottom-nav-hide<?php }?>"><?php 
		if ( is_home()  ){?>
       		<div class="numpostcontent"><?php
				echo $wp_query->found_posts.' '.$tr_home_info; ?>
            </div><?php
 		}else if(is_search()){?>
       		<div class="numpostcontent"><?php
				echo $wp_query->found_posts.' '.$tr_search_info; ?>
            </div><?php
		}else if(is_archive()){?>
        <div class="numpostcontent">
        <?php
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
					}?>
                    </div>
                    
       		<?php
		
		}?>
	</div>
    
    <?php 
	
	if(of_get_option('pagination-display') == "pagination"){
    	t_pagination($pages = '', $range = 2); 
	}?>
    <div class="bottom-nav">
		<div>
        	<i id="backb-arrow" class="icon-step-backward navkey"></i> <i id="prev-arrow" class="icon-arrow-left navkey"></i> <i id="enter-arrow" class="icon-level-down navkey"></i> <i id="next-arrow" class="icon-arrow-right navkey "></i>
        </div>
	</div> 
</div> 

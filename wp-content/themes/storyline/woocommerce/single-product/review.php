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
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version    2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $post_color, $comment;

$rating = esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );
?>


<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
<div class="ss-row iscomm  c-comment " >
				<div class="ss-full" >
                    <div class="container-border" id="comment-<?php comment_ID(); ?>">
                        <div class="gray-container <?php global $post_color; echo $post_color;?>"  style="text-align:left;"> 
							<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
                                <em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em>
                            <?php else : ?>
                      		 <h3 class="content-title comm-title ">
                                <strong itemprop="author"><?php comment_author(); ?></strong> <?php
                                    if ( get_option('woocommerce_review_rating_verification_label') == 'yes' )
                                        if ( woocommerce_customer_bought_product( $GLOBALS['comment']->comment_author_email, $GLOBALS['comment']->user_id, $post->ID ) )
                                            echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';?>
                            </h3>
                            <?php endif; ?>
                            <comm id="comment-<?php comment_ID(); ?>" class="comment">
                                <foot class="comment-meta">
                                    <div class="comment-author vcard">
                                        <?php edit_comment_link( __( 'Edit', 'timeline' ), '<span class="edit-link">', '</span>' ); ?>
                                    </div>
                                    <?php if ( $comment->comment_approved == '0' ) : ?>
                                        <em class="comment-awaiting-moderation"><?php echo isset($tr_comm_waitapp); ?></em>
                                        <br />
                                    <?php endif; ?>
                                </foot>
                                <div class="nano">
                              			 <div class="cscrol content">
                                        <div class="comment-content">
                                            <div class="comment-avatarin"><?php 
                                                $avatar_size = 68;
                                                if( '0' != $comment->comment_parent )
                                                    $avatar_size = 69;
                                                
												 echo get_avatar( $GLOBALS['comment'], $size='68') ?>
                                            </div>
                                            <div itemprop="description" class="description"><?php comment_text(); ?></div>
                         
                                        </div>
                                        </div>
                                        </div>
                                    
							</comm>
							<div class="icon-soc-container">
						   		<div class="share-btns">								
									<div class="empty-left time-holder-nob"><i class="icon-time icon-large"></i>
                                    
                                     <?php  /* translators: 1: comment author, 2: date and time */
                                printf( __( '%2$s', 'timeline' ),
                                    sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                    sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                        esc_url( get_comment_link( $comment->comment_ID ) ),
                                        get_comment_time( 'c' ),
                                        /* translators: 1: date, 2: time */
                                        sprintf( __( '%1$s at %2$s', 'timeline' ), get_comment_date(), get_comment_time() )
                                    )
                                );?> 
								</div>
                                    
                     		<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>
                            <div style="padding-top:13px;">
                            	<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $rating) ?>">
       						    	<span style="width:<?php echo ( intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
       							</div>
							</div>
							<?php endif; ?> 
                                    
                                    
                                    
                                </div>   
                            </div>
                        </div>
                    </div> 
                </div>
			</div>




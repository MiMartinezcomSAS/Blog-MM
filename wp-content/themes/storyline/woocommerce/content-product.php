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
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly






global $product, $woocommerce_loop;

do_action('woocommerce_after_subcategory');
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 1 );

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
	
global $product, $woocommerce_loop;
	$id = get_the_ID();
	$post_meta_data = get_post_custom($post->ID);
	include(get_template_directory( __FILE__ ).'/functions/post-settings.php');	
	
	if(of_get_option('tr-readmore') != ''){
	$tr_readmore = of_get_option('tr-readmore');
}else{
	$tr_readmore = "Read more";
};
if(of_get_option('tr-searchtitle') != ''){
	$tr_searchtitle = of_get_option('tr-searchtitle');
}else{
	$tr_searchtitle = "Nothing Found";
};
if(of_get_option('tr-searchsubtitle') != ''){
	$tr_searchsubtitle = of_get_option('tr-searchsubtitle');
}else{
	$tr_searchsubtitle = "Sorry, but nothing matched your search criteria. Please try again with some different keywords.";
};
if(of_get_option('tr-home-info') != ''){
	$tr_home_info = of_get_option('tr-home-info');
}else{
	$tr_home_info = "posts at home page";
};
if(of_get_option('tr-search-info') != ''){
	$tr_search_info = of_get_option('tr-search-info');
}else{
	$tr_search_info = "results found";
};
if(of_get_option('tr-archive-info') != ''){
	$tr_archive_info = of_get_option('tr-archive-info');
}else{
	$tr_archive_info = "posts in archive";
};
	
	//ROW BODY
	//=====================================================
		
	do_shortcode( get_the_content() );?>
	<section>
         <div class="layer" data-depth="1"><?php
	
          //JAVASCRIPT FOR FLEX SLIDER AND FADE IN
				//=====================================================?>
			   <?php
				do_shortcode( get_the_content() );
				
				//ROW BODY
				//=====================================================?>
                <?php $attachment_ids = $product->get_gallery_attachment_ids();
					if(isset($attachment_ids[0]) != ''){?>
                                    
				<script>//$(window).bind("load", function() {
					jQuery( document ).ready( function($){
						$(window).bind("load", function() {				 					 
							$('#flexslider-<?php echo $id;?>').flexslider({
								animation: "<?php echo $post_img_effect; ?>",
								direction: "<?php echo $post_img_sdirection; ?>",
								slideshow: <?php echo $post_img_slideshow; ?>,
								smoothHeight: true,
							});
						})
					});
					
				</script><?php };				
				if($row_style == "circle"){
					if(of_get_option('max-excerpt-circle') != ''){
						$exceptnum = of_get_option('max-excerpt-circle');
					}else{
						$exceptnum = 325;
					};?>		
					<div class="circle-img go-anim <?php echo $post_color;?>" >
						<div class="c-size-big">
							<div class="circle-img-c " ><?php 
								if ( has_post_thumbnail() || $post_embed_video_yt !='' || $post_embed_video_vm !='') {  
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 480,480, ), true );
									global $post, $product, $woocommerce;
									$attachment_ids = $product->get_gallery_attachment_ids();
									if(isset($attachment_ids[0]) != ''){?>
										<div id="flexslider-<?php echo $id;?>" class="flexslider" >
											<ul class="slides ">
												<!--[if IE]><div style="width:340px; min-width:340px;"></div> <![endif]-->
												<li> <?php
													if($row_style == "circle"){ ?>
														<ul class="ch-grid">
															<li>
																<div class="ch-item" style="background-image: url(<?php echo $src[0]; ?>);"><?php 															if($post_showdate != "hide"){
																	if($post_ribbon_display == 'date'){?>
																		<div class="ribbon"><i class="icon-time icon-large"></i> 
																			<?php echo get_the_date('d,F'); ?>
																			<div class="seclevelribbon">
																				<div class="thirdlevelribbon">
																					<div class="ribbon-sec"><?php echo get_the_date('Y');?></div>
																				</div>
																			</div>
																		</div><?php
																	}else if($post_ribbon_display == "price" ){?>
																		<div class="ribbon <?php if(!$product->is_on_sale()){?> ribbon-title<?php }?>"> <?php
																			if($product->is_on_sale()){?>
																				<div class="seclevelribbon">
																					<div class="thirdlevelribbon">
																						<div class="ribbon-sec"><?php 
																						if($product->regular_price == 0){
																							 $percentage = "0";
																						}else{
																						$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );}
																						echo sprintf( __('%s', 'woocommerce' ), $percentage . '%' ); ?>
																						</div>
																					</div>
																				</div><?php 
																			}
																			echo "".$product->get_price_html();?>
																		</div>
																		<?php
																	}else if($post_ribbon_display == "rating" ){?>
																		<div class="ribbon ribbon-title">
																			<span><?php if ( $rating_html = $product->get_rating_html() ) { echo $rating_html;}else{?><div class="star-rating" title="Rated 0.00 out of 0"><span class="no-rating"><strong class="rating">0.00</strong> out of 0</span>
																					</div><?php 
																				}?>
																			</span>
																		</div>
																		 <?php
																	}else if($post_ribbon_display == "title"){?>
																		<div class="ribbon ribbon-title"><?php 
																			if(apply_filters ('the_title', get_the_title()) !=''  ) {
																				if($post_showtitle != 'hide'){?>  
																					<h2><a class="read-more-init" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
																				};
																			};?>
																		</div><?php 
																	
																	}else{
																		  echo get_the_date();
																	}
																}?>				
																	<div class="ch-info-wrap">
																		<div class="ch-info">
																			<div class="ch-info-front" style="background-image: url(<?php echo $src[0]; ?>);"></div>
																			<div class="ch-info-back"><?php 
																				if(apply_filters ('the_title', get_the_title()) !='') {
																					if($post_showtitle != 'hide'){?>
																						<h3 class="content-title"><a id="<?php echo $id;?>"   class="read-more-init" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
																					};
																				};?>
																				<p><?php
																					if($post_excerpt != 'off'){
																						$linktofull = '... <a href="'.get_permalink().'" class="read-more-init"><strong>'.$tr_readmore.'</strong> <i class="icon-long-arrow-right"></i></a>';
																						if(get_the_excerpt() !=""){
																							echo substr( get_the_excerpt(),0,$exceptnum).$linktofull;
																						} 
																					}else{
																						the_content($tr_readmore);
																					}
																					if($post_showcategory != "hide"){?>
                                                                                        <div class="circle-info"><?php
																							global $product;
																							$price_html = $product->get_price_html();?>
																							<span class="empty-left time-holder woobtn">    <?php do_action( 'woocommerce_after_shop_loop_item' );  ?>
																							</span>
																							<span class="empty-left comm-holder"><span class="price" style="margin-top:22px!important;"><?php echo $price_html; ?></span>  </span>
                                                                                        </div><?php
                                                                                    };?>										
																				</p>
																			</div>	
																		</div><?php
																		 if($post_showcategory != "hide"){ 
																			if($post_showsoc == "show"){?>
																				<div class="cell">
																					<div class="share-wrapper below">
																						<div class="rc50 share-action "><i class="icon-share-sign icon-large"></i></div>
																						<div class="share-container rc50" >
																							<a class="share-btn bl icn-google" href='https://plus.google.com/share?url=<?php the_permalink();?>'><i class="icon-google-plus"></i></a>    
																							<a class="share-btn tr icn-twitter" rel="https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>" href="javascript:window.open('https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>', '_blank', 'width=550,height=420');void(0);"><i class="icon-twitter"></i></a>    
																							<a class="share-btn tl icn-facebook" rel="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>" href="javascript:window.open('http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>', '_blank', 'width=600,height=400');void(0);"><i class="icon-facebook"></i></a>    
																							<a class="share-btn br icn-pinterest" href='http://pinterest.com/pin/create/button/?url=<?php the_permalink()?>&media=<?php echo $src[0]; ?>'><i class="icon-pinterest"></i></a> 
																						</div>
																					</div>
																				</div><?php
																			};
																		};?>
																	</div>
																</div>
															</li>
														</ul><?php
													};?>
												</li> <?php
												foreach ($attachment_ids as $attachment_id) {
													$srcslider = wp_get_attachment_image_src( $attachment_id, array( 480,480, ), true );?>												
													<li><?php
														if($row_style == "circle"){ ?>
															<ul class="ch-grid">
																<li>
																	<div class="ch-item" style="background-image: url(<?php echo $srcslider[0]; ?>);"><?php 
																	if($post_showdate != "hide"){
																		if($post_ribbon_display == 'date'){?>
																			<div class="ribbon"><i class="icon-time icon-large"></i> 
																				<?php echo get_the_date('d,F'); ?>
																				<div class="seclevelribbon">
																					<div class="thirdlevelribbon">
																						<div class="ribbon-sec"><?php echo get_the_date('Y');?></div>
																					</div>
																				</div>
																			</div><?php
																		}else if($post_ribbon_display == "price" ){?>
																			<div class="ribbon <?php if(!$product->is_on_sale()){?> ribbon-title<?php }?>"> <?php
																				if($product->is_on_sale()){?>
																					<div class="seclevelribbon">
																						<div class="thirdlevelribbon">
																							<div class="ribbon-sec"><?php 
																							if($product->regular_price == 0){
																								 $percentage = "0";
																							}else{
																							$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );}
																							echo sprintf( __('%s', 'woocommerce' ), $percentage . '%' ); ?>
																							</div>
																						</div>
																					</div><?php 
																				}
																				echo "".$product->get_price_html();?>
																			</div>
																			<?php
																		}else if($post_ribbon_display == "rating" ){?>
																			<div class="ribbon ribbon-title">
																				<span><?php if ( $rating_html = $product->get_rating_html() ) { echo $rating_html;}else{?><div class="star-rating" title="Rated 0.00 out of 0"><span class="no-rating"><strong class="rating">0.00</strong> out of 0</span>
																						</div><?php 
																					}?>
																				</span>
																			</div>
																			 <?php
																		}else if($post_ribbon_display == "title"){?>
																			<div class="ribbon ribbon-title"><?php 
																				if(apply_filters ('the_title', get_the_title()) !=''  ) {
																					if($post_showtitle != 'hide'){?>  
																						<h2><a class="read-more-init" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
																					};
																				};?>
																			</div><?php 
																		
																		}else{
																			  echo get_the_date();
																		}
																	}?>				
						
																		<div class="ch-info-wrap">
																			<div class="ch-info">
																				<div class="ch-info-front" style="background-image: url(<?php echo $srcslider[0]; ?>);"></div>
																				<div class="ch-info-back"><?php 
																					if(apply_filters ('the_title', get_the_title()) !='') {
																						if($post_showtitle != 'hide'){?>
																							<h3 class="content-title"><a id="<?php echo $id;?>" class="read-more-init" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
																						};
																					};?>
																					<p><?php
																						if($post_excerpt != 'off'){
																							$linktofull = '... <a href="'.get_permalink().'" class="read-more-init"><strong>'.$tr_readmore.'</strong> <i class="icon-long-arrow-right"></i></a>';
																							if(get_the_excerpt() !=""){
																								echo substr( get_the_excerpt(),0,$exceptnum).$linktofull;
																							} 
																						}else{
																							the_content($tr_readmore);
																						} 
																						if($post_showcategory != "hide"){?>
                                                                                           <div class="circle-info"><?php
																								global $product;
																								$price_html = $product->get_price_html();?>
																								<span class="empty-left time-holder woobtn">    <?php do_action( 'woocommerce_after_shop_loop_item' );  ?>
																								</span>
																								<span class="empty-left comm-holder"><span class="price" style="margin-top:22px!important;"><?php echo $price_html; ?></span>  </span>
                                                                                            </div><?php
                                                                                        };?>										
																					</p>
																				</div>		
																			</div><?php
                                                                             if($post_showcategory != "hide"){ 
																				if($post_showsoc == "show"){?>
																					<div class="cell">
																						<div class="share-wrapper below">
																							<div class="rc50 share-action "><i class="icon-share-sign icon-large"></i></div>
																							<div class="share-container rc50" >
																								<a class="share-btn bl icn-google" href='https://plus.google.com/share?url=<?php the_permalink();?>'><i class="icon-google-plus"></i></a>    
																								<a class="share-btn tr icn-twitter" rel="https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>" href="javascript:window.open('https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>', '_blank', 'width=550,height=420');void(0);"><i class="icon-twitter"></i></a>    
																								<a class="share-btn tl icn-facebook" rel="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>" href="javascript:window.open('http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>', '_blank', 'width=600,height=400');void(0);"><i class="icon-facebook"></i></a>    
																								<a class="share-btn br icn-pinterest" href='http://pinterest.com/pin/create/button/?url=<?php the_permalink()?>&media=<?php echo $src[0]; ?>'><i class="icon-pinterest"></i></a> 
																							</div>
																						</div>
																					</div><?php
																				};
																			};?>
																		</div>
																	</div>
																</li>
															</ul><?php
														};?>
													</li> <?php 
												};?>
											</ul>
										</div> <?php
									}else{
										if($row_style == "circle"){ ?>
											<ul class="ch-grid">
												<li>
													<div class="ch-item" style="background-image: url(<?php echo $src[0]; ?>);"><?php
													if($post_showdate != "hide"){
														if($post_ribbon_display == 'date'){?>
																		<div class="ribbon"><i class="icon-time icon-large"></i> 
																			<?php echo get_the_date('d,F'); ?>
																			<div class="seclevelribbon">
																				<div class="thirdlevelribbon">
																					<div class="ribbon-sec"><?php echo get_the_date('Y');?></div>
																				</div>
																			</div>
																		</div><?php
																	}else if($post_ribbon_display == "price" ){?>
																		<div class="ribbon <?php if(!$product->is_on_sale()){?> ribbon-title<?php }?>"> <?php
																			if($product->is_on_sale()){?>
																				<div class="seclevelribbon">
																					<div class="thirdlevelribbon">
																						<div class="ribbon-sec"><?php 
																						if($product->regular_price == 0){
																							 $percentage = "0";
																						}else{
																						$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );}
																						echo sprintf( __('%s', 'woocommerce' ), $percentage . '%' ); ?>
																						</div>
																					</div>
																				</div><?php 
																			}
																			echo "".$product->get_price_html();?>
																		</div>
																		<?php
																	}else if($post_ribbon_display == "rating" ){?>
																		<div class="ribbon ribbon-title">
																			<span><?php if ( $rating_html = $product->get_rating_html() ) { echo $rating_html;}else{?><div class="star-rating" title="Rated 0.00 out of 0"><span class="no-rating"><strong class="rating">0.00</strong> out of 0</span>
																					</div><?php 
																				}?>
																			</span>
																		</div>
																		 <?php
																	}else if($post_ribbon_display == "title"){?>
																		<div class="ribbon ribbon-title"><?php 
																			if(apply_filters ('the_title', get_the_title()) !=''  ) {
																				if($post_showtitle != 'hide'){?>  
																					<h2><a class="read-more-init" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
																				};
																			};?>
																		</div><?php 
																	
																	}else{
																		  echo get_the_date();
																	}
																}?>						
														<div class="ch-info-wrap">
                                                        
															<div class="ch-info">
                                                            
																<div class="ch-info-front" style="background-image: url(<?php echo $src[0]; ?>);"></div>
																<div class="ch-info-back"><?php 
																	if(apply_filters ('the_title', get_the_title()) !='') {
																		if($post_showtitle != 'hide'){?>
																			<h3 class="content-title"><a class="read-more-init" id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
																		};
																	};?>
																	<p><?php
																		if($post_excerpt != 'off'){
																			$linktofull = '... <a href="'.get_permalink().'" class="read-more-init"><strong>'.$tr_readmore.'</strong> <i class="icon-long-arrow-right"></i> </a>';
																			if(get_the_excerpt() !=""){
																				echo substr( get_the_excerpt(),0,$exceptnum).$linktofull;
																			} 
																		}else{
																			the_content($tr_readmore);
																		}
																		if($post_showcategory != "hide"){?>
                                                                        	<div class="circle-info"><?php
																				global $product;
																				$price_html = $product->get_price_html();?>
                                                                                <span class="empty-left time-holder woobtn">    <?php do_action( 'woocommerce_after_shop_loop_item' );  ?>
                                                                                </span>
                                                                                <span class="empty-left comm-holder"><span class="price" style="margin-top:22px!important;"><?php echo $price_html; ?></span>  </span>
																			</div><?php
																		};?>										
                                                                    </p>
																</div>	
															</div><?php
                                                            if($post_showcategory != "hide"){ 
																if($post_showsoc == "show"){?>
                                                                    <div class="cell">
                                                                        <div class="share-wrapper below">
                                                                            <div class="rc50 share-action "><i class="icon-share-sign icon-large"></i></div>
                                                                            <div class="share-container rc50" >
                                                                                <a class="share-btn bl icn-google" href='https://plus.google.com/share?url=<?php the_permalink();?>'><i class="icon-google-plus"></i></a>    
                                                                                <a class="share-btn tr icn-twitter" rel="https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>" href="javascript:window.open('https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>', '_blank', 'width=550,height=420');void(0);"><i class="icon-twitter"></i></a>    
                                                                                <a class="share-btn tl icn-facebook" rel="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>" href="javascript:window.open('http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>', '_blank', 'width=600,height=400');void(0);"><i class="icon-facebook"></i></a>    
                                                                                <a class="share-btn br icn-pinterest" href='http://pinterest.com/pin/create/button/?url=<?php the_permalink()?>&media=<?php echo $src[0]; ?>'><i class="icon-pinterest"></i></a> 
                                                                            </div>
                                                                        </div>
                                                                    </div><?php
                                                                };
															};?>
														</div>
													</div>
												</li>
											</ul><?php
										};
									};	
								};?>
							</div>
						</div>
					</div><?php 
				}else{
					if(of_get_option('max-excerpt-square') != ''){
						$exceptnum = of_get_option('max-excerpt-square');
					}else{
						$exceptnum = 225;
					};?> 
					<div class="<?php echo $post_color;?> ss-row go-anim <?php if(apply_filters( 'the_content', get_the_content()) == ''){?>no-content<?php }?>">
						<div class="ss-full"><?php 
							if($post_showdate != "hide"){
								if($post_ribbon_display == 'date'){?>
                                    <div class="ribbon"><i class="icon-time icon-large"></i> 
                                        <?php echo get_the_date('d,F'); ?>
                                        <div class="seclevelribbon">
                                            <div class="thirdlevelribbon">
                                                <div class="ribbon-sec"><?php echo get_the_date('Y');?></div>
                                            </div>
                                        </div>
                                    </div><?php
								}else if($post_ribbon_display == "price" ){?>
									<div class="ribbon <?php if(!$product->is_on_sale()){?> ribbon-title<?php }?>"> <?php
										if($product->is_on_sale()){?>
											<div class="seclevelribbon">
												<div class="thirdlevelribbon">
													<div class="ribbon-sec"><?php 
													if($product->regular_price == 0){
														 $percentage = "0";
													}else{
													$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );}
													echo sprintf( __('%s', 'woocommerce' ), $percentage . '%' ); ?>
													</div>
												</div>
											</div><?php 
										}
										// echo woocommerce_price( $product->regular_price ); echo woocommerce_price( $product->sale_price); 
										echo "".$product->get_price_html();?>
                                    </div>
									<?php
								}else if($post_ribbon_display == "rating" ){?>
									<div class="ribbon ribbon-title">
                                    	<span><?php if ( $rating_html = $product->get_rating_html() ) { echo $rating_html;}else{?><div class="star-rating" title="Rated 0.00 out of 0"><span class="no-rating"><strong class="rating">0.00</strong> out of 0</span>
												</div><?php 
											}?>
                                        </span>
                                    </div>
									 <?php
								}else if($post_ribbon_display == "title"){?>
									<div class="ribbon ribbon-title"><?php 
										if(apply_filters ('the_title', get_the_title()) !=''  ) {
											if($post_showtitle != 'hide'){?>  
												<h2><a class="read-more-init" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
											};
										};?>
									</div><?php 
								
								}else{?>
									  <div class="ribbon"><i class="icon-time icon-large"></i> 
                                        <?php echo get_the_date('d,F'); ?>
                                        <div class="seclevelribbon">
                                            <div class="thirdlevelribbon">
                                                <div class="ribbon-sec"><?php echo get_the_date('Y');?></div>
                                            </div>
                                        </div>
                                    </div><?php
								}
						};?>
						<?php if(apply_filters( 'the_content', get_the_content()) == ''){?>
						<a class="read-more-init hidelink" id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php };
							if(has_post_thumbnail() || $post_embed_video_yt !='' || $post_embed_video_vm !='') {	
								if(apply_filters( 'the_content', get_the_content()) == ''){
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 550,550, ), true );
								}else{
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 520, 550, ), true );
								}
								$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true );
								global $post, $product, $woocommerce;
								$attachment_ids = $product->get_gallery_attachment_ids();
								
								if(isset($attachment_ids[0])!= ''){?>
									<div id="flexslider-<?php echo $id;?>" class="flexslider" >
										<ul class="slides">
											<li>
												<div class="hover-effect h-style"><?php 
													if($img_title && $post_embed_video_yt =='' && $post_embed_video_vm =='' || $img_content && $post_embed_video_yt =='' && $post_embed_video_vm ==''){ ?>
														<img src="<?php echo $src[0]; ?>" class="clean-img"/> 
														<div class="mask"><?php 
															if($img_title){ ?>
																<h2><?php echo $img_title; ?></h2> <?php 
															}; ?>
															<p><?php echo do_shortcode($img_content); ?></p><?php 
															if($img_link){ ?>
																<a href="<?php echo $img_link; ?>" class="info read-more-init"> <span class="button wpb_defbtn"><?php echo $img_buttontitle; ?></span></a><?php
															};?>
														</div><?php 
													}else{ 
														if ($post_embed_video_yt !='') {?>
																<iframe id="embedvideo" width="100%" height="190px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>?html5=1" frameborder="0" allowfullscreen></iframe><?php
														}else if ($post_embed_video_vm !=''){?>
																<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="190px" id="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
														}else{
															if($post_img_link =='link'){?>
                                                                <a class="read-more-init" href="<?php the_permalink(); ?>">
                                                                <img src="<?php echo $src[0]; ?>" class="clean-img"/> 
                                                                    <div class="mask"><i class="icon-link"></i>
                                                                        <span class="img-rollover"></span>
                                                                    </div>
                                                                </a><?php
															}else if($post_img_link =='image'){
															?>
                                                        
															<a href="<?php echo $srcf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $src[0]; ?>" class="clean-img"/> 
																<div class="mask"><i class="icon-search"></i>
                                                                
																	<span class="img-rollover"></span>
																</div>
															</a><?php 
															}else if($post_img_link =='disable'){?>
                                                            	<img src="<?php echo $src[0]; ?>" class="clean-img"/><?php 
															}
														}
														
													};?>
												</div>
											</li> <?php
											foreach ($attachment_ids as $attachment_id ) {
												if(apply_filters( 'the_content', get_the_content()) == ''){
													$srcslider = wp_get_attachment_image_src( $attachment_id, array( 550,550, ), true );
												}else{
													$srcslider = wp_get_attachment_image_src( $attachment_id, array( 520,550, ), true );
												}
												$srcsliderf = wp_get_attachment_image_src( $attachment_id, 'full', true );
												?>
												<li>
													<div class="hover-effect h-style">
														<?php
                                                        if($post_img_link =='link'){?>
                                                                <a class="read-more-init" href="<?php the_permalink(); ?>">
                                                                <img src="<?php echo $srcslider[0]; ?>" class="clean-img"/> 
                                                                    <div class="mask"><i class="icon-link"></i>
                                                                        <span class="img-rollover"></span>
                                                                    </div>
                                                                </a><?php
															}else if($post_img_link =='image'){
															?>
                                                        
															<a href="<?php echo $srcsliderf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $srcslider[0]; ?>" class="clean-img"/> 
																<div class="mask"><i class="icon-search"></i>
                                                                
																	<span class="img-rollover"></span>
																</div>
															</a><?php 
															}else if($post_img_link =='disable'){?>
                                                            	<img src="<?php echo $srcslider[0]; ?>" class="clean-img"/><?php 
															}?>
													</div>
												</li> <?php 
											};?>
										</ul>
									</div> <?php
								}else{?>
									<div class="hover-effect h-style"><?php 
										if($img_title && $post_embed_video_yt =='' && $post_embed_video_vm =='' || $img_content && $post_embed_video_yt =='' && $post_embed_video_vm ==''){  ?>
                                        
											<img src="<?php echo $src[0]; ?>" class="clean-img"/> 
											<div class="mask"><?php 
												if($img_title){ ?>
													<h2><?php echo $img_title; ?></h2><?php  
												}; ?>
												<p><?php echo do_shortcode($img_content); ?></p><?php  
												if($img_link){ ?>
													<a href="<?php echo $img_link; ?>" class="info read-more-init"> <span class="button wpb_defbtn"><?php echo $img_buttontitle; ?></span></a><?php
												}; ?>
											</div><?php 
										}else{ 
											if ($post_embed_video_yt !='') {?>
													<iframe id="embedvideo" width="100%" height="190px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>?html5=1" frameborder="0" allowfullscreen></iframe><?php
											}else if ($post_embed_video_vm !=''){?>
													<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="190px" id="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
											}else{;
												if($post_img_link =='link'){?>
                                                    <a class="read-more-init" href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo $src[0]; ?>" class="clean-img"/> 
                                                        <div class="mask"><i class="icon-link"></i>
                                                            <span class="img-rollover"></span>
                                                        </div>
                                                    </a><?php
                                                }else if($post_img_link =='image'){
                                                ?>
                                            
                                                <a href="<?php echo $srcf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $src[0]; ?>" class="clean-img"/> 
                                                    <div class="mask"><i class="icon-search"></i>
                                                    
                                                        <span class="img-rollover"></span>
                                                    </div>
                                                </a><?php 
                                                }else if($post_img_link =='disable'){?>
                                                    <img src="<?php echo $src[0]; ?>" class="clean-img"/><?php 
                                                }
											};
										};?>
									</div><?php 
								};
							}
							 
							if(apply_filters( 'the_content', get_the_content()) != '' || $post_showtitle == 'hide' && has_post_thumbnail()){ ?>
								<div class="container-border">
                                
									<div class="gray-container <?php if($post_showcategory == "hide" && $post_showsoc == "hide"){ ?>gcnopadding<?php }?>">
										<div class="containera <?php if(!has_post_thumbnail() && $post_showdate == "show" && $post_embed_video_yt == '' && $post_embed_video_vm =='') {?> addpadding<?php }?>"><?php
											if(apply_filters ('the_title', get_the_title()) !='') {
												if($post_showtitle != 'hide' && $post_ribbon_display != "title" ){?>
													<h3 class="content-title"><a class="read-more-init" id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title();?></a></h3> <?php 
												};
											};
										
											if($post_excerpt != 'off'){
											$linktofull = '...<a href="'.get_permalink().'" class="read-more-init"> <strong>'.$tr_readmore.'</strong> <i class="icon-long-arrow-right"></i> </a>';?>
											<div class="hideifneed"><?php
												if(get_the_excerpt() !="" && get_the_excerpt() !=" "){
													echo substr( get_the_excerpt(),0,$exceptnum).$linktofull;
												}?>
											</div><?php
											}else{
												 the_content($tr_readmore);
											}
											if($post_showcategory != "hide" || $post_showsoc != "hide"){ ?>
												<div class="icon-soc-container">
													<div class="share-btns"><?php
													if($post_showcategory != "hide"){					
														$category = get_the_category();?>
														<div class="empty-left time-holder ">
                                                        <?php do_action( 'woocommerce_after_shop_loop_item' );  ?>
                                                     
														</div> 
                                                       
                                                   		<?php if($post_ribbon_display != "price" ){?> 
														 <div class="empty-left comm-holder">  <?php do_action( 'woocommerce_after_shop_loop_item_title' );?></div>
														<?php }else{?>
                                                         <div class="empty-left comm-holder">
                                                        	<a href="<?php the_permalink(); ?>/#review_form"><span><?php if ( $rating_html = $product->get_rating_html() ) { echo $rating_html;}else{?><div class="star-rating" title="Rated 0.00 out of 0"><span class="no-rating"><strong class="rating">0.00</strong> out of 0</span>
												</div><?php 
											}?>
                                        </span></a></div>
                                        
                                                        <?php };
													}
														if($post_showsoc == "show"){?>
                                                      
                                                            <div class="cell">
                                                                <div class="share-wrapper below">
                                                                    <div class=" share-action"><i class="icon-share-sign icon-large"></i></div>
                                                                    <div class="share-container">
                                                                        <a class="share-btn bl icn-google" href='https://plus.google.com/share?url=<?php the_permalink();?>'><i class="icon-google-plus"></i></a>    
                                                                        <a class="share-btn tr icn-twitter" rel="https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>" href="javascript:window.open('https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>', '_blank', 'width=550,height=420');void(0);"><i class="icon-twitter"></i></a>    
                                                                        <a class="share-btn tl icn-facebook" rel="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>" href="javascript:window.open('http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>', '_blank', 'width=600,height=400');void(0);"><i class="icon-facebook"></i></a>    
                                                                        <a class="share-btn br icn-pinterest" href='http://pinterest.com/pin/create/button/?url=<?php the_permalink()?>&media=<?php echo $src[0]; ?>'><i class="icon-pinterest"></i></a>    
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
															<?php
														}?>
													</div>   
												</div><?php
											};?>
										</div>
									</div>
								</div><?php
							}; ?>
						</div>
					</div><?php 
				};?>
</div>
			</section><?php 
		


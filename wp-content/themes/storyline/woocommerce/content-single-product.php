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
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $post_showdate , $img_badge, $woocommerce, $messages, $size, $message;

?>
<script>  
jQuery(document).ready(function($){
	'use strict';
	var themes,
		selectedThemeIndex,
		instructionsTimeout,
		deck;
	window.scrollinit = function(){
		deck = bespoke.from('article');
		initThemeSwitching();
	};
	scrollinit();
	function initThemeSwitching() {
		themes = [
			'classic',
			'cube',
			'carousel',
			'concave',
			'coverflow'
		];
		selectedThemeIndex = 0;
		initKeys();
		initSlideGestures();
		
		initClickInactive();
		deck.slide(0);

	
		//If browser doesn't support trasnforms3d swich scroll effect to classic
		//==================================================
		if(Modernizr.csstransforms3d === false){
			$('body').addClass("classic");
		}
	}
	//Keyboard navigation
	//==================================================
	function initKeys(e) {
		var start = 0;
		if (/Firefox/.test(navigator.userAgent)) {
			document.addEventListener('keydown', function(e) {
				if (e.which >= 37 && e.which <= 40) {
					e.preventDefault();
				}
			});
		}
		window.gokb = function(e) {
			if(window.bopen === 1){
				hideInstructions();	
				window.bopen = 2;
			}
			var key = e.which;
			if(key === 37){
				deck.prev();
			}
			if(key === 39){
				deck.next();
			}
			if(start === 0 && key === 39 || key === 37 ){
				if( $('.cscrol').is(':animated') ) {
					start = 0;
				}else{
					$('.cscrol').animate({
							scrollTop: 0
						}, 'slow', function(){ 
						if( $('#firsts').hasClass('bespoke-active') ){
								var start = 0;
							$('article').css('overflow', 'visible');
						}else{
						
							$('article').css('overflow', 'hidden');
						}
						start = 1;
					});
				}
			}
		}
		document.addEventListener('keydown', gokb);
	}
	
	function extractDelta(e) {
		if (e.wheelDelta) {
			return e.wheelDelta;
		}
	
		if (e.originalEvent.detail) {
			return e.originalEvent.detail* -40;
		}
	
		if (e.originalEvent && e.originalEvent.wheelDelta) {
			return e.originalEvent.wheelDelta;
		}
	}
	//Mouse wheel navigation
	//==================================================
	window.gomouse = function gomousewheel(){
		if( $('#firsts').hasClass('bespoke-active') ){
			$('article').css('overflow', 'visible');
		}else{
		
			$('article').css('overflow', 'hidden');
		}
		if ($('article').hasClass('bespoke-active') ){
			$('article').css('overflow', 'visible');
		}
		var el = $('.bespoke-inactive');
		if(el.length === 0){
			return;
		}
		var start = 0;
		$('#main').bind('mousewheel DOMMouseScroll', function(e){
			if( $('#firsts').hasClass('bespoke-active') ){
				if($('.cscrol').scrollTop() + $('.cscrol').innerHeight() >= $('.cscrol')[0].scrollHeight -10){
					if(extractDelta(e) < 0) {
						$("#main").unbind("mousewheel DOMMouseScroll");
						jQuery('.cscrol').animate({
								scrollTop: 0
							}, 'slow', function(){ 
								if(start === 0 ){
									 setTimeout( nextp, 400);
									 start = 1;
							}
						});
					}	
				}
			}else{
				if(extractDelta(e) > 0) {
					$("#main").unbind("mousewheel DOMMouseScroll");
						setTimeout( prevp, 200);  
					}
					if(extractDelta(e) < 0) {
						$("#main").unbind("mousewheel DOMMouseScroll");
							setTimeout( nextp, 200); 
						}
					}
				});
				function prevp(){
					deck.prev();
					setTimeout( gomousewheel, 200);  
				}
				function nextp(){
					deck.next();
					setTimeout( gomousewheel, 200);
				}
			}
	window.gomouse();
	//Navigation for touch devices
	//==================================================
	function initSlideGestures() {
		var start = 0;
		var main = document.getElementById('main'),
			startPosition,
			delta,

			singleTouch = function(fn, preventDefault) {
				start = 0;
				return function(e) {
					if (preventDefault) {
						//e.preventDefault();
					}
					e.touches.length === 1 && fn(e.touches[0].pageX);
				};
			},

			touchstart = singleTouch(function(position) {
				startPosition = position;
				delta = 0;
				
			}),

			touchmove = singleTouch(function(position) {
				delta = position - startPosition;
			}, true),

			touchend = function() { 
				start = 0;
				if( $('#firsts').hasClass('bespoke-active') ){
					if($('.cscrol').scrollTop() + $('.cscrol').innerHeight() >= $('.cscrol')[0].scrollHeight -20){
						jQuery('.cscrol').animate({
							scrollTop: 0
						}, 'slow', function(){
							if( $('#firsts').hasClass('bespoke-active') ){
								$('article').css('overflow', 'visible');
							}else{
								$('article').css('overflow', 'hidden');
							}
							if(start == 0 ){
								deck.next();
								start = 1;
							}	
						});
					}		
				}
				if(Math.abs(delta) < 50) {
					return;
				}
				jQuery('.cscrol').animate({
					scrollTop: 0
				}, 'slow', function(){
					if( $('#firsts').hasClass('bespoke-active') ){
						$('article').css('overflow', 'visible');
					}else{
						$('article').css('overflow', 'hidden');
					}
					if(start === 0 ){ 
						delta > 0 ? deck.prev() : deck.next();
						start = 1;
					}	
				});
			};
		main.addEventListener('touchstart', touchstart);
		main.addEventListener('touchmove', touchmove);
		main.addEventListener('touchend', touchend);	
	}
	//Small bottom navigation
	//==================================================
	function initButtons() {
		document.getElementById('backb-arrow').addEventListener('click', gobegin);
		document.getElementById('next-arrow').addEventListener('click', gonext);
		document.getElementById('prev-arrow').addEventListener('click', goprev);
	}
	function gobegin(){
		deck.slide(0)
		if( $('#firsts').hasClass('bespoke-active') ){
			$('article').css('overflow', 'visible');
		}else{
			$('article').css('overflow', 'hidden');
		}
	}
	function goprev(){
		deck.prev();
		if( $('#firsts').hasClass('bespoke-active') ){
			$('article').css('overflow', 'visible');
		}else{
			$('article').css('overflow', 'hidden');
		}
	}
	function gonext(){
		deck.next();
		var start = 0
		if( $('.cscrol').is(':animated') ) {
			start = 1 
		}else{
			$('.cscrol').animate({
				scrollTop: 0
			}, 'slow', function(){ 
				if( $('#firsts').hasClass('bespoke-active') ){
					$('article').css('overflow', 'visible');
				}else{
					$('article').css('overflow', 'hidden');
				}	
			});
		};
	};
	//Show hide wellcome bubble
	//==================================================
	function showInstructions() {
		$('section').addClass('addblur');
		$('.addbg').addClass('addbgv');
		$('.addbg').click(function() {
			if(window.bopen === 1){
				hideInstructions();	
				window.bopen = 2;
			}
			$(this).unbind("click");
		});
		document.querySelectorAll('header p')[0].className = 'visible animated fadeInUp';
	}

	function hideInstructions() {
		window.gomouse();
		$('section').removeClass('addblur');
		$('.addbg').removeClass('addbgv');
		clearTimeout(instructionsTimeout);
		document.querySelectorAll('header p')[0].className = 'hidden';
	}

	function isTouch() {
		return !!('ontouchstart' in window) || navigator.msMaxTouchPoints;
	}

	function modulo(num, n) {
		return ((num % n) + n) % n;
	}
	//Mouse click navigation
	//==================================================
	function initClickInactive(){
		var n = $("section").length;
		$('section').click(function() {
			var page = $(this).attr('rel');
			if( $(this).hasClass('bespoke-inactive') ){
				jQuery('.cscrol').animate({
					scrollTop: 0
				}, 'slow', function(){ 
					if( $('#firsts').hasClass('bespoke-active') ){
						$('article').css('overflow', 'visible');
					}else{
					
						$('article').css('overflow', 'hidden');
					}
					deck.slide(page);				
				});
			}
		});
	}
	
	//Animate post on  click
	//==================================================
	var contentholder = document.getElementsByClassName("bespoke-active");
	var allholder = document.getElementsByClassName("bespoke-parent");
	function animate(){
		'use strict';
		$('a.read-more-init').click(function () {
			var storyId = $(this).attr('href');
			selectactive(storyId);
			return false;
		});   
		function selectactive(storyId){
			allholder[0].style.opacity -= 0.1;
			document.body.style.opacity -= 0.1;
			move(contentholder[0])
				.rotate(10)
				.scale(6)
				.duration('0.4s')
				.end(function(){
					window.open(storyId, '_self');
			});
		}
	} <?php  
	if(of_get_option('post-fx') == "on" ){ ?>
		animate();
	<?php }; ?>
	if(Modernizr.csstransforms3d !== false){
		var contentholder2 = document.getElementsByClassName("go-anim");
		if(contentholder2.length > 0){
			for(var i = 0, j=contentholder.length; i<j; i++){
				contentholder2[i].addEventListener("mouseover", function(){
					var holdertoanimate = this.getElementsByClassName("container-border")[0];							   
					move(holdertoanimate)
					.set('margin-top', -20)
					.end();
				});
				contentholder2[i].addEventListener("mouseout", function(){
					var holdertoanimate = this.getElementsByClassName("container-border")[0];						   
					 move(holdertoanimate)
					.set('margin-top', 0)
					.end();
				});
			}
		}
	}
	//Comments scroll animation
	//==================================================
	var el = $('.bespoke-inactive');
	if(el.length > 0){
		var elpos_original = el.offset().top;
		$('.cscrol').scroll(function(){
			if(el.length > 0){
				var elpos = el.offset().top;
				var windowpos = $('.cscrol').scrollTop();
				var finaldestination = windowpos;
				if(windowpos<elpos_original) {
					finaldestination = elpos_original;
					el.stop().animate({'top':350},500);
				}else{
					el.stop().animate({'top':windowpos+350},500);
				}
			}
		});
	}
});
</script>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
	
?>
<div id="main" <?php post_class(); ?>>
	<div class="nano mnano">
    	<div class="cscrol content"><?php 
			//BEGIN LOOP
			//=====================================================?> 
   
<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

            <article class="single-post"  ><?php
			global $post_color; 
			
				$id = get_the_ID();
				$post_meta_data = get_post_custom($post->ID);
				include(get_template_directory( __FILE__ ).'/functions/post-settings.php');	?>
                
                 <section id='firsts'><?php
				//JAVASCRIPT FOR FLEX SLIDER AND BACKGROUND
				//=====================================================
				if($post_bgimage != ''){
					$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full', true );
					$srcsliderfa = wp_get_attachment_image_src( $post_bgimage, 'full', true );?>
					<script>
						jQuery( document ).ready( function($){
							window.hasownbg = 1;
							jQuery.vegas('stop');
							jQuery.vegas({
									src:'<?php echo  $srcsliderfa[0]; ?>', 
									fade:2000, 
									valign:'<?php echo of_get_option('background-valign-1'); ?>', 
									align:'<?php echo of_get_option('background-halign-1'); ?>' 
							
							})('overlay', {
							  src:'<?php echo get_template_directory_uri(); ?>/images/overlays/<?php echo of_get_option('background-overlays', 'no entry' ); ?>.png'
							});
						});
					
					</script><?php 
				}; ?>
				<script>
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
				</script><?php
				//BODY
				//=====================================================?>
				<div class="ss-stand-alone  <?php echo $post_color;?>">
					<div class="ss-full  <?php if($show_sidebar == 'sbleft'){ ?>sblefton empty-right<?php }else if($show_sidebar == 'sbright'){?> sblefton empty-left<?php }?> " >
                    
					<div class="ss-row "><?php 
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
									<div class="ribbon ribbon-price <?php if(!$product->is_on_sale()){?> ribbon-title<?php }?>"> <?php
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
												<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
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
						};
						if(has_post_thumbnail()) {
							if(of_get_option('product-style') == 'style2'){
							$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,550, ), true );
							$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full', true );
							$attachment_ids = $product->get_gallery_attachment_ids();
if ( $attachment_ids ) {?>
								<div id="flexslider-<?php echo $id;?>" class="flexslider">
									<ul class="slides">
										<li> 
											<div class="hover-effect h-style <?php if ($post_embed_video_yt !='' || $post_embed_video_vm !='') {?>embedvideoh<?php }; ?>"><?php 
												if ($post_embed_video_yt !='') {?>
															<iframe class="embedvideo"  width="100%" height="340px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>" frameborder="0" allowfullscreen></iframe><?php
												}else if ($post_embed_video_vm !=''){?>
															<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0"  width="100%" height="340px" class="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
												}else{?>
													<a href="<?php echo $srcf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $src[0]; ?>" class="clean-img"/> 
														<div class="mask"><i class="icon-search"></i>
															<span class="img-rollover"></span>
														</div>
													</a><?php 
												}?>
											</div>
										</li> <?php
										foreach ( $attachment_ids as $attachment_id ) {
											$image_link = wp_get_attachment_url( $attachment_id );
											if ( ! $image_link )
												continue;
								
											$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
											
											$srcslider = wp_get_attachment_image_src( $attachment_id, array( 720,550, ), true );
											$srcsliderf = wp_get_attachment_image_src( $attachment_id, 'full', true );?>
											<li>
												<div class="hover-effect h-style"><?php
												echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" title="%s"  rel="prettyPhotoImages['.$id.']">%s<div class="mask"><i class="icon-search"></i><span class="img-rollover"></span></div></a>', $image_link, $image_title, $image ), $attachment_id, $post->ID );?>
                                                
												
												</div>
											</li> <?php 
										};?>
									</ul>
								</div> <?php
							}else{?>
								<div class="hover-effect h-style <?php if ($post_embed_video_yt !='' || $post_embed_video_vm !='') {?>embedvideoh<?php }; ?>"><?php 
									if ($post_embed_video_yt !='') {?>
										<iframe class="embedvideo" width="100%" height="340px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>" frameborder="0" allowfullscreen></iframe><?php
									}else if ($post_embed_video_vm !=''){?>
										<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="340px" class="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
									}else{;?>
										<a href="<?php echo $srcf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $src[0]; ?>" class="clean-img"/>
											<div class="mask"><i class="icon-search"></i>
												<span class="img-rollover"></span>
											</div>
										</a><?php
									};?>
								</div><?php 
							};
						};
						};
						if(get_the_content() !='' || $post_showtitle == 'hide' ){
							
							?>
							<div class="container-border zindex-up ">
                           
								<div class="gray-container <?php if($post_showcategory == "hide" && $post_showsoc == "hide"){ ?>gcnopadding<?php }?> <?php if(!has_post_thumbnail() && $post_showdate == "show" && $post_embed_video_yt == '' && $post_embed_video_vm =='') {?> addpaddingmore<?php }?>"> <?php 
									?><div style="display:inline-block;"><?php 
									if(has_post_thumbnail()) {
										if(of_get_option('product-style') == 'style1'){
						
											$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 550,550, ), true );
											$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full', true );
											
									$attachment_ids = $product->get_gallery_attachment_ids();
									if ( $attachment_ids ) {?>
									
									<div class="images">
									<div id="flexslider-<?php echo $id;?>" class="product-thumb flexslider">
										<!--<div id="flexslider-<?php echo $id;?>" class="flexslider">-->
									<ul class="slides">
										<li> 
											<div class="hover-effect h-style <?php if ($post_embed_video_yt !='' || $post_embed_video_vm !='') {?>embedvideoh<?php }; ?>"><?php 
												if ($post_embed_video_yt !='') {?>
															<iframe class="embedvideo"  width="100%" height="340px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>" frameborder="0" allowfullscreen></iframe><?php
												}else if ($post_embed_video_vm !=''){?>
															<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0"  width="100%" height="340px" class="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
												}else{?>
													<a href="<?php echo $srcf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $src[0]; ?>" class="clean-img"/> 
														<div class="mask"><i class="icon-search"></i>
															<span class="img-rollover"></span>
														</div>
													</a><?php 
												}?>
											</div>
										</li> <?php
										foreach ( $attachment_ids as $attachment_id ) {
											$image_link = wp_get_attachment_url( $attachment_id );
											if ( ! $image_link )
												continue;
								
											$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
											
											$srcslider = wp_get_attachment_image_src( $attachment_id, array( 550,550, ), true );
											$srcsliderf = wp_get_attachment_image_src( $attachment_id, 'full', true );?>
											<li>
												<div class="hover-effect h-style"><?php
												echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" title="%s"  rel="prettyPhotoImages['.$id.']">%s<div class="mask"><i class="icon-search"></i><span class="img-rollover"></span></div></a>', $image_link, $image_title, $image ), $attachment_id, $post->ID );?>
                                                
												
												</div>
											</li> <?php 
										};?>
									</ul>
								</div>
                                </div><?php }else{?><div class="images">
                                            <div  class="product-thumb flexslider">
								<div class="hover-effect h-style <?php if ($post_embed_video_yt !='' || $post_embed_video_vm !='') {?>embedvideoh<?php }; ?>"><?php 
									if ($post_embed_video_yt !='') {?>
										<iframe class="embedvideo" width="100%" height="340px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>" frameborder="0" allowfullscreen></iframe><?php
									}else if ($post_embed_video_vm !=''){?>
										<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="340px" class="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
									}else{;?>
										<a href="<?php echo $srcf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $src[0]; ?>" class="clean-img"/>
											<div class="mask"><i class="icon-search"></i>
												<span class="img-rollover"></span>
											</div>
										</a><?php
									};?>
								</div></div></div><?php 
							};
						}
						}	
									//	do_action( 'woocommerce_before_single_product_summary' );
										
										?>
                                        
                                        <div class="summary entry-summary <?php if(of_get_option('product-style') == 'style2'){?>addfullwidth<?php }?>" >
                                        
											<?php if ( ! empty( $_SESSION['ys-atcm'] ) ) {?>
                                            <div class="woocommerce-message"><?php
                                            global $davidim;
                                            
                                            echo $_SESSION['ys-atcm'];
                                            echo $davidim;
                                            
                                            unset( $_SESSION['ys-atcm'] );?></div><?php
                                            
                                            }; 
                                                /**
                                                 * woocommerce_single_product_summary hook
                                                 *
                                                 * @hooked woocommerce_template_single_title - 5
                                                 * @hooked woocommerce_template_single_price - 10
                                                 * @hooked woocommerce_template_single_excerpt - 20
                                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                                 * @hooked woocommerce_template_single_meta - 40
                                                 * @hooked woocommerce_template_single_sharing - 50
                                                 */
                                                do_action( 'woocommerce_single_product_summary' );
                                            ?>
                                    
                                        </div><!-- .summary -->
                                        </div>
                                        <?php do_action( 'woocommerce_after_single_product_summary' );
									 if($post_showcategory != "hide" || $post_showsoc != "hide"){ ?>
										<div class="icon-soc-container">
											<div class="share-btns"><?php
                                                       if($post_showcategory != "hide"){ 
                                                       $category = get_the_category(); ?> 
                                                       <div class="empty-left time-holder "> <a class="read-more-init" href="<?php echo get_category_link( $category[0]->term_id );?>"><i class="icon-tag icon-large"></i><?php echo $product->get_categories( ' ', '<span class="posted_in">' . _n( '', '', $size, 'woocommerce' ) . ' ', '	</span>' ); ?></a>
														</div> 
                                                        <?php if ( have_comments()){?>
                                                            <div class="empty-left user-holder"> <a  href="#" class="linkclick"><i class="icon-comments icon-large"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                                                            </div>
                                                            <?php };?>
                                                            <?php if( function_exists('dot_irecommendthis') ) {?> 
                                                             <div class="empty-left comm-holder"> <?php if( function_exists('dot_irecommendthis') ) dot_irecommendthis(); ?></div><?php };?><?php
															 
															
														};
												if($post_showsoc == "show"){?>
													<div class="cell">
														<div class="share-wrapper below">
															<div class=" share-action"><i class="icon-share-sign icon-large"></i></div>
															<div class="share-container">
																<a class="share-btn bl icn-google" href='https://plus.google.com/share?url=<?php the_permalink();?>'><i class="icon-google-plus"></i></a>    
																<a class="share-btn tr icn-twitter" href='https://twitter.com/share?url=<?php the_permalink();?>'><i class="icon-twitter"></i></a>    
																<a class="share-btn tl icn-facebook" rel="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>" href="javascript:window.open('http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>', '_blank', 'width=600,height=400');void(0);"><i class="icon-facebook"></i></a>    
																<a class="share-btn br icn-pinterest" href='http://pinterest.com/pin/create/button/?url=<?php the_permalink()?>&media=<?php echo $src[0]; ?>'><i class="icon-pinterest"></i></a>    
															
															</div>
														</div>
													</div><?php
												}?>	
											</div>   
										</div><?php
                                        }?>	

								</div>
							</div>
						</div><?php
					};
						if($show_sidebar == 'sbleft'){?>
							<div class="sbleft sbleftnofx"><?php 
								dynamic_sidebar ('woo-product-sidebar'); ?>
							</div><?php
						}else if($show_sidebar == 'sbright'){?>
							<div class="sbright sbrightnofx"><?php 
								dynamic_sidebar ('woo-product-sidebar'); ?>
							</div><?php
						};
						
						if( $post_showfbcomments == 'on'){?>
                        	<div class="ss-full ss-row fb-padding  nofx">
								<div class="container-border " >
									<div class="gray-container <?php global $post_color; echo $post_color;?>">
                                    <h3 class="content-title comm-title">Facebook</h3> 
                                        <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="2" data-height="250" data-width="470" <?php if($post_color == 'gglass gdarck'){ ?> data-colorscheme="dark" <?php }; ?>>
                                        
                                        </div>
                                        <div class="icon-soc-container">
                                            <div class="share-btns">								
                                                <div class="empty-left time-holder-nob"><i class="icon-comments icon-large"></i> 
                                                    <fb:comments-count href=<?php the_permalink(); ?>></fb:comments-count>
                                                </div>
                                            </div>   
                                        </div>
									</div>
								</div>
							</div> <?php 
						};          
						if($post_showdscomments == 'on'  ){?> 
              
					<div class="ss-full ss-row fb-holder nofx disquis_h ">
						<div class="container-border ">
							<div class="gray-container <?php global $post_color; echo $post_color;?>">
                             	<h3 class="content-title comm-title">Disquis<?php //echo $tr_disqus_title;?></h3> 
								<div class="nano">
									<div class="cscrol content">
                             			<div id="disqus_thread"><p></p></div>
									</div>
                                </div>
                                <div class="icon-soc-container">
                                    <div class="share-btns">								
                                        <div class="empty-left time-holder-nob"><i class="icon-comments icon-large"></i> 
                                        </div>
                                    </div>   
                                </div>
							</div> 
						</div> 
					</div> 
					<?php
			
            };        
						?>
                        <div class="nofx">
                        <?php global $woocommerce, $product, $post;
if ( comments_open() ) : ?><div id="reviews"><?php
	echo '<div id="comments">';
	if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
	
		$count = $product->get_rating_count();
		if ( $count > 0 ) {
			$average = $product->get_average_rating();?>
            <div class="ss-row iscomm  c-comment  "  >
				<div class="ss-full">
                    <div class="container-border">
                        <div class="gray-container gcnopadding <?php global $post_color; echo $post_color;?>" > 
        <?php
						echo '<a href="#review_form"><div class="star-rating" style="font-size:17px!important; margin-top:7px; "  title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average ).'"><span class="  " style=" color:inherit!important; width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating" >'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div></a>';
						echo '<h3 class="content-title" style="text-align:left; padding-bottom:0;">'.sprintf( _n('%s review for %s', '%s reviews for %s', $count, 'woocommerce'), '<span itemprop="ratingCount" class="count">'.$count.'</span>', wptexturize($post->post_title) ).'</h3>';
						?>
            		</div>
                    </div>
				</div>
               
			</div><?php
		} else {?>
            <div class="ss-row iscomm  c-comment "  >
				<div class="ss-full">
                    <div class="container-border">
                        <div class="gray-container gcnopadding <?php global $post_color; echo $post_color;?>" ><?php
                    echo '<h2>'.__( 'Reviews', 'woocommerce' ).'</h2>';
                    echo '<p class="noreviews">'.__( 'There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'woocommerce' ).'</p>';?>
                    </div>
                </div>
                </div>
            </div><?php
		}
	} else {?>
        <div class="ss-full page-no-date">
        	<div class="container-border">
				<div class="gray-container"><?php
				echo '<h2>'.__( 'Reviews', 'woocommerce' ).'</h2>';?>
            	</div>
			</div>
 		</div><?php
	}
	$title_reply = '';
	if ( have_comments() ) :
		echo '<ol>';
			wp_list_comments( array( 'callback' => 'woocommerce_comments' ) );
		echo '</ol>';
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<div class="ss-row iscomm  c-comment "  >
				<div class="ss-full">
                    <div class="container-border">
                        <div class="gray-container navnopadding <?php global $post_color; echo $post_color;?>" > 
                                            <div class="nav-previous empty-left"  ><?php previous_comments_link( __( '&larr; Older Comments', 'twentyeleven' ) ); ?></div>
                                            <div class="nav-next empty-right" ><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyeleven' ) ); ?></div>
                                       
						</div>
					</div>
        		</div>
			</div><?php 
		endif;
		//echo '<p class="add_review"><a href="#review_form" class="inline show_review_form button" title="' . __( 'Add Your Review', 'woocommerce' ) . '">' . __( 'Add Review', 'woocommerce' ) . '</a></p>';
		$title_reply = __( 'Add a review', 'woocommerce' );
	else :
		$title_reply = __( 'Be the first to review', 'woocommerce' ).' &ldquo;'.$post->post_title.'&rdquo;';
		//echo '<p class="noreviews">'.__( 'There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'woocommerce' ).'</p>';
	endif;

	$commenter = wp_get_current_commenter();?>
    </div>
	<div class="ss-row iscomm  c-comment"  >
				<div class="ss-full">
                    <div class="container-border">
                        <div class="gray-container <?php global $post_color; echo $post_color;?>" >
                    <div id="review_form_wrapper">
                        <div id="review_form"><?php
                        $comment_form = array(
                            'title_reply' => $title_reply,
                            'comment_notes_before' => '',
                            'comment_notes_after' => '',
                            'fields' => array(
                                'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . '</label> ' . '<span class="required">*</span>' .
                                            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
                                'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . '</label> ' . '<span class="required">*</span>' .
                                            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
                            ),
                            'label_submit' => __( 'Submit Review', 'woocommerce' ),
                            'logged_in_as' => '',
                            'comment_field' => ''
                        );
                    
                        if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {
							
                            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . __( 'Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
                                <option value="">'.__( 'Rate&hellip;', 'woocommerce' ).'</option>
                                <option value="5">'.__( 'Perfect', 'woocommerce' ).'</option>
                                <option value="4">'.__( 'Good', 'woocommerce' ).'</option>
                                <option value="3">'.__( 'Average', 'woocommerce' ).'</option>
                                <option value="2">'.__( 'Not that bad', 'woocommerce' ).'</option>
                                <option value="1">'.__( 'Very Poor', 'woocommerce' ).'</option>
                            </select></div>';
                    
                        }
                    
                        $comment_form['comment_field'] .= '<div class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>' . $woocommerce->nonce_field('comment_rating', true, false);
                    
                        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );?>
                    
                        </div>
                    </div>
                            
             <div class="icon-soc-container">
                            <div class="share-btns"><?php
							if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ){?>
                            	<nav class="comment-nav-below">
                                	
								</nav>
                            <?php };?>
                            </div>
                        </div>
                </div>
                
                
            </div>
            
    
		</div>
        
	</div>
</div>
<?php endif; 




					
					
					
					
					
					
					
					
					
					
						comments_template();?>
					</div>
			</div>
				
				 
			</div>
<script>
jQuery(document).ready(function ($) {
	//Custom scroll
	//==================================================
$("#dropdown_product_cat").msDropDown();
	$(".variations select").msDropDown();
	
	$('div.widgetmarg').each(function() {
		var thedd = $(this);
    if($('div.dd', this).length > 0) {
     thedd.css('z-index','999999');
    }
});
	scrollrefresh = function(){
	
	
		$(".nano").nanoScroller({ alwaysVisible: true, iOSNativeScrolling: false});
		$('.slider').addClass("<?php echo $post_color;?> ");
	}
	setInterval("scrollrefresh()",550);
});
</script>        	
              
	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		//do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			//do_action( 'woocommerce_single_product_summary' );
		?>

	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		//do_action( 'woocommerce_after_single_product_summary' );
	?>

	</section>	
	</article>
</div><!-- #product-<?php the_ID(); ?> -->
</div>
</div>
</div>




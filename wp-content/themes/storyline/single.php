<?php
/*
* Theme Name: Storyline Board Theme
*

* Description: Storyline Board Theme is a stand-out-of-the-crowd product, 
* a perfect board to display your creative work or just amaze your friends
* with a new generation blog.
*
* Version: 1.0 
*/
?>

<?php get_header();?>
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
		<?php if(of_get_option('comments-fx', 'no entry' ) == 'on'){ ?>
			initButtons();<?php 
		}?>
		initClickInactive();
		deck.slide(0);
		
			
		
		var hash = window.location.hash;
		if(hash === "#comments"){
			<?php  if(of_get_option('comments-fx', 'no entry' ) != 'off'){?>
			setTimeout( function(){
			$('article').css('overflow', 'hidden');
			deck.next()}, 800);  <?php
			}?>
		}
		
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
		var bounce = '<?php echo of_get_option('comments-bounce', 'on' ); ?>';
		var start = 0;
		$('#main').bind('mousewheel DOMMouseScroll', function(e){
			if( $('#firsts').hasClass('bespoke-active') ){
				if($('.cscrol').scrollTop() + $('.cscrol').innerHeight() >= $('.cscrol')[0].scrollHeight -10 && bounce == 'on' ){
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
				var bounce = '<?php echo of_get_option('comments-bounce', 'on' ); ?>';
				if( $('#firsts').hasClass('bespoke-active') ){
					if($('.cscrol').scrollTop() + $('.cscrol').innerHeight() >= $('.cscrol')[0].scrollHeight -20 && bounce == 'on'){
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
				if(Math.abs(delta) < 100) {
					return;
				}
			
				
				jQuery('.cscrol').animate({
					scrollTop: 1
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
		var hasBeenClicked = false;
		var n = $("section").length;
		$('#linkclick').click(function(){
			hasBeenClicked = true;
		});
		$('section').click(function() {
			if(hasBeenClicked) {
				jQuery('.cscrol').animate({
					scrollTop: 0
				}, 'slow', function(){ 
					if( $('#firsts').hasClass('bespoke-active') ){
						$('article').css('overflow', 'visible');
					}else{
						$('article').css('overflow', 'hidden');
					}
						deck.slide(1);
						hasBeenClicked = false;				
				});	
					
			}else{
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
							hasBeenClicked = false;			
					});
				}
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
</script><?php
global $fbcomm, $post_showfbcomments;
if ( $post_showfbcomments == 'on' ){
	$fbcomm = 2;
}else{
	$fbcomm = 1;
}
?>
<div id="main" <?php post_class(); ?>>
	<div class="nano mnano  ">
    	<div class="cscrol content"><?php 
			//BEGIN LOOP
			//=====================================================?> 
            <article class="single-post"><?php
				if(have_posts()) : ?><?php while(have_posts()) : the_post(); 
				$id = get_the_ID();
				$post_meta_data = get_post_custom($post->ID);
				include('functions/post-settings.php');
				$nextPost = get_next_post();
				$prevPost = get_previous_post();				
				if (!empty( $nextPost )){ 
					$large_image_url_n = wp_get_attachment_image_src( get_post_thumbnail_id($nextPost->ID), array(90,90));
					$nepoid = $nextPost->ID;
					$next_post_url = get_permalink($nepoid); 
				}
				if (!empty( $prevPost )){ 	
					$large_image_url_p = wp_get_attachment_image_src( get_post_thumbnail_id($prevPost->ID), array(90,90));
					$prpoid = $prevPost->ID;
					$prev_post_url = get_permalink($prpoid);
				}
				
				?>
                
                <section rel="0" id='firsts'><?php
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
						})
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
					<div class="ss-row"><?php 
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
								
							}else{?>
								<div class="ribbon ribbon-title">
									<?php if(apply_filters ('the_title', get_the_title()) !=''  ) {
										if($post_showtitle != 'hide'){?>  
										<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
											<?php
										};
									};?>
									
								
								</div><?php 
							
							}
						};
						if(has_post_thumbnail() && $post_show_featured != 'hide') {
							$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,305, ), true );
							$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full', true );
							if($custom_repeatable[0] != ''){?>
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
										foreach ($custom_repeatable as $string) {
											$srcslider = wp_get_attachment_image_src( $string, array( 720,405, ), true );
											$srcsliderf = wp_get_attachment_image_src( $string, 'full', true );?>
											<li>
												<div class="hover-effect h-style">
													<a href="<?php echo $srcsliderf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $srcslider[0]; ?>" class="clean-img"/> 
														<div class="mask"><i class="icon-search"></i>
															<span class="img-rollover"></span>
														</div>
													</a>
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
						if(apply_filters( 'the_content', get_the_content()) !='' || $post_showtitle == 'hide' ){
							?>
							<div class="container-border zindex-up">
								<div class="gray-container <?php if($post_showcategory == "hide" && $post_showsoc == "hide"){ ?>gcnopadding<?php }?> <?php if(!has_post_thumbnail() && $post_showdate == "show" && $post_embed_video_yt == '' && $post_embed_video_vm =='') {?> addpaddingmore<?php }?>"> <?php 
									if(apply_filters ('the_title', get_the_title()) !=''  ) {
										if($post_showtitle != 'hide'){
											if($post_ribbon_display == 'date'){?>                         	
												<h1 class="content-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><?php
											};
										};
									};
									the_content();
									wp_link_pages(); 
								   	the_tags('<ol class="tags"><li>', '</li><li>', '</li> </ol>');?>
                                  <?php
									if($post_showcategory != "hide" || $post_showsoc != "hide"){ ?>
										<div class="icon-soc-container">
											<div class="share-btns"><?php	
										
                                                if($post_showcategory != "hide"){		
												$category = get_the_category();?>
														<div class="empty-left time-holder "> <a class="read-more-init" href="<?php echo get_category_link( $category[0]->term_id );?>"><i class="icon-tag icon-large"></i> <?php echo $category[0]->cat_name;?></a>
														</div> 
                                                       
                                                        <div class="empty-left user-holder"><a href="#"><i class="icon-user icon-large"></i> <?php  the_author(); ?> </a>
														</div>
														
                                                        <?php if ( comments_open()){?>
                                                            <div class="empty-left user-holder"> <a  href="<?php comments_link(); ?>" id='linkclick'><i class="icon-comments icon-large"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                                                            </div>
                                                            <?php };?>
                                                        <?php if( function_exists('dot_irecommendthis') ) {?> 
														 <div class="empty-left comm-holder"> <?php if( function_exists('dot_irecommendthis') ) dot_irecommendthis(); ?></div><?php };?><?php 
												}
												if(!empty( $prevPost )){ ?>
													<a class="read-more-init navposts <?php if (empty( $large_image_url_p[0] )){ ?> navpostnoimg <?php }?>" href=" <?php echo $prev_post_url;?>">
                                                        <div class="cell">
                                                            <div class="share-wrapper below navposts">
                                                                <div class=" share-action" ><i class="icon-chevron-right icon-large"></i></div>
                                                                <?php if (!empty( $large_image_url_p[0] )){ ?>
                                                                <div class="share-container" style="background:url(<?php echo $large_image_url_p[0]; ?>) center center;" ></div>
                                                                <?php }; ?>
                                                            </div>
                                                        </div>
													</a><?php 
												};
												if(!empty( $nextPost )){ ?>
													<a class="read-more-init navposts <?php if (empty( $large_image_url_n[0] )){ ?> navpostnoimg <?php }?>" href=" <?php echo $next_post_url;?>">
                                                        <div class="cell">
                                                            <div class="share-wrapper below navposts">
                                                                <div class=" share-action" ><i class="icon-chevron-left icon-large"></i></div>
                                                                <?php if (!empty( $large_image_url_n[0] )){ ?>
                                                                <div class="share-container" style="background:url(<?php echo $large_image_url_n[0]; ?>) center center;" >
                                                                </div>
                                                                <?php }; ?>
                                                            </div>
                                                        </div>
													</a><?php 
												};
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
													</div><?php
												}?>	
											</div>   
										</div><?php
									};?>
								</div>
							</div>
						</div><?php
					};
					
					if(of_get_option('related-posts') == 'on' && of_get_option('comments-fx', 'no entry' ) != 'off'){?>
					<script type="text/javascript">
						//Flexslider settings
						//==================================================
						jQuery(document).ready(function($){				 					 
						   $('#flexslider-related').flexslider({
							animation: "slide",
							itemWidth: 158,
							itemMargin: -3, 
							mousewheel: false, 
							animationLoop: true
						  });
						
						});
					</script><?php	
							
							
					$orig_post = $post;
					global $post;
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
						$tag_ids = array();
						foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
						$args=array(
							'tag__in' => $tag_ids,
							'post__not_in' => array($post->ID),
							'posts_per_page'=> of_get_option('max-related-posts'), // Number of related posts that will be shown.
							'ignore_sticky_posts'=>1
						);
						$my_query = new wp_query( $args );
						if( $my_query->have_posts() ) {?>
							<div class="ss-full fb-padding fb-paddingfx nofx">
                            	<div class="ss-row">
                                	<div class="gray-container <?php global $post_color; echo $post_color;?>">
										<h3 class="content-title comm-title">Related Posts</h3>
                                        <div id="flexslider-related" class="flexslider">
											<ul class="slides"><?php
												while( $my_query->have_posts() ) {
													$my_query->the_post(); ?>
													<li>
														<div class="hover-effect h-style relatedimg">
															<a href="<?php the_permalink()?>" class="read-more-init"><?php the_post_thumbnail( 'thumbnail' ); ?>
																<div class="mask"><i class="icon-link"></i>
																	<span class="img-rollover"></span>
																</div>
															</a>
														</div>
														<div class="relatedcontent">
															<h4><a href="<?php the_permalink()?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
															<?php the_time('M j, Y') ?>
														</div>
													</li><?php 
												}?>
											</ul>
										</div> 
                                        <div class="icon-soc-container">
											<div class="share-btns">								
												<div class="empty-left related-holder-nob"><i class="icon-exchange"></i><?php 
													echo $my_query->post_count; ?> articles are related.
												</div>
											</div>   
										</div>
									</div>
								</div>
							</div><?php 
						}
					}
					$post = $orig_post;
					wp_reset_query(); 
					};

					if(of_get_option('comments-fx', 'no entry' ) == 'off'){
						
						if($show_sidebar == 'sbleft'){?>
							<div class="sbleft sbleftnofx"><?php 
								dynamic_sidebar ('blog-sidebar'); ?>
							</div><?php
						}else if($show_sidebar == 'sbright'){?>
							<div class="sbright sbrightnofx"><?php 
								dynamic_sidebar ('blog-sidebar'); ?>
							</div><?php
						};
						if(of_get_option('related-posts') == 'on'){?>
						<script type="text/javascript">
                            //Flexslider settings
                            //==================================================
                            jQuery(document).ready(function($){				 					 
                               $('#flexslider-related').flexslider({
                                animation: "slide",
                                itemWidth: 158,
                                itemMargin: -3, 
                                mousewheel: false, 
                                animationLoop: true
                              });
                            
                            });
                        </script><?php	
                                
                                
                        $orig_post = $post;
                        global $post;
                        $tags = wp_get_post_tags($post->ID);
                        if ($tags) {
                            $tag_ids = array();
                            foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                            $args=array(
                                'tag__in' => $tag_ids,
                                'post__not_in' => array($post->ID),
                                'posts_per_page'=> of_get_option('max-related-posts'), // Number of related posts that will be shown.
                                'ignore_sticky_posts'=>1
                            );
                            $my_query = new wp_query( $args );
                            if( $my_query->have_posts() ) {?>
                                <div class="ss-full fb-padding nofx">
                                    <div class="ss-row">
                                        <div class="gray-container <?php global $post_color; echo $post_color;?>">
                                            <h3 class="content-title comm-title">Related Posts</h3>
                                            <div id="flexslider-related" class="flexslider">
                                                <ul class="slides"><?php
                                                    while( $my_query->have_posts() ) {
                                                        $my_query->the_post(); ?>
                                                        <li>
                                                            <div class="hover-effect h-style relatedimg">
                                                                <a href="<?php the_permalink()?>" class="read-more-init"><?php the_post_thumbnail( 'thumbnail' ); ?>
                                                                    <div class="mask"><i class="icon-link"></i>
                                                                        <span class="img-rollover"></span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="relatedcontent">
                                                                <h4><a href="<?php the_permalink()?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                                                <?php the_time('M j, Y') ?>
                                                            </div>
                                                        </li><?php 
                                                    }?>
                                                </ul>
                                            </div> 
                                            <div class="icon-soc-container">
                                                <div class="share-btns">								
                                                    <div class="empty-left related-holder-nob"><i class="icon-exchange"></i><?php 
                                                        echo $my_query->post_count; ?> articles are related.
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                </div><?php 
                            }
                        }
                        $post = $orig_post;
                        wp_reset_query(); 
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
                        
                        
                        <div class="nofx"><?php
                        	comments_template();?>
                        </div><?php
					}?> 
				</div><?php
				if(of_get_option('comments-fx', 'no entry' ) != 'off'){ 
					if($show_sidebar == 'sbleft'){?>
						<div class="sbleft">
						  <?php dynamic_sidebar ('blog-sidebar'); ?>
						</div><?php
					}else if($show_sidebar == 'sbright'){?>
						<div class="sbright">
						  <?php dynamic_sidebar ('blog-sidebar'); ?>
						</div><?php
					};
				}?>
                    
                     
			</div>
		</section>
		<?php  
		if($post_showfbcomments == 'on' ){
			if(of_get_option('comments-fx', 'no entry' ) != 'off'){ 
				global $fbcomm;
				$fbcomm = 2;?> 
                <section id="section-1">
					<div class="ss-full ss-row fb-holder">
                    
						<div class="container-border">
                       
							<div class="gray-container <?php global $post_color; echo $post_color;?>">
                             <h3 class="content-title comm-title">Facebook</h3> 
								<div class="nano">
									<div class="cscrol content">
                                    	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="2" data-height="250" data-width="470" <?php if($post_color == 'gglass gdarck'){ ?> data-colorscheme="dark" <?php }; ?>>
                                        </div>
									</div>
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
					</div> 
				</section><?php 
			}
			
		};
		if($post_showdscomments == 'on'  ){
			if(of_get_option('comments-fx', 'no entry' ) != 'off'){ ?> 
                <section id="<?php if($post_showfbcomments == 'on' ){ ?>section-2 <?php }else{?>section-1<?php }?>" class="disquis_h">
					<div class="ss-full ss-row fb-holder">
						<div class="container-border">
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
               
					
               </section><?php
			}
            };
		
				
		if(of_get_option('comments-fx', 'no entry' ) == 'on'){ 
			comments_template(); 
		}?>
			
		<?php endwhile; ?>
        <?php endif;  wp_reset_query();?>
	</article><?php 
	if(of_get_option('comments-fx', 'no entry' ) == 'on'){ ?>
		<div class="bottom-nav">
			<div><i id="backb-arrow" class="icon-step-backward navkey"></i> <i id="prev-arrow" class="icon-arrow-left navkey"></i> <i id="next-arrow" class="icon-arrow-right navkey "></i></div>
		</div><?php
	}?>
</div>
</div>
</div>

 <script>
jQuery(document).ready(function ($) {
	//Custom scroll
	//==================================================

	scrollrefresh = function(){
		
		$(".nano").nanoScroller({ alwaysVisible: true, iOSNativeScrolling: false});
		$('.slider').addClass("<?php global $post_color; echo $post_color;?> ");
	}	
	
	setInterval("scrollrefresh()",550);
});
</script>
<?php get_sidebar(); ?>	
<?php get_footer(); ?>


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
<?php get_header();

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
	
	//scrollinit();
	setTimeout(scrollinit,1000);
	function initThemeSwitching() {
		themes = [
			'classic',
			'cube',
			'carousel',
			'concave',
			'coverflow'
		];
		selectedThemeIndex = 0;
		if(window.lastslide !==''){
			deck.slide(window.lastslide-1);
		}else{
			deck.slide(0);
		}
		if(window.openfirst !== 1){
			deck.slide(<?php if( of_get_option('select-first-post') != ''){echo of_get_option('select-first-post');}else{ echo '0';};?>);
			window.openfirst = 1
		}
		
		initInstructions();
		initKeys();
		initButtons();
		initSlideGestures();
		initClickInactive();
		var whichtehem = "<?php if( of_get_option('scroll-effect') != ''){echo of_get_option('scroll-effect');}else{ echo '0';};?>";
		//If browser doesn't support trasnforms3d swich scroll effect to classic
		//==================================================
		if(Modernizr.csstransforms3d === false){
			$('body').addClass("classic");
		}
		var hash = window.location.hash;
		var findme = "!slide-";
		var n = $("section").length;
		var getString = hash.replace ( /[^\d.]/g, '' );
		if(getString && hash.indexOf(findme) > -1){
			if(n <= getString){
				document.removeEventListener('keydown', gokb);
				setTimeout( function(){
				window.initajax()},10)
			}
			deck.slide(getString);
		}
	}
	//Display wellcome buble (use cookie to show only once
	//==================================================
	function initInstructions() {
		if (isTouch()) {
			$('body').addClass('forios');
		}
		function setCookie(c_name,value,exdays){
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays===null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
		}	
		function getCookie(c_name){
			var c_value = document.cookie;
			var c_start = c_value.indexOf(" " + c_name + "=");
			if (c_start === -1){
				c_start = c_value.indexOf(c_name + "=");
			}
			if (c_start === -1){
				c_value = null;
			}else{
				c_start = c_value.indexOf("=", c_start) + 1;
				var c_end = c_value.indexOf(";", c_start);
				if (c_end === -1){
					c_end = c_value.length;
				}
				c_value = unescape(c_value.substring(c_start,c_end));
			}
			return c_value;
		}
		function checkCookie(){
			window.bopen = 2;
			var bubleopen = Number(getCookie("storyline"));
			if(bubleopen !== 1){
				$(window).bind("load", function() {
					window.bopen = 1;
					$("#ss-container").unbind("mousewheel DOMMouseScroll");
					
					showInstructions()
					instructionsTimeout=setTimeout(showInstructions, 2000);
				});
			}
		}	<?php if(of_get_option('wellcome-msg', 'no entry' ) =='1'){ 
		if(of_get_option('yt-bg-type') != 'true' ){?>
		checkCookie();
		<?php } ?>
		
		setCookie('storyline','1', 1);	
		<?php };?>
	}
	//Small bottom navigation
	//==================================================
	function initButtons() {
		document.getElementById('enter-arrow').addEventListener('click', function(){
			var storyId = $('.bespoke-active a.read-more-init').attr('href');
			selectactive(storyId);
		});
		document.getElementById('backb-arrow').addEventListener('click', function(){deck.slide(0); window.clearInterval(autorotateposts);});
		document.getElementById('next-arrow').addEventListener('click', gonext);
		document.getElementById('prev-arrow').addEventListener('click', function(){deck.prev(); window.clearInterval(autorotateposts);});

	}
	function gonext(){
		window.clearInterval(autorotateposts);
		deck.next();
		var n = $("section").length;
		$('section').each(function(){
			if( $(this).hasClass('bespoke-active') && Number($(this).attr('rel'))+1 ===n){
				<?php if(of_get_option('def-pagination-display') != "pagination"){?>
				if(window.initajax() !== false){
					document.removeEventListener('keydown', gokb);
					document.getElementById('next-arrow').removeEventListener('click', gonext);
				}
				<?php };?>
			}
		});
	}
	//Keyboard navigation
	//==================================================
	function initKeys(e) {
		document.getElementById('next-arrow').removeEventListener('click', gonext);
		
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
			if(key === 13 ){
				window.issearch = 0;
				$("#searchform").submit(function(e){ window.issearch = 1;});
				var storyId = $('.bespoke-active a.read-more-init').attr('href');
				selectactive(storyId);
			}
			if(key === 37){
				window.clearInterval(autorotateposts);
				deck.prev();
			}
			if(key === 32 || key === 39){
				window.clearInterval(autorotateposts);
				deck.next();
			}
			//theme swiching
			/*if(key === 38){
				if(Modernizr.csstransforms3d !== false){
				prevTheme();
				}
			}
			if(key === 40){
				if(Modernizr.csstransforms3d !== false){
				nextTheme();
				}
			}*/
			var n = $("section").length;
			$('section').each(function(){
				if( $(this).hasClass('bespoke-active') && Number($(this).attr('rel'))+1 ===n){
					<?php if(of_get_option('def-pagination-display') != "pagination"){?>
						if(window.initajax() !== false){
							document.removeEventListener('keydown', gokb);
						}
					<?php }; ?>
					}
				});
			};
		document.addEventListener('keydown', gokb);
	}
	//Animate post on read more click
	//==================================================
	function selectactive(storyId){
		//alert(storyId)
		var contentholder = document.getElementsByClassName("bespoke-active")[0];
		var allholder = document.getElementsByClassName("bespoke-parent")[0];
		<?php
		if(of_get_option('post-fx') == "on" ){ ?>
			allholder.style.opacity -= 0.1;
			document.body.style.opacity -= 0.1;
			move(contentholder)
				.rotate(10)
				.scale(6)
				.duration('0.4s')
				.end(function(){
					if(window.issearch != 1){
						window.open(storyId, '_self');
					}
				});<?php
		}else{?>
			window.open(storyId, '_self');<?php
		}?>
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
		var n = $("section").length;
		$('section').each(function(){
			if( $(this).hasClass('bespoke-active') && Number($(this).attr('rel'))+1 ===n && jQuery(document).width() > 530){
				<?php if(of_get_option('def-pagination-display') != "pagination"){?>
				if(window.initajax() === false){
					document.addEventListener('keydown', gokb);
				}else{
					$("#ss-container").unbind("mousewheel DOMMouseScroll");
					document.removeEventListener('keydown', gokb);	
				}
				<?php }; ?>
			}
		});
		if(jQuery(document).width() < 530){
			if(jQuery(window).scrollTop() > jQuery(document).height() - jQuery(window).height()-150){
				<?php if(of_get_option('def-pagination-display') != "pagination"){?>
				if(window.initajax() === false){
					document.addEventListener('keydown', gokb);
				}else{
					$("#ss-container").unbind("mousewheel DOMMouseScroll");
					document.removeEventListener('keydown', gokb);	
				}
				<?php };?>
				
			}
		}
		$('#ss-container').bind('mousewheel DOMMouseScroll', function(e){
			if(extractDelta(e) > 0) {
			$("#ss-container").unbind("mousewheel DOMMouseScroll");
				setTimeout(prevp, 200); 
			}
			if(extractDelta(e) < 0) {
			$("#ss-container").unbind("mousewheel DOMMouseScroll");
				setTimeout(nextp, 200);
			}
		});
		function prevp(){
			window.clearInterval(autorotateposts);
			deck.prev();
			setTimeout( gomousewheel, 200);  
		}
		function nextp(){
			window.clearInterval(autorotateposts);
			deck.next();
			setTimeout( gomousewheel, 200);  
		}
	};
	window.gomouse();
	//Navigation for touch devices
	//==================================================
	function initSlideGestures() {
		var start = 0;
		var main = document.getElementById('main'),
			startPosition,
			delta,
			
			singleTouch = function(fn, preventDefault) {
				return function(e) {
					if(e.touches.length === 1){
						fn(e.touches[0].pageX);
					}
				};
			},
			touchstart = singleTouch(function(position) {
				startPosition = position;
				delta = 0;
					start = 0;
					main.addEventListener('touchend', touchend); 
			}),

			touchmove = singleTouch(function(position) {
				delta = position - startPosition;
			}, true),
			
			touchend = function() {		
			if(jQuery(document).width() < 530){
					if(jQuery(window).scrollTop() > jQuery(document).height() - jQuery(window).height()-80){
						<?php if(of_get_option('def-pagination-display') != "pagination"){?>
						if(window.initajax() === false){
							main.addEventListener('touchstart', touchstart);
							main.addEventListener('touchmove', touchmove);
							main.addEventListener('touchend', touchend);
						}else{
							main.removeEventListener('touchstart', touchstart);
							main.removeEventListener('touchmove', touchmove);
							main.removeEventListener('touchend', touchend);
						}
						<?php }; ?>
					}
				}	
				if (Math.abs(delta) < 50) {
					return;
				}
				if(delta > 0){
					window.clearInterval(autorotateposts);
					deck.prev();
				}else{
					window.clearInterval(autorotateposts);
					deck.next();
				}
				var n = $("section").length;
						
				$('section').each(function(){
					
					if( $(this).hasClass('bespoke-active') && Number($(this).attr('rel'))+1 ===n && jQuery(document).width() > 530){
						<?php if(of_get_option('def-pagination-display') != "pagination"){?>
						if(window.initajax() === false){
							main.addEventListener('touchstart', touchstart);
							main.addEventListener('touchmove', touchmove);
							main.addEventListener('touchend', touchend);
						}else{
							main.removeEventListener('touchstart', touchstart);
							main.removeEventListener('touchmove', touchmove);
							main.removeEventListener('touchend', touchend);
						}
						<?php }; ?>
					}
				});
				
			};
		window.remvoetuch = function(){
			main.removeEventListener('touchstart', touchstart);
			main.removeEventListener('touchmove', touchmove);
			main.removeEventListener('touchend', touchend);
		};
		window.addtuch = function(){
			main.addEventListener('touchstart', touchstart);
			main.addEventListener('touchmove', touchmove);
			main.addEventListener('touchend', touchend);
		};
		window.addtuch();
	}
	//theme swiching
	function selectTheme(index) {
		var theme = themes[index];
		document.body.className = theme;
		selectedThemeIndex = index;
	}

	function nextTheme() {
		offsetSelectedTheme(1);
		if (window.bopen === 1){
			hideInstructions();	
			window.bopen = 2;
		}
	}
	function prevTheme() {
		offsetSelectedTheme(-1);
		if (window.bopen === 1){
			hideInstructions();	
			window.bopen = 2;
		}
	}
	function offsetSelectedTheme(n) {
		selectTheme(modulo(selectedThemeIndex + n, themes.length));
	}
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
		$("section").unbind("click");
		var main = document.getElementById('main');
		var n = $("section").length;
		window.lastslide = n;
		$('section').click(function() {
			window.clearInterval(autorotateposts);
			var page = $(this).attr('rel');
			var count = Number(page)+1;
			if( $(this).hasClass('bespoke-inactive') ){
				if(count === n){
					<?php if(of_get_option('def-pagination-display') != "pagination"){?>
					if(window.initajax() === false){
						document.addEventListener('keydown', gokb);
						window.remvoetuch();
						initSlideGestures();
					}else{
						document.removeEventListener('keydown', gokb);
						window.remvoetuch();
					}
					<?php }; ?>
				}
			deck.slide(page);
			if (!document.getElementById("firsts") && window.location.hash !='' ) {
				window.location.hash = '!slide-'+jQuery( "section.bespoke-active" ).attr("rel");
			}
			
			}
			
		});
	}
	
		
	
			
	//Animate post on read more click
	//==================================================
	var contentholder = document.getElementsByClassName("bespoke-active");
		var allholder = document.getElementsByClassName("bespoke-parent");
	function animate(){
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
			for(var i = 0, j=contentholder2.length; i<j; i++){
				contentholder2[i].addEventListener("mouseover", function(){
					var holdertoanimate = this.getElementsByClassName("container-border")[0];	
					var ribbon = this.getElementsByClassName("ribbon")[0];	
					if(holdertoanimate){
						move(this)
							.set('margin-top', -20)
							.duration('<?php echo of_get_option('rollover-duration', 'no entry' ); ?>s')
							.end();
						if(ribbon){
							move(ribbon)
								.set('margin-top', -15)
								.duration('<?php echo of_get_option('rollover-duration', 'no entry' ); ?>s')
								.end();
						}
					}else{
						move(this)
							.set('margin-top', -20)
							.duration('<?php echo of_get_option('rollover-duration', 'no entry' ); ?>s')
							.end();
					}
				});
				contentholder2[i].addEventListener("mouseout", function(){
					var holdertoanimate = this.getElementsByClassName("container-border")[0];
					var ribbon = this.getElementsByClassName("ribbon")[0];	
					if(holdertoanimate){
						move(this)
							.set('margin-top', 0)
							.duration('<?php echo of_get_option('rollout-duration', 'no entry' ); ?>s')
							.end();
						if(ribbon){
							move(ribbon)
								.set('margin-top', -0)
								.duration('<?php echo of_get_option('rollover-duration', 'no entry' ); ?>s')
								.end();
						}
					}else{
						move(this)
							.set('margin-top', 0)
							.duration('<?php echo of_get_option('rollout-duration', 'no entry' ); ?>s')
							.end();
					}
				});
			}
		}
	}
	<?php if(of_get_option('active-mouse-parallax', '0' ) == '1'){?>                             
            window.startparallax = function(){
                var $scene = $('#articlehold').parallax();
			}
			setTimeout(window.startparallax,400);<?php
        }?>
    
    var autorotateposts, stopnextslide;
	 <?php if(of_get_option('post-autorotate', 'off' ) =='on'){ ?> 
			function autoslide(){
				stopnextslide = 0;
				var n = $('section').length;
				
				$('section').each(function () {
					if ($(this).hasClass('bespoke-active') && Number($(this).attr('rel'))+1 == n) {
						deck.slide(0);
						stopnextslide = 1;
					}
				});
				if(stopnextslide != 1){
					deck.next();
				}
			}
			$('section').hover(function() {
				window.clearInterval(autorotateposts);
			}, function(){
					window.clearInterval(autorotateposts);
					
					 autorotateposts = setInterval(autoslide, <?php echo of_get_option('post-autorotate-delay', '3000' );?>);
			})
			var autorotateposts = setInterval(autoslide , <?php echo of_get_option('post-autorotate-delay', '3000' );?>);
				
		<?php }; ?>
	
});
</script>
<?php
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
if(of_get_option('tr-category-info') != ''){
	$tr_category_info = of_get_option('tr-category-info');
}else{
	$tr_category_info = "posts in category";
};
?>
<div id="main" <?php post_class(); ?>>


   
     

<?php
	
	//SORT ONLY STICKY ON HOME PAGE
	//=====================================================
	
		if(of_get_option('order-posts') == "ll" ){
		global $query_string;
			query_posts( $query_string . '&order=ASC' );
		}
	global $ha;
	$ha = 0;
	
	
	//BEGIN LOOP
	//=====================================================?> 
  
    <article id="articlehold"><?php
		if(have_posts()) : while ( have_posts() ) : the_post();
 	
	
			//DONT SHOW PAGES IN SEARCH RESULT
			//=====================================================
			if (is_search() && ($post->post_type=='page')) continue;
			//the_meta();
			$id = get_the_ID();
			$post_meta_data = get_post_custom($post->ID);
			
			include('functions/post-settings.php');?>	
				
			<section rel="<?php echo $ha; ?>">
                <div class="layer" data-depth="1"><?php
				$ha++;
				
				
				
				
				//JAVASCRIPT FOR FLEX SLIDER AND FADE IN
				//=====================================================?>
			   <?php
				do_shortcode( get_the_content() );
				
				//ROW BODY
				//=====================================================?>
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
					
				</script><?php 				
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
									if($custom_repeatable[0] != ''){?>
										<div id="flexslider-<?php echo $id;?>" class="flexslider" >
											<ul class="slides ">
                                            
												<!--[if IE]><div style="width:340px; min-width:340px;"></div> <![endif]-->
												<li> <?php
													if($row_style == "circle"){ ?>
														<ul class="ch-grid">
															<li>
																<div class="ch-item" style="background-image: url(<?php echo $src[0]; ?>);">
																<?php
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
																					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php
																					};
																				};?>
																			</div><?php
																		 }	
																	}?>						
																	<div class="ch-info-wrap">
																		<div class="ch-info">
																			<div class="ch-info-front" style="background-image: url(<?php echo $src[0]; ?>);"></div>
																			<div class="ch-info-back"><?php 
																				if(apply_filters ('the_title', get_the_title()) !='') {
																					if($post_showtitle != 'hide'){?>
																						<h3 class="content-title"><a id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
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
                                                                                           $category = get_the_category();?>
                                                                                            <span class="empty-left time-holder "> <a class="read-more-init" href="<?php echo get_category_link( $category[0]->term_id );?>"><i class="icon-tag icon-large"></i> <?php echo $category[0]->cat_name;?></a>
                                                                                            </span> 
                                                                                           
                                                                                            <span class="empty-left user-holder"><a href="#"><i class="icon-user icon-large"></i> <?php  the_author(); ?> </a>
                                                                                            </span>
                                                                                            <?php if ( comments_open()){?>
                                                                                            <span class="empty-left user-holder"> <a  href="<?php comments_link(); ?>"  class="read-more-init"><i class="icon-comments icon-large"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                                                                                            </span>
                                                                                            <?php };?>
                                                                                            <?php if( function_exists('dot_irecommendthis') ) {?> 
                                                                                             <span class="empty-left comm-holder"> <?php if( function_exists('dot_irecommendthis') ) dot_irecommendthis(); ?></span><?php };?> 
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
												foreach ($custom_repeatable as $string) {
													$srcslider = wp_get_attachment_image_src( $string, array( 480,480, ), true );?>												
													<li><?php
														if($row_style == "circle"){ ?>
															<ul class="ch-grid">
																<li>
																	<div class="ch-item" style="background-image: url(<?php echo $srcslider[0]; ?>);">
																	<?php 
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
																		}?>						
																		<div class="ch-info-wrap">
																			<div class="ch-info">
																				<div class="ch-info-front" style="background-image: url(<?php echo $srcslider[0]; ?>);"></div>
																				<div class="ch-info-back"><?php 
																					if(apply_filters ('the_title', get_the_title()) !='') {
																						if($post_showtitle != 'hide'){?>
																							<h3 class="content-title"><a id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
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
                                                                                               $category = get_the_category();?>
                                                                                                <span class="empty-left time-holder "> <a class="read-more-init" href="<?php echo get_category_link( $category[0]->term_id );?>"><i class="icon-tag icon-large"></i> <?php echo $category[0]->cat_name;?></a>
                                                                                                </span> 
                                                                                               
                                                                                                <span class="empty-left user-holder"><a href="#"><i class="icon-user icon-large"></i> <?php  the_author(); ?> </a>
                                                                                                </span>
                                                                                                <?php if ( comments_open()){?>
                                                                                                <span class="empty-left user-holder"> <a  href="<?php comments_link(); ?>"  class="read-more-init"><i class="icon-comments icon-large"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                                                                                                </span>
                                                                                                <?php };?>
                                                                                                <?php if( function_exists('dot_irecommendthis') ) {?> 
                                                                                                 <span class="empty-left comm-holder"> <?php if( function_exists('dot_irecommendthis') ) dot_irecommendthis(); ?></span><?php };?> 
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
													<div class="ch-item" style="background-image: url(<?php echo $src[0]; ?>);"> 
														<?php 
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
														}?>				
														<div class="ch-info-wrap">
                                                        
															<div class="ch-info">
                                                            
																<div class="ch-info-front" style="background-image: url(<?php echo $src[0]; ?>);"></div>
																<div class="ch-info-back"><?php 
																	if(apply_filters ('the_title', get_the_title()) !='') {
																		if($post_showtitle != 'hide'){?>
																			<h3 class="content-title"><a id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
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
                                                                               $category = get_the_category();?>
                                                                                <span class="empty-left time-holder "> <a class="read-more-init" href="<?php echo get_category_link( $category[0]->term_id );?>"><i class="icon-tag icon-large"></i> <?php echo $category[0]->cat_name;?></a>
                                                                                </span> 
                                                                               
                                                                                <span class="empty-left user-holder"><a href="#"><i class="icon-user icon-large"></i> <?php  the_author(); ?> </a>
                                                                                </span>
                                                                                 <?php if ( comments_open()){?>
                                                                                <span class="empty-left user-holder"> <a  href="<?php comments_link(); ?>"  class="read-more-init"><i class="icon-comments icon-large"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                                                                                </span>
                                                                                <?php };?>

                                                                                <?php if( function_exists('dot_irecommendthis') ) {?> 
                                                                                 <span class="empty-left comm-holder"> <?php if( function_exists('dot_irecommendthis') ) dot_irecommendthis(); ?></span><?php };?> 
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
							};?>
						<?php if(apply_filters( 'the_content', get_the_content()) == ''){?>
						<a class="read-more-init hidelink" id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php };
							if(has_post_thumbnail() || $post_embed_video_yt !='' || $post_embed_video_vm !='') {	
								if(apply_filters( 'the_content', get_the_content()) == ''){
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 550,550, ), true );
								}else{
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 550,550, ), true );
								}
								$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true );
								if($custom_repeatable[0] != ''){?>
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
															<p><?php echo $img_content; ?></p><?php 
															if($img_link){ ?>
																<a href="<?php echo $img_link; ?>" class="info" > <span class="button wpb_defbtn"><?php echo $img_buttontitle; ?></span></a><?php
															};?>
														</div><?php 
													}else{ 
														if ($post_embed_video_yt !='') {?>
																<iframe id="embedvideo" width="100%" height="190px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>?html5=1" frameborder="0" allowfullscreen></iframe><?php
											}else if ($post_embed_video_vm !=''){?>
													<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="190px" id="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
											}else if($post_img_link =='link'){?>
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
										};?>
												</div>
											</li> <?php
											foreach ($custom_repeatable as $string) {
												if(apply_filters( 'the_content', get_the_content()) == ''){
													$srcslider = wp_get_attachment_image_src( $string, array( 550,550, ), true );
												}else{
													$srcslider = wp_get_attachment_image_src( $string, array( 550,550, ), true );
												}
												$srcsliderf = wp_get_attachment_image_src( $string, 'full', true );
												?>
												<li>
													<div class="hover-effect h-style"><?php
														if($post_img_link =='link'){?>
                                                            <a class="read-more-init" href="<?php the_permalink(); ?>">
                                                            <img src="<?php echo $srcsliderf[0]; ?>" class="clean-img"/> 
                                                                <div class="mask"><i class="icon-link"></i>
                                                                    <span class="img-rollover"></span>
                                                                </div>
                                                            </a><?php
                                                        }else if($post_img_link =='image'){
                                                        ?>
                                                    
                                                        <a href="<?php echo $srcsliderf[0]; ?>" rel="prettyPhotoImages[<?php echo $id; ?>]"><img src="<?php echo $srcsliderf[0]; ?>" class="clean-img"/> 
                                                            <div class="mask"><i class="icon-search"></i>
                                                            
                                                                <span class="img-rollover"></span>
                                                            </div>
                                                        </a><?php 
                                                        }else if($post_img_link =='disable'){?>
                                                            <img src="<?php echo $srcsliderf[0]; ?>" class="clean-img"/><?php 
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
												<p><?php echo $img_content; ?></p><?php  
												if($img_link){ ?>
													<a href="<?php echo $img_link; ?>" class="info" > <span class="button wpb_defbtn"><?php echo $img_buttontitle; ?></span></a><?php
												}; ?>
											</div><?php 
										}else{ 
											if ($post_embed_video_yt !='') {?>
																<iframe id="embedvideo" width="100%" height="190px" src="http://www.youtube.com/embed/<?php echo $post_embed_video_yt;?>?html5=1" frameborder="0" allowfullscreen></iframe><?php
											}else if ($post_embed_video_vm !=''){?>
													<iframe src="http://player.vimeo.com/video/<?php echo $post_embed_video_vm;?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="190px" id="embedvideo" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe><?php
											}else if($post_img_link =='link'){?>
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
										};?>
									</div><?php 
								};
							}
							 
							if(apply_filters( 'the_content', get_the_content()) != '' || $post_showtitle == 'hide' && has_post_thumbnail()){ ?>
								<div class="container-border">
                                
									<div class="gray-container <?php if($post_showcategory == "hide" && $post_showsoc == "hide"){ ?>gcnopadding<?php }?>">
										<div class="containera <?php if(!has_post_thumbnail() && $post_showdate == "show" && $post_embed_video_yt == '' && $post_embed_video_vm =='') {?> addpadding<?php }?>"><?php
											if(apply_filters ('the_title', get_the_title()) !='') {
												if($post_showtitle != 'hide'){
													if($post_ribbon_display == 'date'){?>
													<h3 class="content-title"><a class="read-more-init" id="<?php echo $id;?>"  href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> <?php 
													};
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
														<div class="empty-left time-holder "> <a class="read-more-init" href="<?php echo get_category_link( $category[0]->term_id );?>"><i class="icon-tag icon-large"></i> <?php echo $category[0]->cat_name;?></a>
														</div> 
                                                       
                                                        <div class="empty-left user-holder"><a href="#"><i class="icon-user icon-large"></i> <?php  the_author(); ?> </a>
														</div>
														 <?php if ( comments_open()){?>
                                                        <div class="empty-left user-holder"> <a  href="<?php comments_link(); ?>"  class="read-more-init"><i class="icon-comments icon-large"></i> <?php comments_number( '0', '1', '%' ); ?></a>
                                                        </div>
                                                        <?php };?>
                                                        <?php if( function_exists('dot_irecommendthis') ) {?> 
														 <div class="empty-left comm-holder"> <?php if( function_exists('dot_irecommendthis') ) dot_irecommendthis(); ?></div><?php };?>
														<?php 
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
			</section><?php 
		endwhile; 
		else : ?>
			 <section >
				<div class=" s-no-result" > 				
					<div class="container-border ss-row">
						<div class="gray-container" >
	
							<h1 class="content-title"><?php echo $tr_searchtitle; ?></h1>
								<p><?php echo $tr_searchsubtitle; ?></p>
								<p><?php echo get_search_form(); ?></p>
						</div>
					</div>
				</div>        
			</div>
        </div>
		</section><?php
		endif;
		 add_editor_style();?>	   
    </article>
	<div class="animated numpostinfi <?php if(of_get_option('def-pagination-display') == "pagination"){?>bottom-nav-hide<?php }?>">
		<div class="numpostcontent"><?php
			echo $wp_query->found_posts.' '.$tr_category_info; 
			$cat_obj = $wp_query->get_queried_object();
			$category = $cat_obj->cat_name;  
			if($category){
				echo ' '.$category;	
			}?>
                
		</div>
	</div>
    <?php t_pagination($pages = '', $range = 2); ?>
</div>
<div class="bottom-nav" >
    <div><i id="backb-arrow" class="icon-step-backward navkey"></i> <i id="prev-arrow" class="icon-arrow-left navkey"></i> <i id="enter-arrow" class="icon-level-down navkey"></i> <i id="next-arrow" class="icon-arrow-right navkey "></i></div>
</div>   
<?php get_footer(); ?>
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
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
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
			deck.slide(<?php if( of_get_option('select-first-product') != ''){echo of_get_option('select-first-product');}else{ echo '0';};?>);
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
				<?php if(of_get_option('pagination-display') != "pagination"){?>
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
					<?php if(of_get_option('pagination-display') != "pagination"){?>
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
				<?php if(of_get_option('pagination-display') != "pagination"){?>
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
				<?php if(of_get_option('pagination-display') != "pagination"){?>
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
	$(".nano").hover(function() {
		$("#ss-container").unbind("mousewheel DOMMouseScroll")},
		function(){
			window.gomouse();
		}
	);
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
						<?php if(of_get_option('pagination-display') != "pagination"){?>
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
						<?php if(of_get_option('pagination-display') != "pagination"){?>
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
					<?php if(of_get_option('pagination-display') != "pagination"){?>
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
<div id="main">
<article id="articlehold">
<?php
/**
* woocommerce_before_shop_loop hook
*
* @hooked woocommerce_result_count - 20
* @hooked woocommerce_catalog_ordering - 30
*/
do_action( 'woocommerce_before_shop_loop' );
?>



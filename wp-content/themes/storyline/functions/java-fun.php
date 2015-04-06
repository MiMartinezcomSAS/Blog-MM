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


<?php
$body_typography = of_get_option('body_typography');
$title_typography = of_get_option('title_typography');
$button_typography = of_get_option('button_typography');
$menu_typography = of_get_option('menu_typography');
$submenu_typography = of_get_option('submenu_typography');
?> 

<style>
body, input, #comment{
	font-family:<?php echo $body_typography['face'];?>, Geneva, sans-serif; 
	font-size:<?php echo $body_typography['size'];?>;
	color:<?php echo $body_typography['color'];?>;
}
.icon-soc-container a, .woocommerce .icon-soc-container{
	 font-family:<?php echo $body_typography['face'];?>, Geneva, sans-serif; 
}

a {
	font-family:<?php echo $body_typography['face'];?>, Geneva, sans-serif; 
	color:<?php echo of_get_option('color_link');?>;
}
/*a:hover, .carousel a:hover {
	color:<?php echo of_get_option('color_link_hover');?>;
}*/
.content-title, .content-title a, .comment-reply-title, .ribbon-title a, .ribbon {
	font-weight:<?php echo $title_typography['style'];?>!important;
	font-family:<?php echo $title_typography['face'];?>, Geneva, sans-serif!important; 
	font-size:<?php echo $title_typography['size'];?>;
}
.ribbon .star-rating {
	font-size:16px!important;
}
.s-no-result .content-title{
	color:<?php echo $title_typography['color'];?>;
	
}
.nav li a, .dk_options_inner a  {
	font-family:<?php echo $menu_typography['face'];?>, Geneva, sans-serif;
	font-size:<?php echo $menu_typography['size'];?>; 
	color:<?php echo of_get_option('color_menu');?>;
	font-weight:<?php echo $menu_typography['style'];?>!important;
}
.nav li:hover a, .selected-nav a, .blackbody .nav li:hover a, .blackbody .selected-nav a{
	color:<?php echo of_get_option('color_menu_hover');?>;
}
.dk_options_inner a,  .dk_container a, .blackbody .dk_options_inner a {
	font-family:<?php echo $menu_typography['face'];?>, Geneva, sans-serif!important;
	font-size:<?php echo $menu_typography['size'];?>!important; 
	color:<?php echo of_get_option('color_menu');?>!important;
}
 .dk_options_inner a:hover  .blackbody .dk_options_inner a:hover,.dk_options a:hover, .dk_option_current a{
	color:<?php echo of_get_option('color_menu_hover');?>;
}


.nav ul li  a:link, .nav ul li  a:visited{
	font-family:<?php echo $submenu_typography['face'];?>, Geneva, sans-serif!important;
	font-size:<?php echo $submenu_typography['size'];?>!important; 
	color:<?php echo of_get_option('color_submenu');?>;
}

ul ul .current_page_item, ul li .current-menu-item, .nav ul li:hover ,.dk_options a:hover, .dk_option_current a{
	background-color:<?php echo of_get_option('color_submenu_hover');?>;
	color:#fff!important;
}
   ul ul .current-menu-item a, ul ul .current-menu-item  li a:hover{
	color:#fff!important;
}
ul ul .current-menu-item  li a{
	color:<?php echo of_get_option('color_menu');?>!important;
}

/**/

.nav ul li  a:hover, .nav ul ul:active a{
	<?php if(of_get_option('color_submenu')){ echo 'color:#fff!important;'; }?>
	
}
#widgets-m{
	padding-top:4px;
	width:32px;
	height:26px;
	visibility:visible;
	
	outline: none;
	<?php if(!of_get_option('color_button_border')){?>
		border:1px solid #666;
	<?php }?>
}
#widgets-m:after {
	content: '';
	position: absolute;
	width: 24px;
	height: 4px;
	top: 6px;
	left: 16%;
	-webkit-transition: all 0.3s linear;
	-moz-transition: all 0.3s linear;
	-o-transition: all 0.3s linear;
	-ms-transition: all 0.3s linear;
	transition: all 0.3s linear;
	<?php if(!of_get_option('color_button_border')){?>
		background: #666;
		color:#666;
		-webkit-box-shadow:0 8px 0 #666, 0 16px 0 #666;
		-moz-box-shadow:0 8px 0 #666, 0 16px 0 #666;
		-o-box-shadow:0 8px 0 #666, 0 16px 0 #666;
		box-shadow: 0 8px 0 #666, 0 16px 0 #666;
	<?php }?>
}

#widgets-m,  #commentform #submit, ol.forms li.buttons button, .defbtn ,.pagination span, .pagination a, .navcal-p .widget_shopping_cart .button{
  	border: solid 1px <?php echo of_get_option('color_button_border');?>!important;
	background:<?php echo of_get_option('color_button_top');?>;
	background: -webkit-linear-gradient(top, <?php echo of_get_option('color_button_top');?>, <?php echo of_get_option('color_button_bottom');?>);
	background: -moz-linear-gradient(top, <?php echo of_get_option('color_button_top');?>, <?php echo of_get_option('color_button_bottom');?>);
	background: -ms-linear-gradient(top, <?php echo of_get_option('color_button_top');?>, <?php echo of_get_option('color_button_bottom');?>);
	background: -o-linear-gradient(top, <?php echo of_get_option('color_button_top');?>, <?php echo of_get_option('color_button_bottom');?>);
	
}
	
.badgecat, .navcal-p .widget_shopping_cart .total{
	background:<?php echo of_get_option('color_button_border');?>!important;
}
.badgecat{
	border:1px solid <?php echo of_get_option('color_button_text');?>!important;
}



#s{
	border: solid 1px <?php echo of_get_option('color_button_border');?>;
}
#searchforma, #searchform, .bottom-nav, .numpostcontent{
	color: <?php echo of_get_option('color_button_text');?>;
}
header p{
	background: <?php echo of_get_option('color_button_text');?>;
}

.flex-direction-nav .flex-next:hover, .flex-direction-nav .flex-prev:hover, #widgets-m:hover , .button.violet:hover, #commentform #submit:hover, ol.forms li.buttons button:hover, .defbtn:hover, .pagination a:hover, .pagination .current  {
	background:<?php echo of_get_option('color_button_bottom');?>;
	background: -webkit-linear-gradient(top, <?php echo of_get_option('color_button_bottom');?>, <?php echo of_get_option('color_button_top');?>);
	background: -moz-linear-gradient(top, <?php echo of_get_option('color_button_bottom');?>, <?php echo of_get_option('color_button_top');?>);
	background: -ms-linear-gradient(top, <?php echo of_get_option('color_button_bottom');?>, <?php echo of_get_option('color_button_top');?>);
	background: -o-linear-gradient(top, <?php echo of_get_option('color_button_bottom');?>, <?php echo of_get_option('color_button_top');?>);
}
.flex-direction-nav .flex-next, .flex-direction-nav .flex-prev, .navcal-p .widget_shopping_cart .button {
	color:<?php echo of_get_option('color_button_text');?>!important;
}

.wpb_button, a.fland-button {
	font-family:<?php echo $button_typography['face'];?>, Geneva, sans-serif!important; 
	font-size:<?php echo $button_typography['size'];?>!important;
	color:<?php echo $button_typography['color'];?>!important;
}
.pagination span, .pagination a{
	  font-family:<?php echo $button_typography['face'];?>, Geneva, sans-serif!important; 
	  color:<?php echo $button_typography['color'];?>!important;
}
#widgets-m:after{
	background: <?php echo of_get_option('color_button_text');?>;
	-webkit-box-shadow:0 8px 0 <?php echo of_get_option('color_button_text');?>, 0 16px 0 <?php echo of_get_option('color_button_text');?>;
	-moz-box-shadow:0 8px 0 <?php echo of_get_option('color_button_text');?>, 0 16px 0 <?php echo of_get_option('color_button_text');?>;
	-o-box-shadow:0 8px 0 <?php echo of_get_option('color_button_text');?>, 0 16px 0 <?php echo of_get_option('color_button_text');?>;
	box-shadow: 0 8px 0 <?php echo of_get_option('color_button_text');?>, 0 16px 0 <?php echo of_get_option('color_button_text');?>;
}
#widgets-m .icon-chevron-down{
	color: <?php echo of_get_option('color_button_text');?>;
}
.ss-row:after{
	background-color:<?php echo of_get_option('color_el_border');?>!important;
}
.nav li:hover, .selected-nav, .current-menu-item, .current-menu-parent, .navcal li ul, .blackbody .navcal li ul, .nav li ul, .blackbody .nav li ul, .blackbody .dk_options_inner, .dk_options_inner, .dk_focus .dk_toggle {
	border-bottom-color:<?php echo of_get_option('color_el_border');?>;
}
.dk_toggle:hover {
	border-color:<?php echo of_get_option('color_el_border');?>!important;
}
.bar span{
	background-image: -webkit-linear-gradient(-45deg,  <?php echo of_get_option('color_el_border');?> 25%,transparent 25%,transparent 50%, <?php echo of_get_option('color_el_border');?> 50%, <?php echo of_get_option('color_el_border');?> 75%, transparent 75%, transparent );
	background-image: -moz-linear-gradient(-45deg, <?php echo of_get_option('color_el_border');?> 25%,transparent 25%,transparent 50%, <?php echo of_get_option('color_el_border');?> 50%, <?php echo of_get_option('color_el_border');?> 75%, transparent 75%, transparent);
	background-image: -o-linear-gradient(-45deg, <?php echo of_get_option('color_el_border');?> 25%,transparent 25%,transparent 50%, <?php echo of_get_option('color_el_border');?> 50%, <?php echo of_get_option('color_el_border');?> 75%, transparent 75%, transparent);
	background-image: -ms-linear-gradient(-45deg, <?php echo of_get_option('color_el_border');?> 25%,transparent 25%,transparent 50%, <?php echo of_get_option('color_el_border');?> 50%, <?php echo of_get_option('color_el_border');?> 75%, transparent 75%, transparent);
	background-image: linear-gradient(-45deg, <?php echo of_get_option('color_el_border');?> 25%,transparent 25%,transparent 50%, <?php echo of_get_option('color_el_border');?> 50%, <?php echo of_get_option('color_el_border');?> 75%, transparent 75%, transparent);
	border-color:<?php echo of_get_option('color_el_border');?> ;	
}
.nano > .pane > .slider{
	background: <?php echo of_get_option('color_scroll');?>;
}
 .flex-direction-nav .flex-next, .flex-direction-nav .flex-prev, .hover-effect .icon-search, .h-style .mask, .h-style h2, .h-style p, .h-style a.info   { 
	-webkit-transition: all <?php echo of_get_option('rollover-duration', 'no entry' ); ?>s ease;
	-moz-transition: all <?php echo of_get_option('rollover-duration', 'no entry' ); ?>s ease; 
	-o-transition: all <?php echo of_get_option('rollover-duration', 'no entry' ); ?>s ease; 
	-ms-transition: all <?php echo of_get_option('rollover-duration', 'no entry' ); ?>s ease; 
	transition: all <?php echo of_get_option('rollover-duration', 'no entry' ); ?>s ease;
}
.flex-direction-nav .flex-next:hover, .flex-direction-nav .flex-prev:hover {
	-webkit-transition: all <?php echo of_get_option('rollout-duration', 'no entry' ); ?>s ease;
	-moz-transition: all <?php echo of_get_option('rollout-duration', 'no entry' ); ?>s ease; 
	-o-transition: all <?php echo of_get_option('rollout-duration', 'no entry' ); ?>s ease; 
	-ms-transition: all <?php echo of_get_option('rollout-duration', 'no entry' ); ?>s ease; 
	transition: all <?php echo of_get_option('rollout-duration', 'no entry' ); ?>s ease;
}
 
</style>

<?php

 if(of_get_option('active-backgroud-yt', '0' ) == '1'){
	 if (isset($_SESSION['videoplayed']) != 1 || of_get_option('yt-bg-type', 'false' ) =='false' ){
		
	 ?>
<script>
jQuery( document ).ready( function($){
	
	 $('#ytbgvideo').tubular({videoId: '<?php echo of_get_option('yt-bg-id', 'ab0TSkLe-E0' ); ?>', mute: <?php echo of_get_option('yt-bg-mute', 'true' ); ?> , start: '<?php echo of_get_option('yt-bg-start', '0' ); ?>', repeat:<?php echo of_get_option('yt-bg-repeat', 'true' ); ?>, teaser: <?php echo of_get_option('yt-bg-type', 'false' ); ?>}); 
});
</script>
<?php 
 $_SESSION['videoplayed'] = 1;

}
}?>




<?php 
global $post_showdscomments;
if($post_showdscomments == 'on' && is_single() || $post_showdscomments == 'on' && is_page() ){?> 
	<script>
		//Disqus API
		//==================================================
		jQuery(document).ready(function ($) {
			var disqus_shortname = '<?php echo of_get_option('disqus-id', '' ); ?>'; // required: replace example with your forum shortname
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();	
		});
		var disqus_shortname = '<?php echo of_get_option('disqus-id', '' ); ?>'; // required: replace example with your forum shortname
		(function () {
			var s = document.createElement('script'); s.async = true;
			s.type = 'text/javascript';
			s.src = '//' + disqus_shortname + '.disqus.com/count.js';
			(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
		}());
	</script>
<?php };?>





<script>

jQuery(function ($) {
	
	
	
               // where idOfYourVideo is the YouTube ID.
    
	
	
    $("#back-top").hide();
    $('#main .cscrol:first-child').scroll(function () {
        if ($(this).scrollTop() > 150) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
});
jQuery('.back-to-top').click(function () {
	'strict mode';
    jQuery('html, body, #main .cscrol:first-child').animate({
        scrollTop: 0
    }, 'slow');
});


jQuery(document).ready(function($){
	$('a').live('touchend', function(e) {
		var el = $(this);
		var link = el.attr('href');
	});
});
//pretty Photo settings( ! Don't change )
//==================================================
jQuery(document).ready(function($){
	$("a[rel^='prettyPhoto']").prettyPhoto({allow_resize: false});	 
});

jQuery(document).ready(function($){
	$("a[rel^='prettyPhotoImages']").prettyPhoto({theme: 'pp_default',allow_resize: true});
});

//Image hover animation
//==================================================
jQuery(document).ready(function($){
	'strict mode';
if(Modernizr.csstransforms3d !== false){
		var imgholder = document.getElementsByClassName("hover-effect");
		for(var i = 0, j=imgholder.length; i<j; i++){
			imgholder[i].addEventListener("mouseover", function(){
				var imgtoanimate = this.getElementsByTagName("img")[0];
				if(imgtoanimate){						   
				move(imgtoanimate)
				.rotate(<?php echo of_get_option('rollover-rotate', '10' ); ?>)
				.scale(<?php echo of_get_option('rollover-scale', '2' ); ?>)
				.duration('<?php echo of_get_option('rollover-duration', '1' ); ?>s')
				.end();
				}
			});
			imgholder[i].addEventListener("mouseout", function(){
				var imgtoanimate = this.getElementsByTagName("img")[0];	
				if(imgtoanimate){							   
				move(imgtoanimate)
				.rotate(<?php echo of_get_option('rollout-rotate', '0' ); ?>)
				.scale(<?php echo of_get_option('rollout-scale', '1' ); ?>)
				.duration('<?php echo of_get_option('rollout-duration', '1' ); ?>s')
				.end();
				}
			});
		}
 	}
}); 
			 
//Video background
//==================================================
<?php if( of_get_option('active-backgroud-video', 'no entry' ) == '1'){ ?> 
jQuery(document).ready(function($){
	'strict mode';
	var screenIndex = 1,
		numScreens = $('.screen').length,
		isTransitioning = false,
		transitionDur = 1000,
		BV,
		videoPlayer,
		isTouch = Modernizr.touch,
		$bigImage = $('.big-image'),
		$window = $(window);
	if (!isTouch) {
		BV = new $.BigVideo({forceAutoplay:isTouch});
		BV.init();
		showVideo();
		BV.getPlayer().addEvent('loadeddata', function() {
			onVideoLoaded();
		});
	}
	function showVideo() {
		BV.show($('#screen-'+screenIndex).attr('data-video'),{ambient:true});
	}
	function onVideoLoaded() {
		$('#screen-'+screenIndex).find('.big-image').transit({'opacity':0},500);
	}
	function onTransitionComplete() {
		isTransitioning = false;
		if (!isTouch) {
			$('#big-video-wrap').css('left',0);
			showVideo();
		}
	}
	function adjustImagePositioning() {
		$bigImage.each(function(){
			var $img = $(this),
				img = new Image();
			img.src = $img.attr('src');
	
			var windowWidth = $window.width(),
				windowHeight = $window.height(),
				r_w = windowHeight / windowWidth,
				i_w = img.width,
				i_h = img.height,
				r_i = i_h / i_w,
				new_w, new_h, new_left, new_top;
	
			if( r_w > r_i ) {
				new_h   = windowHeight;
				new_w   = windowHeight / r_i;
			}
			else {
				new_h   = windowWidth * r_i;
				new_w   = windowWidth;
			}
	
			$img.css({
				width   : new_w,
				height  : new_h,
				left    : ( windowWidth - new_w ) / 2,
				top     : ( windowHeight - new_h ) / 2
			});
	
		});
	
		}
	}); <?php
}?>
</script>
<?php	if( of_get_option('active-background', 'no entry' ) == '1'){ ?>   
<script>	
<?php if(!of_get_option('background-img-2') && !of_get_option('background-img-3') && !of_get_option('background-img-4') && !of_get_option('background-img-5')){?>
		jQuery(document).ready(function($){
			'strict mode';
		if(window.hasownbg != 1){
		jQuery.vegas('stop');
			jQuery.vegas({
					src:'<?php echo of_get_option('background-img-1'); ?>', 
					fade:<?php echo of_get_option('background-fade-1'); ?>, 
					valign:'<?php echo of_get_option('background-valign-1'); ?>', 
					align:'<?php echo of_get_option('background-halign-1'); ?>' 
			
			})('overlay', {
			  src:'<?php echo get_template_directory_uri()?>/images/overlays/<?php echo of_get_option('background-overlays', 'no entry' ); ?>.png',
			});
		}
		});<?php 
	}else{?>
		jQuery(document).ready(function($){
			'strict mode';
			if(window.hasownbg != 1){
			jQuery.vegas('stop');
			jQuery.vegas('slideshow', {
			delay:<?php echo of_get_option('background-slideshow'); ?>,
			backgrounds:[
				 <?php if(of_get_option('background-img-1')){?>
					{ src:'<?php echo of_get_option('background-img-1'); ?>', fade:<?php echo of_get_option('background-fade-1'); ?>, valign:'<?php echo of_get_option('background-valign-1'); ?>', align:'<?php echo of_get_option('background-halign-1'); ?>' }
				 <?php } ?>
				 
				 <?php if(of_get_option('background-img-2')){?>
					,{ src:'<?php echo of_get_option('background-img-2'); ?>', fade:<?php echo of_get_option('background-fade-2'); ?>, valign:'<?php echo of_get_option('background-valign-2'); ?>', align:'<?php echo of_get_option('background-halign-2'); ?>' }
				 <?php } ?>
				 
				  <?php if(of_get_option('background-img-3')){?>
					,{ src:'<?php echo of_get_option('background-img-3'); ?>', fade:<?php echo of_get_option('background-fade-3'); ?>, valign:'<?php echo of_get_option('background-valign-3'); ?>', align:'<?php echo of_get_option('background-halign-3'); ?>' }
				 <?php } ?>
				 
				  <?php if(of_get_option('background-img-4')){?>
					,{ src:'<?php echo of_get_option('background-img-4'); ?>', fade:<?php echo of_get_option('background-fade-4'); ?>, valign:'<?php echo of_get_option('background-valign-4'); ?>', align:'<?php echo of_get_option('background-halign-4'); ?>' },
				 <?php } ?>
				 
				  <?php if(of_get_option('background-img-5')){?>
					,{ src:'<?php echo of_get_option('background-img-5'); ?>', fade:<?php echo of_get_option('background-fade-5'); ?>, valign:'<?php echo of_get_option('background-valign-5'); ?>', align:'<?php echo of_get_option('background-halign-5'); ?>' }
				 <?php } ?>
                         
                <?php if(of_get_option('background-img-6')){?>
					,{ src:'<?php echo of_get_option('background-img-6'); ?>', fade:<?php echo of_get_option('background-fade-6'); ?>, valign:'<?php echo of_get_option('background-valign-6'); ?>', align:'<?php echo of_get_option('background-halign-6'); ?>' }
				 <?php } ?>
                <?php if(of_get_option('background-img-7')){?>
					,{ src:'<?php echo of_get_option('background-img-7'); ?>', fade:<?php echo of_get_option('background-fade-7'); ?>, valign:'<?php echo of_get_option('background-valign-7'); ?>', align:'<?php echo of_get_option('background-halign-7'); ?>' }
				 <?php } ?>
                <?php if(of_get_option('background-img-8')){?>
					,{ src:'<?php echo of_get_option('background-img-8'); ?>', fade:<?php echo of_get_option('background-fade-8'); ?>, valign:'<?php echo of_get_option('background-valign-8'); ?>', align:'<?php echo of_get_option('background-halign-8'); ?>' }
				 <?php } ?>
                <?php if(of_get_option('background-img-9')){?>
					,{ src:'<?php echo of_get_option('background-img-9'); ?>', fade:<?php echo of_get_option('background-fade-9'); ?>, valign:'<?php echo of_get_option('background-valign-9'); ?>', align:'<?php echo of_get_option('background-halign-9'); ?>' }
				 <?php } ?>
                         
                <?php if(of_get_option('background-img-10')){?>
					,{ src:'<?php echo of_get_option('background-img-10'); ?>', fade:<?php echo of_get_option('background-fade-10'); ?>, valign:'<?php echo of_get_option('background-valign-10'); ?>', align:'<?php echo of_get_option('background-halign-10'); ?>' }
				 <?php } ?>
			  ]
			})('overlay', {
			  src:'<?php echo get_template_directory_uri(); ?>/images/overlays/<?php echo of_get_option('background-overlays', 'no entry' ); ?>.png'
			});
			}
		});
		
			<?php }; ?>
	</script>
<?php };
		



	
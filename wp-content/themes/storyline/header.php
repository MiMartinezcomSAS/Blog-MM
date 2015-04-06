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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php 
if ( !is_front_page() ) { echo wp_title( ' ', true, 'left' ); echo ' | '; }
	echo bloginfo( 'name' ); echo ''; bloginfo( 'description', 'display' );  ?> 
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 <?php 
if(is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
	$srcf = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full', true );
}?>					
<meta name="twitter:image" content="<?php if(isset($srcf[0])){echo $srcf[0];} ?>">
<meta property="og:title" content="<?php if ( is_single() || is_page() ) { the_title(); }else{ bloginfo('name'); }?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php if ( is_single() || is_page() ) { the_permalink(); }else{ echo get_site_url(); }?>" /> 
<meta name="twitter:url" content="<?php if ( is_single() || is_page() ) { the_permalink(); }else{ echo get_site_url(); }?>">
<meta name="og:description" content="<?php if ( is_single() || is_page() ) { if(get_the_excerpt()!=''){echo get_the_excerpt();}else{ the_title(); }}else{bloginfo('name'); echo " - "; bloginfo('description');} ?>" />

<meta name="twitter:site" content="@flasherland">

		<!--[if lte IE 8]><style>.ss-container, .header-white, .ss-nav, .ss-row-clear{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
        <!--[if IE]>
            <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/styleIE.css" />
        <![endif]-->
    	
<!-- Force to reload page on back button for firefox
================================================== -->
<script>

	window.name = "reloader" ;
	window.onbeforeunload = function() {
   		window.name = "reloader"; 
	}
	window.onunload = function(){};
	 
</script>
<?php  ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script('jquery');
	wp_get_archives('type=monthly&format=link');
	wp_head();
?>
</head>

<body <?php body_class();?>>
<?php 
	if( of_get_option('active-backgroud-video', 'no entry' ) != '1' && of_get_option('active-background', 'no entry' ) != '1'){?> 
    	<div id="site-background"></div> <?php 
	};
	if(of_get_option('wellcome-msg', 'no entry' ) =='1'){ ?>
		<header>
			<p class="hidden"><?php echo of_get_option('wellcome-msg-text-hidden', 'no entry' ); ?>
            </p>
		</header>
 		<div class="addbg"></div><?php
	};?>
    <div id="fb-root"></div><?php 
	if( of_get_option('active-backgroud-video', 'no entry' ) == '1'){ ?> 
        <div class="wrapper">
            <div class="screen" id="screen-1" data-video="<?php echo of_get_option('background-video-mp4'); ?>"><?php 
            if( of_get_option('background-video-image', 'no entry' ) != ''){ ?> 
                <img src="<?php echo of_get_option('background-video-image'); ?>" class="big-image" /><?php
             };?>
            </div>
        </div><?php
     };?>

	<div id="loading">
		<div class="inifiniteLoaderP animated <?php if(is_single()){?>move-rightl<?php } ?> <?php if(of_get_option('active-dglass') == 1){?>dglassstyle<?php }?>">
    		<div class="bar">
				<span></span>
    		</div>
		</div>
    </div>
	<div class="<?php if(of_get_option('active-glass') == 1){?>glassstyle <?php }?> <?php if(of_get_option('active-dglass') == 1){?>dglassstyle <?php }?> header-white"></div>
	<div> 
    	<div class="ss-stand-alone">
            <div class="ss-nav <?php if(of_get_option('active-glass') == 1){?>glassstyle <?php }?> <?php if(of_get_option('active-dglass') == 1){?>dglassstyle <?php }?>">
                <div id="header-wrapper">
                    <a href="<?php echo get_site_url(); ?>" class="logohover">
                    	<div class="logo" style=" background:url( <?php echo of_get_option('logo-img', 'no entry' ); ?>) no-repeat left bottom; ">
               			</div>
                	</a> 
                    <div id="mainmenu" class="wrapper ddsmoothmenu dl-menuwrapper"  >
                    	<ul class="navcal">
                        	<li id="widgets-m">
                                             	<i class="icon-chevron-down"></i> 
                                                   <?php global $woocommerce; ?>
                            <div class="badgecat <?php if($woocommerce->cart->cart_contents_count != 0){ ?>showcat <?php }else{?>hidecat<?php };?>"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></div>
           
                            	<ul class="navcal-d">
                                	<div class="arrowa"></div>
                                    <div class="navcal-p"><?php
                                		get_sidebar(); ?>	
                            		</div>
                                </ul>
                            </li>
                        </ul>
                        <?php wp_nav_menu( array( 'sort_column' => 'menu_order','container' => '', 'menu_class' => 'nav', 'menu_id' => 'nav', 'theme_location' => 'primary-menu' ) );?>
                    </div>
                </div>
            </div>
		</div><?php
        $st = "0";
		global $product, $woocommerce_loop;
		if(is_home()){
			$sticky = get_option( 'sticky_posts');
			$wp_query = new WP_Query(array( 'post__in' => $sticky) );
			$st = "0";
		}else if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ){
			$st = "2";
		}else{
			$st = "1";
		}
		global $slectloop;
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			
			 if (is_woocommerce() && of_get_option('pagination-display') == "infinite" || !is_woocommerce() && of_get_option('def-pagination-display') == "infinite"){
			
				 if(is_woocommerce()){
					$slectloop = 'loop-woocommerce';
				}else{
					$slectloop = 'loop';
				}
				 $goinfinite  = 1;
			 }
		}else{
			 if (of_get_option('def-pagination-display') == "infinite"){
				 
				$slectloop = 'loop';
				 $goinfinite  = 1;
			 }
			
		};
		if($goinfinite == 1){
			$wpqueryvarsSerialized = rawurlencode(serialize($wp_query->query_vars));?>
			<script>
				'strict mode';
				var slectloop = <?php echo json_encode($slectloop); ?>;
				var whait = 0;
				var count = 2;
				var total = <?php echo $wp_query->max_num_pages; ?>;
				var is_state = <?php echo $st; ?>;
				var var_string = '<?php echo $wpqueryvarsSerialized; ?>';
				
				window.initajax = function(){
					
					if (count > total){
						return false;
					}else{
						if(whait !=1){  
							loadArticle(count, is_state, var_string);
                            
							whait = 1
						}else{
						   return false;
						}
					}
					count++;
				}
				function loadArticle(pageNumber, is_state, var_string){ 
					jQuery('.inifiniteLoader').removeClass('fadeOutDown').addClass("fadeInUp");
					jQuery('.numpostinfi').removeClass('fadeInUp').addClass("fadeOutDown");
						jQuery.ajax({
							url: "<?php echo site_url() ?>/wp-admin/admin-ajax.php",
							type:'POST',
							data:"action=infinite_scroll&page_no="+ pageNumber + '&loop_file='+slectloop+'&is_state='+is_state+'&var_string='+var_string,
							success: function(html){
								jQuery('.inifiniteLoader').removeClass('fadeInUp').addClass("fadeOutDown");	
								jQuery('.numpostinfi').removeClass('fadeOutDown').addClass("fadeInUp");
								jQuery("#articlehold").append(html);
								whait = 0;
							}
						});
					return false;
				}
			</script><?php 
		}; ?>
        <header>
        	<div class="support-note"><!-- let's check browser support with modernizr -->
					<!--span class="no-cssanimations">CSS animations are not supported in your browser</span-->
					<!--span class="no-csstransforms">CSS transforms are not supported in your browser</span-->
					<!--span class="no-csstransforms3d">CSS 3D transforms are not supported in your browser</span-->
					<!--span class="no-csstransitions">CSS transitions are not supported in your browser</span-->
                <span class="note-ie"><br>We are apologize for the inconvenience but you need to download <br> more modern browser in order to be able to browse our page<br />
                    <div class="support-note-ico">
                    
                        <a href="http://support.apple.com/kb/DL1531?viewlocale=en_US&locale=en_US"><img src="<?php echo get_template_directory_uri(); ?>/images/support/safari.png" width="50" height="50" /> <br>Download Safari
                        </a>
                        <a href="https://www.google.com/intl/en/chrome/browser/"><img src="<?php echo get_template_directory_uri(); ?>/images/support/chrome.png" width="50" height="50"  /> <br>Download Chrome
                        </a>
                        <a href="http://www.mozilla.org/en-US/firefox/new/"><img src="<?php echo get_template_directory_uri(); ?>/images/support/firefox.png" width="50" height="50"/> <br>Download Firefox
                        </a>
                        <a href="http://www.opera.com/download/"><img src="<?php echo get_template_directory_uri(); ?>/images/support/opera.png" width="50" height="50"/> <br>Download Opera
                        </a>
                    </div>
                    
                </span>
            </div>
        </header>
        
		<div class="header-top-p">
		<div id="ss-container" class="ss-container  <?php if(!is_home() && of_get_option('header-height') == 0 && of_get_option('active-header', 'no entry' ) == '1'){ ?> pad-slider<?php }; ?> <?php if(of_get_option('active-glass') == 1){?>glassstyle <?php }?> <?php if(of_get_option('active-dglass') == 1){?>dglassstyle <?php }?>">
        <?php if ( ! isset( $content_width ) ) $content_width = 900; ?>
		<div id="ytbgvideo"></div>
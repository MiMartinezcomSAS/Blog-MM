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

//Add support for WordPress 3.0's custom menus
add_action( 'init', 'register_my_menu' );

//Register area for custom menu
function register_my_menu() {
	register_nav_menu( 'primary-menu', 'Primary Menu');
}
$theme  = wp_get_theme();
//Code for custom background support

add_theme_support( 'custom-background'); 

//Enable post and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// Enable post thumbnails
add_theme_support('post-thumbnails');
set_post_thumbnail_size(520, 250, true);
if(function_exists('vc_set_as_theme')) vc_set_as_theme( true);
add_action( 'admin_init', 'deactivate_plugin_conditional' );
function deactivate_plugin_conditional() {
    if ( is_plugin_active('js_composer/js_composer.php') ) {
    deactivate_plugins('js_composer/js_composer.php');    
    }
}

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */
if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
		$optionsframework_settings = get_option('optionsframework');
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}	
		if ( isset($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}

//Register javascripts and css
function my_scripts_method() {
	wp_enqueue_style('fontawesome', get_template_directory_uri().'/css/font-awesome/css/font-awesome.css');
	wp_enqueue_style('mainstyle', get_template_directory_uri().'/style.css');
	wp_register_script('prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js', false,'1.0',true);
	wp_enqueue_style('prettyPhoto', get_template_directory_uri().'/css/prettyPhoto.css');
	wp_enqueue_script('prettyPhoto');
	wp_register_script('easing', get_template_directory_uri().'/js/jquery.easing.1.3.js', false,'1.0',true);
	wp_enqueue_script('easing');
	wp_register_script('flexslider', get_template_directory_uri().'/js/jquery.flexslider.js', false,'1.0',true);
	wp_enqueue_script('flexslider');
	wp_enqueue_style('flexslider', get_template_directory_uri().'/css/flexslider.css');
	wp_register_script('ddsmoothmenu', get_template_directory_uri().'/js/ddsmoothmenu.js', false,'1.0',true);
	wp_enqueue_script('ddsmoothmenu');
	wp_enqueue_style('customdropdowncss', get_template_directory_uri().'/functions/adminanddropdown.css');
	

	



	
	wp_register_script('modernizr', get_template_directory_uri().'/js/modernizr.custom.79639.js', false,'1.0',true);
	wp_enqueue_script('modernizr');
	wp_register_script('move', get_template_directory_uri().'/js/move.js', false,'1.0',true);
	wp_enqueue_script('move');
	wp_register_script('vegas', get_template_directory_uri().'/js/jquery.vegas.js', false,'1.0',true);
	wp_enqueue_style('vegas', get_template_directory_uri().'/css/jquery.vegas.css');
	wp_enqueue_script('vegas');	
	wp_register_script('selectnav', get_template_directory_uri().'/js/selectnav.js', false,'1.0',true);
	wp_enqueue_script('selectnav');
	wp_register_script('dropkick', get_template_directory_uri().'/js/jquery.dropkick-1.0.0.js', false,'1.0',true);
	wp_enqueue_script('dropkick');
	wp_register_script('classList', get_template_directory_uri().'/js/classList.js', false,'1.0',true);
	wp_enqueue_script('classList');
	wp_register_script('fbcomments', 'http://connect.facebook.net/en_EN/all.js#xfbml=1&status=0', false,'1.0',true);
	wp_enqueue_script('fbcomments');
	wp_register_script('nanoscroller', get_template_directory_uri().'/js/jquery.nanoscroller.js', false,'1.0',true);
	wp_enqueue_script('nanoscroller');
	wp_register_script('customdropdown', get_template_directory_uri().'/js/jquery.dd.js', false,'1.0',true);
	wp_enqueue_script('customdropdown');
    
    if(of_get_option('active-mouse-parallax', '0' ) == '1' && !wp_is_mobile()){
        wp_register_script('mouseparallax', get_template_directory_uri().'/js/jquery.parallax.js', false,'1.0',true);
        wp_enqueue_script('mouseparallax');
    }
	wp_register_script('bespoke', get_template_directory_uri().'/js/bespoke.js', false,'1.0',true);
	wp_enqueue_script('bespoke');
	if(of_get_option('active-backgroud-video', 'no entry' ) == '1' ){
		wp_register_script('bigvideo', get_template_directory_uri().'/js/bigvideo.js', false,'1.0',true);
		wp_enqueue_script('bigvideo');	
		wp_register_script('videoto', 'http://vjs.zencdn.net/c/video.js');
		wp_enqueue_script('videoto');	
		wp_register_script('transit', get_template_directory_uri().'/js/jquery.transit.min.js', false,'1.0',true);
		wp_enqueue_script('transit');
	}
	wp_enqueue_style('responsive', get_template_directory_uri().'/css/responsive.css');
	if(of_get_option('active-backgroud-yt', '0' ) == '1'){
	wp_register_script('tubular', get_template_directory_uri().'/js/jquery.tubular.1.0.js', false,'1.0',true);
	wp_enqueue_script('tubular');
	}
}
add_action('wp_enqueue_scripts', 'my_scripts_method');

// Javascript functions for admin settings
function admin_js() { ?>
    <script type="text/javascript">
		jQuery(function($) {
			jQuery('#media-items').bind('DOMNodeInserted',function(){
				jQuery('input[value="Insert into Post"]').each(function(){
						jQuery(this).attr('value','Use This Image');
				});
			});
			jQuery('.custom_upload_image_button').live("click", function() {
				window.restore_send_to_editor = window.send_to_editor;
				formfield = jQuery(this).siblings('.custom_upload_image');
				preview = jQuery(this).siblings('.custom_preview_image');
				tb_show('', 'media-upload.php?type=image&TB_iframe=true');
				window.send_to_editor = function(html) {
					imgurl = jQuery('img',html).attr('src');
					classes = jQuery('img', html).attr('class');
					id = classes.replace(/(.*?)wp-image-/, '');
					formfield.val(id);
					preview.attr('src', imgurl);
					tb_remove();
					window.send_to_editor = window.restore_send_to_editor;
				}
				return false;
			});
		
			jQuery('.custom_clear_image_button').click(function() {
							
				var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
				jQuery(this).parent().siblings('.custom_upload_image').val('');
				jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
				return false;
			});
		
			jQuery('.repeatable-add').click(function() {
				field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
				fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
				jQuery('input.custom_upload_image', field).val('').attr('name', function(index, name) {
					return name.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});

			})
			jQuery('.custom_preview_image', field).attr('src', '');
			field.insertAfter(fieldLocation, jQuery(this).closest('td'))
			return false;
		});
		
		jQuery('.repeatable-remove').click(function(){

			jQuery(this).parent().remove();
			return false;
		});
	});
	</script><?php 
}
if(is_admin()) {
	add_action('admin_head', 'admin_js');
}

$is_black = of_get_option('color-scheme', 'no entry' );

// Add specific CSS class by filter
add_filter('body_class','my_class_names');
function my_class_names($classes) {
	
		$classes[] = "";
	
	if(of_get_option('scroll-effect') == 0){
		$classes[] = "classic";
	}else if(of_get_option('scroll-effect') == 1){
		$classes[] = "cube";
	}else if(of_get_option('scroll-effect') == 2){
		$classes[] = "carousel";
	}else if(of_get_option('scroll-effect') == 3){
		$classes[] = "concave";
	}else if(of_get_option('scroll-effect') == 4){
		$classes[] = "coverflow";
	}else if(of_get_option('scroll-effect') == 5){
		$classes[] = "spiraltop";
	}else if(of_get_option('scroll-effect') == 6){
		$classes[] = "spiralbottom";
	}else if(of_get_option('scroll-effect') == 7){
		$classes[] = "classictilt";
	}
	
	return $classes;
}
add_theme_support('custom-header'); 


// This one shows/hides the an option when a checkbox is clicked.
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
function optionsframework_custom_scripts() { ?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
		jQuery("body select").msDropDown();
			jQuery('#example_showhidden').click(function() {
				jQuery('#section-example_text_hidden').fadeToggle(400);
			});
			
			if (jQuery('#example_showhidden:checked').val() !== undefined) {
				jQuery('#section-example_text_hidden').show();
			}
			
			jQuery('#wellcome-msg').click(function() {
				jQuery('#section-wellcome-msg-text-hidden').fadeToggle(400);
			});
			
			if (jQuery('#wellcome-msg:checked').val() !== undefined) {
				jQuery('#section-wellcome-msg-text-hidden').show();
			}
			
		});
    </script><?php
}
// Search only in posts
function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
if (!isset( $_GET['post_type'] ) ){
	add_filter('pre_get_posts','SearchFilter');
}

//Send vars for AJAX infinite scroll
function wp_infinitepaginate(){
	global $wp_query;
    $loopFile        = $_POST['loop_file'];  
    $paged           = $_POST['page_no']; 
	$is_state        = $_POST['is_state'];
	$var_string      = $_POST['var_string'];
	if(of_get_option('order-posts') == "ll" ){
		$order_posts = 'ASC';
	}else{
		$order_posts = 'DESC';
	}
	if($is_state == "0"){
    	$filter_args['paged'] = $paged;
		$filter_args['order'] = $order_posts;
		$filter_args['post_status'] = 'publish';
		$args = array_merge( unserialize(stripslashes($var_string)), $filter_args );
		query_posts( $args );
	}
	if($is_state == "1"){
		$filter_args['paged'] = $paged;
		$filter_args['order'] = $order_posts;
		$filter_args['post_status'] = 'publish';
		$args = array_merge( unserialize(stripslashes($var_string)), $filter_args );
		query_posts( $args );
	}
    if($is_state == "2"){
		remove_filter('pre_get_posts','SearchFilter');
		$filter_args['paged'] = $paged;
		$filter_args['post_type'] = 'product';
		$filter_args['post_status'] = 'publish';
		
		$args = array_merge( unserialize(stripslashes($var_string)), $filter_args );
		query_posts( $args );	
	}
    get_template_part( $loopFile );
    exit;   
}
add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user  
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate'); 


if ( ! function_exists( 'sotryline_end' ) ) :
function sotryline_end( $comment, $args, $depth ) {
	return'';
}
endif;
// Template for comments
if ( ! function_exists( 'timeline_comment' ) ) :
function timeline_comment( $comment, $args, $depth ) {
	if(of_get_option('tr-comm-said') != ''){
		$tr_comm_said = of_get_option('tr-comm-said');
	}else{
		$tr_comm_said = "said";
	};
	if(of_get_option('tr-comm-waitapp') != ''){
		$tr_comm_waitapp = of_get_option('tr-comm-waitapp');
	}else{
		$tr_comm_waitapp = "Your comment is awaiting moderation.";
	};
	if(of_get_option('tr-comm-attime') != ''){
		$tr_comm_attime = of_get_option('tr-comm-attime');
	}else{
		$tr_comm_attime = "at";
	};
	$GLOBALS['comment'] = $comment;
	
		global $fbcomm;
 		if(of_get_option('comments-fx', 'no entry' ) == 'off'){ ?>
         
      		<sectionoff id="section-<?php echo $fbcomm; ?>" rel="<?php echo $fbcomm; ?>"><?php 
		}else{?>
       		<section id="section-<?php echo $fbcomm; ?>" rel="<?php echo $fbcomm; ?>"> <?php
		} 
		$fbcomm++; ?>
        	<div class="ss-row iscomm  <?php if(of_get_option('comments-fx', 'no entry' ) == 'off'){ ?> c-comment <?php } ?> "  >
				<div class="ss-full ">
                    <div class="container-border">
                        <div class="gray-container <?php global $post_color; echo $post_color;?>" > 
                      		<h3 class="content-title comm-title"><?php 
								printf( '<span class="comment-auth">%2$s</span> <span class="says">'.$tr_comm_said.':</span>', 'timeline',
									sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
									sprintf( '<time pubdate datetime="%2$s">%3$s</time>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										/* translators: 1: date, 2: time */
										sprintf( __( '%1$s at %2$s', 'timeline' ), get_comment_date(), get_comment_time() )
									)
								);?>
                            </h3>
                            <comm id="comment-<?php comment_ID(); ?>" class="comment">
                                <foot class="comment-meta">
                                    <div class="comment-author vcard">
                                        <?php edit_comment_link( __( 'Edit', 'timeline' ), '<span class="edit-link">', '</span>' ); ?>
                                    </div>
                                    <?php if ( $comment->comment_approved == '0' ) : ?>
                                        <em class="comment-awaiting-moderation"><?php echo $tr_comm_waitapp; ?></em>
                                        <br />
                                    <?php endif; ?>
                                </foot>
                                <div class="nano">
                                	<div class="hidecomm">
                                        <div class="comment-avatarin"><?php 
                                            $avatar_size = 68;
                                            echo get_avatar( $comment, $avatar_size ); ?>
                                        </div>
									<?php  comment_text(); ?>
									</div>
                                    <div class="cscrol content">
                                        <div class="comment-content">
                                            <div class="comment-avatarin"><?php 
                                                $avatar_size = 68;
                                                if( '0' != $comment->comment_parent )
                                                    $avatar_size = 69;
                                                echo get_avatar( $comment, $avatar_size ); ?>
                                            </div>
                                            <?php  comment_text(); ?>
                                        </div>
                                    </div>
                                </div>
							</comm>
							<div class="icon-soc-container">
						   		<div class="share-btns">								
									<div class="empty-left time-holder-nob"><i class="icon-time icon-large"></i> <?php
                                        printf( __( '%2$s', 'timeline' ),
                                            sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                            sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                                esc_url( get_comment_link( $comment->comment_ID ) ),
                                                get_comment_time( 'c' ),
                                                /* translators: 1: date, 2: time */
                                                sprintf( '%2$s '.$tr_comm_attime.' %3$s', 'timeline', get_comment_date(), get_comment_time() )
                                            )
                                        );?> 
									</div>
                                </div>   
                            </div>
                        </div>
                    </div> 
                </div>
			</div><?php 
            if(of_get_option('comments-fx', 'no entry' ) == 'off'){ ?> 
            	</sectionoff><?php
			}else{?>
            	</section><?php 
			};
			
	
}
endif;


function has_shortcode_property($shortcode = '') {  
    $post_to_check = get_post(get_the_ID());  
    $found = false;  
    if (!$shortcode) {  
        return $found;  
    }   
    if ( stripos($post_to_check->post_content, $shortcode) !== false ) {  
        $found = true;  
    }  
    return $found;  
}  

//Add diferent images sizes
add_image_size('related-posts', 200, 200, $crop = true);
add_image_size('circle-big', 480, 480, $crop = true);
add_image_size('standart-image-small', 650, 365, $crop = true);
add_image_size('standart-image', 720, 405, $crop = true);
add_image_size('full-width-content', 720, 205, $crop = true);
if(function_exists('add_theme_support')) {
    /** Exists! So add the post-thumbnail */
    add_theme_support('post-thumbnails'); 
    /** #2 for post thumbnail */
    add_image_size( 'ch-item', 550, 550, $crop = true);
}

//Disable read more jump
function remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');
function thumbget(){
	the_post_thumbnail();
}
//Add custom login form
function custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<br><form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
	' .  "This post is password protected. To view it please enter your password below:"  . '
	<br>Password:<br><input name="post_password" id="' . $label . '" type="password" size="20" class="password-blog" /><input type="submit" class="button defbtn" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
	</form> <br><br>
	';
	return $o;
}
add_filter( 'the_password_form', 'custom_password_form' );

add_filter('protected_title_format', 'blank');
add_filter('private_title_format', 'blank');
function blank($title) {
       return '%s';
}

// Custom pagination
function t_pagination($pages = '', $range = 2){
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$woo = is_woocommerce(); 
	}
	 
	if(of_get_option('def-pagination-display') != "infinite" ||  $woo == true && of_get_option('pagination-display') != "infinite"){
		$showitems = ($range * 2)+1;  
		 global $paged;
		 if(empty($paged)) $paged = 1;

		 if($pages == ''){
			 global $wp_query;
			 $pages = $wp_query->max_num_pages;
			 if(!$pages){
				 $pages = 1;
			 }
		 }   

		 if(1 != $pages){
         	echo '<div class="pagination"><div class="p-position"><nav id="page_nav"></nav>';
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
			 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
			 for ($i=1; $i <= $pages; $i++){
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
				 }
			 }
			 if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			 echo "</div>\n";
    	 }
	};
}

include('functions/add_meta_box.php');	

//Hide older posts
add_filter( 'posts_where', 'hop_exclude_posts' );
add_filter( 'getarchives_where', 'hop_exclude_posts' );
function hop_exclude_posts( $where ) {
	if(of_get_option('older-posts') == 'frontend'){
		if( of_get_option('hide-categories') != 'all'){
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$q = $cat_obj->term_id;
			if( of_get_option('hide-categories') == $q ){
				if( !is_admin() ){
						$where .= " AND ( post_date > '".date( 'Y-m-d', strtotime( of_get_option('hide-post-date') ) )."' OR post_type NOT LIKE 'post' ) ";
				} else {
					if (defined('DOING_AJAX') && DOING_AJAX) { 
						$where .= " AND ( post_date > '".date( 'Y-m-d', strtotime( of_get_option('hide-post-date') ) )."' OR post_type NOT LIKE 'post' ) ";
					}
				}
			}
		}else{
			if( !is_admin() ){
					$where .= " AND ( post_date > '".date( 'Y-m-d', strtotime( of_get_option('hide-post-date') ) )."' OR post_type NOT LIKE 'post' ) ";
			} else {
				if (defined('DOING_AJAX') && DOING_AJAX) { 
					$where .= " AND ( post_date > '".date( 'Y-m-d', strtotime( of_get_option('hide-post-date') ) )."' OR post_type NOT LIKE 'post' ) ";
				}
			}
		}
	}
	if(of_get_option('older-posts') == 'backend'){
		if( of_get_option('hide-categories') != 'all'){
			echo $post->ID;
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$q = $cat_obj->term_id;
			if( of_get_option('hide-categories') == $q ){
						$where .= " AND ( post_date > '".date( 'Y-m-d', strtotime( of_get_option('hide-post-date') ) )."' OR post_type NOT LIKE 'post' ) ";
			}				
		}else{
				$where .= " AND ( post_date > '".date( 'Y-m-d', strtotime( of_get_option('hide-post-date') ) )."' OR post_type NOT LIKE 'post' ) ";		
		}
	}
    return $where;
}

// Add custom name to menu widget
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Menu widgets',
		'description' => 'Appears in drop down widget menu',
	
	));
}
// Add custom widget sidebar for woocommerce
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Woocommerce Scroll Widgets',
			'id' => 'homepage-sidebar',
			'description' => 'Appears at top on shop page',
			'after_widget' => '<div style="padding-bottom:10px;"></div>'
		));
	}
}
// Add custom widget sidebar for woocommerce product page
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if ( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'name' => 'Woocommerce Product Widgets',
			'id' => 'woo-product-sidebar',
			'description' => 'Appears at top on shop page',
			'before_widget' => '<div class="ss-row widgetmarg"><div class="container-border"><div class="gray-container single-page-t" ><li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li></div></div></div>',
	'before_title'  => '<div class="widgttl"><h2 class="widgettitle">',
	'after_title'  => '</h2></div><div class="widgheight"></div>'
		));
	}
}
// Refresh number of products added to woocommerce cart
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_badge');
function woocommerce_header_add_to_badge( $fragments ) {
	global $woocommerce;
	ob_start();?>
	<div class="badgecat <?php if($woocommerce->cart->cart_contents_count != 0){ ?>showcat <?php }else{?>hidecat<?php };?>"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></div><?php
	
	$fragments['div.badgecat'] = ob_get_clean();
	return $fragments;
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Sidebar widgets',
		'id' => 'blog-sidebar',
		'description' => 'Appears in sidebar',
		'before_widget' => '<div class="ss-row widgetmarg"><div class="container-border"><div class="gray-container single-page-t" ><li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li></div></div></div>',
	'before_title'  => '<div class="widgttl"><h2 class="widgettitle">',
	'after_title'  => '</h2></div><div class="widgheight"></div>',
	));
}

// Enables adding widgest with shortcodes to post
add_shortcode( 'widget', 'my_widget_shortcode' );
function my_widget_shortcode( $atts ) {
	// Configure defaults and extract the attributes into variables
	extract( shortcode_atts( 
		array( 
			'type'  => '',
			'title' => '',
			'number' => ''
		), 
		$atts 
	));
	$args = array(
		'before_widget' => '<div class="box widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	);
	ob_start();
	the_widget( $type, $atts, $args ); 
	$output = ob_get_clean();
		
	return $output;
}

// Enables posts with future date to be published instead sheduled  
if(of_get_option('future-posts', 'no entry' ) == 'on'){
	remove_action('future_post', '_future_post_hook');
	add_filter( 'wp_insert_post_data', 'futur_posts_is_on' );
	function futur_posts_is_on( $data ) {
		if ( $data['post_status'] == 'future' && $data['post_type'] == 'post' )
			$data['post_status'] = 'publish';
		return $data;
	};
}

add_filter('show_admin_bar', '__return_false'); 

function options_typography_get_os_fonts() {
	// OS Font Defaults
	$os_faces = array(
		'Arial, sans-serif' => 'Arial',
		'"Avant Garde", sans-serif' => 'Avant Garde',
		'Cambria, Georgia, serif' => 'Cambria',
		'Copse, sans-serif' => 'Copse',
		'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
		'Georgia, serif' => 'Georgia',
		'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
		'Tahoma, Geneva, sans-serif' => 'Tahoma'
	);
	return $os_faces;
}
//Google fonts


// apply_filters( 'of_recognized_font_styless', $default );

function options_typography_get_google_fonts() {
	


	// Google Font Defaults
	$google_faces = array(
	"ABeeZee" => "ABeeZee",
	"Abel" => "Abel",
	"Abril Fatface" => "Abril+Fatface",
	"Aclonica" => "Aclonica",
	"Acme" => "Acme",
	"Actor" => "Actor",
	"Adamina" => "Adamina",
	"Advent Pro" => "Advent+Pro",
	"Aguafina Script" => "Aguafina+Script",
	"Akronim" => "Akronim",
	"Aladin" => "Aladin",
	"Aldrich" => "Aldrich",
	"Alegreya" => "Alegreya",
	"Alegreya SC" => "Alegreya+SC",
	"Alex Brush" => "Alex+Brush",
	"Alfa Slab One" => "Alfa+Slab+One",
	"Alice" => "Alice",
	"Alike" => "Alike",
	"Alike Angular" => "Alike+Angular",
	"Allan" => "Allan",
	"Allerta" => "Allerta",
	"Allerta Stencil" => "Allerta+Stencil",
	"Allura" => "Allura",
	"Almendra" => "Almendra",
	"Almendra Display" => "Almendra+Display",
	"Almendra SC" => "Almendra+SC",
	"Amarante" => "Amarante",
	"Amaranth" => "Amaranth",
	"Amatic SC" => "Amatic+SC",
	"Amethysta" => "Amethysta",
	"Anaheim" => "Anaheim",
	"Andada" => "Andada",
	"Andika" => "Andika",
	"Angkor" => "Angkor",
	"Annie Use Your Telescope" => "Annie+Use+Your+Telescope",
	"Anonymous Pro" => "Anonymous+Pro",
	"Antic" => "Antic",
	"Antic Didone" => "Antic+Didone",
	"Antic Slab" => "Antic+Slab",
	"Anton" => "Anton",
	"Arapey" => "Arapey",
	"Arbutus" => "Arbutus",
	"Arbutus Slab" => "Arbutus+Slab",
	"Architects Daughter" => "Architects+Daughter",
	"Archivo Black" => "Archivo+Black",
	"Archivo Narrow" => "Archivo+Narrow",
	"Arimo" => "Arimo",
	"Arizonia" => "Arizonia",
	"Armata" => "Armata",
	"Artifika" => "Artifika",
	"Arvo" => "Arvo",
	"Asap" => "Asap",
	"Asset" => "Asset",
	"Astloch" => "Astloch",
	"Asul" => "Asul",
	"Atomic Age" => "Atomic+Age",
	"Aubrey" => "Aubrey",
	"Audiowide" => "Audiowide",
	"Autour One" => "Autour+One",
	"Average" => "Average",
	"Average Sans" => "Average+Sans",
	"Averia Gruesa Libre" => "Averia+Gruesa+Libre",
	"Averia Libre" => "Averia+Libre",
	"Averia Sans Libre" => "Averia+Sans+Libre",
	"Averia Serif Libre" => "Averia+Serif+Libre",
	"Bad Script" => "Bad+Script",
	"Balthazar" => "Balthazar",
	"Bangers" => "Bangers",
	"Basic" => "Basic",
	"Battambang" => "Battambang",
	"Baumans" => "Baumans",
	"Bayon" => "Bayon",
	"Belgrano" => "Belgrano",
	"Belleza" => "Belleza",
	"BenchNine" => "BenchNine",
	"Bentham" => "Bentham",
	"Berkshire Swash" => "Berkshire+Swash",
	"Bevan" => "Bevan",
	"Bigelow Rules" => "Bigelow+Rules",
	"Bigshot One" => "Bigshot+One",
	"Bilbo" => "Bilbo",
	"Bilbo Swash Caps" => "Bilbo+Swash+Caps",
	"Bitter" => "Bitter",
	"Black Ops One" => "Black+Ops+One",
	"Bokor" => "Bokor",
	"Bonbon" => "Bonbon",
	"Boogaloo" => "Boogaloo",
	"Bowlby One" => "Bowlby+One",
	"Bowlby One SC" => "Bowlby+One+SC",
	"Brawler" => "Brawler",
	"Bree Serif" => "Bree+Serif",
	"Bubblegum Sans" => "Bubblegum+Sans",
	"Bubbler One" => "Bubbler+One",
	"Buda" => "Buda",
	"Buenard" => "Buenard",
	"Butcherman" => "Butcherman",
	"Butterfly Kids" => "Butterfly+Kids",
	"Cabin" => "Cabin",
	"Cabin Condensed" => "Cabin+Condensed",
	"Cabin Sketch" => "Cabin+Sketch",
	"Caesar Dressing" => "Caesar+Dressing",
	"Cagliostro" => "Cagliostro",
	"Calligraffitti" => "Calligraffitti",
	"Cambo" => "Cambo",
	"Candal" => "Candal",
	"Cantarell" => "Cantarell",
	"Cantata One" => "Cantata+One",
	"Cantora One" => "Cantora+One",
	"Capriola" => "Capriola",
	"Cardo" => "Cardo",
	"Carme" => "Carme",
	"Carrois Gothic" => "Carrois+Gothic",
	"Carrois Gothic SC" => "Carrois+Gothic+SC",
	"Carter One" => "Carter+One",
	"Caudex" => "Caudex",
	"Cedarville Cursive" => "Cedarville+Cursive",
	"Ceviche One" => "Ceviche+One",
	"Changa One" => "Changa+One",
	"Chango" => "Chango",
	"Chau Philomene One" => "Chau+Philomene+One",
	"Chela One" => "Chela+One",
	"Chelsea Market" => "Chelsea+Market",
	"Chenla" => "Chenla",
	"Cherry Cream Soda" => "Cherry+Cream+Soda",
	"Cherry Swash" => "Cherry+Swash",
	"Chewy" => "Chewy",
	"Chicle" => "Chicle",
	"Chivo" => "Chivo",
	"Cinzel" => "Cinzel",
	"Cinzel Decorative" => "Cinzel+Decorative",
	"Clicker Script" => "Clicker+Script",
	"Coda" => "Coda",
	"Coda Caption" => "Coda+Caption",
	"Codystar" => "Codystar",
	"Combo" => "Combo",
	"Comfortaa" => "Comfortaa",
	"Coming Soon" => "Coming+Soon",
	"Concert One" => "Concert+One",
	"Condiment" => "Condiment",
	"Content" => "Content",
	"Contrail One" => "Contrail+One",
	"Convergence" => "Convergence",
	"Cookie" => "Cookie",
	"Copse" => "Copse",
	"Corben" => "Corben",
	"Courgette" => "Courgette",
	"Cousine" => "Cousine",
	"Coustard" => "Coustard",
	"Covered By Your Grace" => "Covered+By+Your+Grace",
	"Crafty Girls" => "Crafty+Girls",
	"Creepster" => "Creepster",
	"Crete Round" => "Crete+Round",
	"Crimson Text" => "Crimson+Text",
	"Croissant One" => "Croissant+One",
	"Crushed" => "Crushed",
	"Cuprum" => "Cuprum",
	"Cutive" => "Cutive",
	"Cutive Mono" => "Cutive+Mono",
	"Damion" => "Damion",
	"Dancing Script" => "Dancing+Script",
	"Dangrek" => "Dangrek",
	"Dawning of a New Day" => "Dawning+of+a+New+Day",
	"Days One" => "Days+One",
	"Delius" => "Delius",
	"Delius Swash Caps" => "Delius+Swash+Caps",
	"Delius Unicase" => "Delius+Unicase",
	"Della Respira" => "Della+Respira",
	"Denk One" => "Denk+One",
	"Devonshire" => "Devonshire",
	"Didact Gothic" => "Didact+Gothic",
	"Diplomata" => "Diplomata",
	"Diplomata SC" => "Diplomata+SC",
	"Domine" => "Domine",
	"Donegal One" => "Donegal+One",
	"Doppio One" => "Doppio+One",
	"Dorsa" => "Dorsa",
	"Dosis" => "Dosis",
	"Dr Sugiyama" => "Dr+Sugiyama",
	"Droid Sans" => "Droid+Sans",
	"Droid Sans Mono" => "Droid+Sans+Mono",
	"Droid Serif" => "Droid+Serif",
	"Duru Sans" => "Duru+Sans",
	"Dynalight" => "Dynalight",
	"EB Garamond" => "EB+Garamond",
	"Eagle Lake" => "Eagle+Lake",
	"Eater" => "Eater",
	"Economica" => "Economica",
	"Electrolize" => "Electrolize",
	"Elsie" => "Elsie",
	"Elsie Swash Caps" => "Elsie+Swash+Caps",
	"Emblema One" => "Emblema+One",
	"Emilys Candy" => "Emilys+Candy",
	"Engagement" => "Engagement",
	"Englebert" => "Englebert",
	"Enriqueta" => "Enriqueta",
	"Erica One" => "Erica+One",
	"Esteban" => "Esteban",
	"Euphoria Script" => "Euphoria+Script",
	"Ewert" => "Ewert",
	"Exo" => "Exo",
	"Expletus Sans" => "Expletus+Sans",
	"Fanwood Text" => "Fanwood+Text",
	"Fascinate" => "Fascinate",
	"Fascinate Inline" => "Fascinate+Inline",
	"Faster One" => "Faster+One",
	"Fasthand" => "Fasthand",
	"Federant" => "Federant",
	"Federo" => "Federo",
	"Felipa" => "Felipa",
	"Fenix" => "Fenix",
	"Finger Paint" => "Finger+Paint",
	"Fjalla One" => "Fjalla+One",
	"Fjord One" => "Fjord+One",
	"Flamenco" => "Flamenco",
	"Flavors" => "Flavors",
	"Fondamento" => "Fondamento",
	"Fontdiner Swanky" => "Fontdiner+Swanky",
	"Forum" => "Forum",
	"Francois One" => "Francois+One",
	"Freckle Face" => "Freckle+Face",
	"Fredericka the Great" => "Fredericka+the+Great",
	"Fredoka One" => "Fredoka+One",
	"Freehand" => "Freehand",
	"Fresca" => "Fresca",
	"Frijole" => "Frijole",
	"Fruktur" => "Fruktur",
	"Fugaz One" => "Fugaz+One",
	"GFS Didot" => "GFS+Didot",
	"GFS Neohellenic" => "GFS+Neohellenic",
	"Gabriela" => "Gabriela",
	"Gafata" => "Gafata",
	"Galdeano" => "Galdeano",
	"Galindo" => "Galindo",
	"Gentium Basic" => "Gentium+Basic",
	"Gentium Book Basic" => "Gentium+Book+Basic",
	"Geo" => "Geo",
	"Geostar" => "Geostar",
	"Geostar Fill" => "Geostar+Fill",
	"Germania One" => "Germania+One",
	"Gilda Display" => "Gilda+Display",
	"Give You Glory" => "Give+You+Glory",
	"Glass Antiqua" => "Glass+Antiqua",
	"Glegoo" => "Glegoo",
	"Gloria Hallelujah" => "Gloria+Hallelujah",
	"Goblin One" => "Goblin+One",
	"Gochi Hand" => "Gochi+Hand",
	"Gorditas" => "Gorditas",
	"Goudy Bookletter 1911" => "Goudy+Bookletter+1911",
	"Graduate" => "Graduate",
	"Grand Hotel" => "Grand+Hotel",
	"Gravitas One" => "Gravitas+One",
	"Great Vibes" => "Great+Vibes",
	"Griffy" => "Griffy",
	"Gruppo" => "Gruppo",
	"Gudea" => "Gudea",
	"Habibi" => "Habibi",
	"Hammersmith One" => "Hammersmith+One",
	"Hanalei" => "Hanalei",
	"Hanalei Fill" => "Hanalei+Fill",
	"Handlee" => "Handlee",
	"Hanuman" => "Hanuman",
	"Happy Monkey" => "Happy+Monkey",
	"Headland One" => "Headland+One",
	"Henny Penny" => "Henny+Penny",
	"Herr Von Muellerhoff" => "Herr+Von+Muellerhoff",
	"Holtwood One SC" => "Holtwood+One+SC",
	"Homemade Apple" => "Homemade+Apple",
	"Homenaje" => "Homenaje",
	"IM Fell DW Pica" => "IM+Fell+DW+Pica",
	"IM Fell DW Pica SC" => "IM+Fell+DW+Pica+SC",
	"IM Fell Double Pica" => "IM+Fell+Double+Pica",
	"IM Fell Double Pica SC" => "IM+Fell+Double+Pica+SC",
	"IM Fell English" => "IM+Fell+English",
	"IM Fell English SC" => "IM+Fell+English+SC",
	"IM Fell French Canon" => "IM+Fell+French+Canon",
	"IM Fell French Canon SC" => "IM+Fell+French+Canon+SC",
	"IM Fell Great Primer" => "IM+Fell+Great+Primer",
	"IM Fell Great Primer SC" => "IM+Fell+Great+Primer+SC",
	"Iceberg" => "Iceberg",
	"Iceland" => "Iceland",
	"Imprima" => "Imprima",
	"Inconsolata" => "Inconsolata",
	"Inder" => "Inder",
	"Indie Flower" => "Indie+Flower",
	"Inika" => "Inika",
	"Irish Grover" => "Irish+Grover",
	"Istok Web" => "Istok+Web",
	"Italiana" => "Italiana",
	"Italianno" => "Italianno",
	"Jacques Francois" => "Jacques+Francois",
	"Jacques Francois Shadow" => "Jacques+Francois+Shadow",
	"Jim Nightshade" => "Jim+Nightshade",
	"Jockey One" => "Jockey+One",
	"Jolly Lodger" => "Jolly+Lodger",
	"Josefin Sans" => "Josefin+Sans",
	"Josefin Slab" => "Josefin+Slab",
	"Joti One" => "Joti+One",
	"Judson" => "Judson",
	"Julee" => "Julee",
	"Julius Sans One" => "Julius+Sans+One",
	"Junge" => "Junge",
	"Jura" => "Jura",
	"Just Another Hand" => "Just+Another+Hand",
	"Just Me Again Down Here" => "Just+Me+Again+Down+Here",
	"Kameron" => "Kameron",
	"Karla" => "Karla",
	"Kaushan Script" => "Kaushan+Script",
	"Kavoon" => "Kavoon",
	"Keania One" => "Keania+One",
	"Kelly Slab" => "Kelly+Slab",
	"Kenia" => "Kenia",
	"Khmer" => "Khmer",
	"Kite One" => "Kite+One",
	"Knewave" => "Knewave",
	"Kotta One" => "Kotta+One",
	"Koulen" => "Koulen",
	"Kranky" => "Kranky",
	"Kreon" => "Kreon",
	"Kristi" => "Kristi",
	"Krona One" => "Krona+One",
	"La Belle Aurore" => "La+Belle+Aurore",
	"Lancelot" => "Lancelot",
	"Lato" => "Lato",
	"League Script" => "League+Script",
	"Leckerli One" => "Leckerli+One",
	"Ledger" => "Ledger",
	"Lekton" => "Lekton",
	"Lemon" => "Lemon",
	"Libre Baskerville" => "Libre+Baskerville",
	"Life Savers" => "Life+Savers",
	"Lilita One" => "Lilita+One",
	"Limelight" => "Limelight",
	"Linden Hill" => "Linden+Hill",
	"Lobster" => "Lobster",
	"Lobster Two" => "Lobster+Two",
	"Londrina Outline" => "Londrina+Outline",
	"Londrina Shadow" => "Londrina+Shadow",
	"Londrina Sketch" => "Londrina+Sketch",
	"Londrina Solid" => "Londrina+Solid",
	"Lora" => "Lora",
	"Love Ya Like A Sister" => "Love+Ya+Like+A+Sister",
	"Loved by the King" => "Loved+by+the+King",
	"Lovers Quarrel" => "Lovers+Quarrel",
	"Luckiest Guy" => "Luckiest+Guy",
	"Lusitana" => "Lusitana",
	"Lustria" => "Lustria",
	"Macondo" => "Macondo",
	"Macondo Swash Caps" => "Macondo+Swash+Caps",
	"Magra" => "Magra",
	"Maiden Orange" => "Maiden+Orange",
	"Mako" => "Mako",
	"Marcellus" => "Marcellus",
	"Marcellus SC" => "Marcellus+SC",
	"Marck Script" => "Marck+Script",
	"Margarine" => "Margarine",
	"Marko One" => "Marko+One",
	"Marmelad" => "Marmelad",
	"Marvel" => "Marvel",
	"Mate" => "Mate",
	"Mate SC" => "Mate+SC",
	"Maven Pro" => "Maven+Pro",
	"McLaren" => "McLaren",
	"Meddon" => "Meddon",
	"MedievalSharp" => "MedievalSharp",
	"Medula One" => "Medula+One",
	"Megrim" => "Megrim",
	"Meie Script" => "Meie+Script",
	"Merienda" => "Merienda",
	"Merienda One" => "Merienda+One",
	"Merriweather" => "Merriweather",
	"Merriweather Sans" => "Merriweather+Sans",
	"Metal" => "Metal",
	"Metal Mania" => "Metal+Mania",
	"Metamorphous" => "Metamorphous",
	"Metrophobic" => "Metrophobic",
	"Michroma" => "Michroma",
	"Milonga" => "Milonga",
	"Miltonian" => "Miltonian",
	"Miltonian Tattoo" => "Miltonian+Tattoo",
	"Miniver" => "Miniver",
	"Miss Fajardose" => "Miss+Fajardose",
	"Modern Antiqua" => "Modern+Antiqua",
	"Molengo" => "Molengo",
	"Molle" => "Molle",
	"Monda" => "Monda",
	"Monofett" => "Monofett",
	"Monoton" => "Monoton",
	"Monsieur La Doulaise" => "Monsieur+La+Doulaise",
	"Montaga" => "Montaga",
	"Montez" => "Montez",
	"Montserrat" => "Montserrat",
	"Montserrat Alternates" => "Montserrat+Alternates",
	"Montserrat Subrayada" => "Montserrat+Subrayada",
	"Moul" => "Moul",
	"Moulpali" => "Moulpali",
	"Mountains of Christmas" => "Mountains+of+Christmas",
	"Mouse Memoirs" => "Mouse+Memoirs",
	"Mr Bedfort" => "Mr+Bedfort",
	"Mr Dafoe" => "Mr+Dafoe",
	"Mr De Haviland" => "Mr+De+Haviland",
	"Mrs Saint Delafield" => "Mrs+Saint+Delafield",
	"Mrs Sheppards" => "Mrs+Sheppards",
	"Muli" => "Muli",
	"Mystery Quest" => "Mystery+Quest",
	"Neucha" => "Neucha",
	"Neuton" => "Neuton",
	"New Rocker" => "New+Rocker",
	"News Cycle" => "News+Cycle",
	"Niconne" => "Niconne",
	"Nixie One" => "Nixie+One",
	"Nobile" => "Nobile",
	"Nokora" => "Nokora",
	"Norican" => "Norican",
	"Nosifer" => "Nosifer",
	"Nothing You Could Do" => "Nothing+You+Could+Do",
	"Noticia Text" => "Noticia+Text",
	"Nova Cut" => "Nova+Cut",
	"Nova Flat" => "Nova+Flat",
	"Nova Mono" => "Nova+Mono",
	"Nova Oval" => "Nova+Oval",
	"Nova Round" => "Nova+Round",
	"Nova Script" => "Nova+Script",
	"Nova Slim" => "Nova+Slim",
	"Nova Square" => "Nova+Square",
	"Numans" => "Numans",
	"Nunito" => "Nunito",
	"Odor Mean Chey" => "Odor+Mean+Chey",
	"Offside" => "Offside",
	"Old Standard TT" => "Old+Standard+TT",
	"Oldenburg" => "Oldenburg",
	"Oleo Script" => "Oleo+Script",
	"Oleo Script Swash Caps" => "Oleo+Script+Swash+Caps",
	"Open Sans" => "Open+Sans",
	"Open Sans Condensed" => "Open+Sans+Condensed",
	"Oranienbaum" => "Oranienbaum",
	"Orbitron" => "Orbitron",
	"Oregano" => "Oregano",
	"Orienta" => "Orienta",
	"Original Surfer" => "Original+Surfer",
	"Oswald" => "Oswald",
	"Over the Rainbow" => "Over+the+Rainbow",
	"Overlock" => "Overlock",
	"Overlock SC" => "Overlock+SC",
	"Ovo" => "Ovo",
	"Oxygen" => "Oxygen",
	"Oxygen Mono" => "Oxygen+Mono",
	"PT Mono" => "PT+Mono",
	"PT Sans" => "PT+Sans",
	"PT Sans Caption" => "PT+Sans+Caption",
	"PT Sans Narrow" => "PT+Sans+Narrow",
	"PT Serif" => "PT+Serif",
	"PT Serif Caption" => "PT+Serif+Caption",
	"Pacifico" => "Pacifico",
	"Paprika" => "Paprika",
	"Parisienne" => "Parisienne",
	"Passero One" => "Passero+One",
	"Passion One" => "Passion+One",
	"Patrick Hand" => "Patrick+Hand",
	"Patrick Hand SC" => "Patrick+Hand+SC",
	"Patua One" => "Patua+One",
	"Paytone One" => "Paytone+One",
	"Peralta" => "Peralta",
	"Permanent Marker" => "Permanent+Marker",
	"Petit Formal Script" => "Petit+Formal+Script",
	"Petrona" => "Petrona",
	"Philosopher" => "Philosopher",
	"Piedra" => "Piedra",
	"Pinyon Script" => "Pinyon+Script",
	"Pirata One" => "Pirata+One",
	"Plaster" => "Plaster",
	"Play" => "Play",
	"Playball" => "Playball",
	"Playfair Display" => "Playfair+Display",
	"Playfair Display SC" => "Playfair+Display+SC",
	"Podkova" => "Podkova",
	"Poiret One" => "Poiret+One",
	"Poller One" => "Poller+One",
	"Poly" => "Poly",
	"Pompiere" => "Pompiere",
	"Pontano Sans" => "Pontano+Sans",
	"Port Lligat Sans" => "Port+Lligat+Sans",
	"Port Lligat Slab" => "Port+Lligat+Slab",
	"Prata" => "Prata",
	"Preahvihear" => "Preahvihear",
	"Press Start 2P" => "Press+Start+2P",
	"Princess Sofia" => "Princess+Sofia",
	"Prociono" => "Prociono",
	"Prosto One" => "Prosto+One",
	"Puritan" => "Puritan",
	"Purple Purse" => "Purple+Purse",
	"Quando" => "Quando",
	"Quantico" => "Quantico",
	"Quattrocento" => "Quattrocento",
	"Quattrocento Sans" => "Quattrocento+Sans",
	"Questrial" => "Questrial",
	"Quicksand" => "Quicksand",
	"Quintessential" => "Quintessential",
	"Qwigley" => "Qwigley",
	"Racing Sans One" => "Racing+Sans+One",
	"Radley" => "Radley",
	"Raleway" => "Raleway",
	"Raleway Dots" => "Raleway+Dots",
	"Rambla" => "Rambla",
	"Rammetto One" => "Rammetto+One",
	"Ranchers" => "Ranchers",
	"Rancho" => "Rancho",
	"Rationale" => "Rationale",
	"Redressed" => "Redressed",
	"Reenie Beanie" => "Reenie+Beanie",
	"Revalia" => "Revalia",
	"Ribeye" => "Ribeye",
	"Ribeye Marrow" => "Ribeye+Marrow",
	"Righteous" => "Righteous",
	"Risque" => "Risque",
	"Roboto" => "Roboto",
	"Roboto Condensed" => "Roboto+Condensed",
	"Rochester" => "Rochester",
	"Rock Salt" => "Rock+Salt",
	"Rokkitt" => "Rokkitt",
	"Romanesco" => "Romanesco",
	"Ropa Sans" => "Ropa+Sans",
	"Rosario" => "Rosario",
	"Rosarivo" => "Rosarivo",
	"Rouge Script" => "Rouge+Script",
	"Ruda" => "Ruda",
	"Rufina" => "Rufina",
	"Ruge Boogie" => "Ruge+Boogie",
	"Ruluko" => "Ruluko",
	"Rum Raisin" => "Rum+Raisin",
	"Ruslan Display" => "Ruslan+Display",
	"Russo One" => "Russo+One",
	"Ruthie" => "Ruthie",
	"Rye" => "Rye",
	"Sacramento" => "Sacramento",
	"Sail" => "Sail",
	"Salsa" => "Salsa",
	"Sanchez" => "Sanchez",
	"Sancreek" => "Sancreek",
	"Sansita One" => "Sansita+One",
	"Sarina" => "Sarina",
	"Satisfy" => "Satisfy",
	"Scada" => "Scada",
	"Schoolbell" => "Schoolbell",
	"Seaweed Script" => "Seaweed+Script",
	"Sevillana" => "Sevillana",
	"Seymour One" => "Seymour+One",
	"Shadows Into Light" => "Shadows+Into+Light",
	"Shadows Into Light Two" => "Shadows+Into+Light+Two",
	"Shanti" => "Shanti",
	"Share" => "Share",
	"Share Tech" => "Share+Tech",
	"Share Tech Mono" => "Share+Tech+Mono",
	"Shojumaru" => "Shojumaru",
	"Short Stack" => "Short+Stack",
	"Siemreap" => "Siemreap",
	"Sigmar One" => "Sigmar+One",
	"Signika" => "Signika",
	"Signika Negative" => "Signika+Negative",
	"Simonetta" => "Simonetta",
	"Sintony" => "Sintony",
	"Sirin Stencil" => "Sirin+Stencil",
	"Six Caps" => "Six+Caps",
	"Skranji" => "Skranji",
	"Slackey" => "Slackey",
	"Smokum" => "Smokum",
	"Smythe" => "Smythe",
	"Sniglet" => "Sniglet",
	"Snippet" => "Snippet",
	"Snowburst One" => "Snowburst+One",
	"Sofadi One" => "Sofadi+One",
	"Sofia" => "Sofia",
	"Sonsie One" => "Sonsie+One",
	"Sorts Mill Goudy" => "Sorts+Mill+Goudy",
	"Source Code Pro" => "Source+Code+Pro",
	"Source Sans Pro" => "Source+Sans+Pro",
	"Special Elite" => "Special+Elite",
	"Spicy Rice" => "Spicy+Rice",
	"Spinnaker" => "Spinnaker",
	"Spirax" => "Spirax",
	"Squada One" => "Squada+One",
	"Stalemate" => "Stalemate",
	"Stalinist One" => "Stalinist+One",
	"Stardos Stencil" => "Stardos+Stencil",
	"Stint Ultra Condensed" => "Stint+Ultra+Condensed",
	"Stint Ultra Expanded" => "Stint+Ultra+Expanded",
	"Stoke" => "Stoke",
	"Strait" => "Strait",
	"Sue Ellen Francisco" => "Sue+Ellen+Francisco",
	"Sunshiney" => "Sunshiney",
	"Supermercado One" => "Supermercado+One",
	"Suwannaphum" => "Suwannaphum",
	"Swanky and Moo Moo" => "Swanky+and+Moo+Moo",
	"Syncopate" => "Syncopate",
	"Tangerine" => "Tangerine",
	"Taprom" => "Taprom",
	"Tauri" => "Tauri",
	"Telex" => "Telex",
	"Tenor Sans" => "Tenor+Sans",
	"Text Me One" => "Text+Me+One",
	"The Girl Next Door" => "The+Girl+Next+Door",
	"Tienne" => "Tienne",
	"Tinos" => "Tinos",
	"Titan One" => "Titan+One",
	"Titillium Web" => "Titillium+Web",
	"Trade Winds" => "Trade+Winds",
	"Trocchi" => "Trocchi",
	"Trochut" => "Trochut",
	"Trykker" => "Trykker",
	"Tulpen One" => "Tulpen+One",
	"Ubuntu" => "Ubuntu",
	"Ubuntu Condensed" => "Ubuntu+Condensed",
	"Ubuntu Mono" => "Ubuntu+Mono",
	"Ultra" => "Ultra",
	"Uncial Antiqua" => "Uncial+Antiqua",
	"Underdog" => "Underdog",
	"Unica One" => "Unica+One",
	"UnifrakturCook" => "UnifrakturCook",
	"UnifrakturMaguntia" => "UnifrakturMaguntia",
	"Unkempt" => "Unkempt",
	"Unlock" => "Unlock",
	"Unna" => "Unna",
	"VT323" => "VT323",
	"Vampiro One" => "Vampiro+One",
	"Varela" => "Varela",
	"Varela Round" => "Varela+Round",
	"Vast Shadow" => "Vast+Shadow",
	"Vibur" => "Vibur",
	"Vidaloka" => "Vidaloka",
	"Viga" => "Viga",
	"Voces" => "Voces",
	"Volkhov" => "Volkhov",
	"Vollkorn" => "Vollkorn",
	"Voltaire" => "Voltaire",
	"Waiting for the Sunrise" => "Waiting+for+the+Sunrise",
	"Wallpoet" => "Wallpoet",
	"Walter Turncoat" => "Walter+Turncoat",
	"Warnes" => "Warnes",
	"Wellfleet" => "Wellfleet",
	"Wendy One" => "Wendy+One",
	"Wire One" => "Wire+One",
	"Yanone Kaffeesatz" => "Yanone+Kaffeesatz",
	"Yellowtail" => "Yellowtail",
	"Yeseva One" => "Yeseva+One",
	"Yesteryear" => "Yesteryear",
	"Zeyada" => "Zeyada",
	);
	//$google_faces = $fontArray;
	return $google_faces;
}

/**
 * Checks font options to see if a Google font is selected.
 * If so, options_typography_enqueue_google_font is called to enqueue the font.
 * Ensures that each Google font is only enqueued once.
 */
/**
 * Checks font options to see if a Google font is selected.
 * If so, options_typography_enqueue_google_font is called to enqueue the font.
 * Ensures that each Google font is only enqueued once.
 */
if ( !function_exists( 'options_typography_google_fonts' ) ) {
	function options_typography_google_fonts() {
		$all_google_fonts = array_keys( options_typography_get_google_fonts() );
		// Define all the options that possibly have a unique Google font
		$deffont = array('face' => 'Arial, serif');
		$google_font = of_get_option('body_typography', $deffont);
		$title_typography = of_get_option('title_typography', $deffont);
		$button_typography = of_get_option('button_typography', $deffont);
		$menu_typography = of_get_option('menu_typography', $deffont);
		$submenu_typography = of_get_option('submenu_typography', $deffont);
		$google_mixed = of_get_option('google_mixed', false);
		// Get the font face for each option and put it in an array
		$selected_fonts = array(
			$google_font['face'],
			$title_typography['face'],
			$button_typography['face'],
			$menu_typography['face'],
			$submenu_typography['face'],
			$google_mixed['face']);
		// Remove any duplicates in the list
		$selected_fonts = array_unique($selected_fonts);
			
		// Check each of the unique fonts against the defined Google fonts
		// If it is a Google font, go ahead and call the function to enqueue it
		foreach ( $selected_fonts as $font ) {
			if ( in_array( $font, $all_google_fonts ) ) {
				options_typography_enqueue_google_font($font);
				
			}
		}
	}
}

add_action( 'wp_enqueue_scripts', 'options_typography_google_fonts' );

/**
 * Enqueues the Google $font that is passed
 */ 
function options_typography_enqueue_google_font($font) {
	$font = explode(',', $font);
	$font = $font[0];
	// Certain Google fonts need slight tweaks in order to load properly
	// Like our friend "Raleway"
	if ( $font == 'Raleway' )
		$font = 'Raleway:100';
	$font = str_replace(" ", "+", $font);

	wp_enqueue_style( "options_typography_$font", "http://fonts.googleapis.com/css?family=$font", false, null, 'all' );
}

/* 
 * Outputs the selected option panel styles inline into the <head>
 */
function options_typography_styles() {
     $output = '';
     $input = '';
     if ( of_get_option( 'body_typography' ) ) {
          $input = of_get_option( 'body_typography' );
	  $output .= options_typography_font_styles( of_get_option( 'body_typography' ) , '.google-font');
     }
	  if ( of_get_option( 'title_typography' ) ) {
          $input = of_get_option( 'title_typography' );
	  $output .= options_typography_font_styles( of_get_option( 'title_typography' ) , '.google-font');
     }
	 if ( of_get_option( 'button_typography' ) ) {
          $input = of_get_option( 'button_typography' );
	  $output .= options_typography_font_styles( of_get_option( 'button_typography' ) , '.google-font');
     }
	  if ( of_get_option( 'menu_typography' ) ) {
          $input = of_get_option( 'menu_typography' );
	  $output .= options_typography_font_styles( of_get_option( 'menu_typography' ) , '.google-font');
     }
	 if ( of_get_option( 'submenu_typography' ) ) {
          $input = of_get_option( 'submenu_typography' );
	  $output .= options_typography_font_styles( of_get_option( 'submenu_typography' ) , '.google-font');
     }
	 

     if ( $output != '' ) {
	$output = "\n<style>\n" . $output . "</style>\n";
	echo $output;
     }
}
//add_action('wp_head', 'options_typography_styles');

/* 
 * Returns a typography option in a format that can be outputted as inline CSS
 */

function options_typography_font_styles($option, $selectors) {
		$output = $selectors . ' {';
		$output .= ' color:' . $option['color'] .'; ';
		$output .= 'font-family:' . $option['face'] . '; ';
		$output .= 'font-weight:' . $option['style'] . '; ';
		$output .= 'font-size:' . $option['size'] . '; ';
		$output .= '}';
		$output .= "\n";
		return $output;
}

class rpwe_widget extends WP_Widget
{

	/**
	 * Widget setup
	 */
	function rpwe_widget()
	{

		$widget_ops = array(
			'classname' => 'rpwe_widget recent-posts-extended',
			'description' => __('Storyline Board recent posts widget.', 'rpwe')
		);

		$this->WP_Widget('rpwe_widget', __('SB Recent Posts', 'rpwe'), $widget_ops);

	}

	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);

		$title = apply_filters('widget_title', $instance['title']);
		$limit = $instance['limit'];
		$excerpt = $instance['excerpt'];
		$length = (int)($instance['length']);
		$thumb = $instance['thumb'];
		$cat = $instance['cat'];
		$post_type = 'post';
		$date = $instance['date'];

		echo $before_widget;

		if (!empty($title))
			echo $before_title . $title . $after_title;

		global $post;

		if (false === ($rpwewidget = get_transient('rpwewidget_' . $widget_id))) {

			$args = array(
				'numberposts' => $limit,
				'cat' => $cat,
				'post_type' => $post_type
			);

			$rpwewidget = get_posts($args);

			

		} ?>

		<div class="rpsb-block">

			<ul class="rpsb-ul">

				<?php foreach ($rpwewidget as $post) : setup_postdata($post); ?>

					<li class="rpsb-clearfix">

						<?php if (has_post_thumbnail() && $thumb == true) { ?>

							<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'rpsb'), the_title_attribute('echo=0')); ?>" rel="bookmark">
								<?php
								if (current_theme_supports('get-the-image'))
									get_the_image(array('meta_key' => 'Thumbnail', 'height' => '60', 'width' => '60', 'image_class' => 'rpwe-alignleft', 'link_to_post' => false));
								else
									the_post_thumbnail(array('60', '60'), array('class' => 'rpsb-alignleft', 'alt' => esc_attr(get_the_title()), 'title' => esc_attr(get_the_title())));
								?>
							</a>

						<?php } ?>

						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'rpsb'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h3>

						<?php if ($date == true) { ?>
							<span class="rpsb-time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . __(' ago', 'rpsb'); ?></span>
						<?php } ?>

						<?php if ($excerpt == true) { ?>
							<div class="rpsb-summary"><?php echo rpwe_excerpt($length); ?></div>
						<?php } ?>

					</li>

				<?php endforeach;
				wp_reset_postdata(); ?>

			</ul>

		</div>

		<?php

		echo $after_widget;

	}

	/**
	 * Update widget
	 */
	function update($new_instance, $old_instance)
	{

		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['limit'] = $new_instance['limit'];
		$instance['excerpt'] = $new_instance['excerpt'];
		$instance['length'] = (int)($new_instance['length']);
		$instance['thumb'] = $new_instance['thumb'];
		$instance['cat'] = $new_instance['cat'];
		$instance['date'] = $new_instance['date'];


		delete_transient('rpwewidget_' . $this->id);

		return $instance;

	}

	/**
	 * Widget setting
	 */
	function form($instance)
	{

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => '',
			'limit' => 5,
			'excerpt' => '',
			'length' => 10,
			'thumb' => true,
			'cat' => '',
			'date' => true,
		);

		$instance = wp_parse_args((array)$instance, $defaults);
		$title = esc_attr($instance['title']);
		$limit = $instance['limit'];
		$excerpt = $instance['excerpt'];
		$length = (int)($instance['length']);
		$thumb = $instance['thumb'];
		$cat = $instance['cat'];
		$date = $instance['date'];

		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'rpwe'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php _e('Number of posts to show:', 'rpwe'); ?></label>
            <input class="widefat" name="<?php echo $this->get_field_name('limit'); ?>" id="<?php echo $this->get_field_id('limit'); ?>" type="text" value="<?php echo $limit; ?>"/>
          
		</p>
        
		<?php if (current_theme_supports('post-thumbnails')) { ?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('thumb')); ?>"><?php _e('Display Thumbnail?', 'rpwe'); ?></label>
				<input id="<?php echo $this->get_field_id('thumb'); ?>" name="<?php echo $this->get_field_name('thumb'); ?>" type="checkbox" value="1" <?php checked('1', $thumb); ?> />&nbsp;
			</p>
		<?php } ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('date')); ?>"><?php _e('Display Date?', 'rpwe'); ?></label>
			<input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" value="1" <?php checked('1', $date); ?> />&nbsp;
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('excerpt')); ?>"><?php _e('Display Excerpt?', 'rpwe'); ?></label>
			<input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" value="1" <?php checked('1', $excerpt); ?> />&nbsp;
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('length')); ?>"><?php _e('Excerpt Length:', 'rpwe'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('length')); ?>" name="<?php echo esc_attr($this->get_field_name('length')); ?>" type="text" value="<?php echo $length; ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php _e('Category: ', 'rpwe'); ?></label>
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('cat'), 'show_option_all' => __('All categories', 'rpwe'), 'hide_empty' => 1, 'hierarchical' => 1, 'selected' => $cat)); ?>
		</p>
		
	

	<?php
	}

}

function rpwe_register_widget()
{
	register_widget('rpwe_widget');
}

add_action('widgets_init', 'rpwe_register_widget');

function rpwe_excerpt($length)
{

	$excerpt = explode(' ', get_the_excerpt(), $length);
	if (count($excerpt) >= $length) {
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt) . '&hellip;';
	} else {
		$excerpt = implode(" ", $excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

	return $excerpt;

}
add_filter('widget_text', 'do_shortcode');






function mytheme_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'mytheme-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans" );}
add_action( 'wp_enqueue_scripts', 'mytheme_fonts' );



add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
	
    if(!session_id()) {
        session_start();
		
    }
}

function myEndSession() {
    session_destroy ();
}

// Remove theme support woocommerce notice from administration
add_theme_support( 'woocommerce' );

/*if ( !session_id() ){
add_action( 'init', 'session_start' );
$_SESSION['videoplayed'] = 0;
}*/
function ys_wc_custom_add_to_cart_message( $massage ) {

	

	$_SESSION['ys-atcm'] = $massage;

	return $massage;

}

add_filter( 'woocommerce_add_to_cart_message', 'ys_wc_custom_add_to_cart_message' );

include( 'inc/plugins.php' );


?>
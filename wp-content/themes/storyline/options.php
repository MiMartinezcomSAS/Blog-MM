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
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {
	$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
asort($typography_mixed_fonts);

	$slider_play = array(
		'true' => __('Yes', 'options_check'),
		'false' => __('No', 'options_check')
	);
	
	$background_valign = array(
		'top' => __('Top', 'options_check'),
		'center' => __('Center', 'options_check'),
		'bottom' => __('Bottom', 'options_check')
	);
	$background_halign = array(
		'left' => __('Left', 'options_check'),
		'center' => __('Center', 'options_check'),
		'right' => __('Right', 'options_check')
	);
	
	$scroll_effect = array(
		'0' => __('Classic', 'options_check'),
		'1' => __('Cube', 'options_check'),
		'2' => __('Carousel', 'options_check'),
		'3' => __('Concave', 'options_check'),
		'4' => __('Coverflow', 'options_check'),
		'5' => __('Spiral top', 'options_check'),
		'6' => __('Spiral bottom', 'options_check'),
		'7' => __('Tilt Classic', 'options_check')
		
		
	);
	
	$date_bubble = array(
		'hide' => __('Hide', 'options_check'),
		'date' => __('Date', 'options_check'),
		'price' => __('Price', 'options_check'),
		'rating' => __('Rating', 'options_check')
	);
	$pagination_display = array(
		'infinite' => __('Infinite Scroll', 'options_check'),
		'pagination' => __('Pagination', 'options_check')
	);
	$typography_defaults = array(
		'size' => '12px',
		'face' => 'Open Sans',
		'color' => '#8b8b8b' );
		
	$typography_options_titles = array(
		'faces' => options_typography_get_google_fonts(),
		'styles' =>  array(
           
	"normal" => "Normal",
	"italic" => "Italic",
	"bold" => "Bold",
	"bold italic" => "Bold italic"
	)
	);
	
	

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	$options_categories['all'] = 'All';
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;

	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('General', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Home page', 'options_check'),
		'desc' => __('Select home page posts type', 'options_check'),
		'id' => 'sticky-posts',
		'std' => 'show_latest',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'show_latest' => __('Latest posts', 'options_check'),
			'show_sticky' => __('Sticky posts', 'options_check')
			)
		);
	$options[] = array(
		'name' => __('Order posts by', 'options_check'),
		'desc' => __('Show or hide category container ', 'options_check'),
		'id' => 'order-posts',
		'std' => 'lf',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'lf' => __('Last added is first', 'options_check'),
			'll' => __('Last added is last', 'options_check')
			)
		);
	$options[] = array(
		'name' => __('Posts in future', 'options_check'),
		'desc' => __('Enable this option if you want to use timeline template for events or something else that requaers posts with future date to be displayed', 'options_check'),
		'id' => 'future-posts',
		'std' => 'off',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
			)
		);
		
	$options[] = array(
		'name' => __('Hide older posts', 'options_check'),
		'desc' => __('Enable this option will automaticaly hide posts after post date has past', 'options_check'),
		'id' => 'older-posts',
		'std' => 'off',
		'type' => 'select',
		'class' => 'tiny', //mini, tiny, small
		'options' => array(
			'off' => __('Disabled', 'options_check'),
			'frontend' => __('Hide from front-end', 'options_check'),
			'backend' => __('Hide from front-end and back-end', 'options_check')
			)
		);
		
	$options[] = array(
		'desc' => __('Select category for which hide older posts is valid', 'options_check'),
		'id' => 'hide-categories',
		'type' => 'select',
		'class' => 'tiny', 
		'options' => $options_categories
		);
	$options[] = array(
		'desc' => __('Add +/- days from now to hide posts (example: "+1 day", "-2 day" or "now")', 'options_check'),
		'id' => 'hide-post-date',
		'std' => 'now',
		'class' => 'mini', 
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Select pagination', 'options_check'),
		'desc' => __('Select how to display pages', 'options_check'),
		'id' => 'def-pagination-display',
		'std' => 'infinite',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pagination_display);
	$options[] = array(
		'name' => __('Select scroll effect ', 'options_check'),
		'desc' => __('Change scroll effect ', 'options_check'),
		'id' => 'scroll-effect',
		'std' => 'perspective1',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $scroll_effect);
	
   
    $options[] = array(
		'name' => __('Mouse parallax effect', 'options_check'),
		'desc' => __('Activate mouse parallax effect', 'options_check'),
		'id' => 'active-mouse-parallax',
		'std' => '0',
		'type' => 'checkbox');    
	$options[] = array(
		'name' => __('Auto rotate ', 'options_check'),
		'desc' => __('Enable or disable post auto rotation ', 'options_check'),
		'id' => 'post-autorotate',
		'std' => 'off',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
		));
		$options[] = array(
		'desc' => __('Add slideshow delay in miliseconds', 'options_check'),
		'id' => 'post-autorotate-delay',
		'std' => '3000',
		'class' => 'mini', 
		'type' => 'text');
		
		
	
	$options[] = array(
		'name' => __('Open post effect', 'options_check'),
		'desc' => __('Enable or disable open post effect ', 'options_check'),
		'id' => 'post-fx',
		'std' => 'on',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
		));
	$options[] = array(
		'name' => __('Bounce to comments', 'options_check'),
		'desc' => __('On / Off automatic scrolling to comments on hitting bottom of the page ', 'options_check'),
		'id' => 'comments-bounce',
		'std' => 'on',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
		));
		
	$options[] = array(
		'name' => __('Disqus ID', 'options_check'),
		'desc' => __('Enter your disqus ID', 'options_check'),
		'id' => 'disqus-id',
		'std' => '',
		'class' => 'mini', 
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Comments effect', 'options_check'),
		'desc' => __('On / Off comments effect ', 'options_check'),
		'id' => 'comments-fx',
		'std' => 'on',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
		));
	$options[] = array(
		'name' => __('Select first post', 'options_check'),
		'desc' => __('Select which post to be on focus first(number).', 'options_check'),
		'id' => 'select-first-post',
		'std' => '0',
		'class' => 'mini', 
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Post excerpt', 'options_check'),
		'desc' => __('Maximum excerpt symbols for square post type', 'options_check'),
		'id' => 'max-excerpt-square',
		'std' => '336',
		'class' => 'mini', 
		'type' => 'text');
	$options[] = array(
		'name' => __('Post excerpt', 'options_check'),
		'desc' => __('Maximum excerpt symbols for circle post type', 'options_check'),
		'id' => 'max-excerpt-circle',
		'std' => '325',
		'class' => 'mini', 
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Related posts', 'options_check'),
		'desc' => __('On / Off related post', 'options_check'),
		'id' => 'related-posts',
		'std' => 'off',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
		));
	$options[] = array(
		'desc' => __('Maximum number of related posts', 'options_check'),
		'id' => 'max-related-posts',
		'std' => '4',
		'class' => 'mini', 
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Select logo', 'options_check'),
		'desc' => __('Select Logo (200x70)', 'options_check'),
		'id' => 'logo-img',
		'class' => 'small', 
		'type' => 'upload');
		
		
	$options[] = array(
		'name' => "Select default content style",
		'desc' => "*Select default content style: square or circle. You can change this option for every single post",
		'id' => "content-style",
		'std' => "square",
		'type' => "images",
		'options' => array(
			'square' => $imagepath . 'options/post-sqr.png',
			'circle' => $imagepath . 'options/post-circ.png',
			
			)
	);
	
	$options[] = array(
		'name' => __('Select other default settings ', 'options_check'),
		'desc' => __('Show or hide date', 'options_check'),
		'id' => 'show-date',
		'std' => 'show',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'show' => __('Show', 'options_check'),
			'hide' => __('Hide', 'options_check')
			)
		);
	
	$options[] = array(
		'desc' => __('Sidebar', 'options_check'),
		'id' => 'show-sidebar',
		'std' => 'sbleft',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'sbleft' => __('Left sidebar', 'options_check'),
			'sbright' => __('Right sidebar', 'options_check'),
			'hide' => __('Hide', 'options_check')
			)
		);
	
	$options[] = array(
		'desc' => __('Show or hide title', 'options_check'),
		'id' => 'show-titile',
		'std' => 'show',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'show' => __('Show', 'options_check'),
			'hide' => __('Hide', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('Show or hide info container ', 'options_check'),
		'id' => 'show-category',
		'std' => 'show',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'show' => __('Show', 'options_check'),
			'hide' => __('Hide', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('Show or hide social icon', 'options_check'),
		'id' => 'show-soc',
		'std' => 'hide',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'show' => __('Show', 'options_check'),
			'hide' => __('Hide', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('Slider effect', 'options_check'),
		'id' => 'img-effect',
		'std' => 'fade',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'fade' => __('Fade', 'options_check'),
			'slide' => __('Slide', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('Slider direction (only if effect is set to "Slide")', 'options_check'),
		'id' => 'img-sdirection',
		'std' => 'horizontal',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'horizontal' => __('Horizontal', 'options_check'),
			'vertical' => __('Vertical', 'options_check')
			)
		);
		
	$options[] = array(
		'desc' => __('Images slideshow', 'options_check'),
		'id' => 'img-slideshow',
		'std' => 'false',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'true' => __('On', 'options_check'),
			'false' => __('Off', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('On / off facebook comments', 'options_check'),
		'id' => 'show-fb-comments',
		'std' => 'off',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
			)
		);
	
	$options[] = array(
		'name' => __('Rollover images effect', 'options_check'),
		'desc' => __('Image rotate', 'options_check'),
		'id' => 'rollover-rotate',
		'std' => '10',
		'class' => 'mini', 
		'type' => 'text');
	$options[] = array(
		'desc' => __('Image scale', 'options_check'),
		'id' => 'rollover-scale',
		'std' => '2',
		'class' => 'mini', 
		'type' => 'text');
	$options[] = array(
		'desc' => __('Duration (in seconds)', 'options_check'),
		'id' => 'rollover-duration',
		'std' => '1',
		'class' => 'mini', 
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Rollout images effect', 'options_check'),
		'desc' => __('Image rotate', 'options_check'),
		'id' => 'rollout-rotate',
		'std' => '0',
		'class' => 'mini', 
		'type' => 'text');
	$options[] = array(
		'desc' => __('Image scale', 'options_check'),
		'id' => 'rollout-scale',
		'std' => '1',
		'class' => 'mini', 
		'type' => 'text');
	$options[] = array(
		'desc' => __('Duration (in seconds)', 'options_check'),
		'id' => 'rollout-duration',
		'std' => '1',
		'class' => 'mini', 
		'type' => 'text');
		
		

	
	$options[] = array(
		'name' => __('Welcome message', 'options_check'),
		'desc' => __('Activate welcome/info message to new visitors.', 'options_check'),
		'id' => 'wellcome-msg',
		'std' => '1',
		'type' => 'checkbox');
	$options[] = array(

		'desc' => __('Add welcome/info message to new visitors', 'options_check'),
		'id' => 'wellcome-msg-text-hidden',
		'std' => '<span class="content-title">Welcome</span>
<span id="input-method">You can navigate trough the site by:</span>
<br />
<span><i class="icon-arrow-left"></i> <i class="icon-arrow-right "></i> keys | 
<i class="icon-sun "></i> scroll | 
<i class="icon-level-down "></i> click</span><br /><br />',
		'class' => 'hidden',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Footer', 'options_check'),
		'desc' => __('Activate footer.', 'options_check'),
		'id' => 'example_showhidden',
		'std' => '1',
		'type' => 'checkbox');
	
	
		
	$options[] = array(

		'desc' => __('Add footer content', 'options_check'),
		'id' => 'example_text_hidden',
		'std' => '<p><strong>Copyright 2012 <?php bloginfo("name"); ?> | All Rights Reserved. </a> </strong> Designed by <a href="http://yoursite.com">Your Name</a></p>',
		'class' => 'hidden',
		'type' => 'textarea');
	
	

	
	
	//Background slideshow
    //==================================================
	$options[] = array(
		'name' => __('Background slideshow', 'options_check'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Background Slideshow Settings', 'options_check'),
		'desc' => __('Activate Background Slideshow', 'options_check'),
		'id' => 'active-background',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Slideshow delay', 'options_check'),
		'desc' => __('Add slideshow delay in miliseconds', 'options_check'),
		'id' => 'background-slideshow',
		'std' => '7000',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => "Select background overlays",
		'desc' => "Change theme color scheme.",
		'id' => "background-overlays",
		'std' => "01",
		'type' => "images",
		'options' => array(
			'01' => $imagepath . 'adminico/p-01.jpg',
			'02' => $imagepath . 'adminico/p-02.jpg',
			'03' => $imagepath . 'adminico/p-03.jpg',
			'04' => $imagepath . 'adminico/p-04.jpg',
			'05' => $imagepath . 'adminico/p-05.jpg',
			'06' => $imagepath . 'adminico/p-06.jpg',
			'07' => $imagepath . 'adminico/p-07.jpg',
			'08' => $imagepath . 'adminico/p-08.jpg',
			'09' => $imagepath . 'adminico/p-09.jpg',
			'10' => $imagepath . 'adminico/p-10.jpg',
			'11' => $imagepath . 'adminico/p-11.jpg',
			'12' => $imagepath . 'adminico/p-12.jpg',
			'13' => $imagepath . 'adminico/p-13.jpg',
			'14' => $imagepath . 'adminico/p-14.jpg',
			'15' => $imagepath . 'adminico/p-15.jpg',
			'16' => $imagepath . 'adminico/p-16.png'
			)
	);
	$options[] = array(
		'name' => __('Select images', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-1',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-1',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vertical alignment', 'options_check'),
		'id' => 'background-valign-1',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-1',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-2',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-2',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-2',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-2',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-3',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-3',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-3',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-3',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-4',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-4',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-4',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-4',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-5',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-5',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-5',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-5',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
    
    $options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-6',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-6',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-6',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-6',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
    $options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-7',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-7',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-7',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-7',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
    $options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-8',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-8',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-8',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-8',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
    $options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-9',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-9',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-9',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-9',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
    $options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-img-10',
		'type' => 'upload');
	$options[] = array(
		'desc' => __('Fade in miliseconds', 'options_check'),
		'id' => 'background-fade-10',
		'std' => '4000',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Vartical alignment', 'options_check'),
		'id' => 'background-valign-10',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_valign);
	$options[] = array(
		'desc' => __('Horizontal alignment', 'options_check'),
		'id' => 'background-halign-10',
		'std' => 'center',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $background_halign);
	
	//Background Video
    //==================================================
	$options[] = array(
		'name' => __('Background video', 'options_check'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('Youtube Background Video', 'options_check'),
		'desc' => __('Activate Background Video', 'options_check'),
		'id' => 'active-backgroud-yt',
		'std' => '0',
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('Add Youtube ID', 'options_check'),
		'id' => 'yt-bg-id',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Video type', 'options_check'),
		'id' => 'yt-bg-type',
		'std' => 'false',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'false' => __('Background', 'options_check'),
			'true' => __('Homepage teaser', 'options_check')
			)
	);
	$options[] = array(
		'desc' => __('Video controls', 'options_check'),
		'id' => 'yt-bg-cotrols',
		'std' => 'off',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
			)
	);
		
	$options[] = array(
		'desc' => __('Mute video', 'options_check'),
		'id' => 'yt-bg-mute',
		'std' => 'true',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'true' => __('Mute', 'options_check'),
			'false' => __('Unmute', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('Repeat video', 'options_check'),
		'id' => 'yt-bg-repeat',
		'std' => 'true',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'true' => __('Repeat', 'options_check'),
			'false' => __('Play once', 'options_check')
			)
		);
	$options[] = array(
		'desc' => __('Starting position in seconds', 'options_check'),
		'id' => 'yt-bg-start',
		'std' => '0',
		'class' => 'mini',
		'type' => 'text');

		
	$options[] = array(
		'name' => __('Background Video Settings', 'options_check'),
		'desc' => __('Activate Background Video', 'options_check'),
		'id' => 'active-backgroud-video',
		'std' => '0',
		'type' => 'checkbox');
	$options[] = array(
		'name' => __('Select image ', 'options_check'),
		'desc' => __('Select image', 'options_check'),
		'id' => 'background-video-image',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Select video (videos must be with same name)', 'options_check'),
		'desc' => __('Select mp4 video', 'options_check'),
		'id' => 'background-video-mp4',
		'type' => 'upload');
	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('Select ogv video', 'options_check'),
		'id' => 'background-video-ogv',
		'type' => 'upload');
		
	//Translate
    //==================================================
	$options[] = array(
		'name' => __('Translate', 'options_check'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('Post', 'options_check'),
		'desc' => __('Read more link', 'options_check'),
		'id' => 'tr-readmore',
		'std' => 'Read more',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'name' => __('Search', 'options_check'),
		'desc' => __('Search nothing found title', 'options_check'),
		'id' => 'tr-searchtitle',
		'std' => 'Nothing Found',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Search nothing found subtitle', 'options_check'),
		'id' => 'tr-searchsubtitle',
		'std' => 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.',
		'class' => 'mini',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Comments', 'options_check'),
		'desc' => __('Leave a replay title label', 'options_check'),
		'id' => 'tr-comm-title',
		'std' => 'Leave a Replay',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Leave a replay subtitle', 'options_check'),
		'id' => 'tr-comm-subtitle',
		'std' => 'Your email address will not be published.',
		'class' => 'tiny',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Submint button label', 'options_check'),
		'id' => 'tr-comm-submit',
		'std' => 'Post Comment',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Author label', 'options_check'),
		'id' => 'tr-comm-author',
		'std' => 'Name',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('E-mail label', 'options_check'),
		'id' => 'tr-comm-email',
		'std' => 'E-mail',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Comment label', 'options_check'),
		'id' => 'tr-comm-comment',
		'std' => 'Comment',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Logged in as label', 'options_check'),
		'id' => 'tr-comm-loggedin',
		'std' => 'Logged in as',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('You must be logged in label', 'options_check'),
		'id' => 'tr-comm-mustlogin',
		'std' => 'You must be logged to post a comment.',
		'class' => 'tiny',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Log in label', 'options_check'),
		'id' => 'tr-comm-login',
		'std' => 'Log in.',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Older comments button label', 'options_check'),
		'id' => 'tr-comm-backbutton',
		'std' => 'Older Comments',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Newer comments button label', 'options_check'),
		'id' => 'tr-comm-nextbutton',
		'std' => 'Newer Comments',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'desc' => __('Log out label', 'options_check'),
		'id' => 'tr-comm-logout',
		'std' => 'Log out?',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('User said', 'options_check'),
		'id' => 'tr-comm-said',
		'std' => 'said',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Date at time label', 'options_check'),
		'id' => 'tr-comm-attime',
		'std' => 'at',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Waiting moderation text', 'options_check'),
		'id' => 'tr-comm-waitapp',
		'std' => 'Your comment is awaiting moderation.',
		'class' => 'tiny',
		'type' => 'text');
	$options[] = array(
		'name' => __('Small info text', 'options_check'),
		'desc' => __('Home info text', 'options_check'),
		'id' => 'tr-home-info',
		'std' => 'posts at home page',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Search info text', 'options_check'),
		'id' => 'tr-search-info',
		'std' => 'results found',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Archive info text', 'options_check'),
		'id' => 'tr-archive-info',
		'std' => 'posts in archive',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'desc' => __('Category info text', 'options_check'),
		'id' => 'tr-category-info',
		'std' => 'posts in category',
		'class' => 'mini',
		'type' => 'text');
	
		
		
	
	
	//Colors settings
    //==================================================
	$options[] = array(
			'name' => __('Colors Settings', 'options_check'),
			'type' => 'heading');
	
	$options[] = array(
		'name' => __('Links', 'options_check'),
		'desc' => __('No color selected by default.', 'options_check'),
		'id' => 'color_link',
		'std' => '#52ccb3',
		'type' => 'color' );
	$options[] = array(
		'desc' => __('Link hover color.', 'options_check'),
		'id' => 'color_link_hover',
		'std' => '#247967',
		'type' => 'color' );
		
	$options[] = array(
		'name' => __('Buttons', 'options_check'),
		'desc' => __('Gradient color top .', 'options_check'),
		'id' => 'color_button_top',
		'std' => '',
		'type' => 'color' );
	$options[] = array(
		'desc' => __('Gradient color bottom.', 'options_check'),
		'id' => 'color_button_bottom',
		'std' => '',
		'type' => 'color' );
	$options[] = array(
		'desc' => __('Border color.', 'options_check'),
		'id' => 'color_button_border',
		'std' => '#52ccb3',
		'type' => 'color' );
	$options[] = array(
		'desc' => __('Symbol color.', 'options_check'),
		'id' => 'color_button_text',
		'std' => '#52ccb3',
		'type' => 'color' );
		
	$options[] = array( 
		'desc' => __('Button typography.', 'options_check'),
		'id' => "button_typography",
		'std' => array(
			'size' => '12px',
			'face' => 'Open Sans',
			'color' => '#ffffff' ),
		'type' => 'typography',
		'options' => array(
			'faces' => options_typography_get_google_fonts(),
			'styles' => false ));
			
	$options[] = array(
		'name' => __('Scroll color', 'options_check'),
		'desc' => __('Scroll color.', 'options_check'),
		'id' => 'color_scroll',
		'std' => '#52ccb3',
		'type' => 'color' );
	$options[] = array(
		'name' => __('Elements bottom border color', 'options_check'),
		'desc' => __('Elements border color.', 'options_check'),
		'id' => 'color_el_border',
		'std' => '#52ccb3',
		'type' => 'color' );
	$options[] = array( 
		'name' => __('Body text', 'options_check'),
		'desc' => __('Chabge your body typography.', 'options_check'),
		'id' => "body_typography",
		'std' => array(
			'size' => '12px',
			'face' => 'Open Sans',
			'color' => '#8b8b8b' ),
		'type' => 'typography',
		'options' => array(
			'faces' => options_typography_get_google_fonts(),
			'styles' => false ));
	$options[] = array( 
		'name' => __('Titles', 'options_check'),
		'desc' => __('Titles typography.', 'options_check'),
		'id' => "title_typography",
		'std' => array(
			'size' => '30px',
			'face' => 'Open Sans',
			'color' => '#52ccb3',
			'styles' => 'normal'
			 ),
		'type' => 'typography',
		'options' => $typography_options_titles);
			
			
	
	$options[] = array(
		'name' => __('Menu', 'options_check'),
		'desc' => __('Menu color.', 'options_check'),
		'id' => 'color_menu',
		'std' => '#8b8b8b',
		'type' => 'color' );
	$options[] = array(
		'desc' => __('Menu hover color.', 'options_check'),
		'id' => 'color_menu_hover',
		'std' => '#52ccb3',
		'type' => 'color' );
	$options[] = array( 
		'desc' => __('Menu typography.', 'options_check'),
		'id' => "menu_typography",
		'std' => array(
			'size' => '13px',
			'face' => 'Open Sans'
			 ),
		'type' => 'typography',
		'options' => array(
			'faces' => options_typography_get_google_fonts(),
			'color' => false,
			'styles' =>  array(
	"normal" => "Normal",
	"italic" => "Italic",
	"bold" => "Bold",
	"bold italic" => "Bold italic"
	) ));
	
	$options[] = array(
		'desc' => __('Submenu color.', 'options_check'),
		'id' => 'color_submenu',
		'std' => '#8b8b8b',
		'type' => 'color' );
	$options[] = array(
		'desc' => __('Submenu hover color.', 'options_check'),
		'id' => 'color_submenu_hover',
		'std' => '#52ccb3',
		'type' => 'color' );
	$options[] = array( 
		'desc' => __('Submenu typography.', 'options_check'),
		'id' => "submenu_typography",
		'std' => array(
			'size' => '11px',
			'face' => 'Open Sans'
			 ),
		'type' => 'typography',
		'options' => array(
			'faces' => options_typography_get_google_fonts(),
			'color' => false,
			'styles' => false ));
			
	$options[] = array(
		'name' => __('Glass style header, menu and footer', 'options_check'),
		'desc' => __('Activate glass style', 'options_check'),
		'id' => 'active-glass',
		'std' => '0',
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('Activate dark glass style', 'options_check'),
		'id' => 'active-dglass',
		'std' => '0',
		'type' => 'checkbox');
		
	//Woocommerce settings
    //==================================================
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$options[] = array(
			'name' => __('Woocommerce Settings', 'options_check'),
			'type' => 'heading');
			
	$options[] = array(
		'name' => __('Select first product', 'options_check'),
		'desc' => __('Select which product to be on focus first(number).', 'options_check'),
		'id' => 'select-first-product',
		'std' => '0',
		'class' => 'mini', 
		'type' => 'text');
	$options[] = array(
		'name' => __('Product style', 'options_check'),
		'desc' => __('Select product page style ', 'options_check'),
		'id' => 'product-style',
		'std' => 'style1',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'style1' => __('Woo style', 'options_check'),
			'style2' => __('Theme style', 'options_check')
		));
	
	$options[] = array(
		'name' => __('Select Pagination', 'options_check'),
		'desc' => __('Select how to display pages', 'options_check'),
		'id' => 'pagination-display',
		'std' => 'infinite',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $pagination_display);
	$options[] = array(
		'name' => __('Scroll Widget', 'options_check'),
		'desc' => __('Display widgets in scroll ', 'options_check'),
		'id' => 'scroll-widget',
		'std' => 'off',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'on' => __('On', 'options_check'),
			'off' => __('Off', 'options_check')
		));
	
	$options[] = array(

		'desc' => __('Select color shceme', 'options_check'),
		'id' => 'scroll-widget-color',
		'std' => 'turquoise',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array (
			'turquoise'	=>  __('Turquoise', 'options_check'),
			'greensea'	=>  __('Green sea', 'options_check'),
			'emerald'	=>  __('Emerald', 'options_check'),
			'nephritis'	=>  __('Nephritis', 'options_check'),
			'peterriver'	=>  __('Peter river', 'options_check'),
			'belizehole'	=>  __('Belize hole', 'options_check'),
			'amethyst'	=>  __('Amethyst', 'options_check'),
			'wisteria'	=>  __('Wisteria', 'options_check'),
			'wetasphalt'	=>  __('Wet asphalt', 'options_check'),
			'midnightblue'	=>  __('Midnight blue', 'options_check'),
			'Sun flower'	=>  __('sunflower', 'options_check'),
			'orange'	=>  __('Orange', 'options_check'),
			'carrot'	=>  __('Carrot', 'options_check'),
			'pumpkin'	=>  __('Pumpkin', 'options_check'),
			'alizarin'	=>  __('Alizarin', 'options_check'),
			'pomegranate'	=>  __('Pomegranate', 'options_check'),
			'concrete'	=>  __('Concrete', 'options_check'),
			'asbestos'	=>  __('Asbestos', 'options_check'),
			'gglass'	=>  __('Glass', 'options_check'),
			'gglass gdarck'	=>  __('Darck glass', 'options_check'),
			'turquoise'	=>  __('Turquoise', 'options_check'),
			'turquoise'	=>  __('Turquoise', 'options_check'),
			'turquoise'	=>  __('Turquoise', 'options_check'),
			
			)
		);
		
	}
		
	return $options;
	
}
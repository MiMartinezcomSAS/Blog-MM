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
global $row_style, $img_title, $img_content, $img_link, $img_buttontitle, $post_showsoc, $post_showtitle, $post_showcategory , $post_showdate, $post_showfbcomments, $post_showdscomments, $post_bgimage, $post_img_slideshow, $post_embed_video_yt, $post_embed_video_vm, $show_sidebar, $post_img_effect, $post_img_sdirection, $post_excerpt, $post_color, $post_show_featured, $post_img_link, $post_ribbon_display;
if(isset($post_meta_data['custom_repeatable'][0]) ){
			$custom_repeatable = unserialize($post_meta_data['custom_repeatable'][0]); 
		}else{
			$custom_repeatable[0] = '';
		};
		
		if(isset( $post_meta_data['custom_select_color_style'][0]))
			$post_color = $post_meta_data['custom_select_color_style'][0];
		else $post_color = "turquoise";
		if(isset( $post_meta_data['custom_select_row_style'][0]))
			$row_style = $post_meta_data['custom_select_row_style'][0];
		else $row_style = "scuare";
		if(isset($post_meta_data['custom_img_title'][0]))
			$img_title = $post_meta_data['custom_img_title'][0];
		else $img_title ='';
		if(isset($post_meta_data['custom_img_content'][0]))
			$img_content = $post_meta_data['custom_img_content'][0];
		else $img_content ='';
		if(isset($post_meta_data['custom_img_link'][0]))
			$img_link = $post_meta_data['custom_img_link'][0];
		else $img_link='';
		if(isset($post_meta_data['custom_img_buttontitle'][0]))
			$img_buttontitle = $post_meta_data['custom_img_buttontitle'][0];
		else $img_buttontitle ='';
		if(isset($post_meta_data['custom_select_show_sidebar'][0]))
			$show_sidebar = $post_meta_data['custom_select_show_sidebar'][0];
		else $show_sidebar ='hide';
        if(isset($post_meta_data['custom_select_show_soc'][0]))
			$post_showsoc = $post_meta_data['custom_select_show_soc'][0];
		else $post_showsoc ='show';
		if(isset($post_meta_data['custom_select_show_title'][0]))
			$post_showtitle = $post_meta_data['custom_select_show_title'][0];
		else $post_showtitle = 'show';
		if(isset($post_meta_data['custom_select_show_category'][0]))
			$post_showcategory = $post_meta_data['custom_select_show_category'][0];
		else $post_showcategory = 'show';
		if(isset($post_meta_data['custom_select_show_date'][0]))
			$post_showdate = $post_meta_data['custom_select_show_date'][0];
		else $post_showdate = 'show';
		if(isset($post_meta_data['custom_select_fb_comments'][0]))
			$post_showfbcomments = $post_meta_data['custom_select_fb_comments'][0];
		else $post_showfbcomments = 'off';
		if(isset($post_meta_data['custom_select_ds_comments'][0]))
			$post_showdscomments = $post_meta_data['custom_select_ds_comments'][0];
		else $post_showdscomments = 'off';
		if(isset($post_meta_data['custom_select_post_excerpt'][0]))
			$post_excerpt = $post_meta_data['custom_select_post_excerpt'][0];
		else $post_excerpt = 'on';
		if(isset($post_meta_data['custom_image'][0]))
			$post_bgimage = $post_meta_data['custom_image'][0];
		else $post_bgimage = '';
		if(isset($post_meta_data['custom_select_img_effect'][0]))
			$post_img_effect = $post_meta_data['custom_select_img_effect'][0];
		else $post_img_effect = 'fade';
		if(isset($post_meta_data['custom_select_img_sdirection'][0]))
			$post_img_sdirection = $post_meta_data['custom_select_img_sdirection'][0];
		else $post_img_sdirection = 'horizontal';
		if(isset($post_meta_data['custom_select_img_slideshow'][0]))
			$post_img_slideshow = $post_meta_data['custom_select_img_slideshow'][0];
		else $post_img_slideshow = 'false';
		if(isset($post_meta_data['custom_embed_video_yt'][0]))
			$post_embed_video_yt = $post_meta_data['custom_embed_video_yt'][0];
		else $post_embed_video_yt = '';
		if(isset($post_meta_data['custom_embed_video_vm'][0]))
			$post_embed_video_vm = $post_meta_data['custom_embed_video_vm'][0];
		else $post_embed_video_vm = '';
		if(isset($post_meta_data['custom_select_ribbon_display'][0]))
			$post_ribbon_display = $post_meta_data['custom_select_ribbon_display'][0];
		else $post_ribbon_display = '';
		if(isset($post_meta_data['custom_select_show_featured'][0]))
			$post_show_featured = $post_meta_data['custom_select_show_featured'][0];
		else $post_show_featured = '';
		if(isset($post_meta_data['custom_select_img_link'][0]))
			$post_img_link = $post_meta_data['custom_select_img_link'][0];
		else $post_img_link = 'image';
		
		
		
		?>
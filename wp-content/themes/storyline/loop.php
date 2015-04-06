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

if(have_posts()) :
$firsttime = 0;
$postsperpage = get_option('posts_per_page');
$currentpage = get_query_var('paged');

if(of_get_option('tr-readmore') != ''){
	$tr_readmore = of_get_option('tr-readmore');
}else{
	$tr_readmore = "Read more";
};
while(have_posts()) : the_post();
	if (is_search() && ($post->post_type=='page')) continue;
		$id = get_the_ID();
			$post_meta_data = get_post_custom($post->ID);
			
			include('functions/post-settings.php');?>	
				
			<section>
                <div class="layer" data-depth="1"><?php 
			if($firsttime !=1 ){?>
                <script>
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
                    window.scrollinit();
                    jQuery(document).ready(function($){
                    //Animate post on read more click
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
                     <?php if(of_get_option('active-mouse-parallax', '0' ) == '1'){?>  
                        var $scene = $('#articlehold').parallax();
                        $scene.parallax('updateLayers');
                        <?php
                    }?>
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
                    
                    
                </script><?php 
				$firsttime = 1; 
			};?>
			
			
			<?php
				$idnum++;
				do_shortcode( get_the_content() );
				
				//ROW BODY
				//=====================================================?>
				<script>
					jQuery(document).ready( function($){
						setTimeout(function(){			 					 
							$('#flexslider-<?php echo $id;?>').flexslider({
								animation: "<?php echo $post_img_effect; ?>",
								direction: "<?php echo $post_img_sdirection; ?>",
								slideshow: <?php echo $post_img_slideshow; ?>,
								smoothHeight: true,
							})
						}, 100);
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
										<div class="containera <?php if(!has_post_thumbnail() && $post_showdate == "show" && $post_embed_video_yt == '' && $post_embed_video_vm =='') {?> addpadding<?php }?> "><?php
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
			</section>
<?php endwhile; wp_reset_query() ?>
<?php endif;?>

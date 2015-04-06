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
if(post_password_required()) : ?>
    <section>
        <div id="comments">
            <div class="ss-row comments-m-top">    
                <div class="ss-full"> 
                    <div class="container-border">
                        <div class="gray-container">
                            <p class="nopassword"><?php echo 'This post is password protected. Enter the password to view any comments.';?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><?php
	return;
endif;
if ( have_comments() ) :
	global $fbcomm, $post_showfbcomments, $post_showdscomments;
	if ( $post_showfbcomments == 'on' || $post_showdscomments == 'on' ){
		$fbcomm = 2;
	}else{
		$fbcomm = 1;
	}
	wp_list_comments( array( 'callback' => 'timeline_comment', 'end-callback'=> 'sotryline_end' ) );
endif; 
global $fbcomm, $post_showfbcomments, $post_showdscomments;
if(comments_open() ){
	global $fbcomm, $post_showfbcomments, $post_showdscomments;
	if ( $post_showfbcomments == 'on' || $post_showdscomments == 'on' ){
		$fbcomm = 2;
	}else{
		$fbcomm = 1;
	}
	if(of_get_option('comments-fx', 'no entry' ) == 'off'){ ?> 
		<sectionoff id="section-<?php echo $fbcomm; ?>" rel="<?php echo $fbcomm; ?>">
	<?php }else{?>
		<section id="section-<?php echo $fbcomm; ?>" rel="<?php echo $fbcomm; ?>"> <?php
	}?>
		<div class="ss-row <?php if(of_get_option('comments-fx', 'no entry' ) == 'off'){ ?> c-comment <?php } ?>  ">
			<div class="container-border ">
				<div class="gray-container <?php global $post_color; echo $post_color;?> addcolor">
					<div class="nano <?php if(of_get_option('comments-fx', 'no entry' ) == 'off'){ ?>addcomm-nofx<?php }else{?>addcomm<?php }?>" >
                    	<div class="cscrol content">
							<div class="comments-add-c"><?php
								if( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ){?>
									<p class="nocomments"><?php echo 'Comments are closed.'; ?></p><?php
								};
								if(of_get_option('tr-comm-submit') != ''){
									$tr_comm_submit = of_get_option('tr-comm-submit');
								}else{
									$tr_comm_submit = "Post Comment";
								};
								if(of_get_option('tr-comm-author') != ''){
									$tr_comm_author = of_get_option('tr-comm-author');
								}else{
									$tr_comm_author = "Author";
								};
								if(of_get_option('tr-comm-email') != ''){
									$tr_comm_email = of_get_option('tr-comm-email');
								}else{
									$tr_comm_email = "E-mail";
								};
								if(of_get_option('tr-comm-comment') != ''){
									$tr_comm_comment = of_get_option('tr-comm-comment');
								}else{
									$tr_comm_comment = "Comment";
								};
								if(of_get_option('tr-comm-title') != ''){
									$tr_comm_title = of_get_option('tr-comm-title');
								}else{
									$tr_comm_title = "Leave a Replay";
								};
								if(of_get_option('tr-comm-subtitle') != ''){
									$tr_comm_subtitle = of_get_option('tr-comm-subtitle');
								}else{
									$tr_comm_subtitle = "";
								};
								if(of_get_option('tr-comm-loggedin') != ''){
									$tr_comm_loggedin = of_get_option('tr-comm-loggedin');
								}else{
									$tr_comm_loggedin = "Logged in as";
								};
								if(of_get_option('tr-comm-logout') != ''){
									$tr_comm_logout = of_get_option('tr-comm-logout');
								}else{
									$tr_comm_logout = "Log out?";
								};
								if(of_get_option('tr-comm-logout') != ''){
									$tr_comm_logout = of_get_option('tr-comm-logout');
								}else{
									$tr_comm_logout = "Log out?";
								};
								if(of_get_option('tr-comm-mustlogin') != ''){
									$tr_comm_mustlogin = of_get_option('tr-comm-mustlogin');
								}else{
									$tr_comm_mustlogin = "You must be logged to post a comment.";
								};
								if(of_get_option('tr-comm-login') != ''){
									$tr_comm_login = of_get_option('tr-comm-login');
								}else{
									$tr_comm_login = "Log in.";
								};
								if(of_get_option('tr-comm-backbutton') != ''){
									$tr_comm_backbutton = of_get_option('tr-comm-backbutton');
								}else{
									$tr_comm_backbutton = "Older Comments";
								};
								if(of_get_option('tr-comm-nextbutton') != ''){
									$tr_comm_nextbutton = of_get_option('tr-comm-nextbutton');
								}else{
									$tr_comm_nextbutton = "Newer Comments";
								};
								$args = array(
									'id_form'           => 'commentform',
									'id_submit'         => 'submit',
									'title_reply'       => $tr_comm_title,
									'title_reply_to'    => $tr_comm_title.'to %s',
									'label_submit'      => $tr_comm_submit ,
									
									'comment_field'		=>  '<p class="comment-form-comment"><label for="comment">' .$tr_comm_comment .
									'</label><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true">' .
									'</textarea></p>',
									
									'must_log_in' 		=> '<p class="must-log-in">' .
									sprintf(
									  $tr_comm_mustlogin.' <a href="%s">'.$tr_comm_login .'</a>',
									  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
									) . '</p>',
									
									'logged_in_as' 		=> '<p class="logged-in-as">' .
									sprintf(
									 $tr_comm_loggedin.' <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">'.$tr_comm_logout.'</a>' ,
									  admin_url( 'profile.php' ),
									  $user_identity,
									  wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
									) . '</p>',
									
									'comment_notes_before' => '<div class="comment-notes">' .$tr_comm_subtitle.
									'</div>',
									
									'comment_notes_after' => '',
									
									'fields' 		=> apply_filters( 'comment_form_default_fields', array(
									
									'author' 		=>
									  '<p class="comment-form-author">' .
									  '<label for="author">'.$tr_comm_author.'</label><span class="required">*</span>
									  <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
									  '" size="30" /></p>',
									
									'email' 		=>
									  '<p class="comment-form-email"><label for="email">'.$tr_comm_email.'</label> ' .
									  ( $req ? '<span class="required">*</span>' : '' ) .
									  '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
									  '" size="30" /></p>',
									
									'url' =>''
										)
									),
								);
								comment_form($args);?>
							</div>
                    	</div>
                    </div><?php 
					 // are there comments to navigate through ?>
                        <div class="icon-soc-container">
                            <div class="share-btns"><?php
							if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ){?>
                            	<nav class="comment-nav-below">
                                	<div class="nav-previous empty-left"  ><?php previous_comments_link( '<i class="icon-angle-left"></i> '.$tr_comm_backbutton  ); ?></div>
                                    <div class="nav-next empty-right" ><?php next_comments_link(  $tr_comm_nextbutton.' <i class="icon-angle-right"></i>' ); ?></div>
								</nav>
                            <?php };?>
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
	};
	
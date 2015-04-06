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




		<?php if(of_get_option('example_showhidden', 'no entry' ) !='0'){ ?>
            <div id="footer" <?php if(of_get_option('active-glass') == 1){?>class="glassstyle"<?php }?> <?php if(of_get_option('active-dglass') == 1){?>class="dglassstyle"<?php }?>>
                <div class="f-padding">
                    <?php echo of_get_option('example_text_hidden', '<p>no entry</p>' ); ?>                      
                </div>
            </div><?php
        }; ?>
         
    	</div>
    </div>    
</div>
<?php if(of_get_option('yt-bg-cotrols') == "on" && of_get_option('yt-bg-type') == 'false' && of_get_option('active-backgroud-yt') == 1 ){?>
<script>
jQuery(document).ready(function($){
	document.getElementById('hide-content').addEventListener('click', hidecontent);
	var iscontenthiden = 0;
	function hidecontent(){
		if(iscontenthiden == 0 ){
			$('#main').delay(300).addClass('addopahide').delay(300).removeClass('remopa');
			iscontenthiden = 1;
		}else{
			$('#main').delay(300).addClass('remopa').delay(300).removeClass('addopahide');
			iscontenthiden = 0;
		}
	}
});
</script>
<div class="bottom-video-nav <?php if(of_get_option('active-dglass') == 1){?>dglassstyle<?php }?>">
	<div><i id="hide-content" class="icon-resize-full navkey"></i> <i id="prev-arrow" class="icon-pause navkey tubular-pause"></i> <i id="enter-arrow" class="icon-play navkey tubular-play"></i> <i id="next-arrow" class="icon-volume-up navkey tubular-mute"></i></div>
</div><?php 
}?>
<!--Scroll back to top-->
<div class="back-to-top" id="back-top">
	<a href="javascript:void(0)" class="back-to-top"><i class="icon-chevron-up"></i></a>
</div>	
<?php get_template_part( 'functions/java-fun');?>

<!--end of Scroll back to top-->
<div class="inifiniteLoader animated <?php if(of_get_option('active-dglass') == 1){?>dglassstyle<?php }?>">
    <div class="bar">
        <span></span>
    </div>
</div>

<?php wp_footer();?>
</body>
</html>
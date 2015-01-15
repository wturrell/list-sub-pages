<?php 

add_action( 'admin_menu', 'ls_admin_menu' );
add_action('admin_enqueue_scripts','ls_add_script');

/**
 *  It enqueues the js files for the plugins settings page.
 *
 *  @return    void
 *  @var	No arguments passed
 *  @author    HG
  
 */

function ls_add_script()
{   
	global 	$ls_plugin_version;

	if( !wp_script_is( 'jquery' ) )
	if( !wp_script_is( 'jquery' ) )
	{
		wp_enqueue_script('jquery');
	}
	
	wp_enqueue_script('shortcode_js',ls_sub_pages::ls_get_plugin_dir_url().'/js/jquery_create_shortocode.js',array('jquery'), $ls_plugin_version);
	
}

/**
 *  It is used to add the option page for the plugin page.
 *
 *  @return     void
 *  @var	No arguments passed
 *  @author     HG
  
 */
function ls_admin_menu() {
	add_options_page( 'List Sub Pages','List Sub Pages','manage_options', 'sub-page', 'ls_options_page' );
}

/**
 *  It is used to render the form for the settings page.
 *
 *  @return     form
 *  @var	No arguments passed
 *  @author     HG

 */
function ls_options_page() {

//$result='0';
 
?>
    <div class="wrap">
        <h2><?php _e('Sub Page Plugin Options','subpage'); ?></h2>
        
        <form action="" method="POST">
            
             <h3><?php _e('Sub Page Display Options','subpage'); ?></h3>
             <h4><?php _e('Select the subpage dislaying options if subpage exists for that particular parent page.','subpage');?></h4>
          
             <table class="form-table">
             	<tbody>
             		
             		<tr valign="top">
             		<th scope="row"><?php _e('Title','subpage');?></th>
             		<!-- Title Field -->
             		<td>
             		<?php 
				echo "<input id='title' type='text' name='title' value='Pages' />";?>
             		</td>
             		</tr>
             		
             		<tr valign="top">
             		<th scope="row"><?php _e('Sort Order','subpage');?></th>
             		
             		<!-- Sort Order Field -->
             		<td>
             			
	
			<select id='child_sort_order' name="child_sort_order"  tabindex="1">
			<?php 
		
				$order_options = array(
							'ASC'=>__('Ascending','subpage'), 
							'DESC'=>__('Descending','subpage')
							);
			foreach ($order_options as $option_key=>$option_value ) { ?>
				<option
					value="<?php echo esc_attr($option_key); ?>"><?php echo __($option_value,'subpage'); ?>
				</option>
				<?php }?>
	</select>
             		</td>
             		</tr>
             	
             	</tbody>
             </table>
             
             <h3><?php _e('Parent Pages Display Options','subpage'); ?></h3>
             <h4><?php _e('Select the options to add effect in the parent pages display when subpages are not available to display.','subpage');?></h4>
             
             <table class="form-table">
             	<tbody>
             		<tr valign="top">
             		<th scope="row"> <?php _e('Sorting Criteria:','subpage');?></th>
             		
             		<!-- Sorting Criteria Field -->
             		<td>
				<select id='sorting_criteria' name="sorting_criteria[]" size="7" multiple="multiple" tabindex="1">
					<?php
						$options = array(
								'ID'=>__('Page ID','subpage'),
								'post_title'=>__('Page Title','subpage'),
								'menu_order'=>__('Menu Order','subpage'),
								'post_date'=>__('Date Created','subpage'),
								'post_modified'=>__('Date Modified','subpage'),
								'post_author'=>__('Page Author','subpage'),
								'post_name'=>__('Post Slug','subpage')
								);
							
						foreach ( $options as $key=>$value ) {?>
							<option
								value="<?php echo $key; ?>">
								<?php echo __($value,'subpage'); ?>
							</option>
							<?php } ?>
				</select>
             		</td>
             		</tr>
             		<tr valign="top">
             		<th scope="row"><?php _e('Exclude Pages','subpage');?></th>
             		
             		<!-- Exclude Pages Field -->
             		<td>
             			<select id='exclude_page' name="exclude_page[]" size="6" multiple="multiple"
						tabindex="1">
						
							<?php 
							
								$pages = get_pages();
								foreach ( $pages as $page ) { 
							?>
							<option
								value="<?php echo esc_attr($page->ID);?>">
							<?php echo __("$page->post_title"); ?>
							</option>
							<?php } ?>
					</select>
             		</td>
             		
             		<tr valign="top">
             		<th scope="row"><?php _e('Depth Level','subpage'); ?></th>
             		
             		<!-- Depth Level Field -->	
             		<td>
             			<select id='depth_level' name="depth_level"  tabindex="1">
					<?php
						$depth_options = array(
							'1'=>__('1st Level Depth','subpage'),
							'2'=>__('2nd Level Depth','subpage'),
							'3'=>__('3rd Level Depth','subpage'),
							'4'=>__('4th Level Depth','subpage'),
							'0'=>__('Unlimited Depth','subpage')
						);
						foreach($depth_options as $depth_number=>$depth_label) {   ?>
						<option
							value="<?php echo $depth_number; ?>"><?php echo __($depth_label,'subpage'); ?>
						</option>
					<?php }?>
				</select>
             		</td>
             		
             		<tr valign="top">
             		<th scope="row"><?php _e('Parent Sort Order','subpage'); ?></th>
             		<!-- Parent Sort Order Field -->
             		<td>
				<select id='parent_sort_order' name="parent_sort_order"  tabindex="1">
					<?php 
						$order_options = array(
									'ASC'=>__('Ascending','subpage'),
									'DESC'=>__('Descending','subpage')
									);
						foreach ($order_options as $option_key=>$option_value ) { ?>
						<option
							value="<?php echo esc_attr($option_key); ?>"><?php echo __($option_value,'subpage'); ?>
						</option>
					<?php }?>
				</select>
             		</td>
             		</tr>
             	</tbody>
             </table>
              <h3><?php _e('Dynamic Shortcode','subpage');?></h3>
             <h4> <?php _e('Please Copy This Shortcode and paste where you want to display subpages or parent pages.','subpage');?></h4>
             <table class="form-table">
             	<tbody>
             		<tr valign="top">
             		<th scope="row"><?php _e('Dynamic Shortcode:','subpage');?></th>
             		<td>
             			<?php echo '<div id= "shortcode"></div>';?>
             		</td>
             </tr></tbody></table>
        </form>
    </div>
    <?php
}

/**
 *  It is used to render the output when the shortcode is called.	 
 *
 *  @return             ARRAY
 *  @var				$atts datatype is ARRAY
 *  @author             HG / William Turrell

 */
function ls_shortcode($atts)
{
	global $post;
	extract(shortcode_atts(array(
					'title' => '',
					'page_id' => '',             // new: allow you to customise the start page
					'sort_order'=>'',
					'sort_by_values'=>'',
					'exclude_page_id'=>'',
					'depth'=>'',
					'sort_order_parent'=>'',
					'hide_if_no_children' => '',
				), $atts));

	
	$title = empty($title) ? 'Pages' : $title;
	 
	$sort_order=empty($sort_order) ? 'ASC' : $sort_order;
	 
	$sort_by_values=empty($sort_by_values) ? 'page_title ' : $sort_by_values;
	 
	$exclude_page_id=empty($exclude_page_id) ? ' ' : $exclude_page_id;
	 
	$depth=empty($depth) ? '1' : $depth;
	 
	$sort_order_parent=empty($sort_order_parent) ? 'ASC' : $sort_order_parent;
	 
	$page_id= empty($page_id) ? $post->ID : $page_id;

	$hide_if_no_children = ($hide_if_no_children === 1) ? true : false;

	$ls_str = '';
	$ls_str .= '<div class="ls_container">';
	$ls_str .= '<h3 class="widget_title">'.$title.'</h3>' ;
	 
	// WIDGET CODE GOES HERE
	 
	$args = array(
			'order' => $sort_order,
			'post_parent' => $page_id,
			'post_status' => 'publish',
			'post_type' => 'page',
	);
	
	$attachments = get_children( $args );
	
   	$ls_str .= '<ul class="ls_page_list">';
   	if($attachments)
   	{
	    // 'attachments' is a bit of a misleading name - these are the actual sub pages
		foreach($attachments as $attachment)
   	    	{
		        if ( class_exists( 'Groups_Post_Access' ) && ! Groups_Post_Access::user_can_read_post( $attachment->ID, get_current_user_id() ) ) {
			        // skip any pages they're not allowed to view
			        continue;
		        }

		        $class = 'page-'.$attachment->post_name;

		        $pagename = get_query_var( 'pagename' );

		        if ($pagename == $attachment->post_name) {
			        $class .= ' current-page';
		        }

		        $ls_str .= sprintf( '<li class="%s"><a href="%s">%s</a></li>',
			        $class,
			        get_permalink( $attachment->ID ),
			        $attachment->post_title
		        );
   	    	}
   	}
   	else
   	{
	    if ( $hide_if_no_children ) {

			// do nothing
		    $ls_str = '';

	    } else {

		    $args = array(
			    'depth'=> $depth,
			    'title_li' => '',
			    'echo' => 0,
			    'sort_order'=>$sort_order_parent,
			    'sort_column' => $sort_by_values,
			    'post_type'    => 'page',
			    'post_status'  => 'publish',
			    'exclude'=>$exclude_page_id,
		    );
		    $pages = wp_list_pages($args);

	    }

    }

	if ( ! empty( $ls_str ) ) {
		$ls_str .= '</ul>';
		$ls_str .= '</div>';
	}

	return $ls_str;
   }
   
      
?>

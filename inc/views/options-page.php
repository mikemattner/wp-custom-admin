<?php 
/**
 * @package CUSTOM_Site_Functionality
 * @version 1.0
 */

 
//right_now,comments,incoming_links,plugins,quick_press,recent_drafts,wordpress_blog,wordpress_news
$options  = get_option('mm_admin_widgets');

?>
        <?php if ( !empty($_POST) ) { ?>
			<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'mm_custom') ?></strong></p></div>
		<?php } ?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e('Custom Admin', 'mm_custom'); ?></h2>
			<form action="" method="post" id="mm_custom-options">
				<h3><?php _e('Dashboard Widget Settings','mm_custom'); ?></h3>
				<table class="form-table">
					<tbody>
					    <tr>
							<th scope="row"><?php _e('Right Now Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-right_now" id="mm-right_now" value="true" type="checkbox" <?php if ( $options['right_now'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'right_now'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Comments Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-comments" id="mm-comments" value="true" type="checkbox" <?php if ( $options['comments'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'comments'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Incoming Links Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-incoming_links" id="mm-incoming_links" value="true" type="checkbox" <?php if ( $options['incoming_links'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'incoming_links'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Plugins Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-plugins" id="mm-plugins" value="true" type="checkbox" <?php if ( $options['plugins'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'plugins'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Quick Press Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-quick_press" id="mm-quick_press" value="true" type="checkbox" <?php if ( $options['quick_press'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'quick_press'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Recent Drafts Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-recent_drafts" id="mm-recent_drafts" value="true" type="checkbox" <?php if ( $options['recent_drafts'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'recent_drafts'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('WordPress Blog Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-wordpress_blog" id="mm-wordpress_blog" value="true" type="checkbox" <?php if ( $options['wordpress_blog'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'wordpress_blog'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('WordPress News Widget', 'mm_custom'); ?></th>
							<td><label><input name="mm-wordpress_news" id="mm-wordpress_news" value="true" type="checkbox" <?php if ( $options['wordpress_news'] == 'true' ) echo ' checked="checked" '; ?> /> &mdash; <?php _e('Check if you want to show widget on dashboard.', 'wordpress_news'); ?></label></td>
						</tr>
					</tbody>
				</table>
				
				<p class="submit">
					<?php wp_nonce_field('mm_custom','_wp_mm_custom_nonce'); ?>
					<?php submit_button( __('Save Changes', 'mm_custom'), 'button-primary', 'submit', false ); ?>
				</p>
			</form>
			
		</div>
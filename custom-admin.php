<?php
/**
 * @package CUSTOM_Site_Functionality
 * @version 1.2
 */
/*
Plugin Name: Custom Admin
Plugin URI: http://mikemattner.com
Description: Custom admin functionality.
Author: Mike Mattner
Version: 1.2
Author URI: http://mikemattner.com/
*/

class CUSTOM_Site_Functionality {
   static $instance;
   var $plugin_dir = null;
   var $plugin_url;
	
   public function __construct() {
      self::$instance = $this;
      $this->init();
	  $this->plugin_dir = plugin_dir_path( __FILE__ );
      $this->plugin_url = plugin_dir_url( __FILE__ );
   }

   public function init() {
        //custom admin styling
		add_action( 'admin_head', array($this,'add_google_fonts') ); //admin fonts
		add_action( 'admin_enqueue_scripts', array($this,'cc_custom_css') ); //admin css
		add_action( 'admin_menu', array($this,'disable_default_dashboard_widgets') );//disable some default dashboard widgets
		add_action( 'admin_notices', array($this,'no_update_notification'), 1 ); //remove update notices from everyone but admins
		//add_action( 'admin_menu', array($this,'my_remove_menu_pages') );//remove a few menu pages
		remove_all_actions('in_admin_footer',1001); //remove footer text
        add_filter('admin_footer_text', array($this,'modify_footer_admin')); //add footer attribution
		add_filter( 'show_admin_bar', '__return_false' );// remove admin bar
		
		// calling it only on the login page
		add_action('login_head', array($this,'cc_login_css') );           //add login css
		add_filter('login_headerurl', array($this,'cc_login_url') );      //change login url
		add_filter('login_headertitle', array($this,'cc_login_title') );  //change login title
		
		isset($_REQUEST['_wp_mm_custom_nonce']) ? add_action('admin_init',array($this,'mm_options_save') ) : null;
		add_action( 'admin_init', array($this,'admin_set_defaults') ); // set default values on first run
		add_filter( 'plugin_action_links', array($this,'mm_plugin_action_links'), 10, 3 ); // add settings page to menu
		add_action( 'admin_menu', array($this,'gads_options_menu') ); // options page
		
   }
   
   public function admin_set_defaults() {
		/*	
	    * CHECKS OPTIONS VALUES
		*/
		
		$test = get_option('mm_admin_widgets');
        		
		if( $test == FALSE ) {
		    $options = array(
		        'right_now'      => 'true',
			    'comments'       => 'true',
			    'incoming_links' => 'true',
			    'plugins'        => 'true',
			    'quick_press'    => 'true',
			    'recent_drafts'  => 'true',
			    'wordpress_blog' => 'false',
			    'wordpress_news' => 'false',
		    );
		    update_option('mm_admin_widgets', $options);
	    }
		
	}
   
    // Google Fonts Code
    public function add_google_fonts() {
	  	/*
        Wide variety of decent fonts available. Try any one of them and adjust your css accordingly.		
		Google Fonts:
	  	* 'Open+Sans:400,400italic,700,700italic'     : 'Open Sans'
	  	* 'Gudea:400,400italic,700'                   : 'Gudea'
	  	* 'Open+Sans+Condensed:700,300italic,300'     : 'Open Sans Condensed'
	  	* 'Abel'                                      : 'Abel'
	  	* 'Droid+Sans:400,700'                        : 'Droid Sans'
	  	* 'PT+Sans:400,400italic,700,700italic'       : 'PT Sans'
	  	* 'PT+Sans+Narrow:400,700'                    : 'PT Sans Narrow'
	
		---- Below is the Google Font Loader ----
		*/
	  	echo '<script type="text/javascript">
      	WebFontConfig = {
			google: { 
			    families: [\'PT+Sans:400,400italic,700,700italic\']
			}
      	};
      	(function() {
    		var wf = document.createElement(\'script\');
    		wf.src = (\'https:\' == document.location.protocol ? \'https\' : \'http\') +
		    	\'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js\';
    		wf.type = \'text/javascript\';
    		wf.async = \'true\';
    		var s = document.getElementsByTagName(\'script\')[0];
    		s.parentNode.insertBefore(wf, s);
      	})();
    	</script>';
	}
	
    /************* CUSTOM ADMIN *****************/ 
    //add css to head
	public function cc_custom_css() {
		wp_register_style( 'custom-admin', $this->plugin_url . '/assets/css/admin.css' );
        wp_enqueue_style( 'custom-admin' );
    }  
    
	//add attributions to footer.
    public function modify_footer_admin () {
      $year = date('Y');
	  echo 'Custom Admin powered by <a href="http://WordPress.org">WordPress</a>.';
    }
	
    /************* CUSTOM LOGIN PAGE *****************/
    // calling your own login css so you can style it 
    public function cc_login_css() {
	    $this->add_google_fonts();
		wp_register_style( 'custom-login', $this->plugin_url . '/assets/css/login.css' );
        wp_enqueue_style( 'custom-login' );
    }

    // changing the logo link from wordpress.org to your site 
    public function cc_login_url() { return get_bloginfo('url'); }

    // changing the alt text on the logo to show your site name 
    public function cc_login_title() { return get_option('blogname'); }
    
	/************* CUSTOM DASHBOARD *****************/
	// disable default dashboard widgets
	public function disable_default_dashboard_widgets() {
		//right_now,comments,incoming_links,plugins,quick_press,recent_drafts,wordpress_blog,wordpress_news
		$options  = get_option('mm_admin_widgets');
		
		if($options['right_now'] == 'false') {remove_meta_box('dashboard_right_now', 'dashboard', 'core');}       // Right Now Widget
	    if($options['comments'] == 'false') {remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');} // Comments Widget
	    if($options['incoming_links'] == 'false') {remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');}  // Incoming Links Widget
	    if($options['plugins'] == 'false') {remove_meta_box('dashboard_plugins', 'dashboard', 'core');}         // Plugins Widget
	    if($options['quick_press'] == 'false') {remove_meta_box('dashboard_quick_press', 'dashboard', 'core');}     // Quick Press Widget
	    if($options['recent_drafts'] == 'false') {remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');}   // Recent Drafts Widget
	    if($options['wordpress_blog'] == 'false') {remove_meta_box('dashboard_primary', 'dashboard', 'core');}         // Wordpress Blog Feed
	    if($options['wordpress_news'] == 'false') {remove_meta_box('dashboard_secondary', 'dashboard', 'core');}       // Other Wordpress News
	
	}
	public function no_update_notification() {  
        if (!current_user_can('activate_plugins')) remove_action('admin_notices', 'update_nag', 3);  
    } 
	
	//remove a few default menus from the admin
    public function my_remove_menu_pages() {
	    $unused     = array('link-manager.php','edit-comments.php'/*,'upload.php'*/);
	    $restricted = array('edit.php','edit.php?post_type=page','users.php','themes.php','plugins.php','tools.php','options-general.php');
	
	    foreach ($unused as $key => $value) {
	        remove_menu_page($value);
	    }
	
	    if(!current_user_can('manage_options')) {
          foreach ($restricted as $key => $value) {
	        remove_menu_page($value);
	      }
        }
    }
	
	/*
	 * Admin Options Save
	 */
	public function mm_options_save() {
	
	    //right_now,comments,incoming_links,plugins,quick_press,recent_drafts,wordpress_blog,wordpress_news

		if(wp_verify_nonce($_REQUEST['_wp_mm_custom_nonce'],'mm_custom')) {
			if ( isset($_POST['submit']) ) {
				( function_exists('current_user_can') && !current_user_can('manage_options') ) ? die(__('Cheatin&#8217; uh?', 'mm_custom')) : null;
												
                $options['right_now']       = ( isset($_POST['mm-right_now'])      ? 'true' : 'false' );
				$options['comments']        = ( isset($_POST['mm-comments'])       ? 'true' : 'false' );
				$options['incoming_links']  = ( isset($_POST['mm-incoming_links']) ? 'true' : 'false' );
				$options['plugins']         = ( isset($_POST['mm-plugins'])        ? 'true' : 'false' );
				$options['quick_press']     = ( isset($_POST['mm-quick_press'])    ? 'true' : 'false' );
				$options['recent_drafts']   = ( isset($_POST['mm-recent_drafts'])  ? 'true' : 'false' );
				$options['wordpress_blog']  = ( isset($_POST['mm-wordpress_blog']) ? 'true' : 'false' );
				$options['wordpress_news']  = ( isset($_POST['mm-wordpress_news']) ? 'true' : 'false' );

				
				update_option('mm_admin_widgets', $options);
				
			}
		}
	}
	
	public function mm_plugin_action_links($links, $file) {
	    $plugin_file = basename(__FILE__);
	    if (basename($file) == $plugin_file) {
		    $settings_link = '<a href="options-general.php?page=mm-admin-options">'.__('Settings', 'mm_custom').'</a>';
		    array_unshift($links, $settings_link);
	    }
	    return $links;
    }
	
	/*
	 * Admin Options Page
	 */
	public function mm_options_page() {		
	   $tmp = $this->plugin_dir . '/inc/views/options-page.php';
	   
	   ob_start();
	   include( $tmp );
	   $output = ob_get_contents();
	   ob_end_clean();
	   echo $output;
	}
	
	/*
	 * Add Options Page to Settings menu
	 */
	public function gads_options_menu() {		
		if(function_exists('add_submenu_page')) {
			add_options_page(__('Dashboard Settings', 'mm_custom'), __('Dashboard Settings', 'mm_custom'), 'manage_options', 'mm-admin-options', array($this,'mm_options_page'));
		}
	}
	
}

$mm = new CUSTOM_Site_Functionality;
?>
<?php
	
	namespace app\common;
	
	use app\backend\TP_Email_Hook;
	
	if (!defined('ABSPATH'))
		exit;
	
	//@todo: update class and file name.
	if (!class_exists('pt_Track_WP_Mails_Init')) {
		class pt_Track_WP_Mails_Init
		{
			
			private static $pluginpath;
			
			//@todo: change this plugin path
			private static $track_wp_mails;
 		
			public function __construct ()
			{
				// DO NOT DELETE THESE
				add_action('init', [$this, 'constants'], 5);
				add_action('init', [$this, 'inc_debug_abstract_class'], 5);
				add_action('init', [$this, 'inc_traits'], 5);
				
				// insert other classes here using init hook
				add_action('admin_menu', [$this, 'add_menu_page_for_options']);
				add_action('init', [$this, 'tp_email_hook'], 5);
				
				add_action('init', [$this, 'debug_tracking_file']);
				
			}
			
			public function debug_tracking_file ()
			{
				if (! isset($_GET['debug']))
					return;
				
				$data = file_get_contents(pt_track_wp_mails_PLUGIN_PATH . DIRECTORY_SEPARATOR . '/app/common/track/views.txt');
				print_r(unserialize($data));
				exit;
			}
			
			public function tp_email_hook ()
			{
				return TP_Email_Hook::singleton();
			}
			
			public function add_menu_page_for_options ()
			{
				add_menu_page(__('Track WP Mails', pt_track_wp_mails_TEXT_DOMAIN), 'pt_track_wp_mails', 'manage_options', 'pt_track_wp_mails', [$this, 'add_menu_page_for_options_callback']);
			}
			
			public function add_menu_page_for_options_callback ()
			{
				//@todo: Write some html here to print on the page.
			}
			
			
			/*
			 * @todo: Update plugin name in all below strings "__PLUGIN_NAME__"
			 *
			 * @todo: search all entries that have "__PLUGIN_NAME__" - Update according to your plugin name.
			 *
			 *
			 * */
			public function constants ()
			{
				define('pt_track_wp_mails_PLUGIN_FILE_PATH', self::getPluginpath());
				
				define('pt_track_wp_mails_PLUGIN_PATH', dirname(self::getPluginpath()));
				define('pt_track_wp_mails_PLUGIN_URL', plugins_url('', self::getPluginpath()));
				
				define('pt_track_wp_mails_FRONTEND_PATH', pt_track_wp_mails_PLUGIN_FILE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'frontend');
				define('pt_track_wp_mails_FRONTEND_URL', trailingslashit(pt_track_wp_mails_PLUGIN_URL) . 'app/frontend');
				
				define('pt_track_wp_mails_BACKEND_PATH', pt_track_wp_mails_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'backend');
				define('pt_track_wp_mails_BACKEND_URL', trailingslashit(pt_track_wp_mails_PLUGIN_URL) . 'app/backend');
				
				define('pt_track_wp_mails_DEBUGGING_PATH', pt_track_wp_mails_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'debugging');
				define('pt_track_wp_mails_DEBUGGING_URL', trailingslashit(pt_track_wp_mails_PLUGIN_URL) . 'debugging');
				
				define('pt_track_wp_mails_ABSTRACT_PATH', pt_track_wp_mails_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'abstracts');
				define('pt_track_wp_mails_ABSTRACT_URL', trailingslashit(pt_track_wp_mails_PLUGIN_URL) . 'app/abstracts');
				
				define('pt_track_wp_mails_TRAITS_PATH', pt_track_wp_mails_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'traits');
				define('pt_track_wp_mails_TRAITS_URL', trailingslashit(pt_track_wp_mails_PLUGIN_URL) . 'app/traits');
				
				
				define('pt_track_wp_mails_VERSION', '1.0.0');
				define('pt_track_wp_mails_MIN_PHP_VER', '5.6');
				define('pt_track_wp_mails_TEXT_DOMAIN', 'pt');
			}
			
			
			public function inc_debug_abstract_class ()
			{
				if (file_exists(pt_track_wp_mails_ABSTRACT_PATH . DIRECTORY_SEPARATOR . 'pt_Exception_Handler.php'))
					require_once pt_track_wp_mails_ABSTRACT_PATH . DIRECTORY_SEPARATOR . 'pt_Exception_Handler.php';
			}
			
			public function inc_traits ()
			{
				if (file_exists(pt_track_wp_mails_TRAITS_PATH . DIRECTORY_SEPARATOR . 'pt_Queries.php'))
					require_once pt_track_wp_mails_TRAITS_PATH . DIRECTORY_SEPARATOR . 'pt_Queries.php';
			}
			
			public static function plugin_activated ()
			{
				/*
				 * DO NOT DELETE BELOW CHECKS.
				 *
				 * */
				
				if ( version_compare( get_bloginfo('version'), '4.6', '<') )  {
					$message = "Sorry! Impossible to activate plugin. <br />";
					$message .= "This Plugin requires at least WP Version 4.6";
					die( $message );
				}
				
				if (version_compare(PHP_VERSION, '5.6', '<')){
					$message = "Sorry! Impossible to activate plugin. <br />";
					$message .= "This Plugin requires minimum PHP Version 5.6.0";
					die( $message );
				}
				
				
				
				
				
				/*
				 * DO WHAT YOU WANT ON PLUGIN ACTIVATION.
				 *
				 * */
				
				
			}
			
			
			
			public static function plugin_deactivated ()
			{
				
				/*
				 * DO WHAT YOU WANT ON PLUGIN DEACTIVATION.
				 *
				 * */
				
			}
			
			public static function app ($filepath)
			{
				register_activation_hook($filepath, [pt_Track_WP_Mails_Init::class, 'plugin_activated']);
				register_deactivation_hook($filepath, [pt_Track_WP_Mails_Init::class, 'plugin_deactivated']);
				
				//@todo: change $trs_plugin_name variable name
				self::$track_wp_mails = new self;
				self::$track_wp_mails->setPluginpath($filepath);
				
				return self::$track_wp_mails;
			}
			
			
			
			
			/*---------------------------- Setters and Getters ------------------------------------------------------*/
			
			/**
			 * @return mixed
			 */
			public static function getPluginpath ()
			{
				return self::$pluginpath;
			}
			
			/**
			 * @param mixed $pluginpath
			 */
			protected static function setPluginpath ($pluginpath)
			{
				self::$pluginpath = $pluginpath;
			}
			
		}
	}
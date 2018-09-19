<?php
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Track WP Mails
	 *
	 * @package     track_wp_mails
	 * @author      Ali Shan
	 * @copyright   2017 © TheRightSol - All rights are reserved
	 * @license     GPL-3.0+
	 *
	 * @wordpress-plugin
	 * Plugin Name: Track WP Mails
	 * Plugin URI:  http://therightsol.com
	 * Description: This plugin can track all outgoing email. And update status if email is read or not.
	 * Version:     1.0.0
	 * Author:      Ali Shan
	 * Author URI:  http://alishan.therightsol.com
	 * Text Domain: therightsol
	 * License:     GPL-3.0+
	 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
	 */
	
	use app\common\pt_Track_WP_Mails_Init;

        //@todo: change this global variable name
        global $pt_track_wp_mails;

        if ( file_exists( __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php' ) ) {
			require_once 'vendor/autoload.php';
		}


        if ( file_exists( __DIR__ . DIRECTORY_SEPARATOR . 'frameworks' . DIRECTORY_SEPARATOR . 'admin-folder' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'admin-init.php' ) ) {
			require_once __DIR__ . DIRECTORY_SEPARATOR . 'frameworks' . DIRECTORY_SEPARATOR . 'admin-folder' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'admin-init.php';
		}

        //@todo: change variable name
        $pt_track_wp_mails = pt_Track_WP_Mails_Init::app( __FILE__ );
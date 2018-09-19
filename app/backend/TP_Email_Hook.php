<?php
	/**
	 * Created by PhpStorm.
	 * User: ali.shan
	 * Date: 9/19/2018
	 * Time: 6:51 PM
	 */
	
	namespace app\backend;
	
	
	if (! class_exists('TP_Email_Hook')){
		class TP_Email_Hook
		{
			
			private $mail_sent = true;
			private $mail_post_id = 0;
			private static $tp_email_hook_obj;
			
			
			public function __construct ()
			{
				add_action('phpmailer_init', [$this, 'before_email_send']);
				
				add_action('init', [$this, 'send_email']);
				add_action('wp_mail_failed', [$this, 'email_error']);
				
				add_filter('wp_mail_content_type', [$this, 'update_content_type']);
				add_filter('wp_mail', [$this, 'add_tracking_image']);
			}
			
			private function get_random_email(){
				$emails = [
					'alishan@gmail.com',
					'salman@abc.com',
					'hello@nxb.com.pk',
					'hr@fake.com',
					'services@business.com'
				];
				
				
				return $emails[mt_rand(0, sizeof($emails) -1)];
				
			}
			
			public function add_tracking_image (array $mail_body)
			{
				$src = 'http://wptest.test/wp-content/plugins/wp-track-emails/app/common/track/track.php?time=' . time();
				$src .= '&user=' . $mail_body['to'];
				
				$mail_body['message'] .= '<img style="position:absolute; visibility:hidden" src="'.$src.'" width="1px" height="1px" />';
				
				
				return $mail_body;
			}
			public function update_content_type ($content_type)
			{
				return 'text/html';
			}
			
			public function email_error (\WP_Error $error)
			{
				update_post_meta($this->mail_post_id, 'not-send', $this->mail_sent);
				update_post_meta($this->mail_post_id, 'not-send-message', $error->get_error_message());
				
			}
			
			public function send_email ()
			{
				if (! isset($_GET['psendmail']))
					return;
				
				wp_mail($this->get_random_email(), 'This is test Email at ' . time(), 'Hi, This is email body');
				
			}
			
			public function before_email_send (\PHPMailer $phpMailer)
			{
				$this->mail_post_id = wp_insert_post([
														 'post_content'	=> $phpMailer->Body . PHP_EOL . var_export($phpMailer->getToAddresses(), true),
				
													 ]);
				//pt_debug($phpMailer , true, true);
			}
			
			public static function singleton ()
			{
				if (self::$tp_email_hook_obj instanceof self)
					return self::$tp_email_hook_obj;
				
				return self::$tp_email_hook_obj = new self;
			}
			
			
		}
	}
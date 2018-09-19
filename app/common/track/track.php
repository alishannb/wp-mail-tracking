<?php
	
	
	if (! isset($_GET['debug'])) {
		
		
		// Create an image, 1x1 pixel in size
		$im = imagecreate(1, 1);
		
		// Set the background colour
		$white = imagecolorallocate($im, 255, 255, 255);
		
		// Allocate the background colour
		imagesetpixel($im, 1, 1, $white);
		
		// Set the image type
		header("content-type:image/jpg");
		
		// Create a JPEG file from the image
		imagejpeg($im);
		
		// Free memory associated with the image
		imagedestroy($im);
	}
	
	$user_email = $_GET['user'];
	
	if (! $user_email):
	
		$request_uri = $_SERVER['REQUEST_URI'];
		$request_uri_arr = explode('&amp;', $request_uri);
		
		$time_arr = explode('time=', $request_uri_arr[0]);
		$time = $time_arr[1];
		
		$user_arr = explode('user=', $request_uri_arr[1]);
		$user_email = $user_arr[1];
	
	endif;
	
	$vc_arr = file_get_contents('views.txt');
	
	
	$data = unserialize($vc_arr);
	
	$old_read_time = 1;
	if (isset($data[ $user_email ])){
		
		$old_read_time = (int) $data[$user_email]['read_count'];
		
		
		$data[$user_email] = [
			'read_count' => (++$old_read_time),
		];
	}else {
		$data[$user_email] = [
			'read_count' => $old_read_time,
		];
	}
	
	file_put_contents('views.txt', print_r(serialize($data), true));
	
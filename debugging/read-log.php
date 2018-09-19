<?php
	
	global $secret_code;
	
	
	//@todo: Always update secret code for each plugin.
	$secret_code = "iedXER95JcONlLda";
	
	$get_arr = filter_input_array(INPUT_GET);
	$get_secret_code = isset($get_arr['sc']) ? $get_arr['sc'] : '';
	
	if ($secret_code === $get_secret_code && file_exists('logs.html'))
		include_once 'logs.html';
	else
		echo 'Sorry!';
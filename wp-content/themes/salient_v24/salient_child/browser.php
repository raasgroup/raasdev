<?php
function getBrowser() {

	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$browser = "N/A";
	
	$browsers = array(
	'/msie/i' => 'Internet explorer',
	'/firefox/i' => 'Firefox',
	'/safari/i' => 'Safari',
	'/chrome/i' => 'Chrome',
	'/edge/i' => 'Edge',
	'/opera/i' => 'Opera',
	'/mobile/i' => 'Mobile browser'
	);
	
	foreach ($browsers as $regex => $value) {
	if (preg_match($regex, $user_agent)) { $browser = $value; }
	}
	
	return $browser;
}

function set_window_size()
{
	if(isset($_POST['recordSize'])) {
    	$height = $_POST['height'];
    	$width = $_POST['width'];
    	$_SESSION['screen_height'] = $height;
    	$_SESSION['screen_width'] = $width;
	}
}

add_action( 'wp_ajax_set_window_size', 'set_window_size' );
?>
<?php

// Just include various parts of the app to make sure that they don't php error.

class BasicIncludeTests extends PHPUnit_Framework_TestCase{

	function testIncludeAppIndexScript(){
		$content = null;
		ob_start(); // Start buffering whatever the include returns.
		include('./www/index.php');
		$content = ob_get_contents(); // Get the output.
		ob_end_clean();
		$this->assertTrue(!empty($content));
	}

}

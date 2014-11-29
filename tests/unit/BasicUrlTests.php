<?php

// These tests are just to get some basic checks that the app is running in place, without requiring selenium or other BS like that.
// Other, more robust, web tests should go in a different location.

class BasicUrlTests extends PHPUnit_Framework_TestCase{

	// Simple helper function to ensure a url doesn't 404 or error out.
	function urlDoesntError($url){
		$headers = get_headers($url, 1); // Get headers as array.
		if ($headers[0] == 'HTTP/1.0 200 OK') {
			return true;
		} else {
			return false;
		}
	}

	function bespokeIsJSON($content){
		json_decode($content);
 		return (json_last_error() == JSON_ERROR_NONE);
	}

	// Simple helper function to get any arbitrary url's contents.
	function getUrlContents($url){
		$headers = get_headers($url, 1); // Get headers as array.
		if ($headers[0] == 'HTTP/1.0 200 OK') {
			return file_get_contents($url); // Get the contents of the url to do whatever with.
		}
		return null; // Nope, it didn't load right.
	}

	function testHomepageUrlLoads(){
		$url = BASE_URL;
		$this->assertTrue($this->urlDoesntError($url));
		$content = $this->getUrlContents($url);
		$this->assertTrue(!empty($content));
	}

	function testHelloWorldUrlLoads(){
		$url = BASE_URL.'hello/world';
		$this->assertTrue($this->urlDoesntError($url));
		$content = $this->getUrlContents($url);
		$this->assertTrue(!empty($content));
	}

	function testBasicAPIUrlTestReturnsSomethingInJSONformat(){ // All other api tests beyond this basic thing go in the api test suite.
		$url = BASE_URL.'api/test';
		$this->assertTrue($this->urlDoesntError($url));
		$content = $this->getUrlContents($url);
		$this->assertNotEmpty($content);
		//$content = '{"data":"true", "another":"thing"}';
		$this->assertTrue($this->bespokeIsJSON($content), 'Is not json: '.$content);
	}

}

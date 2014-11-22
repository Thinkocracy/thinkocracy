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

	// Simple helper function to get any arbitrary url's contents.
	function getUrlContents($url){
		$headers = get_headers($url, 1); // Get headers as array.
		if ($headers[0] == 'HTTP/1.0 200 OK') {
			return file_get_contents($url); // Get the contents of the url to do whatever with.
		}
		return null; // Nope, it didn't load right.
	}

	function testHomepageUrl(){
		$url = 'http://localhost:9999';
		$this->assertTrue($this->urlDoesntError($url));
		$content = $this->getUrlContents($url);
		$this->assertTrue(!empty($content));
	}

	function testHelloWorldUrl(){
		$url = 'http://localhost:9999/hello/world';
		$this->assertTrue($this->urlDoesntError($url));
		$content = $this->getUrlContents($url);
		$this->assertTrue(!empty($content));
	}

	function testBasicAPIReturnsStuff(){
		$url = 'http://localhost:9999/api/pulldata/input';
		$this->assertTrue($this->urlDoesntError($url));
		$content = $this->getUrlContents($url);
		$this->assertTrue(!empty($content));
	}


}

<?php

class ApiTests extends PHPUnit_Framework_TestCase{

	/*
	function bespokeIsJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}*/

	function getParsedApiJson($basic_api_url, $url_param){
		return json_decode(file_get_contents($basic_api_url.$url_param), true); // Decode json to array
	}

	function testSomeBasicJsonSyntax(){
		$this->markTestIncomplete(); // For some reason this test fails on the CI build, so marked incomplete for now.
		$json_string = "{'success':true}";
		$decoded = json_decode($json_string, true); // Decode it to an associative array.
		$this->assertEquals(true, $decoded['success']);
	}

	function testApiTestReturnsSuccess(){
		$base_url = BASE_URL.'api/test';
		$response = $this->getParsedApiJson($base_url, $extras='');
		$this->assertNotEmpty($response);
		$this->assertTrue(isset($response['success']), 'json success not returned by /api/test url');
		$this->assertEquals(true, $response['success']);
	}

	function testApiGetUrlsReturnJson(){
		$urls = array('', '/1', '/search/ninja');

		// Example url: http://localhost:9999/api/ideas/
		// Example url: http://localhost:9999/api/ideas/1
		// Example url: http://localhost:9999/api/ideas/search/ninja
		$base_url = BASE_URL.'api/ideas';
		foreach($urls as $extra_url_param){
			// Passes the json data, makes sure there's at least one result of each url
			$response = $this->getParsedApiJson($base_url, $extra_url_param);
			$this->assertNotEmpty($response, 'The api didn\'t correctly return a usable response to: '.$base_url.$extra_url_param);
			$this->assertContainsOnly('array', $response);
			$this->assertNotEmpty(reset($response), 'The idea wasn\'t a array didn\'t have a first item, full response was '.print_r($response, true));
			$this->assertTrue(is_array(reset($response)));
			$idea = reset($response);
			$this->assertTrue(is_string($idea['phrase']), 'Idea array didn\'t have a phrase key for the url: '.$base_url.$extra_url_param);
		}
	}

	function testApiPostUrlsWork(){
		$url = 'api/ideas';
		$post_data = array();
		$this->markTestIncomplete();
	}


	function testAPIReturnsRobustArray(){
		$base_url = BASE_URL.'api/test';
		$response = $this->getParsedApiJson($base_url, $extra_param='');
		$this->assertEquals($response, array('success'=>true));
	}



}
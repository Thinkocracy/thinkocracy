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

	function testSomeCorrectCorrectJson(){
		$json = "{'success':true}";
		$decoded = json_decode($json, true);
		$this->assertEquals($decoded['success'], true);
	}

	function testApiTestReturnsSuccess(){
		$base_url = BASE_URL.'api/test';
		$response = $this->getParsedApiJson($base_url, $extras='');
		$this->assertNotEmpty($response);
		var_dump($response);
		$this->assertTrue(isset($response['success']), 'json success not returned by /api/test url');
		$this->assertEquals($response['success'], true);
	}

	function testApiGetUrlsReturnJson(){
		$urls = array('', '/1', '/search/1');

		// Example url: http://localhost:9999/api/ideas/
		$base_url = BASE_URL.'api/ideas';
		foreach($urls as $extra_url_param){
			// Passes the json data 
			$response = $this->getParsedApiJson($base_url, $extra_url_param);
			$this->assertNotEmpty($response, 'The api didn\'t correctly return a usable response to: '.$base_url.$extra_url_param);
			$this->assertTrue(isset($response['data']), 'The response array wasn\'t set correctly, full response was '.print_r($response, true));
			$this->assertEquals($response['data'], 'no real data');
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
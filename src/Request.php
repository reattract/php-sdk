<?php

namespace Reattract\Reattract;

use Reattract\Reattract\JwtGenerator;
use GuzzleHttp\Client;

class Request
{
	public $path;

	public function __construct($path) 
	{
		$this->path = $path;
	}

	public function get($query = []) 
	{
		$client = $this->client();
		return $client->request('GET', $this->url(), [
			'json' => true,
			'query' => $query
		]);
	}
	
	public function patch($json = []) 
	{
		$client = $this->client();
		return $client->request('PATCH', $this->url(), [
			'json' => $json
		]);
	}

	private function client() 
	{
		return new Client([
			'headers' => [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
				'Authorization' => 'Bearer ' . $this->jwt()
			]
		]);
	}

	private function url()
	{
		return Configuration::url() . $this->path;
	}

	private function jwt()
	{
		$jwtGenerator = new JwtGenerator();
		return $jwtGenerator->generate();
	}
}

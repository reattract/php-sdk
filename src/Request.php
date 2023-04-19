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
		$response = $client->request('GET', $this->url(), [
			'json' => true,
			'query' => $query
		]);

		return $this->formatResponse($response);
	}
	
	public function patch($json = []) 
	{
		$client = $this->client();
		$response = $client->request('PATCH', $this->url(), [
			'json' => $json
		]);

		return $this->formatResponse($response);
	}
	
	public function delete() 
	{
		$client = $this->client();
		$response = $client->request('DELETE', $this->url());

		return $this->formatResponse($response);
	}
	
	public function post($json = []) 
	{
		$client = $this->client();
		$response = $client->request('POST', $this->url(), [
			'json' => $json
		]);

		return $this->formatResponse($response);
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

	private function formatResponse($response)
	{
		$contents = $response->getBody()->getContents();
		$status = $response->getStatusCode();

		return [
			'body' => json_decode($contents, true),
			'status' => $status,
			'response' => $response
		];
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

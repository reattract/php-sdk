<?php

namespace Reattract\Sdk;

use Reattract\Sdk\JwtGenerator;
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
        $pagination = $this->extrctPagination($response);

        $helpfulResponse = [
            'body' => json_decode($contents, true),
            'status' => $status,
            'response' => $response
        ];

        if($pagination !== null) {
            $helpfulResponse['pagination'] = $pagination;
        }

        return $helpfulResponse;
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

    private function extrctPagination($response)
    {
        if($response->hasHeader('Page-Items') === false) {
            return null;
        }

        $headers = $response->getHeaders();

        return [
            'pageItems' => $headers['Page-Items'],
            'currentPage' => $headers['Current-Page'],
            'totalPages' => $headers['Total-Pages'],
            'totalCount' => $headers['Total-Count']
        ];
    }
}

<?php

namespace Reattract\Sdk;

use Reattract\Sdk\JwtGenerator;
use Reattract\Sdk\PaginatedResponse;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

class Request
{
    public string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param array<string, mixed> $query
     */
    public function get(array $query = []): PaginatedResponse
    {
        $client = $this->client();
        $response = $client->request('GET', $this->url(), [
            'json' => true,
            'query' => $query
        ]);

        return $this->formatResponse($response);
    }

    /**
     * @param array<string, mixed> $json
     */
    public function patch(array $json = []): PaginatedResponse
    {
        $client = $this->client();
        $response = $client->request('PATCH', $this->url(), [
            'json' => $json
        ]);

        return $this->formatResponse($response);
    }

    public function delete(): PaginatedResponse
    {
        $client = $this->client();
        $response = $client->request('DELETE', $this->url());

        return $this->formatResponse($response);
    }

    /**
     * @param array<string, mixed> $json
     */
    public function post(array $json = []): PaginatedResponse
    {
        $client = $this->client();
        $response = $client->request('POST', $this->url(), [
            'json' => $json
        ]);

        return $this->formatResponse($response);
    }

    private function client(): Client
    {
        return new Client([
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt()
            ]
        ]);
    }

    private function formatResponse(ResponseInterface $response): PaginatedResponse
    {
        $contents = $response->getBody()->getContents();
        $status = $response->getStatusCode();
        $pagination = $this->extrctPagination($response);

        return new PaginatedResponse(json_decode($contents, true), $status, $response, $pagination);
    }

    private function url(): string
    {
        return Configuration::url() . $this->path;
    }

    private function jwt(): string
    {
        $jwtGenerator = new JwtGenerator();
        return $jwtGenerator->generate();
    }

    /**
     * @return array{'pageItems': int, 'currentPage': int, 'totalPages': int, 'totalCount': int} | null
     */
    private function extrctPagination(ResponseInterface $response)
    {
        if($response->hasHeader('Page-Items') === false) {
            return null;
        }

        $headers = $response->getHeaders();

        return [
            'pageItems' => intval(implode($headers['Page-Items'])),
            'currentPage' => intval(implode($headers['Current-Page'])),
            'totalPages' => intval(implode($headers['Total-Pages'])),
            'totalCount' => intval(implode($headers['Total-Count']))
        ];
    }
}

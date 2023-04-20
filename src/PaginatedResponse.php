<?php

namespace Reattract\Sdk;

use Psr\Http\Message\ResponseInterface;

class PaginatedResponse
{
    public mixed $body;
    public int $status;
    public ResponseInterface $response;
    /**
     * @var null|array{'pageItems': int, 'currentPage': int, 'totalPages': int, 'totalCount': int}
     */
    public array|null $pagination;

    /**
     * @param null|array{'pageItems': int, 'currentPage': int, 'totalPages': int, 'totalCount': int} $pagination
     */
    public function __construct(mixed $body, int $status, ResponseInterface $response, array|null $pagination)
    {
        $this->body = $body;
        $this->status = $status;
        $this->response = $response;
        $this->pagination = $pagination;
    }
}

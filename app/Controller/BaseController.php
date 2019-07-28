<?php


namespace App\Controller;


use Psr\Container\ContainerInterface;

class BaseController extends Controller
{

    protected $tokenType;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function error(string $message = '', int $statusCode = 500, int $code = 0)
    {
        $errorMsg = [
            'message' => $message,
            'code' => $code,
            'status_code' => $statusCode
        ];

        return $this->response->json($errorMsg)->withStatus($statusCode);
    }
}
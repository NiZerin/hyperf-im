<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 4:50 PM
 * FileName: ValidationExceptionHandler.php
 */


namespace App\Exception\Handler;


use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        /** @var  $body string */
        $body = $throwable->validator->errors()->first();
        return $response
            ->withStatus($throwable->status)
            ->withBody(new SwooleStream(error($body)))
            ->withHeader('Content-Type', 'application/json');
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }

}
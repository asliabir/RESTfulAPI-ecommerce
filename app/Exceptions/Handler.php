<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if($exception instanceof ModelNotFoundException){
            $modalName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Does not exists any {$modalName} with the specified identificator",404);
        }
        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }
        if($exception instanceof AuthenticationException){
            return $this->errorResponse($exception->getMessage(), 403);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('The specified URL cannot be found', 404);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }
        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1451){
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource', 409);
            }
        }
        // if debug is true then run this
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        // else run this
        return $this->errorResponse('Unexpected Exception. Try Again', 503);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse("Unauthenticated", 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
            return $this->errorResponse($errors, 422);
    }
}



<?php

namespace App\Exceptions;

use App\Traits\JsonResponseTrait;
use Exception;
use GrahamCampbell\Exceptions\NewExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends NewExceptionHandler
{
    use JsonResponseTrait;
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
        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->getMessages();

            if ($request->expectsJson()) {
                return $this->apiResponse(-422, '数据验证错误', $errors);
            }

            return redirect()->back()->withInput(
                $request->input()
            )->withErrors($errors);
        }
        return parent::render($request, $exception);
    }

    /**
     * Prepare response containing exception render.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->getMessages();

            if ($request->expectsJson()) {
                return $this->apiResponse(-422, '数据验证错误', $errors);
            }

            return redirect()->back()->withInput(
                $request->input()
            )->withErrors($errors);
        }
//        if ($request->expectsJson()) {
//            return $this->renderAPIsException($request, $exception);
//        }
        return parent::prepareResponse($request, $exception);
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
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    protected function renderAPIsException($request, Exception $exception) {

    }
}

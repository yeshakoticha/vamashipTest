<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($this->isHttpException($e))
		{
			return $this->renderHttpException($e);
		}else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
            return response()->json(['token_blacklisted'], $e->getStatusCode());
        }else if ($e instanceof Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
		else
		{
			return parent::render($request, $e);
		}
	}

}

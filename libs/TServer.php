<?php

namespace CatPKT\HttpServer;

use CatPKT\Encryptor\IEncryptor;
use Symfony\Component\HttpFoundation\{  Request,  Response  };

////////////////////////////////////////////////////////////////

trait TServer
{

	/**
	 * Method handle
	 *
	 * @access public
	 *
	 * @param  Request $request
	 * @param  string $basePath
	 *
	 * @return Response
	 */
	final public function handle( Request$request, string$basePath='/' ):Response
	{
		$response= $this->{'action'.$this->route( $request, $basePath )}( $request );

		if(!( $response instanceof Response ))
		{
			$response= new Response(
				$this->app->getEncryptor()->encrypt(
					$response
				)
			);
		}

		return $response;
	}

	/**
	 * Method route
	 *
	 * @access private
	 *
	 * @param  Request $request
	 * @param  string $basePath
	 *
	 * @return string
	 */
	private function route( Request$request, string$basePath='/' ):string
	{
		$path= '/'.trim( substr( $request->getPathInfo(), strlen( $basePath ) ), '/' );

		return $this->getRoutes()[$request->getMethod().':'.$path];
	}

	/**
	 * Method getEncryptor
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @return IEncryptor
	 */
	abstract protected function getEncryptor():IEncryptor;

	/**
	 * Method getRoutes
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @return array
	 */
	abstract protected function getRoutes():array;

}

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
	 * @param  string $baseUrl
	 *
	 * @return Response
	 */
	final public function handle( Request$request, string$baseUrl='/' ):Response
	{
		return new Response(
			$this->getEncryptor()->encrypt(
				$this->{'action'.$this->route( $request, $baseUrl )}( $request )
			)
		);
	}

	/**
	 * Method route
	 *
	 * @access private
	 *
	 * @param  Request $request
	 * @param  string $baseUrl
	 *
	 * @return Response
	 */
	private function route( Request$request, string$baseUrl='/' ):Response
	{
		$path= trim( substr( $request->getPathInfo(), strlen( $baseUrl ) ), '/' )?:'/';

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

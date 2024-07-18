<?php

namespace Crmlva\Exposy;

abstract class Controller 
{

    const REQUEST_METHOD_GET = "GET";
    const REQUEST_METHOD_POST = "POST";

    protected function getData() : array
    {
        return $this->isRequestMethod( self::REQUEST_METHOD_POST ) ? $_POST : $_GET;
    }

    protected function isRequestMethod(string $method) : bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    public function redirect( string $target ) : void
    {
        header( "Location: {$target}" );
    }

    public function error( int $code ) : void {
        http_response_code($code);

        (new View('error', $code));
    }

}
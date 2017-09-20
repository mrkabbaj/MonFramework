<?php
namespace Tests\Framework\Module;

class ErroredModule {

    public function __construct(\Framework\Router $router)
    {
        $router->get('/demo', function (){
            return new \stdClass();
        }, 'demo');
    }
}
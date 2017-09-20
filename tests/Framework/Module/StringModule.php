<?php
namespace Tests\Framework\Module;

class StringModule
{

    public function __construct(\Framework\Router $router)
    {
        $router->get('/demo', function (){
            return 'DEMO';
        }, 'demo');
    }
}

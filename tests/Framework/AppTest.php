<?php
namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Module\ErroredModule;
use Tests\Framework\Module\StringModule;

class AppTest extends TestCase{

  public function testRedirectTraillingSlash()
  {
    $app = new App();
    $request = new ServerRequest('GET','/azeaze/');
    $response = $app->run($request);
    $this->assertContains("/azeaze", $response->getHeader('Location'));
    $this->assertEquals('301', $response->getStatusCode());
  }

  public function testBlog()
  {
      $app = new App([
          BlogModule::class
      ]);

      $request = new ServerRequest('GET','/blog');
      $response = $app->run($request);
      $this->assertContains('<h1>Bienvenue blog</h1>', (string)$response->getBody());
      $this->assertEquals("200",$response->getStatusCode());


      $requestSingle = new ServerRequest('GET','/blog/mon-article');
      $responseSingle = $app->run($requestSingle);
      $this->assertContains('<h1>Bienvenue article mon-article</h1>', (string)$responseSingle->getBody());


  }

  public function testThrowExceptionIfNoResponseSent()
  {
      $app = new App([
          ErroredModule::class
      ]);

      $request = new ServerRequest('Get', '/demo');
      $this->expectException(\Exception::class);
      $app->run($request);
  }

  public function testConvertStringToResponse()
  {
        $app = new App([
            StringModule::class
        ]);

        $request = new ServerRequest('Get', '/demo');
        $response = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('DEMO', (string)$response->getBody());

  }

  public function testError404()
  {
        $app = new App();
        $request = new ServerRequest('GET','/erer');
        $response = $app->run($request);
        $this->assertContains("<h1>Error 404</h1>", (string)$response->getBody());
        $this->assertEquals("404",$response->getStatusCode());

  }


}
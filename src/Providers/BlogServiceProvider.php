<?php

namespace Jiko\Blog\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Input;

class BlogServiceProvider extends ServiceProvider
{
  /**
   * This namespace is applied to the controller routes in your routes file.
   *
   * In addition, it is set as the URL generator's root namespace.
   *
   * @var string
   */
  protected $namespace = 'Jiko\Blog\Http\Controllers';

  /**
   * Define your route model bindings, pattern filters, etc.
   *
   * @param  \Illuminate\Routing\Router $router
   * @return void
   */
  public function boot(Router $router)
  {
    $this->publishes([
      __DIR__.'/../../config/blog.php' => config_path('blog.php')
    ]);
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'blog');

    parent::boot($router);
  }

  /**
   * Define the routes for the application.
   *
   * @param  \Illuminate\Routing\Router $router
   * @return void
   */
  public function map(Router $router)
  {
    $router->group(['namespace' => $this->namespace], function ($router) {
      if (in_array(Input::server('HTTP_HOST'), ['www.joejiko.com', 'local.joejiko.com'])) {
        require_once(__DIR__ . '/../Http/routes.php');;
      }
    });
  }

  public function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/../../config/blog.php', 'blog'
    );
  }
}
<?php

namespace Tests;

use App\Exceptions\Handler;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

/**
 * Class TestCase
 * @property Generator $faker
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $faker;

    protected function setUp()
    {
        ini_set('memory_limit', '2048M');
        parent::setUp();
         config(['app.url' => 'https://ensamblers.com.ua:80/']);
        $this->disableExceptionHandling();
        $this->faker = Factory::create();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');
        $this->actingAs($user);

        return $this;
    }

    protected function passport()
    {
        Artisan::call('passport:install');
    }
    // Hat tip, @adamwathan.
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}

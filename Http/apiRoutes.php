<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/block'], function (Router $router) {
    $router->post('/index', [
        'as' => 'api.block.index',
        'uses' => 'ApiController@index',
    ]);
});

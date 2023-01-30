<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('q3', [
    'as' => 'q3',
    'uses' => 'QuestController@pattern_count',
]);

$router->post('q1', [
    'as' => 'q1',
    'uses' => 'QuestController@sum_deep',
]);

$router->post('q2', [
    'as' => 'q2',
    'uses' => 'QuestController@get_scheme',
]);

$router->get('q4', [
    'as' => 'q4',
    'uses' => 'QuestController@polymorphism',
]);

$router->get('q4', [
    'as' => 'q4',
    'uses' => 'QuestController@polymorphism',
]);

$router->post('product', [
    'as' => 'product.create',
    'uses' => 'ProductController@create',
]);

$router->get('product/{id}', [
    'as' => 'product.show',
    'uses' => 'ProductController@show',
]);

$router->get('products', [
    'as' => 'product.list',
    'uses' => 'ProductController@list',
]);

$router->post('add-product', [
    'as' => 'product.add',
    'uses' => 'ProductController@addProduct',
]);

$router->post('cart-checkout', [
    'as' => 'cart.checkout',
    'uses' => 'ProductController@checkout',
]);

$router->get('list-order', [
    'as' => 'order.list',
    'uses' => 'ProductController@listOrders',
]);

$router->get('summary-product-order', [
    'as' => 'product-order.summary',
    'uses' => 'ProductController@summary',
]);

// $router->get('posts', [
//     'as' => 'post.index',
//     'uses' => 'PostController@index',
// ]);

// $router->get('post/{id}', [
//     'as' => 'post.show',
//     'uses' => 'PostController@show',
// ]);

// $router->post('post', [
//     'as' => 'post.store',
//     'uses' => 'PostController@store',
// ]);

// $router->put('post/{id}', [
//     'as' => 'post.update',
//     'uses' => 'PostController@update',
// ]);

// $router->delete('post/{id}', [
//     'as' => 'post.delete',
//     'uses' => 'PostController@destroy',
// ]);

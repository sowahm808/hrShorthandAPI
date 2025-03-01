<?php

return [

/*
|--------------------------------------------------------------------------
| Stateful Domains
|--------------------------------------------------------------------------
|
| Requests from these domains will receive stateful API authentication
| cookies. Typically, these should include your local and production
| frontend URLs.
|
*/
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,localhost:4200')),

/*
|--------------------------------------------------------------------------
| Sanctum Guards
|--------------------------------------------------------------------------
|
| These are the guards that will be checked for authentication when using
| Sanctum's `Guard` middleware.
|
| Typically, you should use the "web" guard if you are using Sanctum with
| a SPA (like Angular or React).
|
*/
'guard' => ['web'],

/*
|--------------------------------------------------------------------------
| Expiration Minutes
|--------------------------------------------------------------------------
|
| This value controls the number of minutes until an issued token will be
| considered expired. If set to null, the tokens do not expire.
|
| If you would like to specify an expiration time for tokens, set this to
| the desired number of minutes.
|
*/
'expiration' => null,

/*
|--------------------------------------------------------------------------
| Sanctum Middleware
|--------------------------------------------------------------------------
|
| When authenticating your SPA with Sanctum, you may need to customize some
| of the middleware Sanctum uses while processing the request.
|
*/
'middleware' => [
    'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
    'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
],
];

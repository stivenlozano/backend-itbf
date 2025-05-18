<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Define qué rutas estarán disponibles para solicitudes CORS.
    | Normalmente, solo las rutas de tu API y la cookie CSRF de Sanctum.
    |
    */

    'paths' => ['api/*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Puedes poner ['*'] para aceptar todos los métodos (GET, POST, PUT, etc.)
    |
    */

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Aquí defines los dominios que pueden hacer solicitudes.
    | En desarrollo puedes usar ['*'], pero en producción especifica el dominio.
    |
    */

    'allowed_origins' => [
        'https://frontend-itbf.vercel.app', // producción
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | Si quieres permitir orígenes con patrones regex.
    |
    */

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Headers permitidos en las solicitudes. '*' para todos.
    |
    */

    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Headers que pueden ser accedidos desde el cliente (como X-Auth-Token, etc.)
    |
    */

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Tiempo que el navegador puede cachear la respuesta preflight.
    |
    */

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | Si usas cookies o headers de autenticación, activa esto en true.
    |
    */

    'supports_credentials' => true,

];
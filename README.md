<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Pasos de instalación

Seguir los siguientes pasos para la instalación del proyecto

En la terminal ejecutar los siguientes comandos:

- git clone https://github.com/stivenlozano/backend-itbf.git
- cd backend-itbf
- composer install
- cp .env.example .env
- php artisan key:generate

Abrir el archivo .env y reemplazar los valores de bases de datos con los siguientes:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hoteles_decameron

Adicional reemplazar los valores de DB_USERNAME y DB_PASSWORD con lo que tenga configurada su base de datos: 

DB_USERNAME=postgres
DB_PASSWORD=

- Iniciar postgreSQL en el puerto 5432

Volver a la terminal y ejecutar los siguientes comandos:

- php artisan migrate --seed
- php artisan serve

El proyectos se iniciara la url http://127.0.0.1:8000
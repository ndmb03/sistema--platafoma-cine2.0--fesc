<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# sistema--platafoma-cine2.0--fesc
Sistema CRUD desarrollado en Laravel
Descripción del Sistema
La Plataforma de Cine 2.0 es una aplicación web diseñada para gestionar películas, usuarios y contenido multimedia relacionado con el cine.  
El sistema permite:

- Registrar, editar y eliminar películas.
- Administrar categorías, géneros y directores.
- Gestionar usuarios y roles.
- Visualizar información detallada de cada película.
- Manejar imágenes, descripciones y datos técnicos.
- Facilitar la navegación y búsqueda dentro del catálogo.
  
Tecnologías Utilizadas

- PHP
- Laravel (Framework)
- MySQL (Base de datos)
- Composer (Gestor de dependencias)
- Vite (Compilador de assets)
- HTML, CSS y JavaScript

  Estructura del Proyecto

Las carpetas más importantes son:

- app/→ Lógica principal de la aplicación  
- routes/ → Rutas web y API  
- resources/ → Vistas, estilos y scripts  
- public/ → Archivos públicos (CSS/JS compilados, imágenes)  
- vendor/ → Dependencias automáticas instaladas con Composer  
 Instalación

Sigue estos pasos para ejecutar el proyecto:

Instrucciones de Instalación en Linux

1. Actualizar paquetes
``bash
sudo apt update && sudo apt upgrade -y
2. Instalar dependencias necesarias
sudo apt install php php-cli php-mbstring php-xml php-curl php-zip php-mysql git unzip -y
3. Instalar Composer
sudo apt install composer -y
4. Clonar el proyecto
git clone https://github.com/usuario/plataforma-cine2.0.git
cd plataforma-cine2.0
5. Instalar dependencias del proyecto
composer install
6. Configurar archivo .env
cp .env.example .env
editar el archivo
nano .env
configurar
DB_DATABASE=plataforma_cine
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
7. Generar key de Laravel
php artisan key:generate
8. Crear base de datos
mysql -u root -p
CREATE DATABASE plataforma_cine;
EXIT;
9. Ejecutar migraciones
php artisan migrate
10. Ejecutar servidor
php artisan serve



integrantes
nataly dayana medina 
jeanpierre diaz



>>>>>>> 7663384b4526a36c2d20a76de48f415801a1969a

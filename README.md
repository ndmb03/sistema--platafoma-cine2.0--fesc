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




# Project-App

Una aplicación Laravel para prueba de proyecto.

## Acerca del Proyecto

Esta es una aplicación web construida con Laravel Framework 12.36.1. Laravel es un framework de aplicación web con una sintaxis expresiva y elegante que facilita el desarrollo de aplicaciones robustas y escalables.

## Requisitos

- PHP >= 8.2
- Composer
- Node.js y npm (para assets frontend)

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/oswram19/Project-App.git
cd Project-App
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Crear archivo de configuración:
```bash
cp .env.example .env
```

4. Generar clave de aplicación:
```bash
php artisan key:generate
```

5. Ejecutar migraciones (opcional):
```bash
php artisan migrate
```

6. Iniciar el servidor de desarrollo:
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## Testing

Ejecutar las pruebas:
```bash
php artisan test
```

## Documentación de Laravel

Para más información sobre Laravel, consulta la [documentación oficial](https://laravel.com/docs).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

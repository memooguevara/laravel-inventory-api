# 🧰 API REST de Inventario con Laravel + JWT

Esta es una API REST construida con **Laravel 11**, usando **JWT para autenticación**, validación con **Form Requests**, documentación con **Swagger**, y buenas prácticas de estructura limpia.

## 🔗 Url del proyecto

- URL del proyecto: https://ims.pragmaticos.com.co
- Documentación Swagger: https://ims.pragmaticos.com.co/api/documentation

---

## 🚀 1. Instalación local

### Requisitos

- PHP >= 8.2
- Composer
- MySQL o PostgreSQL
- Laravel 11

### Pasos

1. Clona el proyecto
```bash
git clone https://github.com/memooguevara/laravel-inventory-api.git
cd laravel-inventory-api
```

2. Instala dependencias
```bash
composer install
```

3. Copia el archivo de entorno
```bash
cp .env.example .env
```

4. Genera la clave de aplicación
```bash
php artisan key:generate
```

5. Genera la clave JWT
```bash
php artisan jwt:secret
```

6. Configura tu conexión a base de datos en el `.env`
```env
DB_CONNECTION=mysql # o pqsql
DB_HOST=host_db
DB_DATABASE=nombre_bd
DB_USERNAME=usuario
DB_PASSWORD=clave
```

7. Ejecuta migraciones y seeders
```bash
php artisan migrate --seed
```

8. Levanta el servidor
```bash
php artisan serve
```

9. Accede al proyecto: http://localhost:8000/api/login

- Usuario Administrador
```json
{
    "email": "admin@mail.com",
    "password": "password123"
}
```

- Usuario Regular
```json
{
    "email": "user@mail.com",
    "password": "password123"
}
```

## 🧪 2. Documentación de la API (Postman + Swagger)

### 📫 Colección Postman

1. Importa el archivo postman_collection.json que está en la raíz del proyecto.
2. Inicia sesión con el endpoint `/api/login` para obtener el token.
3. Automáticamente el token se agrega a las variables de entorno.

### 📖 Documentación Swagger

1. Accede en: http://localhost:8000/api/documentation
2. Inicia sesión con el endpoint `/api/login` para obtener el token.
3. Haz clic en el botón Authorize para autenticarte.
4. Proporciona tu token JWT.

## 📐 4. Decisiones de diseño

### 🧩 Enums vs Tabla de Roles

- Se utilizó un enum PHP nativo (`App\Enums\Role`) para definir roles como ADMIN y USER.
- Esto simplifica el uso en validaciones y lógica de negocio sin necesidad de consultar una tabla adicional.

```php
enum Role: string {
    case ADMIN = 'admin';
    case USER = 'user';
}
```

### 🔐 Middleware de autorización

- Se crearon middleware personalizados:
    - `IsAuthenticated`: para proteger rutas con JWT. 
    - `IsAdminUser`: para permitir acciones avanzadas a administradores. 
- Se evitó usar paquetes como `spatie/laravel-permission` para mantener la API ligera y simple.

### 🛠 Cambios al esquema de base de datos

- El modelo users incluye una columna role (string) en lugar de una relación con tabla roles.
- Se agregaron migraciones personalizadas para incluir datos iniciales (admin@mail.com).
- Se añadió `category_id` en products como clave foránea.

### 📊 Estructura de validación

- Todos los controladores usan clases FormRequest para mantener limpio el controlador:
  - `RegisterRequest.php`
  - `CategoryRequest.php`
  - `ProductRequest.php`

### 🧱 Diseño del Proyecto: Patrones Actions y Services

Para mejorar la mantenibilidad y escalabilidad del sistema, se implementaron los siguientes patrones:

#### 🎯 Patrón Action
Cada acción importante del sistema (crear, actualizar, eliminar) se delega a una clase específica dentro de `app/Actions/`.
Estas clases manejan un solo caso de uso y permiten mantener los controladores delgados y legibles.

Ejemplos:

- `CreateCategory`
- `UpdateProduct`

#### ⚙️ Patrón Service
Las clases de servicio en `app/Services/` encapsulan la lógica de negocio reutilizable.
Esto permite centralizar reglas, validaciones y operaciones que podrían usarse desde controladores, listeners o comandos.

Ejemplos:

- `CategoryService::create(array $data)`
- `AuthService::register(array $credentials)`

#### 🚀 Ventajas del enfoque

- Código más limpio y fácil de testear. 
- Controladores más simples. 
- Claridad en las responsabilidades. 
- Fácil extensión para nuevos endpoints o cambios de lógica.

## 🐳 5. Uso con Docker
Este proyecto incluye configuración básica para levantar el entorno completo con PHP-FPM, Nginx y PostgreSQL usando Docker.

### 🧱 Requisitos
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### 📁 Estructura relevante
```plaintext
.docker
├── php
│   └── Dockerfile
├── nginx
│   └── default.conf
docker-compose.yml
```

### ▶️ Levantar el proyecto

```bash
docker-compose up -d
```

### 📦 Acceder al contenedor

```bash
docker compose exec -it php bash
```

### 🛠️ Resolución de errores comunes

Si ves errores como Permission denied sobre storage o bootstrap/cache, asegúrate de dar permisos:

```bash
docker composer exec -it php bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```


## 👨‍💻 Autor
Desarrollado por [Jonathan Guevara (@memooguevara)](https://github.com/memooguevara).

## 📄 Licencia
MIT License

# Inventory API - Laravel RESTful API

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php)](https://php.net)

Una API RESTful para gestión de inventario construida con Laravel 11, Laravel Sanctum para autenticación y Laravel Policies para autorización basada en roles.

## 🚀 Características

- **Autenticación JWT** con Laravel Sanctum
- **Autorización basada en roles** (Admin/User) usando Laravel Policies
- **CRUD completo** para Usuarios, Categorías y Productos
- **Sistema de localización** en español e inglés
- **Colección de Postman** incluida para pruebas
- **Seeding automático** con datos de prueba
- **Configuración simplificada** con `.env.example` listo para usar
- **Docker Compose** para entorno de desarrollo

## 📚 Índice

- [Instalación](#-instalación)
- [URL Pública](#-url-pública)
- [Cuentas de Prueba](#-cuentas-de-prueba)
- [Documentación](#-documentación)
- [Endpoints de la API](#-endpoints-de-la-api)
- [Autenticación](#-autenticación)
- [Autorización](#️-autorización)
- [Comandos Útiles](#-comandos-útiles)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Decisiones de Diseño](#️-decisiones-de-diseño)

## 🛠 Instalación

### Opción 1: Instalación Manual

#### Requisitos Previos

- PHP 8.3
- Composer 2.5+
- PostgreSQL 17+
- Node.js (opcional, para assets)

#### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/AndersonTriana/inventory-api.git
cd inventory-api
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Copiar .env.example**
```bash
cp .env.example .env
```

4. **Generar clave de aplicación**
```bash
php artisan key:generate
```

5. **Configurar variables de entorno**: Configura las siguientes variables en tu archivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventory
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

6. **Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

7. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

### Opción 2: Docker Compose (Recomendado)

#### Requisitos Previos

- Docker 24.0+ 
- Docker Compose 2.20+

#### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/AndersonTriana/inventory-api.git
cd inventory-api
```

2. **Copiar .env.example**
```bash
cp .env.example .env
```

3. **Configurar variables de entorno**: Configura las siguientes variables en tu archivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=172.19.0.2
DB_PORT=5432
DB_DATABASE=inventory
DB_USERNAME=inventory
DB_PASSWORD=inventory
```


4. **Levantar servicios**
```bash
docker compose up -d
```

5. **Instalar dependencias**
```bash
docker compose exec inventory-api composer install
```

6. **Configurar aplicación**
```bash
docker compose exec inventory-api php artisan key:generate
docker compose exec inventory-api php artisan migrate:fresh --seed
```

La API estará disponible en `http://inventory-api-anderson.us-east-1.elasticbeanstalk.com/api`

## 🌐 URL Pública

- **AWS**: `http://inventory-api-anderson.us-east-1.elasticbeanstalk.com/`

## 🎯 Cuentas de Prueba

Después de ejecutar los seeders, tendrás disponibles:

**Administrador:**
- Email: `admin@example.com`
- Password: `password`
- Rol: `admin`

**Usuario Regular:**
- Email: `user@example.com`
- Password: `password`
- Rol: `user`

## 📋 Documentación

### Colección de Postman

**Importar y usar:**
1. Importa `postman_collection.json` en Postman
2. Las variables y autenticación están preconfiguradas
3. Flujo recomendado: Registro → Login Usuario → Login Admin

**Configuración para entorno local:**
Por defecto, la colección está configurada para usar la URL pública:
```json
"base_url": "http://inventory-api-anderson.us-east-1.elasticbeanstalk.com/api"
```

Para hacer pruebas en tu entorno local, cambia la variable `base_url` a:
```
http://localhost:8000/api
```

**Incluye:**
- ✅ Variables de entorno preconfiguradas  
- ✅ Casos de prueba para los dos roles

## 📖 Endpoints de la API

### Autenticación

| Método | Endpoint | Descripción | Roles |
|--------|----------|-------------|-------|
| POST | `/api/register` | Registrar nuevo usuario | Público |
| POST | `/api/login` | Iniciar sesión | Público |
| POST | `/api/logout` | Cerrar sesión | Autenticado |

### Usuarios

| Método | Endpoint | Descripción | Roles |
|--------|----------|-------------|-------|
| GET | `/api/users` | Listar usuarios | Admin |
| GET | `/api/users/{id}` | Obtener usuario | Admin/Propio |
| PUT | `/api/users/{id}` | Actualizar usuario | Admin/Propio |
| DELETE | `/api/users/{id}` | Eliminar usuario | Admin |

### Categorías

| Método | Endpoint | Descripción | Roles |
|--------|----------|-------------|-------|
| GET | `/api/categories` | Listar categorías | Todos |
| GET | `/api/categories/{id}` | Obtener categoría | Todos |
| POST | `/api/categories` | Crear categoría | Admin |
| PUT | `/api/categories/{id}` | Actualizar categoría | Admin |
| DELETE | `/api/categories/{id}` | Eliminar categoría | Admin |

### Productos

| Método | Endpoint | Descripción | Roles |
|--------|----------|-------------|-------|
| GET | `/api/products` | Listar productos | Todos |
| GET | `/api/products/{id}` | Obtener producto | Todos |
| POST | `/api/products` | Crear producto | Admin |
| PUT | `/api/products/{id}` | Actualizar producto | Admin |
| DELETE | `/api/products/{id}` | Eliminar producto | Admin |

## 🔐 Autenticación

La API utiliza **Laravel Sanctum** para autenticación basada en tokens.

### Ejemplo de Login

```bash
curl -X POST http://inventory-api-anderson.us-east-1.elasticbeanstalk.com/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Usuario autenticado correctamente",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "1|abc123..."
  }
}
```

### Uso del Token

```bash
curl -X GET http://inventory-api-anderson.us-east-1.elasticbeanstalk.com/api/users \
  -H "Authorization: Bearer 1|abc123..." \
  -H "Accept: application/json"
```

## 🛡️ Autorización

El sistema implementa autorización basada en roles usando **Laravel Policies**:

### Roles Disponibles

- **Admin**: Acceso completo (CRUD) a todos los recursos
- **User**: Solo lectura a categorías y productos

### Políticas de Acceso

**UserPolicy:**
- Solo admins pueden listar usuarios
- Usuarios pueden ver/editar su propio perfil
- Solo admins pueden eliminar usuarios

**CategoryPolicy & ProductPolicy:**
- Todos pueden leer (índice y mostrar)
- Solo admins pueden crear, actualizar y eliminar

## 🧪 Comandos Útiles

### Instalación Manual
```bash
# Refrescar BD y datos de prueba
php artisan migrate:fresh --seed

# Ver rutas de la API
php artisan route:list --path=api

# Limpiar cache
php artisan cache:clear && php artisan config:clear
```

### Docker
```bash
# Refrescar BD y datos de prueba
docker compose exec inventory-api php artisan migrate:fresh --seed

# Ver rutas
docker compose exec inventory-api php artisan route:list --path=api

# Ver logs
docker compose logs -f inventory-api

# Acceder al contenedor
docker compose exec inventory-api bash

# Detener servicios
docker compose down

# Reiniciar servicios
docker compose restart
```

## 🏗️ Decisiones de Diseño

### ¿Por qué Laravel Policies en lugar de Middleware?

**Laravel Policies** fue elegido sobre middleware personalizado por las siguientes razones:

1. **Integración Nativa**: Las políticas están profundamente integradas con el sistema de autorización de Laravel
2. **Granularidad**: Permiten autorización a nivel de modelo, no solo a nivel de ruta
3. **Testabilidad**: Fáciles de probar unitariamente
4. **Mantenibilidad**: Separación clara de responsabilidades
5. **Escalabilidad**: Fácil agregar nuevos permisos sin modificar middleware

```php
// Con Policies: Granular y específico
$this->authorize('update', $user);

// Con Middleware: Genérico y limitado
Route::middleware('admin')->group(function () {
    // Todas las rutas requieren admin
});
```

### Separación de Responsabilidades

La arquitectura sigue principios SOLID:

- **Controllers**: Solo manejo de HTTP (request/response)
- **Policies**: Lógica de autorización
- **Resources**: Transformación de datos
- **Models**: Lógica de negocio y relaciones
- **Migrations**: Estructura de base de datos

### Manejo de Errores

Respuestas consistentes en formato JSON:

```json
{
  "success": false,
  "message": "Descripción del error",
  "errors": {
    "field": ["Mensaje específico"]
  }
}
```

## 📁 Estructura del Proyecto

```
inventory-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/     # Controladores de API
│   │   └── Resources/           # Transformadores de respuesta
│   ├── Models/                  # Modelos Eloquent
│   ├── Policies/               # Políticas de autorización
│   └── ...
├── database/
│   ├── migrations/             # Migraciones de BD
│   ├── factories/              # Factories para testing
│   └── seeders/               # Seeders con datos de prueba
├── routes/
│   └── api.php                # Rutas de API
├── postman_collection.json    # Colección de Postman
└── README.md                  # Este archivo
```

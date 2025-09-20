# 🚀 Laravel API con Docker y PostgreSQL

**Prueba Práctica Desarrollador PHP - API REST con Laravel**

Este proyecto Laravel está completamente dockerizado y configurado con PostgreSQL. Incluye una API REST completa para gestión de tareas con validaciones avanzadas y configuración lista para producción.

## � Características del Proyecto

✅ **API REST completa** para gestión de tareas  
✅ **Validación de título único** con soporte para actualizaciones  
✅ **Dockerización completa** (Laravel + PostgreSQL + Nginx)  
✅ **PgAdmin incluido** para administración de base de datos  
✅ **Configuración lista para desarrollo y producción**  
✅ **Estructura MVC organizada** con Services y Request Validation  

## �🚀 Inicio Rápido

### Prerrequisitos
- [Docker](https://www.docker.com/get-started) 
- [Docker Compose](https://docs.docker.com/compose/)

### 🔧 Instalación y Configuración

#### **Opción 1: Inicio Automático (Recomendado)**

**En Windows (PowerShell):**
```powershell
# Ejecutar script de inicio automático
.\start.ps1
```

**En Linux/Mac:**
```bash
# Dar permisos y ejecutar
chmod +x start.sh
./start.sh
```

#### **Opción 2: Paso a Paso Manual**

```bash
# 1. Construir y levantar contenedores
docker-compose up --build -d

# 2. Esperar que los servicios estén listos (15 segundos aprox)
# Verificar estado: docker-compose ps

# 3. Instalar dependencias
docker-compose exec app composer install

# 4. Generar clave de aplicación
docker-compose exec app php artisan key:generate

# 5. Ejecutar migraciones
docker-compose exec app php artisan migrate

# 6. Limpiar cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
```

### 🌐 Acceso a los Servicios

| Servicio | URL | Credenciales |
|----------|-----|--------------|
| **🏠 Aplicación Laravel** | http://localhost:8000 | - |
| **🔌 API Version** | http://localhost:8000/api/version | - |
| **📋 Tasks API** | http://localhost:8000/api/tasks | - |
| **🗄️ PgAdmin** | http://localhost:5050 | admin@admin.com / admin |

## � Arquitectura Docker

### Contenedores y Servicios

| Servicio | Contenedor | Puerto Interno | Puerto Externo | Descripción |
|----------|------------|----------------|----------------|-------------|
| **Laravel App** | `laravel_app` | 9000 | - | Aplicación PHP-FPM 8.3 |
| **Nginx** | `laravel_nginx` | 80 | **8000** | Servidor web optimizado |
| **PostgreSQL** | `laravel_postgres` | 5432 | **5432** | Base de datos principal |
| **PgAdmin** | `laravel_pgadmin` | 80 | **5050** | Interfaz web para PostgreSQL |

### Configuración de Base de Datos

```env
DB_CONNECTION=pgsql
DB_HOST=postgres          # Nombre del contenedor
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=postgres
DB_PASSWORD=password
```

### Conectar PgAdmin a PostgreSQL

1. Acceder a PgAdmin: http://localhost:5050
2. Login: `admin@admin.com` / `admin`
3. Agregar servidor:
   - **Name**: Laravel DB
   - **Host**: `postgres`
   - **Port**: `5432`
   - **Username**: `postgres`
   - **Password**: `password`

## 🛠️ Comandos de Desarrollo

### 🐳 Gestión de Docker

```bash
# Ver estado de todos los contenedores
docker-compose ps

# Ver logs en tiempo real
docker-compose logs -f app          # Solo aplicación
docker-compose logs -f postgres     # Solo base de datos
docker-compose logs -f              # Todos los servicios

# Reiniciar servicios específicos
docker-compose restart app
docker-compose restart nginx
docker-compose restart postgres

# Detener todos los servicios
docker-compose down

# Detener y eliminar volúmenes (⚠️ ELIMINA DATA)
docker-compose down -v

# Reconstruir contenedores
docker-compose up --build -d

# Acceder al contenedor de la aplicación
docker-compose exec app bash
```

### ⚡ Laravel Artisan (dentro del contenedor)

```bash
# Migraciones
docker-compose exec app php artisan migrate
docker-compose exec app php artisan migrate:rollback
docker-compose exec app php artisan migrate:fresh
docker-compose exec app php artisan migrate:status

# Cache y optimización
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan optimize

# Información y debugging
docker-compose exec app php artisan route:list
docker-compose exec app php artisan tinker
docker-compose exec app php artisan --version

# Testing
docker-compose exec app php artisan test
docker-compose exec app vendor/bin/phpunit

# Generar archivos
docker-compose exec app php artisan make:controller NuevoController
docker-compose exec app php artisan make:model NuevoModel -m
docker-compose exec app php artisan make:request NuevoRequest
```

### 🗄️ Gestión de Base de Datos

```bash
# Conectarse directamente a PostgreSQL
docker-compose exec postgres psql -U postgres -d laravel

# Ejecutar consulta SQL directa
docker-compose exec postgres psql -U postgres -d laravel -c "SELECT * FROM tasks;"

# Backup de la base de datos
docker-compose exec postgres pg_dump -U postgres laravel > backup_$(date +%Y%m%d_%H%M%S).sql

# Restaurar desde backup
docker-compose exec -T postgres psql -U postgres -d laravel < backup.sql

# Ver tablas existentes
docker-compose exec postgres psql -U postgres -d laravel -c "\dt"

# Ver estructura de tabla específica
docker-compose exec postgres psql -U postgres -d laravel -c "\d tasks"
```

### 📦 Composer (Gestión de Dependencias)

```bash
# Instalar dependencias
docker-compose exec app composer install

# Agregar nueva dependencia
docker-compose exec app composer require guzzlehttp/guzzle

# Agregar dependencia de desarrollo
docker-compose exec app composer require --dev phpunit/phpunit

# Actualizar dependencias
docker-compose exec app composer update

# Ver dependencias instaladas
docker-compose exec app composer show

# Generar autoload
docker-compose exec app composer dump-autoload
```

## � API Documentation

### 📊 Endpoints Disponibles

| Método | Endpoint | Descripción | Validaciones |
|--------|----------|-------------|--------------|
| `GET` | `/api/version` | Obtener versión de la API | - |
| `GET` | `/api/tasks` | Listar todas las tareas | - |
| `POST` | `/api/tasks` | Crear nueva tarea | Título único requerido |
| `GET` | `/api/tasks/{id}` | Obtener tarea específica | ID debe existir |
| `PUT` | `/api/tasks/{id}` | Actualizar tarea | Título único (excluye actual) |
| `DELETE` | `/api/tasks/{id}` | Eliminar tarea | ID debe existir |

### 📝 Esquema de Datos - Task

```json
{
  "id": "integer",
  "title": "string (required, unique, max:255)",
  "description": "string (nullable)",
  "status": "boolean (nullable, default: false)",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### 🚀 Ejemplos de Uso

#### **1. Obtener versión de la API**
```bash
curl http://localhost:8000/api/version
```

**Respuesta:**
```json
{
  "version": "1.0.0"
}
```

#### **2. Crear nueva tarea**
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Completar documentación",
    "description": "Escribir README completo del proyecto",
    "status": false
  }'
```

**Respuesta exitosa:**
```json
{
  "success": true,
  "message": "Task created successfully",
  "data": {
    "id": 1,
    "title": "Completar documentación",
    "description": "Escribir README completo del proyecto",
    "status": false,
    "created_at": "2025-09-20T21:30:00.000000Z",
    "updated_at": "2025-09-20T21:30:00.000000Z"
  }
}
```

#### **3. Listar todas las tareas**
```bash
curl http://localhost:8000/api/tasks
```

#### **4. Obtener tarea específica**
```bash
curl http://localhost:8000/api/tasks/1
```

#### **5. Actualizar tarea**
```bash
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Completar documentación",
    "description": "README actualizado y completo",
    "status": true
  }'
```

#### **6. Eliminar tarea**
```bash
curl -X DELETE http://localhost:8000/api/tasks/1
```

### ⚠️ Validaciones y Errores

#### **Error de validación (422)**
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "title": ["Ya existe una tarea con este título."]
  }
}
```

#### **Tarea no encontrada (404)**
```json
{
  "success": false,
  "message": "Task not found"
}
```

## 📁 Estructura del Proyecto

```
prueba_php_backend/
├── 🐳 Docker Configuration
│   ├── docker-compose.yml          # Orchestración de contenedores
│   ├── Dockerfile                  # Imagen personalizada de Laravel
│   ├── .dockerignore              # Archivos excluidos del build
│   ├── docker/
│   │   ├── nginx/
│   │   │   └── default.conf       # Configuración Nginx optimizada
│   │   └── php/
│   │       └── local.ini          # Configuración PHP personalizada
│   ├── start.ps1                  # Script de inicio Windows
│   └── start.sh                   # Script de inicio Linux/Mac
│
├── 🚀 Laravel Application
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/
│   │   │   │   └── TasksController.php    # Controlador de tareas
│   │   │   └── Requests/
│   │   │       └── TasksRequest.php       # Validaciones de entrada
│   │   ├── Models/
│   │   │   ├── Task.php                   # Modelo de tarea
│   │   │   └── User.php                   # Modelo de usuario
│   │   ├── Service/Api/
│   │   │   └── TasksService.php           # Lógica de negocio
│   │   └── Return/
│   │       └── ReturnFormat.php           # Formato de respuestas API
│   │
│   ├── routes/
│   │   ├── api.php                        # Rutas de la API
│   │   ├── web.php                        # Rutas web
│   │   └── console.php                    # Comandos de consola
│   │
│   ├── database/
│   │   ├── migrations/
│   │   │   └── 2025_09_20_200914_create_tasks_table.php
│   │   ├── factories/
│   │   │   └── UserFactory.php
│   │   └── seeders/
│   │       └── DatabaseSeeder.php
│   │
│   ├── config/                            # Configuración de Laravel
│   ├── storage/                           # Logs, cache, uploads
│   ├── tests/                             # Tests unitarios y features
│   └── vendor/                            # Dependencias de Composer
│
├── 📋 Configuration Files
│   ├── .env                               # Variables de entorno
│   ├── composer.json                      # Dependencias PHP
│   ├── phpunit.xml                        # Configuración de tests
│   └── README.md                          # Esta documentación
```

### 🏗️ Arquitectura MVC + Services

```
Request → Route → Controller → Request Validation
    ↓
Controller → Service (Business Logic) → Model → Database
    ↓
Response ← ReturnFormat ← Controller ← Service ← Model
```

### 📋 Archivos Clave del Proyecto

| Archivo | Propósito |
|---------|-----------|
| `TasksController.php` | Maneja endpoints de la API |
| `TasksRequest.php` | Validaciones (título único, etc.) |
| `TasksService.php` | Lógica de negocio de tareas |
| `Task.php` | Modelo Eloquent de tarea |
| `ReturnFormat.php` | Estandariza respuestas JSON |
| `api.php` | Define rutas de la API |

## 🧪 Testing

### Ejecutar Tests

```bash
# Ejecutar todos los tests
docker-compose exec app php artisan test

# Tests específicos
docker-compose exec app php artisan test --filter TaskTest

# Tests con coverage
docker-compose exec app vendor/bin/phpunit --coverage-html coverage/
```

### Crear Tests

```bash
# Test unitario
docker-compose exec app php artisan make:test TaskTest --unit

# Test de feature/integración
docker-compose exec app php artisan make:test TaskApiTest
```

## 🐛 Solución de Problemas

### ❌ La aplicación no carga (HTTP 500/502)

```bash
# 1. Verificar estado de contenedores
docker-compose ps

# 2. Revisar logs de error
docker-compose logs -f app
docker-compose logs -f nginx

# 3. Verificar configuración de Laravel
docker-compose exec app php artisan config:show

# 4. Reiniciar servicios
docker-compose restart app nginx
```

### ❌ Error de conexión a base de datos

```bash
# 1. Verificar que PostgreSQL esté corriendo
docker-compose ps postgres

# 2. Probar conexión manualmente
docker-compose exec postgres pg_isready -U postgres

# 3. Verificar variables de entorno
docker-compose exec app printenv | grep DB_

# 4. Ejecutar migraciones
docker-compose exec app php artisan migrate
```

### ❌ Puerto 8000 ya está en uso

```bash
# Opción 1: Cambiar puerto en docker-compose.yml
# nginx:ports: - "8001:80"

# Opción 2: Detener proceso que usa el puerto
netstat -ano | findstr :8000    # Windows
lsof -i :8000                   # Linux/Mac

# Opción 3: Usar puerto diferente
docker-compose down
# Editar docker-compose.yml
docker-compose up -d
```

### ❌ Problemas de permisos (Linux/Mac)

```bash
# Arreglar permisos de directorios Laravel
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### ❌ Composer/Dependencias no instalan

```bash
# Limpiar cache de Composer
docker-compose exec app composer clear-cache

# Reinstalar dependencias
docker-compose exec app rm -rf vendor/
docker-compose exec app composer install

# Si hay problemas de memoria
docker-compose exec app php -d memory_limit=2G /usr/bin/composer install
```

### ❌ PgAdmin no se conecta a PostgreSQL

1. **Verificar credenciales:**
   - Host: `postgres` (no `localhost`)
   - Puerto: `5432`
   - Usuario: `postgres`
   - Contraseña: `password`

2. **Reiniciar servicios:**
   ```bash
   docker-compose restart postgres pgadmin
   ```

### ❌ Error "version is obsolete" en docker-compose

Este es solo un warning. Para eliminarlo, edita `docker-compose.yml` y remueve la línea:
```yaml
version: '3.8'  # ← Eliminar esta línea
```

### 🔍 Comandos de Diagnóstico

```bash
# Estado general del sistema
docker-compose ps
docker system df
docker system prune -f

# Información detallada de contenedor
docker-compose logs app --tail=50
docker inspect laravel_app

# Verificar conectividad entre contenedores
docker-compose exec app ping postgres
docker-compose exec app nc -zv postgres 5432

# Verificar configuración de Laravel
docker-compose exec app php artisan about
docker-compose exec app php artisan route:list
docker-compose exec app php artisan config:show database

# Monitoreo de recursos
docker stats
```

## 🚀 Deployment y Producción

### Variables de Entorno para Producción

Crear `.env.production`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=laravel_prod
DB_USERNAME=postgres
DB_PASSWORD=tu_password_seguro

# Cache y sessions en Redis para producción
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=redis
```

### Optimizaciones para Producción

```bash
# Optimizar Laravel
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan event:cache

# Optimizar Composer
docker-compose exec app composer install --optimize-autoloader --no-dev
```

## 📞 Soporte

Si encuentras problemas:

1. **Revisa los logs**: `docker-compose logs -f`
2. **Verifica la documentación**: Lee este README completo
3. **Busca en GitHub Issues**: Problemas similares ya resueltos
4. **Crear Issue**: Describe el problema con logs y pasos para reproducir

---

**✨ ¡Proyecto listo para desarrollo y producción!**

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

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

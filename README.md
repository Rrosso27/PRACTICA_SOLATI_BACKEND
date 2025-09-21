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


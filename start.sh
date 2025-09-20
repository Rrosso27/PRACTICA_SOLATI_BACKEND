#!/bin/bash

echo "🚀 Iniciando aplicación Laravel con Docker..."

# Construir y levantar los contenedores
docker-compose up --build -d

echo "⏳ Esperando que los servicios estén listos..."
sleep 10

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de Composer..."
docker-compose exec app composer install

# Generar clave de aplicación si no existe
echo "🔑 Generando clave de aplicación..."
docker-compose exec app php artisan key:generate

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones..."
docker-compose exec app php artisan migrate

# Limpiar cache
echo "🧹 Limpiando cache..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

echo "✅ Aplicación lista!"
echo ""
echo "🌐 Aplicación disponible en: http://localhost:8000"
echo "🗄️ PgAdmin disponible en: http://localhost:5050"
echo "   - Email: admin@admin.com"
echo "   - Password: admin"
echo ""
echo "Para detener los contenedores: docker-compose down"

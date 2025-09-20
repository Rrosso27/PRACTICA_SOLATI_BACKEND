Write-Host "🚀 Iniciando aplicación Laravel con Docker..." -ForegroundColor Green

# Construir y levantar los contenedores
Write-Host "📦 Construyendo contenedores..." -ForegroundColor Yellow
docker-compose up --build -d

Write-Host "⏳ Esperando que los servicios estén listos..." -ForegroundColor Yellow
Start-Sleep -Seconds 15

# Instalar dependencias de Composer
Write-Host "📦 Instalando dependencias de Composer..." -ForegroundColor Yellow
docker-compose exec -T app composer install

# Generar clave de aplicación si no existe
Write-Host "🔑 Generando clave de aplicación..." -ForegroundColor Yellow
docker-compose exec -T app php artisan key:generate

# Ejecutar migraciones
Write-Host "🗄️ Ejecutando migraciones..." -ForegroundColor Yellow
docker-compose exec -T app php artisan migrate

# Limpiar cache
Write-Host "🧹 Limpiando cache..." -ForegroundColor Yellow
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan cache:clear
docker-compose exec -T app php artisan route:clear
docker-compose exec -T app php artisan view:clear

Write-Host "✅ Aplicación lista!" -ForegroundColor Green
Write-Host ""
Write-Host "🌐 Aplicación disponible en: http://localhost:8000" -ForegroundColor Cyan
Write-Host "🗄️ PgAdmin disponible en: http://localhost:5050" -ForegroundColor Cyan
Write-Host "   - Email: admin@admin.com" -ForegroundColor Gray
Write-Host "   - Password: admin" -ForegroundColor Gray
Write-Host ""
Write-Host "Para detener los contenedores: docker-compose down" -ForegroundColor Yellow

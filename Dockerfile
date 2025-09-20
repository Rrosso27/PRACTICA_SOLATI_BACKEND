FROM php:8.3-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario para la aplicación Laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiar código existente de la aplicación
COPY . /var/www/html

# Copiar permisos existentes del directorio de la aplicación
COPY --chown=www:www . /var/www/html

# Cambiar al usuario www
USER www

# Exponer puerto 9000 y iniciar php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

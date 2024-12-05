# LaraStore
Multi vendor e-commerce starter kit built with Laravel and React with Inertia with server side rendering built-in.

## Requirements
 - PHP >= 8.2
 - Laravel 11
 - MariaDB 10.3+
 - MySQL 5.7+
 - PostgreSQL 10.0+
 - SQLite 3.26.0+
 - SQL Server 2017+

## Project Setup
#### 1. Clone or download project repository

```bash
git clone https://github.com/larastore-io/laravel-react-inertia.git
``` 

#### 2. Navigate into project's root directory

```bash
cd laravel-react-inertia
```

Create `.env` file and adjustthe environment variables.

```bash
cp .env.example .env
```

If you want to use MySql instead of sqlite, modify the `DB_*` variables.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larastore
DB_USERNAME=root
DB_PASSWORD=
```

Then we have two options:
1. Setup with docker and sail
2. Or setup manually 

### Setup with Docker

This command will download all necessary docker images and setup the project.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### Manual Setup

#### 3. Install Dependencies

```bash
composer install && npm install
```

#### 4. Generate application key

```bash
php artisan key:generate --ansi
```

#### 5. Create storage link

```bash
php artisan storage:link
```

#### 6. Adjust `.env` parameters

Open `.env` file and adjust the parameters based on your needs

```env
...
APP_URL=http://localhost:8000
...
```

#### 7. Run Migrations

```bash
php artisan migrate --seed
```

#### 8. Start the application 

```bash
composer run dev
```

## License

The project is under [MIT License](LICENSE.md).






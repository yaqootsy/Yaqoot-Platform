# LaraStore
Multi vendor e-commerce starter kit built with Laravel and React with Inertia with server side rendering built-in.

## Project Setup
#### 1. Clone or download project repository

```bash
git clone https://github.com/larastore-io/laravel-react-inertia.git
``` 

#### 2. Navigate into project's root directory

```bash
cd laravel-react-inertia
```

Create `.env` file
```bash
cp .env.example .env
```

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







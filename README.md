# Task Management API

A Robust RESTful API built with Laravel 12 for a simple Task Management System.

## Features Included

* **Sanctum Authentication** (Register, Login, Logout)
* **Projects & Tasks Modules** (CRUD operations)
* **Status & Priority Enums**, Validation, and Soft Deletes
* **Repository and Service Layer Patterns** (Clean Architecture)
* **Localization Middleware** (Accepts `lang` header for multi-language response strings)
* **Automated API Documentation** (via `dedoc/scramble`)
* **Dashboard Stats Endpoint**
* **Background Queue Job** to process overdue tasks
* **Database Seeding with Factories** & Postman Collection included

## Installation Steps

1. **Clone the repository** (if fetched from Git).
2. **Install dependencies**:
   ```bash
   composer install
   ```
3. **Set up the `.env` file**:
   Make sure to configure your DB connection:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task-management
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
5. **Run Migrations and Seeders**:
   ```bash
   php artisan migrate --seed
   ```
   *Note: Seeder will generate dummy users, projects, and tasks for testing.*

### Environment Setup

The application uses standard `stack` logging and `database` queue driver. 
Run the queue worker to process the overdue tasks job:
```bash
php artisan queue:work
```
Run the scheduler manually to trigger the task (which runs daily):
```bash
php artisan schedule:work
```

## API Documentation

The API documentation is generated using **Swagger L5**.

To view the interactive API documentation:

1. Start the development server:
   ```bash
   php artisan serve
   ```
2. Open your browser and navigate to:
   ```
   http://127.0.0.1:8000/api/documentation   ```

## Testing

Feature tests for Projects have been included to demonstrate clean TDD setup.
Run the tests using:
```bash
php artisan test
```

## Postman Collection

A complete Postman API documentation is also available online:

https://documenter.getpostman.com/view/27912305/2sBY4TpxXH
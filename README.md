# HRMS (Human Resource Management System)

A Laravel-based HR management system for managing employees, departments, and time-off requests.

## Prerequisites

- PHP 8.1+
- Laravel 10.x
- MySQL 5.7+ or PostgreSQL 12+
- Composer
- Node.js & NPM

## Installation

```bash
# Clone repository
git clone https://github.com/AymanElh/HRMS.git
cd HRMS

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate
php artisan db:seed 
```

## Environment Configuration

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hrms
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-specific-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Available Endpoints

### Auth Routes
- `/login`
- `/dashboard`

### Admin Routes
- `/departments`
- `/formations`
- `/jobs`
- `/contracts`

### HR Routes
- `/recovery-days-approvals`
- `/vacation-approvals`
- `/employees`

### Manager Routes
- `/employees`
- `/vacation-approvals`

### Employee Routes
- `/vacations`
- `/recovery-days`
- `/profile`

## Required Seeders

```bash
# Run all seeders
php artisan db:seed

# Or run specific seeders
php artisan db:seed --class=RoleSeeder
```

## License

This project is licensed under the MIT License.

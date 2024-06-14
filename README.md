# Laravel Payment Module

This project is a Laravel-based payment module designed to handle high-traffic transactions efficiently and securely. It includes features such as transaction processing, user transaction history, and transaction summaries with caching, queueing, and throttling for optimal performance.

## Requirements

- PHP 8.x
- Composer
- Laravel 9.x
- MySQL or another supported database
- Redis
- [Optional] Docker (for containerized development environment)

## Installation

### 1. Clone the Repository

```sh
git clone https://github.com/kangajos/laravel-payment-module.git
cd laravel-payment-module
```

### 2. Install Dependencies
```sh
composer install
```
### 3. Set Up Environment Variables
- Copy the example environment file and update the necessary variables:
```sh
cp .env.example .env
```
#### Edit the .env file to match your configuration. Set up your database, Redis, and other configurations.

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Run Migrations and Seeders
```sh
php artisan migrate --seed
```
- This will create the necessary tables and seed the database with 1,000 users and 10,000 transactions.

### 6. Install Laravel Passport
```sh
php artisan passport:install
```

### Running the Application
- Start the Development Server
```sh
php artisan serve
```

### Queue Worker
- To process the transaction queue, run the following command:
```sh
php artisan queue:work
```

### Monitor with Laravel Horizon
- To monitor the queue processing, run Laravel Horizon:
```sh
php artisan horizon
```

### Redis Server
- Make sure your Redis server is running. You can start it with:
```sh
redis-server
```

### API Endpoints
- Process Transaction
URL: /api/process
Method: POST
Authentication: Bearer Token
Request Body: {
    "amount": "decimal"
}


### User Transaction History
URL: /api/transactions
Method: GET
Authentication: Bearer Token

### Transaction Summary
URL: /api/summary
Method: GET
Authentication: Bearer Token

### Running Tests
- This project includes unit tests to ensure the functionality of the payment module.
```ssh
php artisan test
```
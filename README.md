# Unggul API

Unggul API is a Laravel-based API for managing sales and stock for the Unggul project.

## Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/unggul-api.git
    cd unggul-api
    ```

2.  **Run the setup script:**
    This project includes a setup script to simplify the installation process.
    ```bash
    composer setup
    ```
    This command will:
    *   Install PHP dependencies with `composer install`.
    *   Create a `.env` file from `.env.example`.
    *   Generate an application key with `php artisan key:generate`.
    *   Run database migrations with `php artisan migrate --force`.
    *   Install JavaScript dependencies with `npm install`.
    *   Build frontend assets with `npm run build`.

3.  **Configure your `.env` file:**
    Open the `.env` file and configure your database connection and other environment variables.

4.  **Run the development server:**
    The project includes a `dev` script to start the development server, queue worker, and vite dev server.
    ```bash
    composer dev
    ```

## Testing

To run the test suite, you can use the `test` script:
```bash
composer test
```
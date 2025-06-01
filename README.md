# Expense Tracker

## Run Locally

Clone the project

```bash
git clone https://github.com/Pnut-Wap/expense-tracker.git
```

Go to the project directory

```bash
cd expense-tracker
```

Install dependencies

```bash
composer install
```

```bash
npm install && npm run dev
```

Optimization

```bash
php artisan optimize:clear
```

Application key

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

Start the server

```bash
composer run dev
```

## Environment Variables

To run this project, you will need to fill up the following environment variables in your `.env` file.

`DB_CONNECTION=sqlsrv`\
`DB_HOST=127.0.0.1`\
`DB_PORT=1433`\
`DB_DATABASE=your_database`\
`DB_USERNAME=your_username`\
`DB_PASSWORD=your_password`\
`DB_TRUST_SERVER_CERTIFICATE=true`

## Author

-   [Joshua Jason Nillos](https://github.com/Pnut-Wap)

## License

&copy; 2025

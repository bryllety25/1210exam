PHP Version 8.1
Node Version 16.14

## Project Setup

```sh
npm install / yarn install
composer install
```

## SET ENV
```sh
RENAME .env.example to .env
SET database credential
```
## Migrate Database
```sh
php artisan migrate
```

### Compile and Hot-Reload for Development

```sh
npm run dev / yarn dev
php artisan serve
```

### Type-Check, Compile and Minify for Production

```sh
npm run build / yarn build
```

## The application can open now in the browser with the url of localhost:8000

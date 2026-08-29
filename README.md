<p align="center">
  <img src="resources/images/favicon.png" alt="Strat" width="96" height="96">
</p>

<h1 align="center">Strat</h1>

**Dashboard and management for Laravel migrations.** Strat gives you a single place to see every migration in your application — which ones have run, which are still pending, and across which database connections — without leaving the browser.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/php-%5E8.5-777bb4.svg)
![Laravel](https://img.shields.io/badge/laravel-%5E13.19-ff2d20.svg)

> ⚠️ **Early stage.** Strat is under active development and its API, routes, and UI are still evolving. Expect breaking changes until a `1.0` release is tagged.

## ✨ Features

- **Migration overview** — browse every migration with its status (executed / pending), file, and type at a glance.
- **Multi-connection aware** — track migrations across multiple database connections, not just the default one.
- **Run migrations from the dashboard** — trigger `migrate` for a specific migration without touching the terminal.
- **Automatic sync** — a scheduled job keeps migration state fresh every 30 minutes, with an on-demand sync endpoint too.
- **Migration lifecycle tracking** — start/end events are recorded via Laravel's native migration events.
- **Gate-based access control** — a single `viewStrat` gate decides who can see the dashboard, defined in your own app.

## 📦 Requirements

- PHP `^8.5`
- Laravel (`illuminate/support` and `illuminate/routing` `^13.19`)

## 🚀 Installation

Install the package via Composer:

```bash
composer require fartex/strat
```

Run the install command, which publishes the config, the compiled assets, an authorization provider stub (`App\Providers\StratServiceProvider`), and runs the package's migrations:

```bash
php artisan strat:install
```

If you'd rather publish each piece manually:

```bash
php artisan vendor:publish --tag=strat-config
php artisan vendor:publish --tag=strat-assets
php artisan vendor:publish --tag=strat-provider
php artisan migrate
```

## 🧭 Dashboard path

By default, the dashboard is served at `/strat`. Change it by setting `STRAT_PATH` in your `.env`, or by editing the `path` value in the published `config/strat.php`:

```php
'path' => env('STRAT_PATH', 'strat'),
```

## 🔐 Access control

Strat ships with no default access, on purpose. After installing, customize the `viewStrat` gate in `app/Providers/StratServiceProvider.php` to control who can view the dashboard:

```php
Gate::define('viewStrat', function ($user = null) {
    return app()->environment('local');
});
```

Make sure to review this before deploying to production.

## ⚙️ Configuration

The published `config/strat.php` file controls which connections Strat monitors and how dashboard-triggered migrations are executed:

```php
'connections' => [
    // 'mysql',
    // 'pgsql',
],

'migrations' => [
    'async' => env('STRAT_MIGRATIONS_ASYNC', false),
    'connection' => env('STRAT_MIGRATIONS_QUEUE_CONNECTION'),
    'queue' => env('STRAT_MIGRATIONS_QUEUE'),
],
```

Leave `connections` empty to monitor only the application's default connection. By default, migrations triggered from the dashboard run synchronously, so Strat works without any extra infrastructure. If your application already runs a queue worker, set `STRAT_MIGRATIONS_ASYNC=true` and point the `connection`/`queue` options at it.

## 🤝 Contributing

Contributions are welcome! Feel free to open an issue or submit a pull request.

## 📄 License

Strat is open-sourced software licensed under the [MIT license](LICENSE).

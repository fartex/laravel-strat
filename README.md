# Strat

## Instalação

Instale o pacote via Composer:

```bash
composer require fartex/strat
```

Rode o comando de instalação, que publica o config, os assets, o provider de
autorização (`App\Providers\StratServiceProvider`) e roda as migrations do pacote:

```bash
php artisan strat:install
```

Se preferir publicar cada parte manualmente:

```bash
php artisan vendor:publish --tag=strat-config
php artisan vendor:publish --tag=strat-assets
php artisan vendor:publish --tag=strat-provider
php artisan migrate
```

Depois de instalado, customize a gate `viewStrat` em
`app/Providers/StratServiceProvider.php` para controlar quem pode acessar as rotas da
dashboard antes de ir pra produção.

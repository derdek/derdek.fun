![example workflow](https://github.com/derdek/derdek.fun/actions/workflows/laravel.yml/badge.svg)

How run project:
* php -r \"file_exists('.env') || copy('.env.example', '.env');\"
* php artisan key:generate --ansi
* docker-compose up -d
* docker-compose exec app php artisan migrate:fresh --seed --seeder=FirstStartSeeder
* open in browser <a href="http://localhost:10000" target="_blank">localhost:10000</a>

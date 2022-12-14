## Installation


- `docker-compose up -d`
- `cp src/.env.example src/.env`
- `docker-compose run --rm composer update`
- `docker-compose run --rm composer key:gen`
- `docker-compose run --rm artisan migrate:fresh --seed`


## Ports details:

- **nginx** - `:80`
- **mysql** - `:3306`
- **php** - `:9000`


## - Credentials

## admin
- admin@admin.com
- 123456

## employee
- employee@employee.com
- 123456
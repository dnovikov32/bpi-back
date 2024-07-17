# Best Private Investor API
View the results of the Best Private Investor competition

## Configuration
- PHP 8.2
- Postgres latest
- Nginx latest

## Local development

Copy environment file:
```bash
cp .env.dist .env
```

Create `docker-compose.yml` symlink:
```bash
ln -s docker-compose.local.yml docker-compose.yml
```

Add `.env` variable `SITE_HOST` value to `/etc/hosts`
```text
127.0.1.1	bpi-back.docker
```

Build application:
```bash
make build
```

Start application:
```bash
make start
```

After start, application is available at http://bpi-back.docker/

## Swagger
http://localhost:8081/

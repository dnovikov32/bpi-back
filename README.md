# Best Private Investor API
View the results of the Best Private Investor competition

## Configuration
- PHP 8.1
- Postgres 16.3
- Nginx 1.27.0

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


## Commands

Import all shares fromTinkoff API
```bash
bin/console app:instrument:share:import`  
```

Import all traders by 2022 year
```bash
bin/console app:trader:trader:import 2022
```


## Info
 Статистика конкурса "лучший частный инвестор 2022 года"  
https://investor.moex.com/ru/statistics/2022/  
http://ftp.moex.com/pub/info/stats_contest/2022/

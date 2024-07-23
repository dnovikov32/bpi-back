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

Import results by year
```bash
app:trader:result:import 2022
```

## Info
[Статистика конкурса ЛЧИ](https://investor.moex.com/ru/statistics/2022/)  
[Данные конкурса ЛЧИ для выгрузки](http://ftp.moex.com/pub/info/stats_contest)  
[Tinkoff invest api](https://tinkoff.github.io/investAPI/)


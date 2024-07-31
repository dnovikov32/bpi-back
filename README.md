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
bin/console app:instrument:share:import
```

Import all traders by 2022 year
```bash
bin/console app:trader:trader:import 2022
```

Import results by year
```bash
bin/console app:trader:result:import 2022
```

## Info
[Статистика конкурса ЛЧИ](https://investor.moex.com/ru/statistics/2022/)  
[Данные конкурса ЛЧИ для выгрузки](http://ftp.moex.com/pub/info/stats_contest)  
[Tinkoff invest api](https://tinkoff.github.io/investAPI/)



## TODO

```sql
select
    date_bin('5 min', start_date, '2001-01-01') as interval_5min,
    (array_agg(open_price ORDER BY start_date))[1] as open_price,
    (array_agg(close_price ORDER BY start_date DESC))[1] as close_price,
    max(max_price) as max_price,
    min(min_price) as min_price,
    sum(volume) as volume
from marketdata_candle
where share_id = '01J3GGC7CFS1H02S1G7HPGH3Y7'
and start_date >= '2024-07-28 00:00:00'
and start_date <= '2024-07-28 23:59:59'
group by interval_5min
order by interval_5min desc
```

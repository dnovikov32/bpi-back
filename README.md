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

Import all shares from Tinkoff API
```bash
bin/console app:instrument:share:import
```

Import all traders by 2022 year from MOEX
```bash
bin/console app:trader:trader:import 2023
```

Import all trader trades by year, trader moex id and market type from MOEX
```bash
bin/console app:trader:trade:import 2023 310910 1
```

Import results by year from MOEX
```bash
bin/console app:trader:result:import 2023
```

## Info
[Статистика конкурса ЛЧИ](https://investor.moex.com/ru/statistics/2022/)  
[Данные конкурса ЛЧИ для выгрузки](http://ftp.moex.com/pub/info/stats_contest)  
[Tinkoff invest api](https://tinkoff.github.io/investAPI/)



## TODO

```sql
select
	date_bin('5 min', date_time, '2001-01-01') as interval,
	(array_agg(open ORDER BY date_time))[1] as open,
	(array_agg(close ORDER BY date_time DESC))[1] as close,
	max(high) as high,
	min(low) as low,
	sum(volume) as volume
from marketdata_candle 
where share_id = '01J3GGC7CFS1H02S1G7HPGH3Y7' 
  and date_time >= '2024-07-28 00:00:00' 
  and date_time <= '2024-07-28 23:59:59'
group by interval
order by interval desc
```



TQBR позволяет осуществлять сделки с акциями.

BOARDID на Московской бирже – это уникальный цифровой идентификатор торговой площадки или режима торгов, в рамках которого проходят торги различными финансовыми инструментами.

Каждой торговой площадке на Мосбирже присваивается свой BOARDID:  

- BOARDID=TQBR – основная площадка для акций и облигаций (Торгово-Quotation Board)  
- BOARDID=TQTF – площадка для биржевых ETF и паев ПИФов  
- BOARDID=EQBR – площадка для торговли акциями малой капитализации  
- BOARDID=FQBR – площадка для корпоративных и муниципальных облигаций и т.д.  

Этот идентификатор широко используется в отчетности и API Московской биржи.  

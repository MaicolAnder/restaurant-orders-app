# Restaurant orders app
Containerized microservices-based restaurant order request application

## Docker options
Iniciar contenedor con todos los servicios
```
docker-compose up
```
Detener contenedor
```
docker-compose up
```

## APIS y Servicios
DB Access         [phpMyAdmin]( http://localhost:9001)

API Estados       [http://localhost:8000]( http://localhost:8000)

API Ordenes       [http://localhost:8001]( http://localhost:8001)

API Inventarios   [http://localhost:8002]( http://localhost:8002)


## Acceso a la base de datos
> DB_CONNECTION=`mysql`

> DB_HOST=`mysql_db`

> DB_PORT=`3306`

> DB_DATABASE=`db_restaurant_orders`

> DB_USERNAME=`root`

> DB_PASSWORD=`root`
>

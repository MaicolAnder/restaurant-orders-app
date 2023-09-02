# Restaurant orders app
Aplicación para solicitud de pedidos de restaurante basada en microservicios.
La aplicación esta desarrollada en `Laravel`, manejando una arquitectura de `microservicios` y conectandose a una base de datos `MySQL`.

Todos los servicios estan contenerizados y orquestados con `docker`.


## Clonar repositorio
```
git clone https://github.com/MaicolAnder/restaurant-orders-app.git
```

## Opciones para ejecutar Contenedores
Iniciar contenedor con todos los servicios
```
docker-compose up
```
Detener contenedor
```
docker-compose up
```

## APIS y Servicios

Angular Client    [Aplicacion web]( http://localhost:80)

Base de datos     [phpMyAdmin]( http://localhost:9001)

API Estados       [http://localhost:8000]( http://localhost:8000)

API Ordenes       [http://localhost:8001]( http://localhost:8001)

API Inventarios   [http://localhost:8002]( http://localhost:8003)


## Acceso a la base de datos
> DB_CONNECTION=`mysql`

> DB_HOST=`mysql_db`

> DB_PORT=`3306`

> DB_DATABASE=`db_restaurant_orders`

> DB_USERNAME=`root`

> DB_PASSWORD=`root`
>

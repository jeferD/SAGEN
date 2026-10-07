# Tesoreria SAGEM Backend

Microservicio Spring Boot que reemplaza la lógica PHP de consultas/descargas CSV.

## Lo que hace

- Ejecuta las funciones PostgreSQL existentes.
- Toma el SQL que esas funciones devuelven.
- Ejecuta ese SQL y responde en CSV, como los PHP.

## Endpoints

- `POST /api/reportes/tesoreria`
- `POST /api/reportes/tesoreria/radicados`
- `POST /api/reportes/tesoreria/nit-periodo`
- `POST /api/reportes/tesoreria/nit-cuenta-cobro`
- `POST /api/reportes/tesoreria/nit-documento`
- `POST /api/reportes/cartera`
- `POST /api/reportes/cartera/radicados`
- `POST /api/reportes/cartera/nit-periodo`
- `POST /api/reportes/cartera/nit-cuenta-cobro`
- `POST /api/reportes/impuestos`
- `POST /api/reportes/impuestos/radicados`
- `POST /api/reportes/impuestos/nit-periodo`
- `POST /api/reportes/impuestos/nit-cuenta-cobro`
- `POST /api/reportes/impuestos/nit-documento`
- `GET /api/reportes/recobros/radicado?id_rad=...`
- `GET /api/reportes/recobros/cuenta-cobro?id_nit=...&id_numero_cuenta_cobro=...`
- `GET /api/reportes/recobros/factura?id_nit=...&id_factura=...`
- `POST /api/reportes/cruce`
- `POST /api/reportes/fepa`

## Variables de entorno

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`

## Ejecutar

```bash
mvn spring-boot:run
```

## Nota

La lógica importante está en PostgreSQL, no en PHP. Este backend la preserva sin reescribir las funciones SQL.

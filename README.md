Welcome to the Symfony.
========================

### First
First let's clone this project [https://github.com/Thomas-Matheus/invteste](https://github.com/Thomas-Matheus/invteste)

### Technologies

- PHP 7.4
- Symfony 5.2
- Postgres
- Git
- Composer
- Docker
- Docker-compose

Initial setting Backend
--------------

Move to folder `invtest` and run the command below.

After use command Docker to run the `invtest`

```bash
    docker-compose up -d
```

The server will run in the port `8080` and for access `http://localhost:8080/`

Enter inside the container `invtest-php-fpm` with the command below

```bash
    docker exec -it invtest-php-fpm bash
```
and run composer install

Composer command:

```shell
    composer install
```

#### APIs aviables

| Method | Endpoint | Description |
| --- | --- | --- |
| POST | /register | Create a new user |
| POST | /login_check | Do login for a registered user |
| GET | /api/person/{id} | Gets one person search by id |
| GET | /api/people | Gets all people |
| GET | /api/order/{id} | Get one order search by id | 
| GET | /api/orders/{id} | Get all orders | 

or you can see the swagger at the following link `http://localhost:8080/doc`

##### Request to add a new user

```shell
$ curl --location --request POST 'http://localhost:8080/register' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username": "thomas",
    "password": "123456"
}'

->  {"id":"5fdfc2873fb7d842bc0b6bf2", "username":"thomas", "roles": [ "ROLE_USER" ]}
```

##### Request to do login

```shell
$ curl --location --request POST 'http://localhost:8080/login_check' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username": "thomas",
    "password": "123456"
}'

->  {"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTA0NjAzNjgsImV4cCI6MTYxMDQ2Mzk2OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiVGhvbWFzICJ9.3PwWeOuKA6Ewk9mXfAtK_JFkpXFPJkz-HquvPdGHBZ5QUz_k64z9w0VGeoScG1AC_J20fqxiiIOemrmSGAuxJWFNlqjSAWFjVNJ4W-b57co-A0nbw3csg6CN2760a9j3bB7ZdDqATme_U_fagjw1spKM4KdiZm3ZqYlJgGOCHD2ZgrVJPM2OAEPD8vwU6pfPz6Yf_KuEd4oprmdEQvy0e2oIgvnp4rctS1eMt5iKKN3DS7DxwLE4JeOXwtIajcVDjd06vtEp47oJCGuRmaFsa18fuvaiO_zBxBuNdhTM72YnN_rHjkXCsFKibi19cWS8VXdgmvqN3DnQZJnLAu3He-PF957IY3KqunzZjbzgg_2_J5gDVNniGuh19HeEZ8dBakJomnWugV61X6hvQjJ11fIsL2GcowtaOERMQQJMZZwghuYG5qP5HfYZsDRGRaTMI9qFhkFeIb9EnQ4a_8-4ELAMXgKzN4UkYp7jH60f97dsbRJNtSd1_59KHCg069Y8ISbMj30iNW5QYwhjLtleuIqQigjcfs4IOSWh2dV0-kuNFPakt1W4P01Tfjlz0lzHvv9SaGPXmfKyxE96Op1ajSNLDNIAG2XlTdO6hJSoK6O3kC-Ds374Z7pS379g0IR0IPb9dSopW3Y1nP4_RuMMbvigd61XWfLVH6TDi3yHlDE"}
```

##### Testes

If you want, execute this command to run tests:

```bash
    php ./bin/phpunit
```

---
#### Documentations

- [Docker](https://www.docker.com/get-started)
- [Docker compose](https://docs.docker.com/compose/install/)
- [Symfony](https://symfony.com/doc/5.2/setup.html)
- [Bootstrap](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
